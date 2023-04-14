<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    // Show all listings
    public function index()
    {

        //get all products but instead of user_id get owner name
        $products = Product::with('user')->get();

        return view('admin.products.index', [
            'products' => $products
        ]);
    }

    // Show create form
    public function create()
    {
        return view('admin.products.create');
    }

    // Store product
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'name' => ['required', Rule::unique('products', 'name'), 'max:255'],
            'score_multiplier' => 'required',

        ]);


        $formFields['user_id'] = auth()->user()->id;

        Product::create($formFields);

        return redirect('/admin/products')->with('status', 'Listing created successfully');
    }

    // Show product delete page
    public function show(Product $product)
    {
        return view('admin.products.delete', [
            'product' => $product
        ]);
    }

    // Delete product
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect('/admin/products')->with('status', 'Listing deleted successfully');
    }

    // Edit product
    public function edit(Product $product)
    {
        return view('admin.products.edit', [
            'product' => $product
        ]);
    }

    // Update product
    public function update(Request $request, Product $product)
    {
        $formFields = $request->validate([
            'name' => ['required', Rule::unique('products', 'name')->ignore($product->id), 'max:255'],
            'score_multiplier' => 'required',

        ]);
        $product->update($formFields);
        return redirect('/admin/products')->with('status', 'Listing updated successfully');
    }

    //get product owner name
    public function getOwnerName(Product $product)
    {
        return $product->getOwnerName();
    }
}
