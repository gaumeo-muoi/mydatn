<?php 
    $orders = App\Models\Order::All();
    $users = App\Models\User::All();
    $products = App\Models\Product::All();
    $blogs = App\Models\Blog::All();
    $categories = App\Models\ProductCategory::All();
    $brands = App\Models\Brand::All();

?>
@extends('admin.layout.master')

@section('body')

    <!-- Main -->
    @if(session('notification'))
							<div class="alert alert-warning" role="alert">
								{{ session('notification')}}
							</div>
						@endif
    
    <div class="app-main__inner">

            <h6 class="card-title">Tổng doanh thu hôm nay: {{$tongNgay->tong}} VND.</h6>
            <h6 class="card-title">Tổng doanh thu theo tháng này: {{$tongThang->tong}} VND.</h6>
            <h6 class="card-title">Số đơn hàng tháng này: {{$tongDHang->tong}} đơn hàng.</h6>
            <h6 class="card-title">Sản phẩm bán chạy nhất trong tháng: {{$bestSellerProducts->name}}.</h6>
            <h6 class="card-title">Tổng doanh thu năm nay: {{$tongNam->tong}} VND.</h6><br>
                    

        <div class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                        <div class="row">
                            <div class="col-sm-4">
                              <div class="card card-dashboard">
                                <div class="card-body">
                                  <h5 class="card-title text-center">Orders</h5>
                                  <p class="card-text">{{count($orders)}}</p>
                                  <a href="./admin/order" class="btn btn-primary">Detail</a>
                                </div>
                              </div>
                            </div>
                            <div class="col-sm-4">
                              <div class="card card-dashboard">
                                <div class="card-body">
                                  <h5 class="card-title text-center">Products</h5>
                                  <p class="card-text">{{count($products)}}</p>
                                  <a href="./admin/product" class="btn btn-primary">Detail</a>
                                </div>
                              </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="card card-dashboard">
                                  <div class="card-body">
                                    <h5 class="card-title text-center">Users</h5>
                                    <p class="card-text">{{count($users)}}</p>
                                    <a href="./admin/user" class="btn btn-primary">Detail</a>
                                  </div>
                                </div>
                              </div>
                        </div>
                </div>
            </div>
        
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="row">
                        <div class="col-sm-4">
                        <div class="card card-dashboard">
                            <div class="card-body">
                            <h5 class="card-title text-center">Blogs</h5>
                            <p class="card-text">{{count($blogs)}}</p>
                            <a href="./admin/blog" class="btn btn-primary">Detail</a>
                            </div>
                        </div>
                        </div>
                        <div class="col-sm-4">
                        <div class="card card-dashboard">
                            <div class="card-body">
                            <h5 class="card-title text-center">Category</h5>
                            <p class="card-text">{{count($categories)}}</p>
                            <a href="./admin/category" class="btn btn-primary">Detail</a>
                            </div>
                        </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="card card-dashboard">
                            <div class="card-body">
                                <h5 class="card-title text-center">Brand</h5>
                                <p class="card-text">{{count($brands)}}</p>
                                <a href="./admin/brand" class="btn btn-primary">Detail</a>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Main -->

@endsection