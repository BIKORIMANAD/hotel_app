<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Room;
use Brian2694\Toastr\Facades\Toastr;

class RoomController extends Controller
{
    public function index()
    {
        
        if (Session::get('role_name') == 'Accountant')
        {
            $result      = DB::table('rooms')->get();
            $location  = DB::table('locations')->get();
            $status_room = DB::table('r_statuses')->get();
            return view('accountant.rooms.roomlist',compact('result','location','status_room'));
        } else {
            return redirect()->route('home');
        }
        
    }
    public function getRoomsData(Request $request)
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

        $rooms =  DB::table('rooms');
        $totalRecords = $rooms->count();

        $totalRecordsWithFilter = $rooms->where(function ($query) use ($searchValue) {
          
            $query->where('roomtype', 'like', '%' . $searchValue . '%');
            $query->orWhere('roomarea', 'like', '%' . $searchValue . '%');
            $query->orWhere('roomprice', 'like', '%' . $searchValue . '%');
            $query->orWhere('roombed', 'like', '%' . $searchValue . '%');
            $query->orWhere('roomno', 'like', '%' . $searchValue . '%');
            $query->orWhere('status', 'like', '%' . $searchValue . '%');
            $query->orWhere('location', 'like', '%' . $searchValue . '%');
        })->count();

        if ($columnName == 'id') {
            $columnName = 'id';
        }
        $records = $rooms->orderBy($columnName, $columnSortOrder)
            ->where(function ($query) use ($searchValue) {
                $query->where('roomtype', 'like', '%' . $searchValue . '%');
                $query->orWhere('roomarea', 'like', '%' . $searchValue . '%');
                $query->orWhere('roomprice', 'like', '%' . $searchValue . '%');
                $query->orWhere('roombed', 'like', '%' . $searchValue . '%');
                $query->orWhere('roomno', 'like', '%' . $searchValue . '%');
                $query->orWhere('status', 'like', '%' . $searchValue . '%');
                $query->orWhere('location', 'like', '%' . $searchValue . '%');
            })
            ->skip($start)
            ->take($rowPerPage)
            ->get();
        $data_arr = [];
        foreach ($records as $key => $record) {
           
            $record->roomtype = '<h2 class="table-avatar"><a href="'.url('#' . $record->id).'" class="id">'.'<img class="avatar" data-avatar='.$record->avatar.' src="'.url('/assets/images/'.$record->avatar).'">' .$record->roomtype.'</a></h2>';

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
                "roomtype"         => '<span class="roomtype">'.$record->roomtype.'</span>',
                "roomarea"      => '<span class="roomarea">'.$record->roomarea.'</span>',
                "roomprice"        => '<span class="roomprice">'.$record->roomprice.'</span>',
                "roombed"     => '<span class="roombed">'.$record->roombed.'</span>',
                "roomno" => '<span class="roomno">'.$record->roomno.'</span>',
                "status"       => $status,
                "location"   => '<span class="location">'.$record->location.'</span>',
                "action"      => 
                '
                <td>
                    <div class="dropdown dropdown-action">
                        <a class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item roomUpdate" data-toggle="modal" data-id="'.$record->id.'" data-target="#edit_room">
                                <i class="fa fa-pencil m-r-5"></i> Edit
                            </a>
                            <a class="dropdown-item roomDelete" data-toggle="modal" data-id="'.$record->id.'" data-target="#delete_room">
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


    public function addNewRoomSave(Request $request)
    {
        $request->validate([
            'roomtype'      => 'required',
            'roomarea'     => 'required|string',
            'roomprice'     => 'required|string',
            'roombed' => 'required|string|max:20',
            'roomno'  => 'required|string|max:255',
            'image'     => 'required|image',
            'status'    => 'required|string|max:255',
            'location'=> 'required|string|max:255',
            
        ]);
        DB::beginTransaction();
        try{
            

            $image = time().'.'.$request->image->extension();  
            $request->image->move(public_path('assets/images'), $image);

            $room = new Room;
            $room->roomtype        = $request->roomtype;
            $room->roomarea        = $request->roomarea;
            $room->roomprice   = $request->roomprice;
            $room->roombed    = $request->roombed;
            $room->roomno       = $request->roomno;
            $room->avatar      = $image;
            $room->status       = $request->status;
            $room->location  = $request->location;
            $room->save();

            DB::commit();
            Toastr::success('New Room registered successfully :)','Success');
            return redirect()->route('roomManagement');
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Register new room fail :)','Error');
            return redirect()->back();
        }
    }
    
    /** update record */
    public function UpdateRoom(Request $request)
    {
        DB::beginTransaction();
        try{
            $id              =$request->id;
            $roomtype        = $request->roomtype;
            $roomarea        = $request->roomarea;
            $roomprice     = $request->roomprice;
            $roombed    = $request->roombed;
            $roomno       = $request->roomno;
        
            $status    = $request->status;
            $location  = $request->location;

            $image_name = $request->hidden_image;
            $image = $request->file('images');
            if($image_name =='photo_defaults.jpg') {
                if (empty($image)) {
                    $image_name = $image_name;
                } else {
                    $image_name = rand() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('/assets/images/'), $image_name);
                }
            } else {
                if (!empty($image)) {
                    unlink('assets/images/'.$image_name);
                    $image_name = rand() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('/assets/images/'), $image_name);
                }
            }
            
            $update = [
                 'id'         =>$id,
                'roomtype'       => $roomtype,
                'roomarea'         => $roomarea,
                'roomprice'    => $roomprice,
                'roombed'        => $roombed,
                'roomno'     => $roomno,
                'location'   => $location,
                'status'       => $status,
                'avatar'       => $image_name,
            ];

           
            Room::where('id',$request->id)->update($update);
            DB::commit();
            Toastr::success('Update Record successfully :)','Success');
            return redirect()->route('roomManagement');

        } catch(\Exception $e){
            DB::rollback();
            Toastr::error('Update record fail :)','Error');
            return redirect()->back();
        }
    } 
    
   

    /** delete record */
    public function delete(Request $request)
    {
        DB::beginTransaction();
        try {


            if ($request->avatar == 'photo_defaults.jpg') { /** remove all information user */
                Room::destroy($request->id);
                
            } else {
                Room::destroy($request->id);
                unlink('assets/images/'.$request->avatar);
               
            }

            DB::commit();
            Toastr::success('Room deleted successfully :)','Success');
           return redirect()->back();
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Room delete fail :)','Error');
            return redirect()->back();
        }
    }

}
