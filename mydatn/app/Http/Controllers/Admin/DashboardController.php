<?php

namespace App\Http\Controllers\Admin;

use App\Models\OrderDetail;
use App\Models\Order;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $now = Carbon::now();
        $today = $now->format('Y-m-d');
        $month = $now->month;
        $year = $now->year;
        $idsBestSeller = OrderDetail::selectRaw('order_details.product_id,SUM(order_details.qty) as amount')
        ->leftJoin('products','products.id','order_details.product_id')
        ->groupBy('order_details.product_id')
        ->orderBy('amount','desc')
        ->limit(1)->pluck('order_details.product_id')->toArray();

        $bestSellerProducts = Product::whereIn('id',$idsBestSeller )->first();

        $tongNam = OrderDetail::selectRaw('SUM(total) as tong')
                                ->whereYear('created_at',$year)->first();
                           //dd($tongNam->tong);

        $tongThang = OrderDetail::selectRaw('SUM(total) as tong')
                                ->whereMonth('created_at',$month)->first();
                                
        $tongNgay = OrderDetail::selectRaw(' SUM(total) as tong')
                                ->whereDate('created_at',$today)->first();
        
        

        $tongDHang = Order::selectRaw('COUNT(id) as tong')
                            ->whereMonth('created_at',$month)->first();
     
        //dd($tongDHang);
        //dd($bestSellerProducts);
        return view('admin.dashboard.index',compact('tongNam','bestSellerProducts','tongThang','tongDHang','tongNgay'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
