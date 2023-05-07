<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Location;
use Brian2694\Toastr\Facades\Toastr;

class LocationController extends Controller
{
    /** page departments */
    public function index()
    {
        $locations = DB::table('locations')->get();
        return view('accountant.location.location',compact('locations'));
    }

    /** save record department */
    public function saveRecordLocation(Request $request)
    {
        $request->validate([
            'location' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {

            $location = Location::where('location',$request->location)->first();
            if ($location === null)
            {
                $location = new Location;
                $location->location = $request->location;
                $location->save();
    
                DB::commit();
                Toastr::success('Add new location successfully :)','Success');
                return redirect()->back();
            } else {
                DB::rollback();
                Toastr::error('Add new location exits :)','Error');
                return redirect()->back();
            }
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Add new location fail :)','Error');
            return redirect()->back();
        }
    }

    /** update record department */
    public function updateRecordLocation(Request $request)
    {
        DB::beginTransaction();
        try {
            // update table departments
            $location = [
                'id'=>$request->id,
                'location'=>$request->location,
            ];
            Location::where('id',$request->id)->update($location);
        
            DB::commit();
            Toastr::success('updated record successfully :)','Success');
            return redirect()->back();
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('updated record fail :)','Error');
            return redirect()->back();
        }
    }

    /** delete record department */
    public function deleteRecordLocation(Request $request) 
    {
        try {
            Location::destroy($request->id);
            Toastr::success('Location deleted successfully :)','Success');
            return redirect()->back();
        
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Location delete fail :)','Error');
            return redirect()->back();
        }
    }
}
