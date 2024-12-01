<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function redirect(){
         $usertype = Auth::user()->usertype;
         if ($usertype=='1'){
           return  view('admin.home');
         }
         else{
            return view('dashboard');
         }
    }
    public function welcome(){
        $getResFromDB= DB::table('categories')-> get();
        //dd($getResFromDB);
        return view('welcome',['categories' =>$getResFromDB]);
    }
    
    public function productsCatId($CatId = null){
        if ($CatId == null){
            $getProFromDB = DB::table('products')->get();
        }
        else{
            $getProFromDB = DB::table('products')->where('category_id',$CatId)-> get();
        }
        return view('products',['products'=>$getProFromDB]);
    }
    

    public function details($id){
        //$getProFromDB = Products::find(id)
        $getProFromDB = DB::table('products')->where('id',$id)-> get();
          // Check if the product exists, otherwise return a 404 error
        if (!$getProFromDB) {
            abort(404, 'Product not found');
        }

        //
        else{
            return view('Details',['products'=>$getProFromDB]);
        }
    }
    public function indexPages()
{
    $products = Products::paginate(10); // Fetch 10 items per page
    return view('products', compact('products'));
}

       
    public function about(){
        return view('about');
    }
 

}
