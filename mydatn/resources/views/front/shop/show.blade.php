@extends('front.layout.master')
@section('title', 'Product detail')

@section('body')

<section class="page-header">
	<div class="overly"></div> 	
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-6">
				<div class="content text-center">
					<h1 class="mb-3">Product Single</h1>
					<p>Hath after appear tree great fruitful green dominion moveth sixth abundantly image that midst of god day multiply you’ll which</p>

				<nav aria-label="breadcrumb">
				  <ol class="breadcrumb bg-transparent justify-content-center">
				    <li class="breadcrumb-item"><a href="/">Home</a></li>
				    <li class="breadcrumb-item active" aria-current="page">Product Single</li>
				  </ol>
				</nav>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="single-product">
	<div class="container">
		<div class="row">
			
			<div class="col-md-5">
				<div class="single-product-slider">
					<div class="carousel slide" data-ride="carousel" id="single-product-slider">
						<div class="carousel-inner">
							<div class="carousel-item active">
								<img src="front/images/shop/products/{{$product->productImages[0]->path ?? ''}}" alt="" class="img-fluid">
							</div>
							<div class="carousel-item">
								<img src="front/images/shop/products/{{$product->productImages[1]->path ?? ''}}" alt="" class="img-fluid">
							</div>
							<div class="carousel-item ">
								<img src="front/images/shop/products/{{$product->productImages[2]->path ?? ''}}" alt="" class="img-fluid">
							</div>
						</div>

						<ol class="carousel-indicators">
						    <li data-target="#single-product-slider" data-slide-to="0" class="active">
						    	<img src="front/images/shop/products/{{$product->productImages[0]->path ?? ''}}" alt="" class="img-fluid">
						    </li>
						    <li data-target="#single-product-slider" data-slide-to="1">
						    	<img src="front/images/shop/products/{{$product->productImages[1]->path ?? ''}}" alt="" class="img-fluid">
						    </li>
						    <li data-target="#single-product-slider" data-slide-to="2">
						    	<img src="front/images/shop/products/{{$product->productImages[2]->path ?? ''}}" alt="" class="img-fluid">
						    </li>
						</ol>
					</div>
				</div>
			</div>
			
			<div class="col-md-7">
				<div class="single-product-details mt-5 mt-lg-0">
					<h2>{{$product->name}}</h2>
					<input id="product_id" type="hidden" value="{{$product->id}}">
					<div class="sku_wrapper mb-4">
						SKU: <span class="text-muted">{{$product->sku}}</span>
					</div>

					<hr>
					
					<h3 class="product-price">
						@if($product->discount != null)
						{{number_format($product->discount)}} VND
						<span style="color: #555555;"><del>{{number_format($product->price)}} VND</del></span>
						@else
						{{number_format($product->price)}} VND
						@endif</h3>
					
					<p class="product-description my-4 ">
						{{$product->content}}					
					</p>


					<div class="colors">
						<span class="font-weight-bold text-capitalize product-meta-title">color:</span>
						@foreach($productColors as $key => $productColor)
							<div class="cc-item">	
								<input {{$check = ($key==0)? "checked" : ""}} type="radio" id="cc-{{ $productColor->color}}" name="color" value="{{$productColor->color}}">
									<label  data-color="{{ $productColor->color}}" class="color {{$check = ($key==0)? "product-color-active" : ""}}" for="cc-{{ $productColor->color}}" style="background-color: {{$productColor->color}}">
								</label>
							</div>
						@endforeach
					</div>

					<div id="sizes" class="sizes">
						<span style="margin-right:88px" class="font-weight-bold text-capitalize product-meta-title">Size:</span>
						@foreach($productSizes as $key=>$productSize)
							<div class="sc-item">	
								<input {{$check = ($key==0)? "checked" : ""}} type="radio" id="sm-{{ $productSize->size}}" name="size" value="{{$productSize->size}}">
									<label data-size="{{ $productSize->size}}" class="size {{$check = ($key==0)? "product-size-active" : ""}}" for="sm-{{ $productSize->size}}">{{$productSize->size}}</label>
							</div>
						@endforeach
					</div>

					<div class="products-meta mt-4">
						<div class="product-category d-flex align-items-center">
							<span class="font-weight-bold text-capitalize product-meta-title">Categories :</span>
							<a href="#">Products , </a>
							<a href="#">{{$product->tag}}</a>
						</div>

						{{-- <div class="product-share mt-5">
							<ul class="list-inline">
								<li class="list-inline-item">
									<a href="#"><i class="tf-ion-social-facebook"></i></a>
								</li>
								<li class="list-inline-item">
									<a href="#"><i class="tf-ion-social-twitter"></i></a>
								</li>
								<li class="list-inline-item">
									<a href="#"><i class="tf-ion-social-linkedin"></i></a>
								</li>
								<li class="list-inline-item">
									<a href="#"><i class="tf-ion-social-pinterest"></i></a>
								</li>
							</ul>
						</div> --}}
						{{-- <form class="cart" action="#" method="post"> --}}
							<div class="quantity d-flex align-items-center">
								{{-- <input type="number" id="#" class="input-text qty text form-control w-25 mr-3" step="1" min="1" max="9" name="quantity" value="1" title="Qty" size="4" > --}}
								<i data-size="{{$productSizes[0]['size']}}" data-color="{{$productColors[0]['color']}}" style="cursor: pointer" data-id="{{ $product->id }}" class="btn btn-main btn-small btn-buy">Add to cart</i>
							</div>
						{{-- </form> --}}
					</div>
				</div>
			</div>
		</div>

		
		<div class="row">
			<div class="col-lg-12">
				<nav class="product-info-tabs wc-tabs mt-5 mb-5">
				  <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
				    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Description</a>
				    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Additional Information</a>
				    <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Reviews({{ count($comments)}})</a>
				  </div>
				</nav>

				<div class="tab-content" id="nav-tabContent">
				  <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
					<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>

					<h4>Product Features</h4>

					<ul class="">
						<li>{{$product->description}}</li>
						<li>Embossed Taffeta Lining</li>
						<li>DRYRIDE Durashell™ 2-Layer Oxford Fabric [10,000MM, 5,000G]</li>
					</ul>

				  </div>
				  <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
					
					<ul class="list-unstyled info-desc">
					  <li class="d-flex">
					    <strong>Weight </strong>	
					    <span>400 g</span>
					  </li>
					  <li class="d-flex">
					    <strong>Dimensions </strong>
					    <span>10 x 10 x 15 cm</span>
					  </li>
					  <li class="d-flex">
					    <strong>Materials</strong>
					    <span >60% cotton, 40% polyester</span>
					  </li>
					  <li class="d-flex">
					    <strong>Color </strong>
					    <span>
							@foreach(array_unique(array_column($product->productDetails->toArray(),'color')) as $productColor)
							{{$productColor}}, 
							@endforeach
						</span>
					  </li>
					  <li class="d-flex">
					    <strong>Size</strong>
					    <span>
							@foreach(array_unique(array_column($product->productDetails->toArray(),'size')) as $productSize)
							{{$productSize}},
							@endforeach
						</span>
					  </li>
					</ul>
				  </div>
				  <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
					<div class="row">
						<div class="col-lg-7">
							@foreach($comments as $comment)
								<div class="media review-block mb-4">
									<img src="front/img/user/{{ $comment->user->avatar ?? 'no-images.jpg'}}" alt="reviewimg" class="img-fluid mr-4">
									<div class="media-body">
										<div class="product-review">
											<span>@for($i = 1; $i <= 5; $i++)
												@if($i <= $comment->rating)
												<i class="tf-ion-android-star"></i></i>
												@else
													<i class="tf-ion-android-star-outline"></i>
												@endif
												@endfor 
											</span>
										</div>
										<h6>{{ $comment->user->name}}<span class="text-sm text-muted font-weight-normal ml-3">- {{ date('M d, Y', strtotime($comment->updated_at)) }}</span></h6>
										<p>{{ $comment->messages }}</p>
									</div>	
								</div>
							@endforeach
						</div>


						<div class="col-lg-5">
							<div class="review-comment mt-5 mt-lg-0">
								@if(($checkComment > 0))
							<div class="review_box">
								@if(session('notification'))
							<div class="alert alert-warning" role="alert">
								{{ session('notification')}}
							</div>
								@endif
								<h4 class="mb-3">Add a Review</h4>

								<form action="#">
									<div class="starrr"></div>
									<div class="form-group">
										<input type="text" class="form-control" placeholder="Your Name">
									</div>
									<div class="form-group">
										<input type="email" class="form-control" placeholder="Your Email">
									</div>
									<div class="form-group">
										<textarea name="comment" id="comment" class="form-control" cols="30" rows="4" placeholder="Your Review"></textarea>
									</div>

									<a href="#" class="btn btn-main btn-small">Submit Review</a>
								</form>
								@else
								<p>Không thể bình luận.</p>
								@endif
							</div>
						</div>
					</div>
				  </div>
				</div>
			</div>
		</div>
	</div>
</section>


<section class="products related-products section">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-6">
				<div class="title text-center">
					<h2>You may like this</h2>
					<p>The best Online sales to shop these weekend</p>
				</div>
			</div>
		</div>
		<div class="row">
			@foreach($relatedProducts as $relatedProduct)
			 <div class="col-lg-3 col-6" >
		      	<div class="product">
					<div class="product-wrap">
						<a href="product-single.html"><img class="img-fluid w-100 mb-3 img-first" src="front/images/shop/products/{{$relatedProduct->productImages[0]->path ?? ''}}" alt="product-img" /></a>
						<a href="product-single.html"><img class="img-fluid w-100 mb-3 img-second" src="front/images/shop/products/{{$relatedProduct->productImages[1]->path ?? ''}}" alt="product-img" /></a>
					</div>

					@if($relatedProduct->discount != null)
						<span class="onsale">Sale</span>
					{{-- @else
						<span class="onsale">New</span> --}}
					@endif
					<div class="product-hover-overlay">
						<a href="#"><i class="tf-ion-android-cart"></i></a>
						<a href="#"><i class="tf-ion-ios-heart"></i></a>
			      	</div>

					<div class="product-info">
				<h2 class="product-title h5 mb-0"><a href="product-single.html">{{$relatedProduct->name}}</a></h2>
						<span class="price">
							@if($relatedProduct->discount != null)
							{{number_format($relatedProduct->discount)}} VND
							<span><del style="color: #555555;">{{number_format($relatedProduct->price)}} VND</del></span>
							@else
							{{number_format($relatedProduct->price)}} VND
							@endif
						</span>
					</div>
				</div>
		     </div>
			 @endforeach
			
		</div>
	</div>
</section>

<script>
	function getLink() {
	let size = $("input[type='radio'][name='size']:checked").val();
	let color = $("input[type='radio'][name='color']:checked").val();
	 $("#buy").attr("href", "./cart/add/" + {{ $product->id }}  + "?size=" + size + "&color=" + color);
  }

  $("input[type=radio]").change(function () { 
	getLink();
  });
  
  $(".color").click(function () {
	$('.product-color-active').removeClass("product-color-active");
	var color = $(this).attr('data-color');
	$('.btn-buy').attr('data-color',color) 
	var product_id = $('#product_id').val();
	$(this).addClass("product-color-active");
	$.ajax({
		type:'POST',
		url:"{{ route('changeColor') }}",
		data:{'color' : color,
				'product_id' : product_id
			},
		success: function (result) {
			$('#sizes').html(result.htmlSize);
		},
	})
  });
  $('body').on('click', '.size', function () {
	var size = $(this).attr('data-size');
	$('.btn-buy').attr('data-size',size) 
	$('.product-size-active').removeClass("product-size-active");
	$(this).addClass("product-size-active");
  });

  
</script>

@endsection