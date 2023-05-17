<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Support\Facades\DB;
use Session;
use App\Models\Restomaterial;

class RestomaterialController extends Controller
{
    public function index(){
        if(Session::get('role_name') =='Accountant'){
            $materials  = DB::table('restomaterials')->get();
            return view('accountant.resto.material', compact('materials'));
        }
        else{
            return redirect()->route('home');
        }
       } 
    
       public function AddMaterial(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|string|max:255',
            'unit' => 'required|string|max:255',
            'uprice' => 'required|string|max:255',
        ]);
        DB::beginTransaction();
        try{
            $material = new Restomaterial;
            $material->name = $request->name;
            $material->quantity  = $request->quantity;
            $material->unit = $request->unit;
            $material->uprice = $request->uprice;
            $material->save();
            
            DB::commit();
            Toastr::success('Material added successfully :)','Success');
            return redirect()->back();
    
        }
        catch(\Exception $e){
            DB::rollback();
            Toastr::error('Add Material fail :)','Error');
            return redirect()->back();
        }
       }
    
       public function UpdateMaterial(Request $request){
        DB::beginTransaction();
        try{
            $id           = $request->id;
            $name  = $request->name;
            $quantity  = $request->quantity;
            $unit  = $request->unit;
            $uprice  = $request->uprice;
    
            $update = [
    
                'id'       => $id,
                'name'     => $name,
                'quantity' => $quantity,
                'unit'     => $unit,
                'uprice'   => $uprice,
                
            ];
    
            Restomaterial::where('id',$request->id)->update($update);
            DB::commit();
            Toastr::success('Material updated successfully :)','Success');
            return redirect()->back();
    
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Material update fail :)','Error');
            return redirect()->back();
        }
       }
    
       public function DeleteMaterial(Request $request){
        try {
            Restomaterial::destroy($request->id);
            Toastr::success('Material deleted successfully :)','Success');
            return redirect()->back();
        
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Material delete fail :)','Error');
            return redirect()->back();
        }
       }
}
