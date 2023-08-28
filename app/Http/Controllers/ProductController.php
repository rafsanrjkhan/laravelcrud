<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    //
    public function index()
    {
        // $products = Product::get();
        return view("products.index",['products'=>Product::get()]);
    }
    public function create()
    {
        return view("products.create");
    }
    public function store(Request $request)
    {
        // Validate Data
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'required|mimes:jpeg,jpg,png,gif|max:10000',
        ]);


        // Upolad Image
        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('products'), $imageName);
        // dd($request->all());
        // dd($imageName);
        $product = new Product;
        $product->image = $imageName;
        $product->name = $request->name;
        $product->description = $request->description;

        $product->save();
        return back()->withSuccess('Product Created');

    }
    public function edit($id)
    {
        $product = Product::where('id',$id)->first(); 
        return view('products.edit',['product' => $product]);
        // dd($id);
    }
    public function update(Request $request, $id)
    {
        // Validate Data
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'nullable|mimes:jpeg,jpg,png,gif|max:10000',
        ]);
 
       $product = Product::where('id',$id)->first();

        if(isset($request->image)){
        // Update Image
        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('products'), $imageName);
        $product->image = $imageName;
        }
       
        // dd($request->all());
        // dd($imageName);
        $product->name = $request->name;
        $product->description = $request->description;

        $product->save();
        return back()->withSuccess('Product Updated');
        // dd($request->all());
        // dd($id);
    }
    public function destroy($id)
    {
        $product = Product::where('id',$id)->first();
        $product->delete();
        return back()->withSuccess('Product Deleted');

    }
}
