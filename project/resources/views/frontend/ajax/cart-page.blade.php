 <!--==================== Cart Section Start ====================-->
 <div class="full-row cartpage">
    <div class="container">
        <div class="row">
            @if(Session::has('cart'))
            <div class="col-xl-8 col-lg-12 col-md-12 col-12">
                <div class="cart-table">
                    <div class="gocover" style="position: absolute; background: url({{ asset('assets/images/xloading.gif') }}) center center no-repeat scroll rgba(255, 255, 255, 0.5); display: none;"></div>
                    <table class="shop_table cart">
                        <tr>
                            <th class="product-thumbnail">&nbsp;</th>
                            <th class="product-name">{{ __('Product') }}</th>
                            <th class="product-price">{{ __('Price') }}</th>
                            <th class="product-quantity">{{ __('Quantity') }}</th>
                            <th class="product-subtotal">{{ __('Subtotal') }}</th>
                            <th class="product-remove">&nbsp;</th>
                        </tr>
                        @php
                        $category_id= array();
                        $subcategory_id= array();
                        $childcategory_id= array();
                        $product_cart_id= array();
                        @endphp 
                        @foreach ($products as $product)
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
                       
                        <tr class="woocommerce-cart-form__cart-item cart_item">
                            <td class="product-thumbnail">
                                <a href="{{ route('front.product', $product['item']['slug']) }}"><img src="{{ $product['item']['photo'] ? asset('assets/images/products/'.$product['item']['photo']) : asset('assets/images/noimage.png') }}" alt="Product image"></a>
                            </td>
                            <td class="product-name">
                                <a href="{{ route('front.product', $product['item']['slug']) }}">{{ $product['item']['id'] }}{{ mb_strlen($product['item']['name'],'UTF-8') > 35 ? mb_substr($product['item']['name'],0,35,'UTF-8').'...' : $product['item']['name']}}</a>
                                @if(!empty($product['color']))
                                <div class="d-flex mt-2 ml-1">

                                <b>{{ __('Colour') }}</b>:  <span id="color-bar" style="border: 10px solid #{{$product['color'] == "" ? "white" : $product['color']}};"></span>
                                </div>
                                @endif
                            </td>
                            <td class="product-price">
                                <span>{{ App\Models\Product::convertPrice($product['item_price']) }}
                                </span>
                            </td>


                            @if($product['item']['type'] == 'Physical' && $product['item']['type'] != 'affiliate')
                            <td class="product-quantity">
                                <input type="hidden" class="prodid" value="{{$product['item']['id']}}">
                                <input type="hidden" class="itemid"
                                    value="{{$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])}}">
                                <input type="hidden" class="size_qty" value="{{$product['size_qty']}}">
                                <input type="hidden" class="size_price" value="{{$product['size_price']}}">
                                <input type="hidden" class="minimum_qty" value="{{ $product['item']['minimum_qty'] == null ? '0' : $product['item']['minimum_qty'] }}">
                                <div class="quantity">
                                    <input id="qty{{$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])}}" class="qttotal1" type="number" name="quantity"  value="{{ $product['qty'] }}">
                                </div>
                            </td>
                            @else
                            <td class="product-quantity">
                                1
                            </td>
                            @endif
                            @if($product['size_qty'])
                            <input type="hidden"
                                id="stock{{$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])}}"
                                value="{{$product['size_qty']}}">
                            @elseif($product['item']['type'] != 'Physical')
                            <input type="hidden"
                                id="stock{{$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])}}"
                                value="1">
                            @else
                            <input type="hidden"
                                id="stock{{$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])}}"
                                value="{{$product['stock']}}">
                            @endif
                            <td class="product-subtotal">
                                <p class="d-inline-block"
                                id="prc{{$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])}}">
                                {{ App\Models\Product::convertPrice($product['price']) }}
                                </p>
                                @if ($product['discount'] != 0)
                                <strong>{{$product['discount']}} %{{__('off')}}</strong>
                                @endif

                            </td>
                            <td class="product-remove">
                                <a href="#" class="remove cart-remove" data-class="cremove{{ $product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values']) }}" data-href="{{ route('product.cart.remove',$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])) }}">×</a>
                            </td>
                        </tr>
                       @endforeach
                    </table>
                </div>
            </div>
            <div class="col-xl-4 col-lg-12 col-md-12 col-12">
                <div class="cart-collaterals">
                    <div class="cart_totals ">
                        <h2>{{ __('Cart totals') }}</h2>
                        <table>
                            <tr>
                                <th>Subtotal</th>
                                <td>
                                    <span><b
                                        class="cart-total">{{ Session::has('cart') ? App\Models\Product::convertPrice($totalPrice) : '0.00' }}</b>
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <th>{{ __('Discount') }}</th>
                                <td>
                                    <span>
                                        <b class="discount">{{ App\Models\Product::convertPrice(0)}}</b>
                                        <input type="hidden" id="d-val" value="{{ App\Models\Product::convertPrice(0)}}">
                                    </span>
                                </td>
                            </tr>

                            <tr class="order-total">
                                <th>Total</th>
                                <td><strong><span class="woocommerce-Price-amount amount main-total">{{ Session::has('cart') ? App\Models\Product::convertPrice($mainTotal) : '0.00' }}</span></strong> </td>
                            </tr>
                        </table>
                        <div class="wc-proceed-to-checkout">
                            <a href="{{ route('front.checkout') }}" class="checkout-button">{{ __('Proceed to checkout') }}</a>
                        </div>
                    </div>
                </div>
            </div>


            @else
            <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="text-center">{{ __('Cart is Empty!! Add some products in your Cart') }}</h4>
                    </div>
                </div>
            </div>



            @endif
        </div>
    </div>
</div>
@if(Session::has('cart'))
<!--====================Cart Related Products Section Start ====================-->
<div class="full-row pt-0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-head border-bottom d-flex justify-content-between align-items-end mb-2">
                        <div class="d-flex section-head-side-title">
                            <h4 class="font-600 text-dark mb-0">{{ __('Related Products') }}</h4>
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
                            class="five-carousel owl-carousel nav-top-right e-title-hover-primary e-image-bg-light e-hover-image-zoom e-info-center">
                            @foreach (DB::table('products')->whereIn($filter,$catgroup)->whereNotIn('id',$product_cart_id)->where('language_id', Session::has('language') ? Session::get('language') : 1)->take(12)->get() as $item)
                                <div class="item">
                                    <div class="product type-product">
                                        <div class="product-wrapper">
                                            <div class="product-image">
                                                <a href="{{ route('front.product', $item->slug) }}"
                                                    class="woocommerce-LoopProduct-link"><img class="lazy"
                                                        data-src="{{ $item->photo ? asset('assets/images/products/' . $item->photo) : asset('assets/images/noimage.png') }}"
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
    </div>
    <!--====================Cart Related Products Section End ====================-->
    @endif
<script src="{{ asset('assets/front/js/custom.js') }}"></script>
