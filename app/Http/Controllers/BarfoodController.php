<?php

namespace App\Http\Controllers;

use App\Models\Barfood;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;
use Session;

class BarfoodController extends Controller
{
   /** index page */
   public function index()
   {
    
    if (Session::get('role_name') == 'Accountant')
    {
       $foods = DB::table('barfoods')->get();
       return view('accountant.bar.foods',compact('foods'));
    }
    else{
        return redirect()->route('home');
    }
   }

   /** save record */
   public function AddFood(Request $request)
   {
       $request->validate([
           'foodname' => 'required|string|max:255',
           'foodquantity' => 'required|string|max:255',
           'foodunit' => 'required|string|max:255',
           'fooduprice' => 'required|string|max:255',
       ]);
       
       DB::beginTransaction();
       try {
           $food = new Barfood();
           $food->foodname = $request->foodname;
           $food->foodquantity  = $request->foodquantity;
           $food->foodunit = $request->foodunit;
           $food->fooduprice = $request->fooduprice;
           $food->save();
           
           DB::commit();
           Toastr::success('food added successfully :)','Success');
           return redirect()->back();
           
       } catch(\Exception $e) {
           DB::rollback();
           Toastr::error('Add food fail :)','Error');
           return redirect()->back();
       }
   }
   
   /** update record */
   public function UpdateFood( Request $request)
   {
       DB::beginTransaction();
       try{
           $id           = $request->id;
           $foodname  = $request->foodname;
           $foodquantity  = $request->foodquantity;
           $foodunit  = $request->foodunit;
           $fooduprice  = $request->fooduprice;

           $update = [

               'id'           => $id,
               'foodname' => $foodname,
               'foodquantity' => $foodquantity,
               'foodunit' => $foodunit,
               'fooduprice' => $fooduprice,
               
           ];

           Barfood::where('id',$request->id)->update($update);
           DB::commit();
           Toastr::success('Food updated successfully :)','Success');
           return redirect()->back();

       }catch(\Exception $e){
           DB::rollback();
           Toastr::error('Food update fail :)','Error');
           return redirect()->back();
       }
   }

   
     /** delete food */
     public function deletefood(Request $request) 
     {
         try {
             Barfood::destroy($request->id);
             Toastr::success('Food deleted successfully :)','Success');
             return redirect()->back();
         
         } catch(\Exception $e) {
             DB::rollback();
             Toastr::error('Food delete fail :)','Error');
             return redirect()->back();
         }
     }

}
