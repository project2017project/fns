    
   <div class="col" >
      <div class="product type-product">
         <div class="product-wrapper">
            <div class="product-image">
               <a href="{{ route('front.product', $product->slug) }}" class="woocommerce-LoopProduct-link"><img class="lazy" data-src="{{ $product->thumbnail ? asset('assets/images/thumbnails/'.$product->thumbnail):asset('assets/images/noimage.png') }}" alt=""></a>

             

               @if (round((int)App\Models\Product::find($product->id)->offPercentage() )>0)
                    <div class="on-sale">- {{ round((int)App\Models\Product::find($product->id)->offPercentage() )}}%</div>
               @endif
              <div class="hover-area">
                  @if($product->product_type == "affiliate")
                  <div class="cart-button">
                     <a href="javascript:;" data-href="{{ $product->affiliate_link }}" class="button add_to_cart_button affilate-btn" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="{{ __('Add To Cart') }}" aria-label="{{ __('Add To Cart') }}"></a>
                  </div>
                  @else
                  
                  @if(App\Models\Product::find($product->id)->emptyStock())
                  <div class="cart-button">
                     <a class="cart-out-of-stock button add_to_cart_button" href="#" title="{{ __('Out Of Stock') }}" ><i class="flaticon-cancel flat-mini mx-auto"></i></a>
                  </div>
                  @else
                  <div class="cart-button">
                     <a href="javascript:;" data-href="{{ route('product.cart.add',$product->id) }}" class="add-cart button add_to_cart_button button-fq" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="{{ __('Add To Cart') }}" aria-label="{{ __('Add To Cart') }}"></a>
                  </div>
                  <div class="cart-button buynow">
                     <a  class="button add_to_cart_button add-to-cart-quick" href="javascript:;" data-bs-toggle="tooltip" data-href="{{ route('product.cart.quickadd',$product->id) }}" data-bs-placement="right" title="{{ __('Buy Now') }}" data-bs-original-title="{{ __('Buy Now') }}"></a>
                  </div>
                  @endif
                  @endif
                  @if(Auth::check())
                  <div class="wishlist-button">
                     <a class="add_to_wishlist  new button add_to_cart_button" id="add-to-wish" href="javascript:;" data-href="{{ route('user-wishlist-add',$product->id) }}" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Add to Wishlist" aria-label="Add to Wishlist">{{ __('Wishlist') }}</a>
                  </div>
                  @else
                  <div class="wishlist-button">
                     <a class="add_to_wishlist button add_to_cart_button" href="{{ route('user.login') }}" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Add to Wishlist" aria-label="Add to Wishlist">{{ __('Wishlist') }}</a>
                  </div>
                  @endif
               </div> 
            </div>
            <div class="product-info">
              
               <h3 class="product-title"><a href="{{ route('front.product', $product->slug) }}">{{ App\Models\Product::find($product->id)->showName() }}</a></h3>
               <div class="product-price">
                  <div class="price">
                     <ins>{{ App\Models\Product::find($product->id)->setCurrency() }}</ins>
                     <del>{{ App\Models\Product::find($product->id)->showPreviousPrice() }}</del>
                  </div>
               </div>
               <div class="shipping-feed-back">
                  <div class="star-rating">
                     <div class="rating-wrap">
                        <p><i class="fas fa-star"></i><span> {{ App\Models\Rating::ratings($product->id) }} ({{ App\Models\Rating::ratingCount($product->id) }})</span></p>
                     </div>
                  </div>
               </div>
           <!--       <div class="deal-counter">
          <div data-countdown="{{ $product->discount_date }}"></div>
       </div> -->
            </div>
         </div>
      </div>
   </div>



