<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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

    public function add_product(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:20',
            'image' => 'required|image',
            'category' => 'required|string',
            'quantity' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/|min:1',
            'price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'expiry_date' => 'required|date',
            'phone_number' => 'required|string|min:10',
            'discount1' => 'required|integer',
            'discount2' => 'required|integer',
            'discount3' => 'required|integer'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $image = $request->file('image');
        $extension = $image->getClientOriginalExtension();
        $filename = time() . '.' . $extension;
        $image->move("photos/", $filename);

        $price=$request->price;
        $discount=$request->discount1;
        $discount=($discount/100)*$price;
        $price=$price-$discount;

        $product = Product::create([
            'name' => $request->name,
            'photo_name' => $filename,
            'photo_path' => URL::to("/photos/$filename"),
            'category' => $request->category,
            'quantity' => $request->quantity,
            'price' => $price,
            'expiry_date' => $request->expiry_date,
            'phone_number' => $request->phone_number,
            'discount2' => $request->discount1,
            'discount3' => $request->discount2,
            'user_id' => auth()->id(),
            'views' => 0,
            'likes' => 0
        ]);
        return response()->json([
            'message' => 'Product successfully added',
            'Product' => $product,
        ], 201);
    }

    public function show_products()
    {

        $data = DB::table('products')->get(['id', 'name', 'photo_path']);
        //$data=Product::get(['id','name','photo_path']);
        return response()->json($data);
    }

    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'by' => 'required|string',
            'text' => 'string',
        ]);
        if ($validator->fails())
            return response()->json($validator->errors(), 400);

        $by = $request->by;
        $text=$request->text;
        switch ($by) {
            case 'name':
                $data = DB::table('products')->where('name', $text)->get(['id', 'name', 'photo_path']);
                break;
            case 'category':
                $data = DB::table('products')->where('category', $text)->get(['id', 'name', 'photo_path']);
                break;
            case 'expiry_date':
                $date=Carbon::parse(strtotime($text))->format('Y-m-d');
                $data = DB::table('products')->where('expiry_date', $date)->get(['id', 'name', 'photo_path']);
                break;
        }
        if (isset($data))
            return response()->json($data);

        return response()->json([
            'No results'
        ]);
    }

    public function show_product($id)
    {
        $views = DB::table('products')->where('id', $id)->get(['views'])->pluck('views');
        $v = $views[0];
        $v++;
        DB::table('products')->where('id', $id)->update(['views' => $v]);
        $data = DB::table('products')->find($id);
        //$data=Product::find($id);
        return response()->json($data);
    }

    public function delete_product($id)
    {
        DB::table('products')->delete($id);
        //Product::find($id)->delete();
        return response()->json([
            'product deleted'
        ]);
    }

    public function update_product($id)
    {

    }

    public function like($id)
    {

        $likes = DB::table('products')->where('id', $id)->get(['likes'])->pluck('likes');
        $l = $likes[0];
        $l++;
        DB::table('products')->where('id', $id)->update(['likes' => $l]);
        $like = true;
        return response()->json([
            'like = ' => $like
        ]);
    }

    public function unlike($id)
    {

        $likes = DB::table('products')->where('id', $id)->get(['likes'])->pluck('likes');
        $l = $likes[0];
        $l--;
        DB::table('products')->where('id', $id)->update(['likes' => $l]);
        $like = false;
        return response()->json([
            'like = ' => $like
        ]);
    }
}
