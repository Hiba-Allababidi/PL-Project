<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function add_product(Request $request){

        $validator = Validator::make($request->all(), [
            'Name' => 'required|string|min:2|max:20',
            'Image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'Category'=>'required|string|min:3|max:10',
            'Quantity'=>'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/|min:1',
            'Price'=>'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            //'Expiry_Date'=>'required|dateTime',
            'Phone_Number'=>'required|min:10'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $product = Product::create([
            'name' => $request->name,
            'Photo_Path'=>$request->file('image')->store('E:\project\PL-Project\images'),
            'Category'=>$request->Category,
            'Quantity'=>$request->Quantity,
            'Price'=>$request->Price,
            //'Expiry-Date'=>$request->Expiry_Date,
            'Phone-Number'=>$request->Phone_Number,
            'User_ID'=>auth()->id()
        ]);

        return response()->json([
            'message' => 'Product successfully added',
            'Product' => $product
        ], 201);

    }
}
