<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\products;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //get all level
        $product = Products::latest()->paginate(5);

        //response
        $response = [
            'message'   =>  'List all products',
            'data'      =>  $product,
        ];

        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validasi data
        $validator = Validator::make($request->all(),[
            'category_id' => 'required',
            'product' => 'required',
            'description' => 'required',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        //jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid field',
                'errors' => $validator->errors()
            ],422);
        }

        $image = $request->file('image');
        $image->storeAs('public/posts', $image->hashName());

        //jika validasi sukses masukan data level ke database
        $products = Products::create([
            'category_id' => $request->category_id,
            'product' => $request->product,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $image->hashName(),
        ]);

        //response
        $response = [
            'success'   => 'Add products success',
            'data'      => $products,
        ];

        return response()->json($response, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //find Level by ID
        $products = Products::find($id);


        //response
        $response = [
            'success'   => 'Detail Product',
            'data'      => $products,
        ];


        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'product' => 'required',
            'description' => 'required',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $image = $request->file('image');
        $image->storeAs('public/posts', $image->hashName());

        $products = Products::find($id);

        $products->update([
            'category_id' => $request->category_id,
            'product' => $request->product,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $image->hashName(),
        ]);

        //response
        $response = [
            'success'   => 'Update Product success',
            'data'      => $products,
        ];


        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //find level by ID
        $products = Products::find($id)->delete();


        $response = [
            'success'   => 'Delete Product Success',
        ];


        return response()->json($response, 200);
    }
}
