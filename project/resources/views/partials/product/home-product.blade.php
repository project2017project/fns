<div class="item mb-4">
                                            <!-- start product image -->
                                            <div class="product-image">
                                                <!--Start Product Image-->
                  <a href="{{ route('front.product', $prod->slug) }}" class="product-img">
                     <!--Image-->
                     <img class="primary blur-up lazyload" data-src="{{ $prod->thumbnail ? asset('assets/images/thumbnails/'.$prod->thumbnail):asset('assets/images/noimage.png') }}" src="{{ $prod->thumbnail ? asset('assets/images/thumbnails/'.$prod->thumbnail):asset('assets/images/noimage.png') }}" alt="image" title="">
                     <!--End image-->
                     <!--Hover image-->
                     <img class="hover blur-up lazyload" data-src="{{ $prod->thumbnail ? asset('assets/images/thumbnails/'.$prod->thumbnail):asset('assets/images/noimage.png') }}" src="{{ $prod->thumbnail ? asset('assets/images/thumbnails/'.$prod->thumbnail):asset('assets/images/noimage.png') }}" alt="image" title="">
                     <!--End hover image-->


                     @if(!empty($prod->features))
                        <div class="product-labels">
                        @foreach($prod->features as $key => $data1)
                           <span class="lbl on-sale rounded" style="background-color:{{ $prod->colors[$key] }}">{{ $prod->features[$key] }}</span>
                           @endforeach 
                        </div>
                     @endif

                  


                  </a>

                                                <!--Countdown Timer-->
                                                <!-- <div class="saleTime desktop" data-countdown="{{ $prod->discount_date }}"></div> -->
                                                <!--End Countdown Timer-->

                                                <!--Product Button-->
                                                <div class="button-set style3">
                                                    <ul>
                                                        <li>
                                                            <!--Cart Button-->
                                                            @if($prod->product_type == "affiliate")
                                                            <a class="btn-icon btn btn-addto-cart affilate-btn rounded" href="javascript:;" data-href="{{ $product->affiliate_link }}" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="{{ __('Add To Cart') }}" aria-label="{{ __('Add To Cart') }}">
                                                                <i class="icon an an-cart-l"></i> <span class="tooltip-label left">Add to Cart</span>
                                                            </a>
                                                            @else
                                                         @if($prod->emptyStock())
                                                           <a class="btn-icon btn btn-addto-cart cart-out-of-stock rounded" href="javascript:void(0)" title="{{ __('Out Of Stock') }}">
                                                                <i class="icon an an-cart-l"></i> 
                                                            </a>
                                                            @else
                                                             <a class="btn-icon btn add-cart btn-addto-cart rounded" href="javascript:void(0)" data-href="{{ route('product.cart.add',$prod->id) }}" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="{{ __('Add To Cart') }}" aria-label="{{ __('Add To Cart') }}">
                                                                <i class="icon an an-cart-l"></i>
                                                                 <span class="tooltip-label left">Add to Cart</span>
                                                            </a>
                                                            @endif
                                                            @endif
                                                            <!--end Cart Button-->
                                                        </li>
                                                        <li>
                                                            <!--Quick View Button-->
                                                           <a href="javascript:;" title="{{ $langg->lang55 }}" class="btn-icon quick-view-popup quick-view rounded" data-toggle="modal" data-href="{{ route('product.quick',$prod->id) }}" data-target="#quickview">
                                <i class="icon an an-search-l"></i>
                                <span class="tooltip-label left">Quick View</span>
                            </a>
                                                            <!--End Quick View Button-->
                                                        </li>

                                                        <li>
                                                            <!--Wishlist Button-->
                                                             @if(Auth::check())
                                                            <a class="btn-icon new wishlist add-to-wishlist rounded" id="add-to-wish" href="javascript:;" data-href="{{ route('user-wishlist-add',$prod->id) }}" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Add to Wishlist" aria-label="Add to Wishlist">
                                                                <i class="icon an an-heart-l"></i>
                                                                <span class="tooltip-label left">{{ __('Wishlist') }}</span>
                                                            </a>
                                                            @else 
                                                            <a class="btn-icon wishlist add-to-wishlist rounded" href="{{ route('user.login') }}" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Add to Wishlist" aria-label="Add to Wishlist">
                                              <i class="icon an an-heart-l"></i>
                                              <span class="tooltip-label left">{{ __('Wishlist') }}</span>
                                           </a>

                                              @endif
                                                            <!--End Wishlist Button-->
                                                        </li>

                                                        <!-- <li>
                                                            <a class="btn-icon compare add-to-compare rounded" href="javascrit:;" data-href="{{ route('product.compare.add',$prod->id) }}" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Compare" aria-label="Compare">
                                                                <i class="icon an an-sync-ar"></i>
                                                                <span class="tooltip-label left">{{ __('Compare') }}</span>
                                                            </a>
                                                        </li> -->
                                                    </ul>
                                                </div>
                                                <!--End Product Button-->  
                                            </div>
                                            <!-- end product image -->
                                            <!--start product details -->
                                            <div class="product-details">
                                                <!-- product name -->
                                                <div class="product-name text-uppercase">
                                                    <a href="{{ route('front.product', $prod->slug) }}">{{ $prod->showName() }}</a>
                                                </div>
                                                <!-- End product name -->
                                                <!-- product price -->
                                                <div class="product-price">
                                                        <span class="price-regular">{{ $prod->showPrice() }}</span>
                                                        <span class="price-old"><del>{{ $prod->showPreviousPrice() }}</del></span>
                                                    </div>
                                                <!-- End product price -->
                                               
                                            </div>
                                            <!-- End product details -->
                                        </div>