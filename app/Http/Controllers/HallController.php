<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hall;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;

class HallController extends Controller
{
    public function index()
    {
        
        if (Session::get('role_name') == 'Accountant')
        {
            $result      = DB::table('halls')->get();
            $location  = DB::table('locations')->get();
            $status_hall = DB::table('hstatuses')->get();
            return view('accountant.hall.hall',compact('result','location','status_hall'));
        } else {
            return redirect()->route('home');
        }
        
    }
    public function getHallData(Request $request)
    {
        $draw            = $request->get('draw');
        $start           = $request->get("start");
        $rowPerPage      = $request->get("length"); // total number of rows per page
        $columnIndex_arr = $request->get('order');
        $columnName_arr  = $request->get('columns');
        $order_arr       = $request->get('order');
        $search_arr      = $request->get('search');

        $columnIndex     = $columnIndex_arr[0]['column']; // Column index
        $columnName      = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue     = $search_arr['value']; // Search value

        $halls =  DB::table('halls');
        $totalRecords = $halls->count();

        $totalRecordsWithFilter = $halls->where(function ($query) use ($searchValue) {
            $query->orWhere('name', 'like', '%' . $searchValue . '%');
            $query->orWhere('numberp', 'like', '%' . $searchValue . '%');
            $query->orWhere('hallprice', 'like', '%' . $searchValue . '%');
            $query->orWhere('status', 'like', '%' . $searchValue . '%');
            $query->orWhere('location', 'like', '%' . $searchValue . '%');
        })->count();

        if ($columnName == 'id') {
            $columnName = 'id';
        }
        $records = $halls->orderBy($columnName, $columnSortOrder)
            ->where(function ($query) use ($searchValue) {
                $query->orWhere('name', 'like', '%' . $searchValue . '%');
                $query->orWhere('numberp', 'like', '%' . $searchValue . '%');
                $query->orWhere('hallprice', 'like', '%' . $searchValue . '%');
                $query->orWhere('status', 'like', '%' . $searchValue . '%');
                $query->orWhere('location', 'like', '%' . $searchValue . '%');
            })
            ->skip($start)
            ->take($rowPerPage)
            ->get();
        $data_arr = [];
        foreach ($records as $key => $record) {
           
            $record->name = '<h2 class="table-avatar"><a href="'.url('#' . $record->id).'" class="id">'.'<img class="avatar" data-avatar='.$record->avatar.' src="'.url('/assets/images/'.$record->avatar).'">' .$record->name.'</a></h2>';

            /** status */
            $full_status = '
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item"><i class="fa fa-dot-circle-o text-success"></i> Active </a>
                    <a class="dropdown-item"><i class="fa fa-dot-circle-o text-warning"></i> Inactive </a>
                    <a class="dropdown-item"><i class="fa fa-dot-circle-o text-danger"></i> Disable </a>
                </div>
            ';

            if ($record->status == 'Active') {
                $status = '
                    <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-dot-circle-o text-success"></i>
                        <span class="status_s">'.$record->status.'</span>
                    </a>
                    '.$full_status.'
                ';
            } elseif ($record->status == 'Inactive') {
                $status = '
                    <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-dot-circle-o text-info"></i>
                        <span class="status_s">'.$record->status.'</span>
                    </a>
                    '.$full_status.'
                ';
            } elseif ($record->status == 'Disable') {
                $status = '
                    <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-dot-circle-o text-danger"></i>
                        <span class="status_s">'.$record->status.'</span>
                    </a>
                    '.$full_status.'
                ';
            } else {
                $status = '
                    <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-dot-circle-o text-dark"></i>
                        <span class="status_s">'.$record->status.'</span>
                    </a>
                    '.$full_status.'
                ';
            }

            $data_arr [] = [
                "no"           => '<span class="id" data-id = '.$record->id.'>'.$start + ($key + 1).'</span>',
                "name"         => '<span class="name">'.$record->name.'</span>',
                "numberp"      => '<span class="numberp">'.$record->numberp.'</span>',
                "hallprice"    => '<span class="hallprice">'.$record->hallprice.'</span>',
                "status"       => $status,
                "location"     => '<span class="location">'.$record->location.'</span>',
                "action"       => 
                '
                <td>
                    <div class="dropdown dropdown-action">
                        <a class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item hallUpdate" data-toggle="modal" data-id="'.$record->id.'" data-target="#edit_hall">
                                <i class="fa fa-pencil m-r-5"></i> Edit
                            </a>
                            <a class="dropdown-item hallDelete" data-toggle="modal" data-id="'.$record->id.'" data-target="#delete_hall">
                                <i class="fa fa-trash-o m-r-5"></i> Delete
                            </a>
                        </div>
                    </div>
                </td>
                ',
            ];
        }
        $response = [
            "draw"                 => intval($draw),
            "iTotalRecords"        => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordsWithFilter,
            "aaData"               => $data_arr
        ];
        return response()->json($response);
    }


    public function addNewHallSave(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'numberp'     => 'required|string|max:255',
            'hallprice'     => 'required|string',
            'image'     => 'required|image',
            'status'    => 'required|string|max:255',
            'location'  => 'required|string|max:255',
            
        ]);
        DB::beginTransaction();
        try{
            

            $image = time().'.'.$request->image->extension();  
            $request->image->move(public_path('assets/images'), $image);

            $hall = new Hall;
            $hall->name        = $request->name;
            $hall->numberp        = $request->numberp;
            $hall->hallprice   = $request->hallprice;
            $hall->avatar      = $image;
            $hall->status       = $request->status;
            $hall->location  = $request->location;
            $hall->save();

            DB::commit();
            Toastr::success('New Hall registered successfully :)','Success');
            return redirect()->route('accountant.hall.hall');
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Register new hall fail :)','Error');
            return redirect()->back();
        }
    }
     
    /** update record */
    public function UpdateHall(Request $request)
    {
        DB::beginTransaction();
        try{
            $imagename = $request->hidden_image;
            $image  = $request->file('avatar');
            if($image != '')
            {
                unlink('assets/images/'.$imagename);
                $imagename = time().'.'.$image->getClientOriginalExtension();  
                $image->move(public_path('assets/images'), $imagename);
            } else {
                $imagename;
            }
            
            $update = [
                 'id'         =>$request->id,
                'name'       => $request->name,
                'numberp'         => $request->numberp,
                'hallprice'    => $request->hallprice,
                'location'   => $request->location,
                'status'       => $request->status,
                'avatar'       => $request->imagename,
            ];

           
            Hall::where('id',$request->id)->update($update);
            DB::commit();
            Toastr::success('Update Record successfully :)','Success');
            return redirect()->route('hallManagement');

        } catch(\Exception $e){
            DB::rollback();
            Toastr::error('Update record fail :)','Error');
            return redirect()->back();
        }
    } 
    
   

    /** delete record */
    public function DeleteHall(Request $request)
    {
        DB::beginTransaction();
        try {


            if ($request->avatar == 'photo_defaults.jpg') { 
                Hall::destroy($request->id);
                
            } else {
                Hall::destroy($request->id);
                unlink('assets/images/'.$request->avatar);
               
            }

            DB::commit();
            Toastr::success('Hall deleted successfully :)','Success');
           return redirect()->back();
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Hall delete fail :)','Error');
            return redirect()->back();
        }
    }
}
