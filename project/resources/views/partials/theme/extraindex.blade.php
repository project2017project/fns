<style>
    .text-center {
    text-align: center!important;
    margin: 0 auto;
}
</style>

 @if($ps->top_big_trending==1)
  <!--Best Seller With Tabs-->
                <section class="section product-slider shop-categoery tab-slider-product">
                    <div class="container">
                        <div class="section-header">
                            <h2>Shop By Categories</h2> 
                            <p>Accumsan vitae pede lacus ut ullamcorper sollicitudin quisque libero</p>   
                        </div>
                        <div class="tabs-listing">
                            <ul class="tabs clearfix d-flex justify-content-between mb-3">
                                <li class="active" rel="shop-tab1">
                                     <div class="cate-tab-image">
                                     <img class="lazyload shop-b" src="/assets/images/categories/fns-cat.png" alt="Kitchenware">
                                    <img class="lazyload shop-w" src="/assets/images/categories/fns-cat-color.png" alt="Kitchenware">
                                     <p>{{ __('Fns Cutlery') }}</p>
                                        </div>
                                   
                                </li>
                                <li rel="shop-tab2">
                                     <div class="cate-tab-image">
                                     <img class="lazyload shop-b" src="/assets/images/categories/montavo-cat.png" alt="Tableware">
                                     <img class="lazyload shop-w" src="/assets/images/categories/montavo-cat-color.png" alt="Tableware">
                                     <p>{{ __('Montavo Cutlery') }}</p>
                                        </div>
                                </li>
                                <li rel="shop-tab3">
                                     <div class="cate-tab-image">
                                   <img class="lazyload shop-b" src="/assets/images/categories/table-cat.png" alt="Tableware">
                                    <img class="lazyload shop-w" src="/assets/images/categories/table-cat-color.png" alt="Tableware">
                                     <p>{{ __('Tableware') }}</p>
                                        </div>
                                </li>
                                <li rel="shop-tab4" class="tab_last">
                                     <div class="cate-tab-image">
                                    <img class="lazyload shop-b" src="/assets/images/categories/bar-cat.png" alt="Decor">
                                    <img class="lazyload shop-w" src="/assets/images/categories/bar-cat-color.png" alt="Decor">
                                     <p>{{ __('Barware') }}</p>
                                        </div>
                                </li>

                                 <li rel="shop-tab5">
                                     <div class="cate-tab-image">
                                    <img class="lazyload shop-b" src="/assets/images/categories/dinner-cat.png" alt="Furniture &amp; Lighting">
                                    <img class="lazyload shop-w" src="/assets/images/categories/dinner-cat-color.png" alt="Furniture &amp; Lighting">
                                     <p>{{ __('Dinnerware') }}</p>
                                        </div>
                                </li>

                                 <span>
                                     <div class="cate-tab-image">
                                        <a href="{{ route('front.index') }}/gifting">
                                    <img class="lazyload shop-b" src="/assets/images/categories/giftbox.png" alt="Lighting">
                                     <p>{{ __('Gifting') }}</p>
                                     </a>
                                        </div>
                                </span>
                               
                            </ul>
                            <div class="tab_container">
                               
                                <div id="shop-tab1" class="tab_content grid-products">
                                    <div class="category-title-name">
                                        <h3 class="title">Fns Cutlery</h3>
                                        <div class="category-view-btn">
                                            <a href="{{ route('front.index') }}/category/fns-cutlery">View all</a>
                                        </div>
                                    </div>
                                    <div class="shopproductSlider">
                                         @if($fnscutlery->count()>0)

                                            @foreach($fnscutlery as $prod)
                                        <div class="product-tab-col">
                                            @include('partials.product.home-product')
                                        </div>
                                         @endforeach
                                            @else 
                                            <div  class="text-center">
                                                <h2>{{__('No Product Found!')}}</h2>
                                            </div>
                                            @endif

                                       
                                        
                                    </div>
                                    
                                </div>
                               
                                <div id="shop-tab2" class="tab_content grid-products">
                                    <div class="category-title-name">
                                        <h3 class="title">Montavo Cutlery</h3>
                                        <div class="category-view-btn">
                                            <a href="{{ route('front.index') }}/category/montavo-cutlery">View all</a>
                                        </div>
                                    </div>
                                    <div class="shopproductSlider">
                                         @if($montavocutlery->count()>0)

                                            @foreach($montavocutlery as $prod)
                                        <div class="product-tab-col">
                                            @include('partials.product.home-product')
                                        </div>
                                         @endforeach
                                            @else 
                                            <div  class="text-center">
                                                <h2>{{__('No Product Found!')}}</h2>
                                            </div>
                                            @endif

                                       
                                        
                                    </div>
                                    
                                </div>
                               
                                <div id="shop-tab3" class="tab_content grid-products">
                                    <div class="category-title-name">
                                        <h3 class="title">Tableware</h3>
                                        <div class="category-view-btn">
                                            <a href="{{ route('front.index') }}/category/tablewares">View all</a>
                                        </div>
                                    </div>
                                   <div class="shopproductSlider">
                                         @if($tableware->count()>0)

                                            @foreach($tableware as $prod)
                                        <div class="product-tab-col">
                                            @include('partials.product.home-product')
                                        </div>
                                         @endforeach
                                            @else 
                                            <div  class="text-center">
                                                <h2>{{__('No Product Found!')}}</h2>
                                            </div>
                                            @endif

                                       
                                        
                                    </div>
                                    
                                </div>

                                 <div id="shop-tab4" class="tab_content grid-products">
                                    <div class="category-title-name">
                                        <h3 class="title">Barware</h3>
                                        <div class="category-view-btn">
                                            <a href="{{ route('front.index') }}/category/barware">View all</a>
                                        </div>
                                    </div>
                                   <div class="shopproductSlider">
                                         @if($barware->count()>0)

                                            @foreach($barware as $prod)
                                        <div class="product-tab-col">
                                            @include('partials.product.home-product')
                                        </div>
                                         @endforeach
                                            @else 
                                            <div  class="text-center">
                                                <h2>{{__('No Product Found!')}}</h2>
                                            </div>
                                            @endif

                                       
                                        
                                    </div>
                                    
                                </div>

                                 <div id="shop-tab5" class="tab_content grid-products">
                                    <div class="category-title-name">
                                        <h3 class="title">Dinnerware</h3>
                                        <div class="category-view-btn">
                                            <a href="{{ route('front.index') }}/category/dinnerware">View all</a>
                                        </div>
                                    </div>
                                   <div class="shopproductSlider">
                                         @if($dinnerware->count()>0)

                                            @foreach($dinnerware as $prod)
                                        <div class="product-tab-col">
                                            @include('partials.product.home-product')
                                        </div>
                                         @endforeach
                                            @else 
                                            <div  class="text-center">
                                                <h2>{{__('No Product Found!')}}</h2>
                                            </div>
                                            @endif

                                       
                                        
                                    </div>
                                    
                                </div>

                               


                            </div>
                        </div>
                    </div>
                </section>
                <!--End Best Seller With Tabs-->

@endif

  @if($ps->our_services == 1)

    {{-- Info Area Start --}}
<section class="section shipping__section pt-0">
            <div class="container">
              
                <div class="shipping__section--inner border-radius-10 d-flex justify-content-center">
                    @foreach($services->chunk(4) as $chunk)
                  @foreach($chunk as $service)
                    <div class="shipping__items text-center">
                        <div class="shipping__items--icon">
                            <img src="{{ asset('assets/images/services/'.$service->photo) }}">
                        </div>
                        <div class="shipping__items--content">
                            <h3 class="shipping__items--content__title">{{ $service->title }}</h3>
                        </div>
                    </div>
                    @endforeach
                   @endforeach
                </div>
                
            </div>
        </section>

                {{-- Info Area End  --}}

        @endif


@if($ps->deal_of_the_day==1)

<!--==================== Deal of the day Section Start ====================-->
<div class="section section-fluid section-padding deal-wrapper">
        <div class="container">
            <div class="row align-items-center learts-mb-n30">
                <div class="col-12">
                    <div class="deals-slide-wrap">

                        <div class="deals-items">
                        <div class="row">
                <div class="col-lg-6 col-md-6 col-12 learts-mb-30">
                    <div class="product-deal-image text-center">
                        <img src="{{ $gs->deal_background ? asset('assets/images/'.$gs->deal_background):asset('assets/images/noimage.png') }}" alt="">
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-12 learts-mb-30">
                    <div class="product-deal-content">
                        <h2 class="title">{{ $gs->deal_title }}</h2>
                        <div class="desc">
                            <p>{{ $gs->deal_details }}</p>
                        </div>
                       
                    

                         <div class="time-count mb-5" data-countdown="{{ $gs->deal_time }}"></div>

                        <a href="{{ route('front.category').'?type=flash'  }}" class="btn btn-dark btn-hover-primary">{{ __('Shop Now') }}</a>
                    </div>
                </div>
            </div>
        </div>
        
            </div>
            </div>

            </div>
        </div>
    </div>
<!--==================== Deal of the day Section End ====================-->

 @endif
        <!--==================== Deal of the day Section End ====================-->



   @if($ps->top_big_trending==1)
  <!--Best Seller With Tabs-->
                <section class="section popular-main-wrapper product-slider tab-slider-product mt-5 mb-5">
                    <div class="container">
                        <div class="section-header">
                            <h2>Most Popular Items</h2> 
                            <p>Lorem ipsum dolor sit amet</p>   
                        </div>
                        <div class="tabs-listing">
                            <ul class="tabs clearfix tabs-style3">
                            <li class="active" rel="popluar_fns">{{ __('Fns Cutlery') }}</li>
                                <li rel="popluar_montavo">{{ __('Montavo Cutlery') }}</li>
                                <li rel="popluar_table">{{ __('Tableware') }}</li>
                                <li rel="popluar_bar">{{ __('Barware') }}</li>
                            <li rel="popluar_dinner" class="tab_last">{{ __('Dinnerware') }}</li>
                            </ul>
                            <div class="tab_container">
                                
                                <div id="popluar_fns" class="tab_content grid-products">
                                    <div class="productSlider">
                                         @if($popluar_fnscutlery->count()>0)

                                            @foreach($popluar_fnscutlery as $prod)
                                        <div class="product-tab-col">
                                            @include('partials.product.home-product')
                                        </div>
                                         @endforeach
                                            @else 
                                            <div  class="text-center">
                                                <h2>{{__('No Product Found!')}}</h2>
                                            </div>
                                            @endif

                                    </div>

                                    
                                </div>
                                
                                <div id="popluar_montavo" class="grid-products tab_content">
                                    <div class="productSlider">
                                         @if($popluar_montavocutlery->count()>0)

                                            @foreach($popluar_montavocutlery as $prod)
                                        <div class="product-tab-col">
                                            @include('partials.product.home-product')
                                        </div>
                                         @endforeach
                                            @else 
                                            <div  class="text-center">
                                                <h2>{{__('No Product Found!')}}</h2>
                                            </div>
                                            @endif

                                    </div>
                                   
                                </div>
                               
                                <div id="popluar_table" class="grid-products tab_content">
                                    <div class="productSlider">
                                         @if($popular_tableware->count()>0)

                                            @foreach($popular_tableware as $prod)
                                        <div class="product-tab-col">
                                            @include('partials.product.home-product')
                                        </div>
                                         @endforeach
                                            @else 
                                            <div  class="text-center">
                                                <h2>{{__('No Product Found!')}}</h2>
                                            </div>
                                            @endif

                                    </div>
                                    
                                </div>

                                 <div id="popluar_bar" class="grid-products tab_content">
                                    <div class="productSlider">
                                         @if($popular_barware->count()>0)

                                            @foreach($popular_barware as $prod)
                                        <div class="product-tab-col">
                                            @include('partials.product.home-product')
                                        </div>
                                         @endforeach
                                            @else 
                                            <div  class="text-center">
                                                <h2>{{__('No Product Found!')}}</h2>
                                            </div>
                                            @endif

                                    </div>
                                    
                                </div>

                                 <div id="popluar_dinner" class="grid-products tab_content">
                                    <div class="productSlider">
                                         @if($popular_dinnerware->count()>0)

                                            @foreach($popular_dinnerware as $prod)
                                        <div class="product-tab-col">
                                            @include('partials.product.home-product')
                                        </div>
                                         @endforeach
                                            @else 
                                            <div  class="text-center">
                                                <h2>{{__('No Product Found!')}}</h2>
                                            </div>
                                            @endif

                                    </div>
                                    
                                </div>

                                

                            </div>
                        </div>
                    </div>
                </section>
                <!--End Best Seller With Tabs-->
                @endif


                 @if($ps->top_big_trending==1)
  <!--New Launches Tabs-->
                <section class="section lauch-wrapper product-slider tab-slider-product pt-0">
                    <div class="container">
                        <div class="section-header">
                            <h2>New Lauches</h2> 
                            <p>Lorem ipsum dolor sit amet</p>   
                        </div>
                        <div class="tabs-listing">
                            <ul class="tabs clearfix tabs-style3">
                                <li class="active" rel="lauch-tab1">{{ __('Fns Cutlery') }}</li>
                                <li rel="lauch-tab2">{{ __('Montavo Cutlery') }}</li>
                                <li rel="lauch-tab3">{{ __('Tableware') }}</li>
                                <li rel="lauch-tab4">{{ __('Barware') }}</li>
                                <li rel="lauch-tab5" class="tab_last">{{ __('Dinnerware') }}</li>
                            </ul>
                            <div class="tab_container">

                                 <div id="lauch-tab1" class="tab_content grid-products">
                                    <div class="productSlider">
                                         @if($latest_fnscutlery->count()>0)

                                            @foreach($latest_fnscutlery as $prod)
                                        <div class="product-tab-col">
                                            @include('partials.product.home-product')
                                        </div>
                                         @endforeach
                                            @else 
                                            <div  class="text-center">
                                                <h2>{{__('No Product Found!')}}</h2>
                                            </div>
                                            @endif

                                    </div>

                                    
                                </div>

                                 <div id="lauch-tab2" class="tab_content grid-products">
                                    <div class="productSlider">
                                         @if($latest_montavocutlery->count()>0)

                                            @foreach($latest_montavocutlery as $prod)
                                        <div class="product-tab-col">
                                            @include('partials.product.home-product')
                                        </div>
                                         @endforeach
                                            @else 
                                            <div  class="text-center">
                                                <h2>{{__('No Product Found!')}}</h2>
                                            </div>
                                            @endif

                                    </div>

                                    
                                </div>

                                 <div id="lauch-tab3" class="tab_content grid-products">
                                    <div class="productSlider">
                                         @if($latest_tableware->count()>0)

                                            @foreach($latest_tableware as $prod)
                                        <div class="product-tab-col">
                                            @include('partials.product.home-product')
                                        </div>
                                         @endforeach
                                            @else 
                                            <div  class="text-center">
                                                <h2>{{__('No Product Found!')}}</h2>
                                            </div>
                                            @endif

                                    </div>

                                    
                                </div>

                                 <div id="lauch-tab4" class="tab_content grid-products">
                                    <div class="productSlider">
                                         @if($latest_barware->count()>0)

                                            @foreach($latest_barware as $prod)
                                        <div class="product-tab-col">
                                            @include('partials.product.home-product')
                                        </div>
                                         @endforeach
                                            @else 
                                            <div  class="text-center">
                                                <h2>{{__('No Product Found!')}}</h2>
                                            </div>
                                            @endif

                                    </div>

                                    
                                </div>

                                 <div id="lauch-tab5" class="tab_content grid-products">
                                    <div class="productSlider">
                                         @if($latest_dinnerware->count()>0)

                                            @foreach($latest_dinnerware as $prod)
                                        <div class="product-tab-col">
                                            @include('partials.product.home-product')
                                        </div>
                                         @endforeach
                                            @else 
                                            <div  class="text-center">
                                                <h2>{{__('No Product Found!')}}</h2>
                                            </div>
                                            @endif

                                    </div>

                                    
                                </div>

                                
                                
                               
                            </div>
                        </div>
                    </div>
                </section>
                <!--End New Launches Tabs-->
                 @endif




<!-- banners section start -->
<section class="section Offerback-bg-wrap" style="background-image: url('./assets/images/Cutlery-Collection.png');">
    
</section>
<!-- banners section end -->

 @if($ps->category==1)
 <!-- video Area Start -->
        <div class="watch-video-wrap section-space pt-5">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="section-header">
                            <h2>Watch It Then Buy It</h2>
                            <p>All Time Bestsellers</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="cutlery-video-slides">
                            @foreach($popular_products as $prod)
                            <div class="video-box-wrap">
                                <div class="cutlury-video">
                                    <video width="100%" height="auto" autoplay="" muted="" loop="">
                                     <source src="/assets/front/videos/quinn_a23.mp4" type="video/mp4">
                                     </video>
                                </div>

                                
                                <div class="video-content">
                                    <div class="video-small-image">
                                        <img data-src="{{ $prod->thumbnail ? asset('assets/images/thumbnails/'.$prod->thumbnail):asset('assets/images/noimage.png') }}" src="{{ $prod->thumbnail ? asset('assets/images/thumbnails/'.$prod->thumbnail):asset('assets/images/noimage.png') }}">
                                    </div>
                                   <div class="product-caption">                                                  
                                                    <p class="product-name">
                                                        <a href="{{ route('front.product', $prod->slug) }}">{{ $prod->showName() }}</a>
                                                    </p>
                                                    <!-- data-bs-toggle="modal" data-bs-target="#quick_video_popup" -->
                                                    <!-- <div class="price-box">
                                                        <span class="price-regular">{{ $prod->showPrice() }}</span>
                                                        <span class="price-old"><del>{{ $prod->showPreviousPrice() }}</del></span>
                                                    </div> -->
                                                    <div class="video-btn-wrap">
                                                        <a href="{{ route('front.product', $prod->slug) }}" class="btn-small" tabindex="0">Read More</a>
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
        <!-- video  Area End -->
@endif


  
 <!--Testimonial Slider-->
                <!-- <section class="section testimonial-slider style1 mt-5" style="background-image:url('./assets/images/testimonial-bg.jpg')">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 section-header style1">
                                <div class="section-header-left">
                                    <h2>Their Words, Our Pride</h2>
                                </div>
                            </div>
                        </div>
                        <div class="quote-wraper">
                            <div class="quotes-slider arwOut3">
                                @foreach($reviews as $review)
                                <div class="quotes-slide">
                                    <blockquote class="quotes-slider__text text-center">  
                                        <div class="testimonial-image"><img class="blur-up lazyloaded" data-src="{{ asset('assets/images/reviews/'.$review->photo) }}" src="{{ asset('assets/images/reviews/'.$review->photo) }}" alt="Wrong Image" title="Testimonial"></div>    
                                        
                                        <div class="rte-setting"><p>{!! $review->details !!}</p></div>
                                        <div class="product-review">
                                            <i class="an an-star"></i>
                                            <i class="an an-star"></i>
                                            <i class="an an-star"></i>
                                            <i class="an an-star"></i>
                                            <i class="an an-star"></i>
                                        </div>
                                        <p class="authour">{{ $review->title }}</p>
                                        <p class="cmp-name">{{ $review->subtitle }}</p>
                                    </blockquote>
                                </div>
                                    @endforeach
                               
                               
                            </div>
                        </div>
                    </div>
                </section> -->
                <!--End Testimonial Slider-->



 <!--Happy Customer-->
                <section class="section customer-wrapper pt-5">
                    <div class="container">
                        <div class="section-header">
                            <h2>Happy Customers</h2>
                            <p>Top News Stories Of The Day</p>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="happy-customer-slider">
                                     @foreach($reviews as $review)
                                    <div class="happyc-item">
                                        <div class="customer-inner-wrap">
                                        <a href="javascript:void(0)" class="customer-pic">
                                            <img class="blur-up lazyload" src="{{ asset('assets/images/reviews/'.$review->photo) }}" data-src="{{ asset('assets/images/reviews/'.$review->photo) }}" alt="image" title=""/>
                                        </a>
                                        <div class="customer-hover-text">
                                            <h4>{{ $review->title }}</h4>
                                            <h6>{{ $review->subtitle }}</h6>
                                            <div class="product-review">
                                            <i class="an an-star"></i>
                                            <i class="an an-star"></i>
                                            <i class="an an-star"></i>
                                            <i class="an an-star"></i>
                                            <i class="an an-star"></i>
                                        </div>
                                            <p>{!! $review->details !!}</p>
                                        </div>
                                        </div>                                        
                                    </div>
                                      @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!--End customer Post-->



@if($ps->blog==1)
<!--Blog Post-->
                <section class="section home-blog-post pt-0">
                    <div class="container">
                        <div class="section-header">
                            <h2>{{ __('Latest Post From Blog') }}</h2>
                            <p>{{ __('Top News Stories Of The Day') }}</p>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="blog-post-slider">
                                    @foreach ($blogs as $blog)
                                    <div class="blogpost-item">
                                        <a href="{{ route('front.blogshow',$blog->slug) }}" class="post-thumb">
                                            <img class="blur-up lazyload" src="{{ asset('assets/images/blogs/'.$blog->photo) }}" data-src="{{ asset('assets/images/blogs/'.$blog->photo) }}" width="380" height="205" alt="image" title=""/>
                                        </a>
                                        <div class="post-detail">
                                            
                                            <ul class="publish-detail d-flex-center mb-3">
                                                <li class="d-flex align-items-center"><i class="an an-calendar me-2"></i> <span class="article__date">{{ date('d M, Y',strtotime($blog->created_at)) }}</span></li>
                                                <!-- <li class="d-flex align-items-center"><i class="an an-comments-l me-2"></i> <a href="#;" class="article-link">1 comment</a></li> -->
                                            </ul>
                                            <h3 class="post-title mb-3"><a href="{{ route('front.blogshow',$blog->slug) }}">{{ mb_strlen($blog->title,'UTF-8') > 200 ? mb_substr($blog->title,0,200,'UTF-8')."...":$blog->title }}</a></h3>
                                            <p class="exceprt">{{ mb_strlen($blog->details,'UTF-8') > 200 ? mb_substr($blog->details,0,100,'UTF-8')."...":$blog->details }}</p>
                                            <a href="{{ route('front.blogshow',$blog->slug) }}" class="btn-small">{{ __('Read More') }}</a>
                                        </div>
                                    </div>
                                       @endforeach
                                   
                                  
                                  
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!--End Blog Post-->
                @endif




  <!--Footer-->
            <div class="footer footer-1">
                <div class="footer-top clearfix">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-4 col-lg-2 footer-links">
                                <h4 class="h4 body-font">Informations</h4>
                                <ul>
                                    <li><a href="{{ route('front.index') }}/about">About Fns</a></li>
                              @if($ps->blog == 1)
                            <li>
                                <a href="{{ route('front.blog') }}">{{ __('Blog') }}</a>
                            </li>
                                @endif

                                    <li><a href="{{ route('front.index') }}/orders-and-returns">Orders and Returns</a></li>
                                 @foreach(DB::table('pages')->where('language_id',$langg->id)->where('footer','=',1)->get() as $data)
                            <li><a href="{{ route('front.vendor',$data->slug) }}">{{ $data->title }}</a></li>
                            @endforeach


                                    <li><a href="javascript:void(0)">Sitemap</a></li>

                            @if($ps->contact == 1)
                                <li>
                                <a href="{{ route('front.contact') }}">{{ __('Contact Us') }}</a>
                            </li>
                                @endif

<!-- 
                                    <li>
                                     @if(!Auth::guard('web')->check())
                                        <a href="{{ route('user.login') }}">My Account</a>
                                        @else
                                        <a href="{{ route('user-dashboard') }}">My Account</a>
                                        @endif
                                    </li>
                                 
                                    
                                    <li>
                                         @if(!Auth::guard('web')->check())
                                        <a href="{{ route('user.login') }}">Login</a>
                                        @else
                                         <a href="{{ route('user-dashboard') }}">My Account</a>
                                          @endif
                                    </li>
                              -->
                           
                                </ul>
                            </div>

                             <div class="col-12 col-sm-12 col-md-4 col-lg-2 footer-links">
                                <h4 class="h4 body-font">{{ __('Product Related') }}</h4>
                                <ul>
                                    <li><a href="javascript:void(0)">E-Catalogue</a></li>
                                    <li><a href="javascript:void(0)">Warranty</a></li>
                                   <!--  @foreach (DB::table('categories')->where('language_id',$langg->id)->get()->take(6) as $cate)
                                    <li>
                                    <a href="{{route('front.category', $cate->slug)}}{{!empty(request()->input('search')) ? '?search='.request()->input('search') : ''}}">{{ $cate->name }}</a>
                                    </li>
                                    @endforeach -->
                                </ul>
                            </div>


                            <div class="col-12 col-sm-12 col-md-4 col-lg-2 footer-links">
                                <h4 class="h4 body-font">{{ __('Top Products') }}</h4>
                                <ul>
                                    @foreach (DB::table('categories')->where('language_id',$langg->id)->orderBy('id', 'DESC')->get()->take(6) as $cate)
                                    <li>
                                    <a href="{{route('front.category', $cate->slug)}}{{!empty(request()->input('search')) ? '?search='.request()->input('search') : ''}}">{{ $cate->name }}</a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="col-12 col-sm-12 col-md-4 col-lg-2 footer-links">
                                <h4 class="h4 body-font">{{ __('Business Categories') }}</h4>
                                <ul>
                                <li>
                                <a href="javascript:void(0)">{{ __('FNS Dealer & Distributor') }}</a>
                              </li>
                              <li>
                                <a href="javascript:void(0)">{{ __('FNS Hospitality') }}</a>
                              </li>
                              <li>
                                <a href="javascript:void(0)">{{ __('FNS Corporate Gifting') }}</a>
                              </li>
                              <li>
                                <a href="javascript:void(0)">{{ __('FNS Premium') }}</a>
                              </li>
                              <li>
                                <a href="javascript:void(0)">{{ __('FNS Promoters ') }}</a>
                              </li>

                             <!--    @if($ps->home == 1)
                               <li>
                                <a href="{{ route('front.index') }}">{{ __('Home') }}</a>
                              </li>
                            @endif
                            
                                @if($ps->faq == 1)
                            <li>
                                <a href="{{ route('front.faq') }}">{{ __('Faq') }}</a>
                            </li>
                            @endif
                            <li><a href="{{ route('front.index') }}/payment_terms">Payment Terms</a></li> -->
                                    
                                </ul>
                            </div>
                            <div class="col-12 col-sm-12 col-md-8 col-lg-4 newsletter-col">
                                @if($ps->third_left_banner==1)
                                <div class="display-table pt-md-3 pt-lg-0">
                                    <div class="display-table-cell footer-newsletter">
                                        <form action="{{route('front.subscribe')}}" method="post">
                                            <label class="h4 body-font">{{ __('NEWSLETTER SIGN UP') }}</label>
                                            <p>Enter Your Email To Receive Daily News And Get 20% Off Coupon For All Items.</p>
                                            <div class="input-group">
                                                @csrf
                                                <input type="email" class="brounded-start input-group__field newsletter-input rounded-0 mb-0" name="EMAIL" value="" placeholder="Email address" required>
                                                <span class="input-group__btn">
                                                    <button type="submit" class="btn newsletter__submit rounded-0" name="commit" id="Subscribe"><i class="an an-envelope-l"></i></button>
                                                </span>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                @endif
                                <ul class="list-inline social-icons mt-3 pt-1">
                                 
                                    @if($socialsetting->f_status == 1)
                                <li class="list-inline-item">
                                    <a href="{{ $socialsetting->facebook }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Facebook">
                                        <i class="an an-facebook" aria-hidden="true"></i>
                                    </a>
                                </li>
                                 @endif

                                     @if($socialsetting->f_status == 1)
                                    <li class="list-inline-item">
                                        <a href="{{ $socialsetting->linkedin }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Instagram">
                                            <i class="an an-instagram" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                     @endif
                                       @if($socialsetting->f_status == 1)
                                    <li class="list-inline-item">
                                        <a href="{{ $socialsetting->linkedin }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Instagram">
                                            <i class="an an-linkedin" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                     @endif
                                     
                                

                                @if($socialsetting->f_status == 1)
                                    <li class="list-inline-item">
                                    <a href="{{ $socialsetting->twitter }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Twitter">
                                            <i class="an an-twitter" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                     @endif
                                    @if($socialsetting->f_status == 1)
                                    <li class="list-inline-item">
                                        <a href="{{ $socialsetting->dribble }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Pinterest">
                                            <i class="an an-youtube" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                     @endif
                                   

                                   <!--  @if($socialsetting->f_status == 1)
                                    <li class="list-inline-item">
                                        <a href="{{ $socialsetting->gplus }}" data-bs-toggle="tooltip" data-bs-placement="top" title="TikTok">
                                            <i class="an an-telegram" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                     @endif -->
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-6 mt-4 mt-lg-5">
                                <h4 class="h4 body-font text-transform-none">One-Stop Destination for All Your Needs</h4>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. </p>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-6 mt-4 mt-lg-5">
                                <h4 class="h4 body-font text-transform-none">How to Shop for Cutlury Online in a Smart Way?</h4>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer-bottom clearfix">
                    <div class="container">
                        <div class="d-flex-center flex-column justify-content-md-between flex-md-row-reverse">
                            <img src="../assets/images/payment.png" alt="Paypal Visa Payments"/>
                            <div class="copytext text-uppercase">{{ $gs->copyright }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Footer-->


<div class="what-wrapper">
<a href="https://api.whatsapp.com/send?phone=8860088288" class="float-whats-wrap" target="_blank">
<i class="an an-whatsapp my-float"></i>
</a>
</div>


 


<script src="{{ asset('assets/front/js/extraindex.js') }}"></script>
<script>
  /*-----------------------------------
     25. Tabs With Accordian Responsive
     -------------------------------------*/
    $(".shop-categoery .tab_content").hide();
    $(".shop-categoery .tab_content:first").show();
    /* if in tab mode */
    $(".shop-categoery ul.tabs li").on('click', function () {
        $(".shop-categoery .tab_content").hide();
        var activeTab = $(this).attr("rel");
        $("#" + activeTab).fadeIn();

        $(".shop-categoery ul.tabs li").removeClass("active");
        $(this).addClass("active");

        $(".shop-categoery .tab_drawer_heading").removeClass("d_active");
        $(".shop-categoery .tab_drawer_heading[rel^='" + activeTab + "']").addClass("d_active");

        $('.shop-categoery .shopproductSlider').slick('refresh');
        $('.shop-categoery .shopproductSlider').slick('refresh');
    });
    /* if in drawer mode */
    $(".shop-categoery .tab_drawer_heading").on('click', function () {
        $(".shop-categoery .tab_content").hide();
        var d_activeTab = $(this).attr("rel");
        $("#" + d_activeTab).fadeIn();

        $(".shop-categoery .tab_drawer_heading").removeClass("d_active");
        $(this).addClass("d_active");

        $(".shop-categoery ul.tabs li").removeClass("d_active");
        $(".shop-categoery ul.tabs li[rel^='" + d_activeTab + "']").addClass("d_active");

        $('.shop-categoery .shopproductSlider').slick('refresh');
        $('.shop-categoery .shopproductSlider').slick('refresh');
    });
    $('.shop-categoery ul.tabs li').last().addClass("tab_last");

/*-----------------------------------
     40. Tabs With Accordian Responsive
     -------------------------------------*/
    $(".popular-main-wrapper .tab_content").hide();
    $(".popular-main-wrapper .tab_content:first").show();
    /* if in tab mode */
    $(".popular-main-wrapper ul.tabs li").on('click', function () {
        $(".popular-main-wrapper .tab_content").hide();
        var activeTab = $(this).attr("rel");
        $("#" + activeTab).fadeIn();

        $(".popular-main-wrapper ul.tabs li").removeClass("active");
        $(this).addClass("active");

        $(".popular-main-wrapper .tab_drawer_heading").removeClass("d_active");
        $(".popular-main-wrapper .tab_drawer_heading[rel^='" + activeTab + "']").addClass("d_active");

        $('.popular-main-wrapper .productSlider').slick('refresh');
        $('.popular-main-wrapper .productSlider').slick('refresh');
    });
    /* if in drawer mode */
    $(".popular-main-wrapper .tab_drawer_heading").on('click', function () {
        $(".popular-main-wrapper .tab_content").hide();
        var d_activeTab = $(this).attr("rel");
        $("#" + d_activeTab).fadeIn();

        $(".popular-main-wrapper .tab_drawer_heading").removeClass("d_active");
        $(this).addClass("d_active");

        $(".popular-main-wrapper ul.tabs li").removeClass("d_active");
        $(".popular-main-wrapper ul.tabs li[rel^='" + d_activeTab + "']").addClass("d_active");

        $('.popular-main-wrapper .productSlider').slick('refresh');
        $('.popular-main-wrapper .productSlider').slick('refresh');
    });
    $('.popular-main-wrapper ul.tabs li').last().addClass("tab_last");

    $(".lauch-wrapper .tab_content").hide();
    $(".lauch-wrapper .tab_content:first").show();
    /* if in tab mode */
    $(".lauch-wrapper ul.tabs li").on('click', function () {
        $(".lauch-wrapper .tab_content").hide();
        var activeTab = $(this).attr("rel");
        $("#" + activeTab).fadeIn();

        $(".lauch-wrapper ul.tabs li").removeClass("active");
        $(this).addClass("active");

        $(".lauch-wrapper .tab_drawer_heading").removeClass("d_active");
        $(".lauch-wrapper .tab_drawer_heading[rel^='" + activeTab + "']").addClass("d_active");

        $('.lauch-wrapper .productSlider').slick('refresh');
        $('.lauch-wrapper .productSlider').slick('refresh');
    });
    /* if in drawer mode */
    $(".lauch-wrapper .tab_drawer_heading").on('click', function () {
        $(".lauch-wrapper .tab_content").hide();
        var d_activeTab = $(this).attr("rel");
        $("#" + d_activeTab).fadeIn();

        $(".lauch-wrapper .tab_drawer_heading").removeClass("d_active");
        $(this).addClass("d_active");

        $(".lauch-wrapper ul.tabs li").removeClass("d_active");
        $(".lauch-wrapper ul.tabs li[rel^='" + d_activeTab + "']").addClass("d_active");

        $('.lauch-wrapper .productSlider').slick('refresh');
        $('.lauch-wrapper .productSlider').slick('refresh');
    });
    $('.lauch-wrapper ul.tabs li').last().addClass("tab_last");



     /* 9.4 Products Slider */
    function shop_product_slider() {
        $('.shopproductSlider').slick({
            dots: false,
            infinite: true,
            rows:2,
            slidesToShow: 4,
            slidesToScroll: 1,
            arrows: true,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                }
            ]

        });
    }
    shop_product_slider();

   /* 9.4 Products Slider */
    function product_slider() {
        $('.productSlider').slick({
            dots: false,
            infinite: true,
            slidesToShow: 4,
            slidesToScroll: 1,
            arrows: true,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                }
            ]

        });
    }
    product_slider();

/* 9.15 Latest Blog Slider */
    function blogpost_slider() {
        $('.blog-post-slider').slick({
            dots: false,
            infinite: true,
            slidesToShow: 4,
            slidesToScroll: 1,
            arrows: true,
            responsive: [
                {
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    }
    blogpost_slider();

           function cutleryvideo_slider() {
        $('.cutlery-video-slides').slick({
            dots: false,
            infinite: true,
            slidesToShow: 5,
            slidesToScroll: 1,
            arrows: true,            
            responsive: [
                {
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    }
   cutleryvideo_slider();

         function happycustomer_slider() {
        $('.happy-customer-slider').slick({
            dots: true,
            infinite: true,
            slidesToShow: 4,
            slidesToScroll: 1,
            arrows: true,
            responsive: [
                {
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    }
   happycustomer_slider();

       function testimonial_slider() {
        $('.quotes-slider').slick({
            dots: true,
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 1,
            arrows: true,
            adaptiveHeight: true,
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        arrows: false
                    }
                },
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                        arrows: false
                    }
                },
                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        arrows: false
                    }
                }
            ]
        });
    }
    testimonial_slider();


    function quick_view_popup() {
        $("body").on("click", ".quick-view-popup", function (e) {
            $.ajax({
                beforeSend: function () {
                    $("body").addClass("loading");
                },
                complete: function () {
                    $("body").removeClass("loading");
                }
            });
        });

        $('.quick-view-popup').magnificPopup({
            items: {
                src: '#quickView-modal'
            },
            type: 'inline',
            midClick: true,
            removalDelay: 500,
            mainClass: 'mfp-zoom-in'
        });
    }
    quick_view_popup();

</script>
<script>

    $(".lazy").Lazy();
</script>

