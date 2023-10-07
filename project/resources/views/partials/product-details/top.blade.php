<div class="full-row pb-0 product-detail-wrapper">
    <div class="container">
        <div class="row single-product-wrapper">
            <div class="col-12 col-lg-7 col-md-6 mb-4 mb-lg-0 ps-lg-0">
               <div class="product-details-img thumb-left clearfix d-flex-wrap mb-3 mb-md-0">
                                    <div class="product-thumb">
                                        <div id="gallery" class="product-dec-slider-2 product-tab-left">
                                            @foreach ($productt->galleries as $gal)
                                            <a data-image="{{ asset('assets/images/galleries/' . $gal->photo) }}" data-zoom-image="{{ asset('assets/images/galleries/' . $gal->photo) }}" class="slick-slide slick-cloned">
                                                <img class="blur-up lazyload" data-src="{{ asset('assets/images/galleries/' . $gal->photo) }}" src="{{ asset('assets/images/galleries/' . $gal->photo) }}" alt="product" />
                                            </a>
                                            @endforeach
                                            
                                        </div>
                                    </div>
                                    <div class="zoompro-wrap product-zoom-right">
                                        <div class="zoompro-span"><img id="zoompro" class="zoompro" src="{{ filter_var($productt->photo, FILTER_VALIDATE_URL) ? $productt->photo : asset('assets/images/products/' . $productt->photo) }}" data-zoom-image="{{ filter_var($productt->photo, FILTER_VALIDATE_URL) ? $productt->photo : asset('assets/images/products/' . $productt->photo) }}" alt="product" /></div>
                                       <div class="product-buttons">
                                            <a href="#" class="btn rounded youtube-popup"><i class="icon an an-video"></i><span class="tooltip-label">Watch Video</span></a>
                                        </div>
                                        
                                    </div>
                                   
                                </div>
            </div>

            <div class="col-12 col-lg-5 col-md-6 ps-lg-3 col-md-5">

                <div class="summary entry-summary">
                    <div class="summary-inner">
                        <div class="entry-breadcrumbs w-100">
                            <nav class="breadcrumb-divider-slash" aria-label="breadcrumb">
                                <ol class="breadcrumb pro-bread">
                                    <li class="breadcrumb-item"><a
                                            href="{{ route('front.index') }}">{{ __('Home') }}</a></li>
                                    <li class="breadcrumb-item"><a
                                            href="{{ route('front.category', $productt->category->slug) }}">{{ $productt->category->name }}</a>
                                    </li>
                                    @if ($productt->subcategory_id != null)
                                        <li class="breadcrumb-item">
                                            <a
                                                href="{{ route('front.category', [$productt->category->slug, $productt->subcategory->slug]) }}">
                                                {{ $productt->subcategory->name }}
                                            </a>
                                        </li>
                                    @endif
                                    @if ($productt->childcategory_id != null)
                                        <li class="breadcrumb-item">
                                            <a
                                                href="{{ route('front.category', [$productt->category->slug, $productt->subcategory->slug, $productt->childcategory->slug]) }}">
                                                {{ $productt->childcategory->name }}
                                            </a>
                                        </li>
                                    @endif

                                </ol>
                            </nav>
                        </div>
                        <h1 class="product_title entry-title">{{ $productt->name }}</h1>

                        <div class="pro-details">
                            <div class="pro-info">
                                <div class="woocommerce-product-rating">
                                    <div class="fancy-star-rating">
                                        <div class="rating-wrap"> <span
                                                class="fancy-rating good">{{ App\Models\Rating::ratings($productt->id) }}
                                                ★</span>
                                        </div>
                                        <div class="rating-counts-wrap">
                                            <a href="#reviews" class="bigbazar-rating-review-link" rel="nofollow"> <span
                                                    class="rating-counts">
                                                    ({{ App\Models\Rating::ratingCount($productt->id) }}) </span> </a>
                                        </div>
                                    </div>
                                </div>

                                <p class="price">
                                    <span class="woocommerce-Price-amount amount mr-4">
                                        <bdi><span class="woocommerce-Price-currencySymbol"
                                                id="sizeprice">{{ $productt->showPrice() }}</bdi>
                                    </span>
                                    <del class="ml-3"><small>{{ $productt->showPreviousPrice() }}</small></del>
                                    <span class="on-sale ms-3"><span>{{ round((int) $productt->offPercentage()) }}</span>%
                                        Off</span>

                                </p>

                               


                                {{-- PRODUCT OTHER DETAILS SECTION --}}
                                <div class="product-offers">
                                    <ul class="product-offers-list">
                                        @if ($productt->ship != null)
                                            <li class="product-offer-item"><span
                                                    class="h6">{{ __('Estimated Shipping Time:') }}</span>
                                                {{ $productt->ship }}
                                            </li>
                                        @endif
                                        @if ($productt->sku != null)
                                            <li
                                                class="product-offer-item product-id{{ $productt->product_type == 'affiliate' ? 'mt-4' : '' }}">
                                                <span class="h6">{{ __('Product SKU:') }} </span>
                                                {{ $productt->sku }}
                                            </li>
                                        @endif

                                       @if($productt->policy != null)
                                       {!! clean($productt->policy, ['Attr.EnableID' => true]) !!}
                                       @endif


                                        {{-- PRODUCT LICENSE SECTION --}}
                                        @if ($productt->type == 'License')
                                            @if ($productt->platform != null)
                                                <li class="product-offer-item license-id"><span
                                                        class="h6">{{ __('Platform:') }}</span>
                                                    {{ $productt->platform }}
                                                </li>
                                            @endif
                                            @if ($productt->region != null)
                                                <li class="product-offer-item license-id"><span
                                                        class="h6">{{ __('Region:') }}</span>
                                                    {{ $productt->region }}
                                                </li>
                                            @endif
                                            @if ($productt->licence_type != null)
                                                <li class="product-offer-item license-id"><span class="h6">
                                                        {{ __('License Type:') }}</span> {{ $productt->licence_type }}
                                                </li>
                                            @endif
                                        @endif
                                        {{-- PRODUCT LICENSE SECTION ENDS --}}
                                    </ul>
                                </div>
                            </div>
                            {{-- PRODUCT OTHER DETAILS SECTION ENDS --}}
                        </div>
                        @if ($productt->stock_check == 1)
                            @if (!empty($productt->size))
                                <div class="product-size">
                                    <p class="title">{{ __('Size :') }}</p>
                                    <ul class="siz-list">
                                        @foreach (array_unique($productt->size) as $key => $data1)
                                            <li class="{{ $loop->first ? 'active' : '' }}"
                                                data-key="{{ str_replace(' ', '', $data1) }}">
                                                <span class="box">
                                                    {{ $data1 }}
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            {{-- PRODUCT COLOR SECTION  --}}

                            @if (!empty($productt->color))

                                <div class="product-color">
                                    <div class="title">{{ __('Color :') }}</div>
                                    <ul class="color-list">
                                        @foreach ($productt->color as $key => $data1)
                                            <li
                                                class="{{ $loop->first ? 'active' : '' }} {{ $productt->IsSizeColor($productt->size[$key]) ? str_replace(' ', '', $productt->size[$key]) : '' }} {{ $productt->size[$key] == $productt->size[0] ? 'show-colors' : '' }}">
                                                <span class="box" data-color="{{ $productt->color[$key] }}"
                                                    style="background-color: {{ $productt->color[$key] }}">

                                                    <input type="hidden" class="size"
                                                        value="{{ $productt->size[$key] }}">
                                                    <input type="hidden" class="size_qty"
                                                        value="{{ $productt->size_qty[$key] }}">
                                                    <input type="hidden" class="size_key" value="{{ $key }}">
                                                    <input type="hidden" class="size_price"
                                                        value="{{ round($productt->size_price[$key] * $curr->value, 2) }}">

                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                            @endif

                            {{-- PRODUCT COLOR SECTION ENDS  --}}
                        @else
                            @if (!empty($productt->size_all))
                                <div class="product-size" data-key="false">
                                    <p class="title">{{ __('Size :') }}</p>
                                    <ul class="siz-list">
                                        @foreach (array_unique(explode(',', $productt->size_all)) as $key => $data1)
                                            <li class="{{ $loop->first ? 'active' : '' }}"
                                                data-key="{{ str_replace(' ', '', $data1) }}">
                                                <span class="box">
                                                    {{ $data1 }}
                                                    <input type="hidden" class="size"
                                                        value="{{ $data1 }}">
                                                    <input type="hidden" class="size_key"
                                                        value="{{ $key }}">
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if (!empty($productt->color_all))
                                <div class="product-color" data-key="false">
                                    <div class="title">{{ __('Color :') }}</div>
                                    <ul class="color-list">

                                        @foreach (explode(',', $productt->color_all) as $key => $color1)
                                            <li class="{{ $loop->first ? 'active' : '' }} show-colors">
                                                <span class="box" data-color="{{ $color1 }}"
                                                    style="background-color: {{ $color1 }}">
                                                    <input type="hidden" class="size_price" value="0">
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif



                            @if (!empty($productt->variation))
                            <div class="variation-details mt-3">
                                <h4 class="title">Variation :</h4>
                                <ul class="variation-inline-wrap">
                            @foreach (explode(',', $productt->variation) as $key => $variation1)
                                @foreach(DB::table('products')->where('sku',$variation1)->get() as $ldata)
                                
                                  <li class="variation-img">
                                    <a href="{{ route('front.product', $ldata->slug) }}">
                            <img src="{{ asset('assets/images/products/' . $ldata->photo) }}">
                            </a>
                                  </li>
                                <!-- <p class="variation-blog">{{ $ldata->name }}</p> -->
                                
                                @endforeach
                            @endforeach
                        </ul>
                            </div>
                            @endif
                        @endif

                        <input type="hidden" id="product_price"
                            value="{{ round($productt->vendorPrice() * $curr->value, 2) }}">
                        <input type="hidden" id="product_id" value="{{ $productt->id }}">
                        <input type="hidden" id="curr_pos" value="{{ $gs->currency_format }}">
                        <input type="hidden" id="curr_sign" value="{{ $curr->sign }}">
                        {{-- PRODUCT STOCK CONDITION SECTION  --}}

                        @if (!empty($productt->size))
                            <input type="hidden" id="stock" value="{{ $productt->size_qty[0] }}">
                        @else
                            @if (!$productt->emptyStock())
                                <input type="hidden" id="stock" value="{{ $productt->stock }}">
                            @elseif($productt->type != 'Physical')
                                <input type="hidden" id="stock" value="0">
                            @else
                                <input type="hidden" id="stock" value="">
                            @endif
                        @endif
                        @if ($ps->deal_of_the_day == 1)
                            @if ($productt->is_discount == 1 && $productt->discount_date >= date('Y-m-d') && $productt->user->is_vendor == 2)
                                <div class="time-count time-box text-center my-30 flex-between w-75"
                                    data-countdown="{{ $productt['discount_date'] }}"></div>
                            @endif
                        @endif
                        {{-- PRODUCT STOCK CONDITION SECTION ENDS --}}
                        <div class="product-stock-wrap mt-4">
                            <div class="qty-stock-wrap d-flex align-items-center">
                            @if ($productt->product_type != 'affiliate' && $productt->type == 'Physical')
                                <div class="multiple-item-price me-4">
                                    <div class="qty mb-0">
                                        <ul class="qty-buttons d-flex">
                                            <li>
                                                <span class="qtminus">
                                                    <i class="icofont-minus"></i>
                                                </span>
                                            </li>
                                            <li>
                                                <input class="qttotal" type="text" id="order-qty"
                                                    value="{{ $productt->minimum_qty == null ? '1' : (int) $productt->minimum_qty }}">
                                                <input type="hidden" id="affilate_user"
                                                    value="{{ $affilate_user }}">
                                                <input type="hidden" id="product_minimum_qty"
                                                    value="{{ $productt->minimum_qty == null ? '0' : $productt->minimum_qty }}">
                                            </li>
                                            <li>
                                                <span class="qtplus">
                                                    <i class="icofont-plus"></i>
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            @endif

                             @if ($productt->type == 'Physical')
                                    @if ($productt->emptyStock())
                                        <div class="stock-availability out-stock m-0">{{ 'Out Of Stock' }}</div>
                                    @else
                                        <div class="stock-availability in-stock text-bold">
                                            {{ $gs->show_stock == 0 ? '' : $productt->stock }} {{ 'In Stock' }}
                                        </div>
                                    @endif
                                @endif

                            </div>

                            


                            {{-- PRODUCT QUANTITY SECTION ENDS --}}
                            <ul class="mt-4 mb-4">
                                @if ($productt->product_type == 'affiliate')

                                    <li class="addtocart">
                                        <a href="javascript:;" class="affilate-btn"
                                            data-href="{{ $productt->affiliate_link }}" target="_blank">
                                            {{ __('Buy Now') }}</a>
                                    </li>
                                @else
                                    @if ($productt->emptyStock())
                                        <li class="addtocart">
                                            <a href="javascript:;" class="cart-out-of-stock">

                                                {{ __('Out Of Stock') }}</a>
                                        </li>
                                    @else
                                        <li class="addtocart">
                                            <a href="javascript:;" id="addcrt">{{ __('Add to Cart') }}</a>
                                        </li>

                                        <li class="addtocart">
                                            <a id="qaddcrt" href="javascript:;">
                                                {{ __('Buy Now') }}
                                            </a>
                                        </li>
                                        <li class="addtocart pin-btn ms-0 m-1">
                                            <a data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                href="javascript:;">
                                                {{ __('Check Pin code Delivery') }}
                                            </a>
                                        </li>
                                    @endif
                            </ul>
                            @endif
                        </div>
                       

                        @if ($gs->is_report)

                            {{-- PRODUCT REPORT SECTION --}}

                            @if (Auth::guard('web')->check())
                                <div class="report-area">
                                    <a class="report-item" href="javascript:;" data-bs-toggle="modal"
                                        data-bs-target="#report-modal"><i class="fas fa-flag"></i>
                                        {{ __('Report This Item') }}</a>
                                </div>
                            @else
                                <div class="report-area">
                                    <a class="report-item" href="{{ route('user.login') }}"><i
                                            class="fas fa-flag"></i> {{ __('Report This Item') }} </a>
                                </div>
                            @endif

                            {{-- PRODUCT REPORT SECTION ENDS --}}

                        @endif

                        <div class="my-2 social-linkss social-sharing a2a_kit a2a_kit_size_32 d-flex">
                            <h5 class="mb-2">{{ __('Share Now') }}</h5>
                            <ul class="social-icons py-1 share-product social-linkss py-md-0">
                                <li>
                                    <a class="facebook a2a_button_facebook" href="">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                </li>
                                <li>
                                    <a class="twitter a2a_button_twitter" href="">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                </li>
                                <li>
                                    <a class="linkedin a2a_button_linkedin" href="">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                </li>
                                <li>
                                    <a class="pinterest a2a_button_pinterest" href="">
                                        <i class="fab fa-pinterest-p"></i>
                                    </a>
                                </li>
                                <li>
                                    <a class="instagram a2a_button_whatsapp" href="">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                </li>
                            </ul>

                             <div class="yith-wcwl-add-to-wishlist wishlist-fragment d-flex align-itens-center ms-5">
                            @if (Auth::check())
                                <div class="wishlist-button mb-0 me-4">
                                    <a class="add_to_wishlist new" id="add-to-wish" href="javascript:;"
                                        data-href="{{ route('user-wishlist-add', $productt->id) }}"data-bs-toggle="tooltip"
                                        data-bs-placement="top" title=""
                                        data-bs-original-title="Add to Wishlist"
                                        aria-label="Add to Wishlist">{{ __('Wishlist') }}</a>
                                </div>
                            @else
                                <div class="wishlist-button mb-0 me-4">
                                    <a class="add_to_wishlist" href="{{ route('user.login') }}"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                        data-bs-original-title="Add to Wishlist"
                                        aria-label="Add to Wishlist">{{ __('Wishlist') }}</a>
                                </div>
                            @endif
                            <div class="compare-button me-4">
                                <a class="compare button"
                                    data-href="{{ route('product.compare.add', $productt->id) }}" href="javascrit:;"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                    data-bs-original-title="Compare" aria-label="Compare">{{ __('Compare') }}</a>
                            </div>

                        </div>


                        </div>
                        <script async src="https://static.addtoany.com/menu/page.js"></script>


                    </div>
                </div>
            </div>


            <div class="row row-cols-xl-5 row-cols-md-3 row-cols-sm-2 row-cols-1 product-attributes my-5">
               
                        @if (!empty($productt->attributes))
                            @php
                                $attrArr = json_decode($productt->attributes, true);
                            @endphp
                        @endif
                        @if (!empty($attrArr))

                                    @foreach ($attrArr as $attrKey => $attrVal)
                                        @if (array_key_exists('details_status', $attrVal) && $attrVal['details_status'] == 1)
                                            <div class="col brands-group">
                                                <div class="form-group">
                                                    <strong
                                                        class="text-capitalize mb-2 d-block">{{ str_replace('_', ' ', $attrKey) }}
                                                        :</strong>
                                                    <div class="brand-box-wrap">
                                                        @foreach ($attrVal['values'] as $optionKey => $optionVal)
                                                            <div class="custom-control custom-radio form-check">
                                                                <input type="hidden" class="keys" value="">
                                                                <input type="hidden" class="values" value="">
                                                                <input type="radio"
                                                                    id="{{ $attrKey }}{{ $optionKey }}"
                                                                    name="{{ $attrKey }}"
                                                                    class="form-check-input custom-control-input product-attr"
                                                                    data-key="{{ $attrKey }}"
                                                                    data-price="{{ $attrVal['prices'][$optionKey] * $curr->value }}"
                                                                    value="{{ $optionVal }}"
                                                                    {{ $loop->first ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="{{ $attrKey }}{{ $optionKey }}">{{ $optionVal }}

                                                                    @if (!empty($attrVal['prices'][$optionKey]))
                                                                        +
                                                                        {{ $curr->sign }}
                                                                        {{ $attrVal['prices'][$optionKey] * $curr->value }}
                                                                    @endif
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                               
                        @endif


                @if (!empty($productt->whole_sell_qty))
                <div class="col brands-group">
                    <div class="pro-summary mb-4">
                        <div class="price-summary">
                            <div class="price-summary-content">
                                <h5 class="text-center mb-2">{{ __('Wholesell') }}</h5>
                                <ul class="price-summary-list">
                                    <li class="regular-price">
                                        <h6 class="mb-1">{{ __('Quantity') }}</h6>
                                        <span>
                                            <span class="woocommerce-Price-amount amount">
                                                <h6 class="mb-1">{{ __('Discount') }}</h6>
                                            </span>
                                        </span>
                                    </li>
                                    @foreach ($productt->whole_sell_qty as $key => $data1)
                                        <li class="selling-price">
                                            <label>{{ $productt->whole_sell_qty[$key] }}+</label> <span><span
                                                    class="woocommerce-Price-amount amount">{{ $productt->whole_sell_discount[$key] }}%
                                                    {{ __('Off') }}
                                                </span>
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

              <!--   @php
                print_r($relatedProducts);
                @endphp
                  -->


              


                
            </div>


        </div>


           <div class="row frequent-main-wrapper">
                @if (count($relatedProducts) > 0)
                    <div class="col-xl-10">
                       <!--  <div class="mb-4 d-xl-none">
                            <button class="dashboard-sidebar-btn btn bg-primary rounded">
                                <i class="fas fa-bars"></i>
                            </button>
                        </div> -->
                        <h4 class="text-center mb-0">Frequently Bought Together</h4>
                        <div class="showing-products pt-40 pb-50 border-2 border-bottom border-light" id="ajaxContent">
                            <div class="row align-items-center" id="multiple-cart-load">
                                <div class="col-lg-9">
                            <div class="row row-cols-xl-4 row-cols-md-3 row-cols-sm-3 row-cols-3 product-style-1 e-title-hover-primary e-image-bg-light e-hover-image-zoom e-info-center justify-content-center">

                             @foreach($relatedProducts as $key => $getproduct)
                             @php                            
                            $productDetails = DB::table('products')->where('id',$key)->get();

                            @endphp
                            @foreach($productDetails as $product)
                            @includeIf('partials.product.frequent')
                            @endforeach
                            @endforeach
                            </div>
                        </div>
                        <div class="col-lg-3">
                        <div class="row row-cols-xl-1 row-cols-md-1 row-cols-sm-1 row-cols-1">
                             <div class="frequent-box-wrap">
                                 <p>Total : <span>1900</span></p>
                                 <div class="frequent-btn">
                                 <a href="javascript:;" class="freq_add btn btn-md btn-danger">Add to cart</a>
                             </div>
                             </div>
                            </div>
                        </div>

                            </div>      
                        </div>
                       
                    </div>
                @else
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="page-center">
                                    <h4 class="text-center">{{ __('No Product Found.') }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>









    </div>
</div>


<div class="youtube-popup-wrapper">
    <div class="you-sec">
        <button title="Close (Esc)" type="button" class="you-close">×</button>
        <iframe width="640" height="360" src="https://www.youtube.com/embed/VifAi6Ob1sA?si=Yl2j9mFSLwU_LshC" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
    </div>
</div>




{{-- MESSAGE MODAL --}}
{{-- MESSAGE MODAL --}}
<div class="message-modal">
    <div class="modal" id="vendorform" tabindex="-1" role="dialog" aria-labelledby="vendorformLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="vendorformLabel">{{ __('Send Message') }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid p-0">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="contact-form">
                                    <form id="emailreply">
                                        {{ csrf_field() }}
                                        <ul>

                                            <li>
                                                <input type="email" class="form-control border mb-1" id="eml"
                                                    name="email" placeholder="{{ __('Email *') }}"
                                                    required="">
                                            </li>


                                            <li>
                                                <input type="text" class="form-control border mb-1" id="subj"
                                                    name="subject" placeholder="{{ __('Subject *') }}"
                                                    required="">
                                            </li>

                                            <li>
                                                <textarea class="form-control textarea border mb-1" name="message" id="msg"
                                                    placeholder="{{ __('Your Message *') }}" required=""></textarea>
                                            </li>

                                            <input type="hidden" name="name"
                                                value="{{ Auth::user() ? Auth::user()->name : '' }}">
                                            <input type="hidden" name="user_id"
                                                value="{{ Auth::user() ? Auth::user()->id : '' }}">

                                        </ul>
                                        <button class="submit-btn" id="emlsub"
                                            type="submit">{{ __('Send Message') }}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MESSAGE MODAL ENDS --}}

{{-- MESSAGE MODAL ENDS --}}

<div class="message-modal">
    <div class="modal show" id="sendMessage" tabindex="-1" role="dialog" aria-labelledby="sendMessageLabel"
        aria-modal="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sendMessageLabel">{{ __('Send Message') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid p-0">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="contact-form">
                                    <form action="{{ route('user-send-message') }}" class="emailreply">
                                        @csrf
                                        <ul>
                                            <li>
                                                <input type="text" class="input-field" name="subject"
                                                    placeholder="{{ __('Subject *') }}" required="">
                                            </li>
                                            <li>
                                                <textarea class="input-field textarea" name="message" placeholder="{{ __('Your Message') }}" required=""></textarea>
                                            </li>
                                            <input type="hidden" name="type" value="Ticket">
                                        </ul>
                                        <button class="submit-btn" type="submit">{{ __('Send Message') }}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Check Pin code delivery availablity</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" id="mainErrorMsg" role="alert" style="display: none;">
                    <strong class="errorMsg">Kindly Provide the Pincode and Payment Type</strong>
                </div>
                <div class="alert alert-success" id="mainSuccessMsg" role="alert" style="display: none;">
                    <strong class="successMsg"></strong>
                </div>
                <form class="form-horizontal sign-in-form" style="padding:0px !important;">
                    <input type="text" class="form-control" id="pincodeValue" placeholder="Enter Pincode">
                    <div class="form-check mt-2">
                        <input type="radio" name="paymentType" class="paymentType" value="cod"
                            style="width: 5%;">
                        <label class="form-check-label" for="flexRadioDefault2" style="position: relative; top:4px;">
                            COD Payment
                        </label>
                        <input type="radio" name="paymentType" class="paymentType" value="online"
                            style="width: 5%;">
                        <label class="form-check-label" for="flexRadioDefault2" style="position: relative; top:4px;">
                            Online Payment
                        </label>
                        <input type="hidden" name="wight" class="wightproduct" value="{{ $productt->weight }}">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="checkPicodeAvailablity" class="btn btn-primary">Check</button>
            </div>
        </div>
    </div>
</div>
@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#mainErrorMsg').hide();
            $('#mainSuccessMsg').hide();
            $('#checkPicodeAvailablity').click(function(e) {
                //e.preventDefault();
                var pincodeval = $('#pincodeValue').val();
                var wightproduct = $('.wightproduct').val();
                var paymenttypeVal = $('input[name="paymentType"]:checked').val();
                if (pincodeval == '' || isNaN(pincodeval)) {
                    $('#mainErrorMsg').show();
                    $('strong.errorMsg').html('please enter a valid pincode value');
                    return false;
                }
                if (paymenttypeVal == null) {
                    $('#mainErrorMsg').show();
                    $('strong.errorMsg').html('please select payment type');
                    return false;
                }

                $.ajax({
                    'type': 'POST',
                    'url': "{{ route('check.pincode.availability') }}",
                    'data': {
                        valueOfpincode: pincodeval,
                        typofPayment: paymenttypeVal,
                        weight: wightproduct
                    },
                    'dataType': 'json',
                    success: function(successData) {
                        if (successData.status == 'success') {
                            $('#mainSuccessMsg').show();
                            $('strong.successMsg').html(successData.message);
                        } else {
                            $('#mainErrorMsg').show();
                            $('strong.errorMsg').html(successData.message);
                        }
                    }
                });
            });
            $('#exampleModal').on('hidden.bs.modal', function() {
                $('#mainErrorMsg').hide();
                $('#mainSuccessMsg').hide();
                $(this).find('form').trigger('reset');
            })
        })
    </script>
    <script>
        $(document).ready(function() {
  $('.youtube-popup').click(function() {
    $('.youtube-popup-wrapper').show();
  });

  $('.you-close').click(function() {
    $('.youtube-popup-wrapper').hide();
  });
});
    </script>

@endsection
