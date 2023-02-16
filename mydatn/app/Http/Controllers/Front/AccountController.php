<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Utilities\Constant;
use Illuminate\Support\Facades\Hash;
use Dotenv\Validator;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Gloudemans\Shoppingcart\Facades\Cart;

class AccountController extends Controller
{
    //
    public function login(){
        return view('front.account.login');
    }

    public function checkLogin(Request $request){
        $password = $request->password;
        $user = User::where('email',$request->email)->first();

        if(Hash::check($password, $user->password)) {
            $request->session()->put('customer', $user);   
            if(Cart::content())
            {
                return redirect('cart');
            }else{
                return redirect(''); //mac dinh la trang chu
            }
        } else {
            return back()->with('notification', 'ERROR: Email hoặc mật khẩu không đúng!');
        }        
    }

    public function logout( Request $request){
        $request->session()->forget('customer');

        return back();
    }

    public function register(){
        return view('front.account.register');
    }

    public function createUser(Request $request){
        
        if($request->password != $request->password_confirmation){
            return back()->with('notification', 'Mật khẩu không trùng khớp.');
        }

        $users = User::where('email', '=', $request->email)->first();//trả về một bản ghi đầu tiên tìm thấy nếu không thì sẽ trả về null
        if ($users != null) {
            return back()->with('notification', 'Email đã tồn tại.');
        }

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'level' => Constant::user_level_client,
        ]);
        

        return redirect('account/login')->with('notification', 'Đăng kí thành công!Vui lòng đăng nhập.');
    }

    public function myOrderIndex(Request $request){
        //lay id cua user
        $user = $request->session()->get('customer');
        $orders = Order::where('user_id', $user->id)->get();
        // dd($orders);

        return view('front.account.my-order.index', compact('orders','user'));
    }

    public function myOrderDetail($id, Request $request){
        $user = $request->session()->get('customer');
        $order = Order::findOrFail($id);
        return view('front.account.my-order.detail',compact('order','user'));
    }

    public function forgot(){
        return view('front.account.forgot');
    }
    //gui mail
    public function checkForgot(Request $request){
        $users = User::where('email', '=', $request->email)->first();//trả về một bản ghi đầu tiên tìm thấy nếu không thì sẽ trả về null
        if ($users == null) {
            return back()->with('notification', 'Email không tồn tại hoặc không đúng. Vui lòng nhập lại');
        } 

        $email_to = $request->email;
        Mail::send('front.account.email', compact('users') , function ($message) use ($email_to){
            $message->from('lttt28022001@gmail.com', 'T.Tam-Shop');
            $message->to($email_to, $email_to);
            $message->subject('Đặt lại mật khẩu');
        });
        return redirect('account/login')->with('notification', 'Vui lòng kiểm tra email của bạn.');
    }

    public function otp($id){
        $users = User::findOrFail($id);
            
        return view('front.account.OTP', compact('users'));
    }

    public function checkOTP($id, Request $request){
        if($request->password != $request->password_confirmation){
            return back()->with('notification', 'Mật khẩu không trùng khớp.');
        }

        $password_h = bcrypt($request->password);
        $users = User::findOrFail($id);
        $users->update(['password' => $password_h]);
        return redirect('account/login')->with('notification', 'Đổi mật khẩu thành công!Vui lòng đăng nhập.');
    }
    
    public function information(Request $request){
        $user = $request->session()->get('customer');
        if ($request->session()->has('customer')) {
            return view('front.account.information',compact('user'));
        } else {
            return redirect('account/login')->with('notification', 'Bạn phải đăng nhập trước.');
        }
    }


    public function history(Request $request){
        //lay id cua user
        $user = $request->session()->get('customer');
        $orders = Order::where('user_id', $user->id)->get();
        // dd($orders);

        return view('front.account.history', compact('orders','user'));
    }

    public function updateInformation(Request $request){
        $data = $request->all();
        //dd($data);
        $id = $request->session()->get('customer')->id;
        $users = User::findOrFail($id);
        $users->update($data);
        return redirect()->back();
    }
}
