<?php

use App\Http\Controllers\Front;
use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Front (client)
Route::get('/', [Front\HomeController::class,'index']);

Route::prefix('shop')->group(function(){
    Route::get('/{id}', [Front\ShopController::class,'show']);
    Route::post('changeColor', [Front\ShopController::class,'changeColor'])->name('changeColor');
    Route::post('/product/{id}', [Front\ShopController::class,'postComment']);

    Route::get('/', [Front\ShopController::class,'index'])->name('shopIndex');

    Route::get('/{categoryName}', [Front\ShopController::class,'category']);
    Route::prefix('product')->group(function(){
        Route::post('/{id}', [Front\ShopController::class,'postComment']);
    });
});

//nhóm các route theo tiền tố cart
Route::prefix('cart')->group(function(){
    //dang ki route de them sp vao gio hang
    Route::post('addProduct', [Front\CartController::class,'addProduct'])->name('addProduct');
    Route::get('/', [Front\CartController::class,'index'])->name('cart');
    Route::get('deleteProduct', [Front\CartController::class,'deleteProduct'])->name('deleteProduct');
    Route::get('/destroy', [Front\CartController::class,'destroy']);
    Route::get('/update', [Front\CartController::class,'update']);
});

Route::prefix('checkout')->group(function(){

    Route::get('/', [Front\CheckOutController::class,'index'])->name('checkout');
    Route::post('/', [Front\CheckOutController::class,'addOrder']);
    Route::get('/vnPayCheck', [Front\CheckOutController::class,'vnPayCheck']); //xử lí dữ liệu trả về từ VNPay
    Route::get('/result', [Front\CheckOutController::class,'result']); 
});

Route::prefix('account')->group(function(){
    Route::get('/login', [Front\AccountController::class,'login'])->name('login');
    Route::post('/login', [Front\AccountController::class,'checkLogin'])->name('checkLogin');
    Route::get('/logout', [Front\AccountController::class,'logout']);
    Route::get('/forgot', [Front\AccountController::class,'forgot'])->name('forgot');
    Route::post('/forgot', [Front\AccountController::class,'checkForgot']);

    Route::get('/otp/{id}', [Front\AccountController::class,'otp'])->name('account.otp');
    Route::post('/otp/{id}', [Front\AccountController::class,'checkOTP']);
    Route::get('/information', [Front\AccountController::class,'information'])->name('information');
    Route::post('/updateInformation', [Front\AccountController::class,'updateInformation'])->name('updateInformation');
    Route::get('/history', [Front\AccountController::class,'history'])->name('ordersHistory');


    Route::get('/register', [Front\AccountController::class,'register'])->name('register');
    Route::post('/register', [Front\AccountController::class,'createUser']);

    Route::prefix('my-order')->group(function(){
        Route::get('/', [Front\AccountController::class,'myOrderIndex'])->name('myorder');
        Route::get('{id}', [Front\AccountController::class,'myOrderDetail'])->name('orderDetail');
    });
});


//Dashboard (Admin)
Route::prefix('admin')->middleware('CheckAdminLogin')->group(function(){
    // Route::redirect('', '/admin/order');//chuyển hướng đến admin/product mặc định
    Route::resource('dashboard', Admin\DashboardController::class);
    Route::resource('order', Admin\OrderController::class);
    Route::prefix('')->middleware('AdminLogin')->group(function(){
        Route::resource('/user', Admin\UserController::class);
    });
    Route::resource('category', Admin\ProductCategoryController::class);
    Route::resource('brand', Admin\BrandController::class);
    Route::resource('product', Admin\ProductController::class);
    Route::resource('product/{product_id}/image', Admin\ProductImageController::class);
    Route::resource('product/{product_id}/detail', Admin\ProductDetailController::class);
    Route::resource('order', Admin\OrderController::class);
    Route::resource('blog', Admin\BlogController::class);
    Route::resource('productComment', Admin\ProductCommentController::class);
    Route::post('/changeStatus', [Admin\ProductCommentController::class, 'changeStatus'])->name('changeStatus');
    

    Route::prefix('login')->group(function(){
        Route::get('', [Admin\HomeController::class,'getLogin'])->withoutMiddleware('CheckAdminLogin');
        Route::post('', [Admin\HomeController::class,'postLogin'])->withoutMiddleware('CheckAdminLogin');

    });

    Route::get('logout', [Admin\HomeController::class,'logout']);

    Route::prefix('setting')->group(function () {
        Route::get('/', [Admin\SettingController::class, 'index'])->name('setting.index');
        Route::post('/addSetting', [Admin\SettingController::class, 'addSetting'])->name('addSetting');
    });

});
