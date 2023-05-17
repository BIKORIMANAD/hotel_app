<?php

namespace App\Http\Controllers;

use App\Models\Barbeverage;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;

class BarbeverageController extends Controller
{

 /** index page */
 public function index()
 {
     if (Session::get('role_name') == 'Accountant')
     {
         $beverage = DB::table('barbeverages')->get();
         return view('accountant.bar.beverage',compact('beverage'));
     } else {
         return redirect()->route('home');
     }
     
 }

  /** save new beverage */
  public function addBeverage(Request $request)
  {
      $request->validate([
          'iname'      => 'required|string|max:255',
          'quantity'   => 'required|numeric|max:255',
          'unit'       => 'required|max:50|string',
          'uprice'     => 'required|string|max:255',
      ]);

      DB::beginTransaction();
      try{
        

          $beverage = new Barbeverage;
          $beverage->iname         = $request->iname;
          $beverage->quantity       = $request->quantity;
          $beverage->unit           = $request->unit;
          $beverage->uprice        = $request->uprice;
          $beverage->save();
          DB::commit();
          Toastr::success('Beverage Added successfully :)','Success');
          return redirect()->back();
      }catch(\Exception $e){
          DB::rollback();
          Toastr::error('Add new Beverage fail :)','Error');
          return redirect()->back();
      }
  }

  /** update record */
  public function UpdateBeverage(Request $request)
  {
      DB::beginTransaction();
      try {
         // update table restobeverages
         $beverage = [
             'id'=>$request->id,
             'iname'=>$request->iname,
             'quantity'=>$request->quantity,
             'unit'=>$request->unit,
             'uprice'=>$request->uprice,
         ];
         Barbeverage::where('id',$request->id)->update($beverage);
     
         DB::commit();
         Toastr::success('beverage updated successfully :)','Success');
         return redirect()->back();
     } catch(\Exception $e) {
         DB::rollback();
         Toastr::error('update beverage fail :)','Error');
         return redirect()->back();
     }
  }

    /** delete record */
    public function DeleteBeverage(Request $request)
    {
       try {
           Barbeverage::destroy($request->id);
           Toastr::success('Beverage deleted successfully :)','Success');
           return redirect()->back();
       
       } catch(\Exception $e) {
           DB::rollback();
           Toastr::error('Beverage delete fail :)','Error');
           return redirect()->back();
       }
    }

}
