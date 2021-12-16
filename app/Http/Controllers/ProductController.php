<?php

namespace App\Http\Controllers;

//use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
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
            'name' => 'required|string|min:2|max:20',
            'image' => 'required|image',
            'category'=>'required|string|min:3|max:10',
            'quantity'=>'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/|min:1',
            'price'=>'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'expiry_date'=>'required|date_format:F/j/Y',
            'phone_number'=>'required|string|min:10'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }


        $image = $request->file('image');
        $extension = $image->getClientOriginalExtension();
        $filename = time().'.'.$extension;
        $image->move("photos/",$filename);
        $product = Product::create([
            'name' => $request->name,
            'photo_name'=>$filename,
            'photo_path'=>URL::to("/images/$filename"),
            'category'=>$request->category,
            'quantity'=>$request->quantity,
            'price'=>$request->price,//m/d/Y g:i A
            'expiry_date'=>Carbon::createFromFormat('F/j/Y', $request->expiry_date)->format('Y-m-d'),
            'phone_number'=>$request->phone_number,
            'user_id'=>auth()->id(),
            'views'=>0
        ]);

        return response()->json([
            'message' => 'Product successfully added',
            'Product' => $product,
        ], 201);

    }
}
