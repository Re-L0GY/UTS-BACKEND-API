<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\categories;


class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //get all level
        $categories = Categories::latest()->paginate(5);

        //response
        $response = [
            'message'   =>  'List all category',
            'data'      =>  $categories,
        ];

        return response()->json($response, 200);
    }

    public function store(Request $request)
    {
        //validasi data
        $validator = Validator::make($request->all(),[
            'category' => 'required|min:2',
        ]);


        //jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid field',
                'errors' => $validator->errors()
            ],422);
        }


        //jika validasi sukses masukan data level ke database
        $categories = Categories::create([
            'category' => $request->category,
        ]);


        //response
        $response = [
            'success'   => 'Add category success',
            'data'      => $categories,
        ];


        return response()->json($response, 201);
    }

    public function show(string $id)
    {
        //find Level by ID
        $categories = Categories::find($id);

        //response
        $response = [
            'success'   => 'Detail Category',
            'data'      => $categories,
        ];

        return response()->json($response, 200);
    }


    public function update(Request $request, string $id)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'category' => 'required|min:2',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $categories = Categories::find($id);

        $categories->update([
            'category' => $request->category,
        ]);

        //response
        $response = [
            'success'   => 'Update category success',
            'data'      => $categories,
        ];


        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //find level by ID
        $categories = Categories::find($id)->delete();


        $response = [
            'success'   => 'Delete Category Success',
        ];


        return response()->json($response, 200);

    }
}
