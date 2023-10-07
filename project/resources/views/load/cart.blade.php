@if(Session::has('cart'))
<div id="cart-drawer" class="block block-cart">
<div class="minicart-header">
<a href="javascript:void(0);" class="close-cart" data-bs-dismiss="modal" aria-label="Close"><i class="an an-times-r" aria-hidden="true" data-bs-toggle="tooltip" data-bs-placement="left" title="Close"></i></a>
<h4 class="fs-6">Your cart (<span class="cart-quantity">{{ Session::has('cart') ? count(Session::get('cart')->items) : '0' }} </span>Items)</h4>
</div>
<div class="minicart-content">
<ul class="clearfix dropdown-cart-products">
@php
$category_id= array();
$subcategory_id= array();
$childcategory_id= array();
$product_cart_id= array();
@endphp
@foreach(Session::get('cart')->items as $product)
@php
$cat = DB::table('products')->where('id',$product['item']['id'])->get();
$product_cart_id[] =  $product['item']['id'];
@endphp
@foreach ($cat as $catv)
@php 
$category_id[] =  $catv->category_id;
$subcategory_id[] =  $catv->subcategory_id;
$childcategory_id[] =  $catv->childcategory_id;
@endphp
@endforeach
<li class="item d-flex-custom justify-content-center align-items-center product cremove{{ $product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values']) }}">
<a class="product-image" href="{{ route('front.product', $product['item']['slug']) }}">
<img class="blur-up lazyload" src="{{ $product['item']['photo'] ? filter_var($product['item']['photo'], FILTER_VALIDATE_URL) ?$product['item']['photo']:asset('assets/images/products/'.$product['item']['photo']):asset('assets/images/noimage.png') }}" data-src="{{ $product['item']['photo'] ? filter_var($product['item']['photo'], FILTER_VALIDATE_URL) ?$product['item']['photo']:asset('assets/images/products/'.$product['item']['photo']):asset('assets/images/noimage.png') }}" alt="image" title="">
</a>
<div class="product-details">
<a class="product-title" href="{{ route('front.product',$product['item']['slug']) }}">{{mb_strlen($product['item']['name'],'utf-8') > 45 ? mb_substr($product['item']['name'],0,45,'utf-8').'...' : $product['item']['name']}}</a>
<div class="variant-cart">{{ $product['item']['measure'] }}</div>
<div class="priceRow">
<div class="product-price">
<span class="money" id="prct{{$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])}}">{{ App\Models\Product::convertPrice($product['item_price']) }}</span>
</div>
</div>
</div>
<div class="qtyDetail text-center">
<div class="wrapQtyBtn">
<div class="qtyField">
<input type="text" name="quantity" value="{{$product['qty']}}" class="qty" readonly>
</div>
</div>
<!-- <a href="#" class="edit-i remove"><i class="icon an an-edit-l" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"></i></a> -->
<a href="javascript:;" class="cart-remove remove" data-class="cremove{{ $product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values']) }}" data-href="{{ route('product.cart.remove',$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])) }}" title="Remove Product"><i class="an an-times-r" data-bs-toggle="tooltip" data-bs-placement="top" title="Remove"></i></a>
</div>
</li>
@endforeach
</ul>

@if(Session::has('cart'))
<!--====================Cart Related Products Section Start ====================-->

        <div class="container similar-product-wrapper">
            <div class="row">
                <div class="col-12 mt-3">
                    <div class="section-head d-flex justify-content-between align-items-end mb-2">
                        <div class="d-flex text-center">
                            <h4 class="font-500 text-dark mb-0">{{ __('You may also like') }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="products product-style-1 owl-mx-5">
                        @php                        
                        if (!empty($childcategory_id[0]) > 0) {
                            $catgroup = $childcategory_id;
                            $filter = 'category_id';
                        }
                        elseif (!empty($subcategory_id[0]) > 0) {
                            $catgroup = $subcategory_id;
                            $filter = 'subcategory_id';
                        }
                        else {
                            $catgroup = $category_id;
                            $filter = 'category_id';
                        }     
                                                              
                        @endphp
                        <div
                            class="auto-single-carousel owl-carousel nav-top-right e-title-hover-primary e-image-bg-light e-hover-image-zoom e-info-center">
                            @foreach (DB::table('products')->whereIn($filter,$catgroup)->whereNotIn('id',$product_cart_id)->where('language_id', Session::has('language') ? Session::get('language') : 1)->take(4)->get() as $item)
                                <div class="item">
                                    <div class="product type-product">
                                        <div class="product-wrapper similar-product-inner">
                                            <div class="product-image">
                                                <a href="{{ route('front.product', $item->slug) }}"
                                                    class="woocommerce-LoopProduct-link"><img class="lazy" src="{{ $item->photo ? filter_var($item->photo, FILTER_VALIDATE_URL) ?$item->photo:asset('assets/images/products/'.$item->photo):asset('assets/images/noimage.png') }}" data-src="{{ $item->photo ? filter_var($item->photo, FILTER_VALIDATE_URL) ?$item->photo:asset('assets/images/products/'.$item->photo):asset('assets/images/noimage.png') }}"
                                                        alt="Product Image"></a>
                                                <div class="on-sale">
                                                    -{{ round((int) App\Models\Product::find($item->id)->offPercentage()), 2 }}%
                                                </div>
                                                <div class="hover-area">
                                                    @if ($item->product_type == 'affiliate')
                                                        <div class="cart-button">
                                                            <a href="javascript:;"
                                                                data-href="{{ $item->affiliate_link }}"
                                                                class="button add_to_cart_button affilate-btn"
                                                                data-bs-toggle="tooltip" data-bs-placement="right"
                                                                title=""
                                                                data-bs-original-title="{{ __('Add To Cart') }}"
                                                                aria-label="{{ __('Add To Cart') }}"></a>
                                                        </div>
                                                    @else
                                                        @if (App\Models\Product::where('id', $item->id)->first()->emptyStock())
                                                            <div class="closed">
                                                                <a class="cart-out-of-stock button add_to_cart_button"
                                                                    href="#" title="{{ __('Out Of Stock') }}"><i
                                                                        class="flaticon-cancel flat-mini mx-auto"></i></a>
                                                            </div>
                                                        @else
                                                            <div class="cart-button">
                                                                <a href="javascript:;"
                                                                    data-href="{{ route('product.cart.add', $item->id) }}"
                                                                    class="add-cart button add_to_cart_button"
                                                                    data-bs-toggle="tooltip" data-bs-placement="right"
                                                                    title=""
                                                                    data-bs-original-title="{{ __('Add To Cart') }}"
                                                                    aria-label="{{ __('Add To Cart') }}"></a>
                                                            </div>
                                                            <div class="closed">
                                                                <a class="button add_to_cart_button add-to-cart-quick"
                                                                    href="javascript:;" data-bs-toggle="tooltip"
                                                                    data-href="{{ route('product.cart.quickadd', $item->id) }}"
                                                                    data-bs-placement="right" title="{{ __('Buy Now') }}"
                                                                    data-bs-original-title="{{ __('Buy Now') }}"><i
                                                                        class="flaticon-shopping-cart-1 flat-mini mx-auto"></i></a>
                                                            </div>
                                                        @endif
                                                    @endif
                                                    @if (Auth::check())
                                                        <div class="wishlist-button">
                                                            <a class="add_to_wishlist  new button add_to_cart_button"
                                                                id="add-to-wish" href="javascript:;"
                                                                data-href="{{ route('user-wishlist-add', $item->id) }}"
                                                                data-bs-toggle="tooltip" data-bs-placement="right"
                                                                title="" data-bs-original-title="Add to Wishlist"
                                                                aria-label="Add to Wishlist">{{ __('Wishlist') }}</a>
                                                        </div>
                                                    @else
                                                        <div class="wishlist-button">
                                                            <a class="add_to_wishlist button add_to_cart_button"
                                                                href="{{ route('user.login') }}" data-bs-toggle="tooltip"
                                                                data-bs-placement="right" title=""
                                                                data-bs-original-title="Add to Wishlist"
                                                                aria-label="Add to Wishlist">{{ __('Wishlist') }}</a>
                                                        </div>
                                                    @endif
                                                    <div class="compare-button">
                                                        <a class="compare button add_to_cart_button"
                                                            data-href="{{ route('product.compare.add', $item->id) }}"
                                                            href="javascrit:;" data-bs-toggle="tooltip"
                                                            data-bs-placement="right" title=""
                                                            data-bs-original-title="Compare"
                                                            aria-label="Compare">{{ __('Compare') }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-info">
                                                <h3 class="product-title"><a
                                                        href="{{ route('front.product', $item->slug) }}">{{ App\Models\Product::find($item->id)->showName() }}</a>
                                                </h3>
                                                <div class="product-price">
                                                    <div class="price">
                                                        <ins>{{ App\Models\Product::find($item->id)->showPrice() }}</ins>
                                                        <del>{{ App\Models\Product::find($item->id)->showPreviousPrice() }}</del>
                                                    </div>
                                                </div>
                                                <div class="shipping-feed-back">
                                                    <div class="star-rating">
                                                        <div class="rating-wrap">
                                                            <p><i class="fas fa-star"></i><span>
                                                                    {{ App\Models\Rating::ratings($item->id) }}
                                                                    ({{ App\Models\Rating::ratingCount($item->id) }})</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
   
    <!--====================Cart Related Products Section End ====================-->
    @endif

</div>
<div class="minicart-bottom">
<!-- <div class="shipinfo text-center mb-3 text-uppercase">
<p class="freeShipMsg"><i class="an an-truck fs-5 me-2 align-middle"></i>SPENT <b>$199.00</b> MORE FOR FREE SHIPPING</p>
</div> -->
<div class="subtotal dropdown-cart-total">
<span>Total:</span>
<span class="product-price"><span class="cart-total-price">
<span class="cart-total">{{ Session::has('cart') ? App\Models\Product::convertPrice(Session::get('cart')->totalPrice) : '0.00' }}</span> </span> </span>
</div>
<a href="{{ route('front.checkout') }}" class="w-100 p-2 my-2 btn btn-outline-primary proceed-to-checkout rounded">Proceed to Checkout</a>
<a href="{{ route('front.cart') }}" class="w-100 btn btn-primary cart-btn rounded">View Cart</a>
</div>
</div>
@else 
<div id="cartEmpty" class="cartEmpty d-flex-justify-center flex-column text-center p-3 text-muted">
<div class="minicart-header d-flex-center justify-content-between w-100">
<h4 class="fs-6">Your cart (0 Items)</h4>
<a href="javascript:void(0);" class="close-cart" data-bs-dismiss="modal" aria-label="Close"><i class="an an-times-r" aria-hidden="true" data-bs-toggle="tooltip" data-bs-placement="left" title="Close"></i></a>
</div>
<div class="cartEmpty-content mt-4">
<i class="icon an an-sq-bag fs-1 text-muted"></i> 
<p class="my-3">No Products in the Cart</p>
<a href="category-4columns.html" class="btn btn-primary cart-btn rounded">Continue shopping</a>
</div>
</div>
@endif
