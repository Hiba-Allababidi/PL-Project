<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            'category'=>'required|string',
            'quantity'=>'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/|min:1',
            'price'=>'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'expiry_date'=>'required|date',
            'phone_number'=>'required|string|min:10',
            'discount1'=>'required|integer',
            'discount2'=>'required|integer'
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
            'photo_path'=>URL::to("/photos/$filename"),
            'category'=>$request->category,
            'quantity'=>$request->quantity,
            'price'=>$request->price,
            'expiry_date'=>$request->expiry_date,
            'phone_number'=>$request->phone_number,
            'discount1'=>$request->discount1,
            'discount2'=>$request->discount2,
            'user_id'=>auth()->id(),
            'views'=>0
        ]);
        return response()->json([
            'message' => 'Product successfully added',
            'Product' => $product,
        ], 201);
    }

    public function show_products(){

        $data= DB::table('products')->get(['id','name','photo_path']);
        return response()->json($data);
    }

    public function delete_product($id){
        DB::table('products')->delete($id);
        return response()->json([
           'message'=>'product deleted'
        ]);
    }

    public function show_product($id){
        //$data=DB::table('products')->where('category','=','fruit')->get();
        $views=DB::table('products')->where('id',$id)->get(['views'])->pluck('views');
        $v=$views[0];
        $v++;
        $views=DB::table('products')->where('id',$id)->update(['views'=>$v]);
        $data=DB::table('products')->find($id);
        return response()->json($data);
    }

    public function search_product(Request $request){

        $validator=Validator::make($request->all(),[
            'name'=>'string',
            'category'=>'string',
            'expiry_date'=>'date'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(),404);
        }
    }
}
