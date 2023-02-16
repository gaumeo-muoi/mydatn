@extends('front.layout.master')
@section('title','Cart')
@section('body')
<section class="page-header">
	<div class="overly"></div> 	
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-6">
				<div class="content text-center">
					<h1 class="mb-3">Cart</h1>
					<p>Hath after appear tree great fruitful green dominion moveth sixth abundantly image that midst of god day multiply you’ll which</p>

				<nav aria-label="breadcrumb">
				  <ol class="breadcrumb bg-transparent justify-content-center">
				    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
				    <li class="breadcrumb-item active" aria-current="page">Cart</li>
				  </ol>
				</nav>
				</div>
			</div>
		</div>
	</div>
</section>



  <section class="cart shopping page-wrapper">
    <div class="container">
      @if(Cart::count() > 0)
      <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="product-list">
              <form class="cart-form" action="#" method="post">
                  <table class="table shop_table shop_table_responsive cart" cellspacing="0">
                      <thead>
                        <tr>
                            <th class="product-thumbnail">&nbsp;</th>
                            <th class="product-name">Product</th>
                            <th class="product-price">Price</th>
                            <th class="product-quantity">Quantity</th>
                            <th class="product-subtotal">Total</th>
                            <th class="product-remove">&nbsp;</th>
                        </tr>
                      </thead>

                      <tbody>
                        {{-- <tr class="cart_item">
                            <td class="product-thumbnail" data-title="Thumbnail">
                                <a href="#"><img src="images/shop/cart/cart-1.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt=""></a>
                            </td>

                            <td class="product-name" data-title="Product">
                                <a href="#">Trendy Cloth</a>
                            </td>

                            <td class="product-price" data-title="Price">
                                <span class="amount"><span class="currencySymbol">$</span>90.00</span>
                            </td>

                            <td class="product-quantity" data-title="Quantity">
                                <div class="quantity">
                                    <label class="sr-only" >Quantity</label>

                                    <input type="number" id="qty" class="input-text qty text" step="1" min="0" max="9" value="1" title="Qty" size="4"  >
                                </div>
                            </td>
                            <td class="product-subtotal" data-title="Total">
                                <span class="amount">
                                  <span class="currencySymbol">$</span>90.00</span>
                            </td>

                             <td class="product-remove" data-title="Remove">
                                <a href="#" class="remove" aria-label="Remove this item" data-product_id="30" data-product_sku="">×</a>           
                            </td>
                        </tr> --}}
                        @foreach($carts as $cart)
                        <tr id="rowCart-{{ $cart->rowId }}" class="cart_item">

                            <td class="product-thumbnail" data-title="Thumbnail">
                                <img src="front/images/shop/products/{{$cart->options->images[0]->path ?? ''}}" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="">
                            </td>

                            <td class="product-name" data-title="Product">
                              <p>{{$cart->name}} - {{$cart->options->color}} - {{$cart->options->size}}</p>
                            </td>

                            <td class="product-price" data-title="Price">
                                <span class="amount"><span class="currencySymbol">{{ number_format($cart->price) }} VND</span>
                            </td>

                            
                            <td class="product-quantity" data-title="Quantity">
                                {{-- <div class="quantity">
                                    <label class="sr-only" >Quantity</label>
                                    <input type="number" data-rowid="{{ $cart->rowId }}" value="{{ $cart->qty }}" id="quantity_5cc58182489a8" class="input-text qty text" step="1" min="0" max="9" name="#" value="1" title="Qty" size="4">
                                  </div> --}}
                                  <div class="quantity">
                                    <div class="pro-qty">
                                      <input type="text" value="{{ $cart->qty }}" data-rowid="{{ $cart->rowId }}">
                                    </div>
                                  </div>
                            </td>
                            <td class="product-subtotal" data-title="Total">
                                <span class="amount">
                                  <span id="totalProduct-{{ $cart->rowId }}" class="currencySymbol">{{ number_format($cart->price * $cart->qty) }} VND</span>
                            </td>
                            <td style="width: 80px;text-align: center" class="product-remove close-td first-row" data-title="Remove">
                              {{-- <a href="#" class="remove ti-close detele-product" aria-label="Remove this item" data-rowid="{{ $cart->rowId }}" >×</a> --}}
                              <p style="color: orange" data-rowid="{{ $cart->rowId }}" class="remove ti-close detele-product">X</p>          
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="6" class="actions">
                                <div class="coupon">
                                  <input type="text" name="coupon_code" class="input-text form-control" id="coupon_code" value="" placeholder="Coupon code"> 

                                  <button type="submit" class="btn btn-black btn-small" name="apply_coupon" value="Apply coupon">Apply coupon</button>

                                  <span class="float-right mt-3 mt-lg-0">
                                    <button type="submit" class="btn btn-dark btn-small" name="update_cart" value="Update cart" disabled="">Update cart</button>
                                  </span>
                                </div>

                                <input type="hidden" id="woocommerce-cart-nonce" name="woocommerce-cart-nonce" value="27da9ce3e8">
                                <input type="hidden" name="_wp_http_referer" value="/cart/">        
                              </td>
                        </tr>
                      </tbody>
                  </table>
              </form>
          </div>
        </div>
      </div>

        <div class="row justify-content-end">
          <div class="col-lg-4">
            <div class="cart-info card p-4 mt-4">
                <h4 class="mb-4">Cart totals</h4>

                <ul class="list-unstyled mb-4">
                  <li class="d-flex justify-content-between pb-2 mb-3">
                    <h5>Subtotal</h5>
                    <span id="subtotal">{{number_format($subtotal)}} VND</span>
                  </li>

                   <li class="d-flex justify-content-between pb-2 mb-3">
                    <h5>Shipping</h5>
                    <span>Free</span>
                  </li>

                   {{-- <li class="d-flex justify-content-between pb-2">
                    <h5>Total</h5>
                    <span id="subtotal">{{number_format($subtotal)}} VND</span>
                  </li> --}}
                </ul>
                <a href="{{route('checkout')}}" class="btn btn-main btn-small">Proceed to checkout</a>
            </div>
          </div>
        </div>
        @else
          <h4 style="text-align: center">Không có sản phẩm trong giỏ hàng!!</h4>
        @endif
      </div>
  </section>

@endsection