<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function addProduct (Request $request){
        if ($request->ajax()) {
        //dd($request->all());
        $product = Product::findOrFail($request->product_id);
        
        $colors = $request->color;
        
        $sizes = $request->size;

        //them sp vao gio hang
        //goi phuong thuc add tu thu vien cart
        Cart::add([
            'id' => $request->product_id,
            'name' => $product->name,
            'qty' => 1,
            'price' => $product->discount ?? $product->price,
            'weight' => $product->weight ?? 0,
            'options' => [
                'images' => $product->productImages,
                'size' => $sizes,
                'color' => $colors,
            ],//[] thông số tùy biến
        ]);
        $result['totalQuantity'] = Cart::count();
        return response()->json($result);
    }
        // dd(Cart::content());//xem tat ca du lieu trong Cart

        //return back();//quay lại trang cũ khi add xog
    }

    public function index(){

        $carts = Cart::content();
        //dd($carts);
        //tổng tiền giỏ hàng
        $total = Cart::total();
        //dd($total);
        $total = str_replace(',','',$total);
        //tổng phụ
        $subtotal = Cart::subtotal();
        $subtotal = str_replace(',','',$subtotal);


        return view('front.shop.cart',compact('carts','total','subtotal'));
    }

    public function deleteProduct(Request $request){
        if ($request->ajax()) {
            Cart::remove($request->rowId);
            $result['totalMoney'] = Cart::total();
            $result['totalQuantity'] = Cart::count();
            return response()->json($result);
        }

    }

    public function destroy(){
        Cart::destroy();//destroy: xóa tất cả
        
        return back();
    }

    public function update(Request $request){
        if ($request->ajax()) {
            $a = Cart::get($request->rowId);
            $productDetais = ProductDetail::where('product_id',$a->id)
            ->where('size',$a->options->size)
            ->where('color',$a->options->color)
            ->first();
            $product = Product::find($a->id);
            if($productDetais){
                if($request->qty < $productDetais->inventory){
                    Cart::update($request->rowId, $request->qty);//cap nhat
    
                    $result['totalMoney'] = number_format(str_replace(',','',Cart::total()));
                    $result['flag'] = 1;
                    $product = Cart::get($request->rowId);
                    //dd($product);
                    $result['totalMoneyProduct'] = number_format(str_replace(',','',$product->price) * $request->qty);
                    $result['totalQuantity'] = Cart::count();
                }else{
                    $result['flag'] = 0;
                }
            }else{
                if($request->qty < $product->inventory){
                    Cart::update($request->rowId, $request->qty);//cap nhat
    
                    $result['totalMoney'] = number_format(str_replace(',','',Cart::total()));
                    $result['flag'] = 1;
                    $product = Cart::get($request->rowId);
                    //dd($product);
                    $result['totalMoneyProduct'] = number_format(str_replace(',','',$product->price) * $request->qty);
                    $result['totalQuantity'] = Cart::count();
                }else{
                    $result['flag'] = 0;
                }
            }
            
            
            return response()->json($result);
        }
        
    }
}
