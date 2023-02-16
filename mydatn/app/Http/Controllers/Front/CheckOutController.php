<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Utilities\Constant;
use App\Utilities\VNPay;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Mail;

class CheckOutController extends Controller
{
    //
    public function index(Request $request){
        
        if ($request->session()->has('customer')) {
                //
            $user = $request->session()->get('customer');
            $carts = Cart::content();
            //tổng tiền giỏ hàng
            $total = Cart::total();
            $total = str_replace(',','',$total);
            //tổng phụ
            $subtotal = Cart::subtotal();
            $total = str_replace(',','',$subtotal);

            return view('front.checkout.index',compact('carts','total','subtotal','user'));
    
        }else{
            return redirect('account/login');
        }
    }

    public function addOrder(Request $request){
        $request->validate([
            'phone' => 'required|numeric',
        ],
        ['phone.required' => 'Bắt buộc nhập số điện thoại.',
        
        'phone.numeric' => 'Số điện thoại phải là kiểu số.'],
    );
        
        //01.Thêm đơn hàng
        //+ thêm dữ liệu vào bảng order
        $data = $request->all();
        $data['status'] = Constant::order_status_ReceiveOrders;
        $order = Order::create($data);

        //02. Thêm chi tiết đơn hàng
        $carts = Cart::content();
        foreach($carts as $cart){
            $data = [
                'order_id' => $order->id,
                'product_id' => $cart->id,
                'qty' => $cart->qty,
                'size' => $cart->options->size,
                'color' => $cart->options->color,
                'amount' => $cart->price,
                'total' => $cart->price * $cart->qty,
                
            ];
            $productDetails = ProductDetail::where('product_id',$cart->id)
                                            ->where('size',$cart->options->size)
                                            ->where('color',$cart->options->color)
                                            ->first();

            if($productDetails){
                $dataProductDetail = [
                    'inventory' => $productDetails->inventory - $cart->qty,
                ];
                $productDetails->update($dataProductDetail);
            }
           

            $product = Product::where('id',$cart->id)->first();
            $dataProduct = [
                'inventory' => $product->inventory - $cart->qty,
            ];
            $product->update($dataProduct);
            

            OrderDetail::create($data);
        }
        if($request->payment_type == 'pay_later'){
            
        //03. Gửi email
        //tổng tiền giỏ hàng
        $total = Cart::total();
        $total = str_replace(',','',$total);
        //tổng phụ
        $subtotal = Cart::subtotal();
        $subtotal = str_replace(',','',$subtotal);
        $this->sendEmail($order, $total, $subtotal);

        //04. Xóa giỏ hàng sau khi đã thêm vào csdl
        Cart::destroy();


        //04.Trả về kết quả
        return view('front.checkout.confirmation',compact('carts','total','subtotal','order'));
        
        }
        
        if($request->payment_type == 'online_payment'){
            //1. Lấy url thanh toan vnpay
            $data_url = VNPay::vnpay_create_payment([
                'vnp_TxnRef' => $order->id, //ID cua don hang
                'vnp_OrderInfo' => 'Mo ta ve don hang...',
                'vnp_Amount' => Cart::total(0, '', ''), // nhân với tỷ giá usd để chuyển sang tiền việt
            ]);

            //2. chuyen huong toi url lay dc
            return redirect()->to($data_url);
        }
        
        

    }

    public function vnPayCheck(Request $request){
        //1.Lay data tu url (do vnpay gui ve qua $vnp_Returnurl)
        $vnp_ResponseCode = $request->get('vnp_ResponseCode'); //Mã phản hồi kết quả thanh toán, 00 = Thành công
        $vnp_TxnRef =$request->get('vnp_TxnRef'); //ticket id
        $vnp_Amount = number_format(substr($request->get('vnp_Amount'), 0, -2)); //số tiền thanh toán
        //2.Kiem tra ket qua giao dich tra ve tu VNPay
        if($vnp_ResponseCode != null){
            //Neu thanh cong
            if($vnp_ResponseCode == 00){
                //Cập nhật trạng thái Order
                //Order::update(['status' => Constant::order_status_Paid],$vnp_TxnRef);
                //gui email
                $order = Order::find($vnp_TxnRef);
                $total = Cart::total();
                $total = str_replace(',','',$total);
                $subtotal = Cart::subtotal();
                $total = str_replace(',','',$subtotal);
                $carts = Cart::content();
                $this->sendEmail($order, $total, $subtotal);

                //xoa gio hang
                Cart::destroy($order);

                //thong bao ket qua thanh cong
                return view('front.checkout.result',compact('carts','total','subtotal','order','vnp_Amount'));
            } else { //neu ko thanh cong
                //xoa don hang da them vao database va tra ve thong bao loi
                Order::find($vnp_TxnRef)->delete();

                //tra ve thong bao loi
                return view('front.checkout.error');

            }
        }
    }

    public function result(){
        //biến lấy dữ liệu thông báo từ session
        $notification = session('notification');
        return view('front.checkout.result', compact('notification'));
    }

    public function sendEmail($order, $total, $subtotal){
        $email_to = $order->email;
        $email_ad = 'lttt28022001@gmail.com';
        Mail::send('front.checkout.email', compact('order','total','subtotal') , function ($message) use ($email_to, $email_ad){
            $message->from('lttt28022001@gmail.com', 'ThanhTam-Shop');
            $message->to($email_to, $email_to);
            $message->to($email_ad, $email_ad);
            $message->subject('Bạn có một đơn hàng');
        });
    }
}
