<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Blog;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        
        //sản phẩm nổi bật
        $idsBestSeller = OrderDetail::selectRaw('order_details.product_id,SUM(order_details.qty) as amount')
        ->leftJoin('products','products.id','order_details.product_id')
        ->groupBy('order_details.product_id')
        ->orderBy('amount','desc')
        ->limit(5)->pluck('order_details.product_id')->toArray();
      
        $bestSellerProducts = Product::whereIn('id',$idsBestSeller )
                                        ->where('inventory','>',0)
                                        ->get();
        //dd($bestSellerProduct);
        $newProducts = Product::where('featured',false)->get();

        // $products = Product::all();

        //kiem tra xem cac lenh da lay du lieu dc chua
        //dd($menProducts);
        $newProducts = Product::where('featured',false)->where('inventory','>',0)->paginate(8);


        //lấy danh sách 3 blog mới nhất từ database
        $blogs = Blog::orderBy('id','desc')->limit(3)->get();

        //truyền biến vào view
        return view('front.index',compact('blogs','newProducts','bestSellerProducts'));
    }
}
