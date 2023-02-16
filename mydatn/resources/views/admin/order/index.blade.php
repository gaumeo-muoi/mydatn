@extends('admin.layout.master')
@section('body')

                <!-- Main -->
                <div class="app-main__inner">
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="pe-7s-ticket icon-gradient bg-mean-fruit"></i>
                                </div>
                                <div>
                                    Order
                                    <div class="page-title-subheading">
                                        View, create, update, delete and manage.
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    @include('admin.components.notification')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="main-card mb-3 card">

                                <div class="card-header">

                                    <form action="">
                                        <div class="input-group">
                                            <input type="search" name="search" id="search" value="{{request('search')}}"
                                                placeholder="Search everything" class="form-control">
                                            <span class="input-group-append">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fa fa-search"></i>&nbsp;
                                                    Search
                                                </button>
                                            </span>
                                        </div>
                                    </form>

                                    <div class="btn-actions-pane-right">
                                        <div role="group" class="btn-group-sm btn-group">
                                            <button class="btn btn-focus">This week</button>
                                            <button class="active btn btn-focus">Anytime</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-center">ID</th>
                                                <th>Customer / Products</th>
                                                <th class="text-center">Address</th>
                                                <th class="text-center">Amount</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($orders as $order)
                                            @foreach($order->orderDetails as $orderDetail)
                                            <tr>
                                                <td class="text-center text-muted">#{{$order->id}}</td>
                                                <td>
                                                    <div class="widget-content p-0">
                                                        <div class="widget-content-wrapper">
                                                            <div class="widget-content-left mr-3">
                                                                <div class="widget-content-left">
                                                                    <img style="height: 60px;"
                                                                        data-toggle="tooltip" title="Image"
                                                                        data-placement="bottom"
                                                                        
                                                                        @foreach ($orderDetail->product->productImages as $key)
                                                                        src="front/img/product/{{$key->path}}" alt="{{ $key->path }}">
                                                                        @endforeach
                                                                        
                                                                    </div>
                                                            </div>
                                                            <div class="widget-content-left flex2">
                                                                <div class="widget-heading">{{$order->first_name . ' ' . $order->last_name}}</div>
                                                                <div class="widget-subheading opacity-7">
                                                                    {{$orderDetail->product->name}}
                                                                    @if(count($order->orderDetails) > 1)
                                                                        (and {{count($order->orderDetails)}} other products)
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    {{$order->street_address . ' ' . $order->town_city}}
                                                </td>
                                                <td class="text-center">{{array_sum(array_column($order->orderDetails->toArray(), 'total') )}}</td>
                                                <td class="text-center">
                                                    @switch($order->status)
                                                        @case(1)
                                                        <div class="badge badge-dark" style="background-color: #66cd00">
                                                            {{ \App\Utilities\Constant::$order_status[$order->status]}}
                                                        </div>
                                                            @break
                                                        @case(2)
                                                        <div class="badge badge-dark" style="background-color: #ff7f24">
                                                            {{ \App\Utilities\Constant::$order_status[$order->status]}}
                                                        </div>
                                                            @break
                                                        @case(3)
                                                            <div class="badge badge-dark" style="background-color: #00cdcd">
                                                                {{ \App\Utilities\Constant::$order_status[$order->status]}}
                                                            </div>
                                                            @break
                                                            @case(4)
                                                            <div class="badge badge-dark" style="background-color: 	#ffb90f">
                                                                {{ \App\Utilities\Constant::$order_status[$order->status]}}
                                                            </div>
                                                            @break
                                                            @case(5)
                                                            <div class="badge badge-dark" style="background-color: 	#556b2f">
                                                                {{ \App\Utilities\Constant::$order_status[$order->status]}}
                                                            </div>
                                                            @break
                                                            @case(6)
                                                            <div class="badge badge-dark" style="background-color: 	#9a32cd">
                                                                {{ \App\Utilities\Constant::$order_status[$order->status]}}
                                                            </div>
                                                            @break
                                                            @case(7)
                                                            <div class="badge badge-dark" style="background-color: #cd1076">
                                                                {{ \App\Utilities\Constant::$order_status[$order->status]}}
                                                            </div>
                                                            @break

                                                        @default
                                                        <div class="badge badge-dark" style="background-color: red">
                                                            {{ \App\Utilities\Constant::$order_status[$order->status]}}
                                                        </div>
                                                    @endswitch
                                                    
                                                </td>
                                                <td class="text-center">
                                                    <a href="./admin/order/{{$order->id}}"
                                                        class="btn btn-hover-shine btn-outline-primary border-0 btn-sm">
                                                        Details
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="./admin/order/{{$order->id}}/edit" data-toggle="tooltip" title="Edit"
                                                        data-placement="bottom" class="btn btn-outline-warning border-0 btn-sm">
                                                        <span class="btn-icon-wrapper opacity-8">
                                                            <i class="fa fa-edit fa-w-20"></i>
                                                        </span>
                                                    </a>
                                                    
                                                </td>
                                            </tr>
                                            @endforeach
                                            @endforeach
                                            
                                        </tbody>
                                    </table>
                                </div>

                                <div class="d-block card-footer">
                                    {{$orders->appends(request()->all())->links()}}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Main -->

@endsection