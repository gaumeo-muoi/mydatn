@extends('front.layout.master')
@section('title', 'Shop')

@section('body')

<section class="page-header">
	<div class="overly"></div> 	
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-6">
				<div class="content text-center">
					<h1 class="mb-3">Shop</h1>
					<p>Hath after appear tree great fruitful green dominion moveth sixth abundantly image that midst of god day multiply you’ll which</p>

				<nav aria-label="breadcrumb">
				  <ol class="breadcrumb bg-transparent justify-content-center">
				    <li class="breadcrumb-item"><a href="/">Home</a></li>
				    <li class="breadcrumb-item active" aria-current="page">Shop</li>
				  </ol>
				</nav>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="products-shop section">
	<div class="container">
		<div class="row">
			<div class="col-md-9">
				<div class="row align-items-center">
					<div class="col-lg-12 mb-4 mb-lg-0">
						<div class="section-title">
								<h2 class="d-block text-left-sm">Shop</h2>

								<div class="heading d-flex justify-content-between mb-5">
									<p class="result-count mb-0"> </p>
									<form class="ordering " method="get">
											<select name="sort_by" onchange="this.form.submit();" class="orderby form-control" aria-label="Shop order" >
												<option {{ request('sort_by') == 'latest' ? 'selected' : '' }} value="latest">Sorting : Mới nhất</option>
												<option {{ request('sort_by') == 'oldest' ? 'selected' : '' }} value="oldest">Sorting : Cũ Nhất</option>
												<option {{ request('sort_by') == 'name-ascending' ? 'selected' : '' }} value="name-ascending">Sorting : Name A-Z</option>
												<option {{ request('sort_by') == 'name-descending' ? 'selected' : '' }} value="name-descending">Sorting : Name Z-A</option>
												<option {{ request('sort_by') == 'price-ascending' ? 'selected' : '' }} value="price-ascending">Sorting : Giá tăng dần</option>
												<option {{ request('sort_by') == 'price-descending' ? 'selected' : '' }} value="price-descending">Sorting : Giá giảm dần</option>
											</select>
											<input type="hidden" name="paged" value="1">
									</form>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					@foreach($products as $product)
					<div class="col-lg-4 col-12 col-md-6 col-sm-6 mb-5" >
						<div class="product">
							<div class="product-wrap">
								<a href="shop/{{$product->id}}"><img class="img-fluid w-100 mb-3 img-first" src="front/images/shop/products/{{$product->productImages[0]->path ?? ''}}" alt="product-img" /></a>
								<a href="shop/{{$product->id}}"><img class="img-fluid w-100 mb-3 img-second" src="front/images/shop/products/{{$product->productImages[1]->path ?? ''}}" alt="product-img" /></a>
							</div>

							@if($product->discount != null)
								<span class="onsale">Sale</span>
							@endif
							<div class="product-hover-overlay">
								<a href=""><i data-size="{{$product->getDefaultSize()}}" data-color="{{$product->getDefaultColor()}}" data-id="{{ $product->id }}" class="tf-ion-android-cart btn-buy"></i></a>
								<a href="#"><i class="tf-ion-ios-heart"></i></a>
							</div>

							<div class="product-info">
								<h2 class="product-title h5 mb-0"><a href="shop/{{$product->id}}">{{$product->name}}</a></h2>
								<span class="price">
									@if($product->discount != null)
										{{number_format($product->discount)}} VND
										<span style="color: #555555;"><del>{{number_format($product->price)}} VND</del></span>
										@else
										{{number_format($product->price)}} VND
									@endif
								</span>
							</div>
						</div>
					</div>
					@endforeach
					{{ $products->links() }}


					{{-- <div class="col-12">
						<nav aria-label="Page navigation">
							<ul class="pagination">
								<li class="page-item">
									<a class="page-link" href="#" aria-label="Previous">
										<span aria-hidden="true">&laquo;</span>
									</a>
								</li>
								<li class="page-item active"><a class="page-link" href="#">1</a></li>
								<li class="page-item"><a class="page-link" href="#">2</a></li>
								<li class="page-item"><a class="page-link" href="#">3</a></li>
								<li class="page-item">
									<a class="page-link" href="#" aria-label="Next">
										<span aria-hidden="true">&raquo;</span>
									</a>
								</li>
							</ul>
						</nav>
					</div> --}}
				</div>				
			</div>
			<div class="col-md-3">
				<!-- categories -->
<section class="widget widget-categories mb-5">
	<h3 class="widget-title h4 mb-4">Categories</h3>
	<form action="">
	<ul>
		
		@foreach($categories as $category)
		<li class="has-children" value={{$category->id}}><a>{{$category->name}}</a><span>(1138)</span>
			@if($category->chils)
				@foreach($category->chils as $chil)
				<ul>
					<li><a href="shop/{{$chil->name}}">{{$chil->name}}</a><span>(508)</span></li>
				</ul>
                @endforeach
            @endif
			{{-- <ul>
				<li><a href="#">Women's</a><span>(508)</span>
					<ul>
						<li><a href="#">Sneakers</a></li>
						<li><a href="#">Heels</a></li>
						<li><a href="#">Loafers</a></li>
						<li><a href="#">Sandals</a></li>
					</ul>
				</li>
				<li><a href="#">Men's</a><span>(423)</span>
					<ul>
						<li><a href="#">Boots</a></li>
						<li><a href="#">Oxfords</a></li>
						<li><a href="#">Loafers</a></li>
						<li><a href="#">Sandals</a></li>
					</ul>
				</li>
				<li><a href="#">Boy's Shoes</a><span>(97)</span></li>
				<li><a href="#">Girl's Shoes</a><span>(110)</span></li>
			</ul> --}}
		</li>
		@endforeach
	</ul>
	</form>
</section>


<!-- color and size -->
<form action="#" class="mb-5">

	<!-- price range -->
	<section id="#" class="widget widget_price_filter mb-5">
		<h3 class="widget-title h4 mb-4">Filter by price</h3>
		<div class="price_slider_wrapper">
			<div class="price_slider_amount" data-step="10">
				<input class="range-track" type="text" data-slider-min="0" data-slider-max="1000" data-slider-step="5"
					data-slider-value="[0,300]" />
				<div class="price_label mb-3">
					Price: <span class="value">$0 - $300</span>
				</div>
			</div>
		</div>
	</section>
	<!-- color -->
	<section class="widget widget-colors mb-5">
		<h3 class="widget-title h4 mb-4">Shop by color</h3>
		<ul class="list-inline">
			<li class="list-inline-item mr-4">
				<div class="custom-control custom-checkbox color-checkbox">
					<input type="checkbox" class="custom-control-input" id="color1">
					<label class="custom-control-label sky-blue" for="color1"></label>
				</div>
			</li>
			<li class="list-inline-item mr-4">
				<div class="custom-control custom-checkbox color-checkbox">
					<input type="checkbox" class="custom-control-input" id="color2" checked>
					<label class="custom-control-label red" for="color2"></label>
				</div>
			</li>
			<li class="list-inline-item mr-4">
				<div class="custom-control custom-checkbox color-checkbox">
					<input type="checkbox" class="custom-control-input" id="color3">
					<label class="custom-control-label dark" for="color3"></label>
				</div>
			</li>
			<li class="list-inline-item mr-4">
				<div class="custom-control custom-checkbox color-checkbox">
					<input type="checkbox" class="custom-control-input" id="color4">
					<label class="custom-control-label magenta" for="color4"></label>
				</div>
			</li>
			<li class="list-inline-item mr-4">
				<div class="custom-control custom-checkbox color-checkbox">
					<input type="checkbox" class="custom-control-input" id="color5">
					<label class="custom-control-label yellow" for="color5"></label>
				</div>
			</li>
		</ul>
	</section>

	<!-- size -->
	<section class="widget widget-sizes mb-5">
		<h3 class="widget-title h4 mb-4">Shop by Sizes</h3>
		<div class="custom-control custom-checkbox">
			<input type="checkbox" class="custom-control-input" id="size1" checked>
			<label class="custom-control-label" for="size1">L Large</label>
		</div>
		<div class="custom-control custom-checkbox">
			<input type="checkbox" class="custom-control-input" id="size2">
			<label class="custom-control-label" for="size2">XL Extra Large</label>
		</div>
		<div class="custom-control custom-checkbox">
			<input type="checkbox" class="custom-control-input" id="size3">
			<label class="custom-control-label" for="size3">M Medium</label>
		</div>
		<div class="custom-control custom-checkbox">
			<input type="checkbox" class="custom-control-input" id="size4">
			<label class="custom-control-label" for="size4">S Small</label>
		</div>
		<div class="custom-control custom-checkbox">
			<input type="checkbox" class="custom-control-input" id="size5">
			<label class="custom-control-label" for="size5">XS Extra Small</label>
		</div>
	</section>

	<button type="submit" class="btn btn-black btn-small">Filter</button>
</form>

			<!-- popular product -->
			<section class="widget widget-popular mb-5">
				<h3 class="widget-title mb-4 h4">Popular Products</h3>
				<a class="popular-products-item media" href="product-single.html">
					<img src="images/shop/p-1.jpg" alt="" class="img-fluid mr-4">
					<div class="media-body">
						<h6>Contrast <br>Backpack</h6>
						<span class="price">$45</span>
					</div>
				</a>

				<a class="popular-products-item media" href="product-single.html">
					<img src="images/shop/p-2.jpg" alt="" class="img-fluid mr-4">
					<div class="media-body">
						<h6>Hoodie with <br>Logo</h6>
						<span class="price">$45</span>
					</div>
				</a>

				<a class="popular-products-item media" href="product-single.html">
					<img src="images/shop/p-3.jpg" alt="" class="img-fluid mr-4">
					<div class="media-body">
						<h6>Traveller<br>Backpack</h6>
						<span class="price">$45</span>
					</div>
				</a>
			</section>
			</div>
		</div>
	</div>
</section>
@endsection



