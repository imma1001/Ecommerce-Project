<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Models\Products;
use App\Models\User;
use Illuminate\Http\Request;



class AdminController extends Controller
{
    public function Admin_category(){
        return view('admin.categories');
    }

    
    public function store() {
        //get the user data
        $id = request()->id;
        $name=request()->name;
        

        // store in Database

        $data= new Category;
        $data->name = $name;
        $data->id = $id;
       // $po->description = $desc;
        $data->save();

        // another way
      // Category::create([
        //   'name'=>$name,
          // ]);
          
           return redirect()->back()->with('message', 'Your Category has been added successfully!');
        
        }
    public function Show(){
           $singCatFromDB = Category::all();
           return view('admin.categories',["categories"=>$singCatFromDB]);
    }
    public function destroy($id){

        $delfromDB = Category::findorfail($id);
        $delfromDB->delete();
        //Post::where('id',$id)-delete();
      return redirect()->back()->with('delete', 'Your Category has been removed');
    }



    //products

    public function adminProduct()
    {
        $categories = Category::all();
        $products = Products::all();
        return view('admin.products', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all(); // Fetch categories for dropdown
        return view('admin.create', compact('categories'));
    }

    public function storeP(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'quantity' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Handle file upload if there's a photo
        if ($request->hasFile('photo')) {
            $filePath = $request->file('photo')->store('products', 'public');
            $validatedData['photo'] = $filePath; // Save the file path
        }

        Products::create($validatedData);

        return redirect()->route('prod.admin')->with('success', 'Product added successfully!');
    }

    public function edit($id)
    {
        $product = Products::findOrFail($id);
        $categories = Category::all();
        return view('admin.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Products::findOrFail($id);
        
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'quantity' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
        ]);

         // Check if a new photo is uploaded
    if ($request->hasFile('photo')) {
        // Delete the old photo if it exists
        if ($product->photo) {
            Storage::disk('public')->delete($product->photo);
        }

        // Store the new photo and get the path
        $filePath = $request->file('photo')->store('products', 'public');
        $validatedData['photo'] = $filePath; 
    }

        $product->update($validatedData);

        return redirect()->route('prod.admin')->with('success', 'Product updated successfully!');
    }

    public function destroyP($id)
    {
        $product = Products::findOrFail($id);
        $product->delete();
        return redirect()->route('prod.admin')->with('success', 'Product deleted successfully!');
    }
}
