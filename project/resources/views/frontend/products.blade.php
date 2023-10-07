@extends('layouts.front')
@section('content')
    @includeIf('partials.global.common-header')
    <!-- breadcrumb -->
    <div class="full-row bg-light overlay-dark py-5"
        style="background-image: url({{ $gs->breadcrumb_banner ? asset('assets/images/' . $gs->breadcrumb_banner) : asset('assets/images/noimage.png') }}); background-position: center center; background-size: cover;">
        <div class="container">
            <div class="row text-center text-white">
                <div class="col-12">
                    <h3 class="mb-2 text-white">{{ __('Product') }}</h3>
                </div>
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 d-inline-flex bg-transparent p-0">
                            <li class="breadcrumb-item"><a href="{{ route('front.index') }}">{{ __('Home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Product') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
    {{-- There are two product page. you have to give condition here --}}
    <div class="full-row">
        <div class="container">
            <div class="row">
                @includeIf('partials.catalog.catalog')
                @if (count($prods) > 0)
                    <div class="col-xl-9">
                        <div class="mb-4 d-xl-none">
                            <button class="dashboard-sidebar-btn btn bg-primary rounded">
                                <i class="fas fa-bars"></i>
                            </button>
                        </div>
                        @includeIf('frontend.category')
                        <div class="showing-products pt-30 pb-50 border-2 border-bottom border-light" id="ajaxContent">
                            @includeIf('partials.product.product-different-view')
                        </div>
                        @include('frontend.pagination.product')
                    </div>
                @else
                    <div class="col-lg-9">
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

            <div class="row mx-0">
            <div class="col-12">
                <div class="section-head border-bottom d-flex justify-content-between align-items-center">
                    <div class="d-flex section-head-side-title">
                        <h5 class="font-700 text-dark mb-0">{{ __('Recent Product') }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="product-style-2 owl-carousel owl-nav-hover-primary nav-top-right single-carousel dot-disable product-list e-bg-white">

                    @foreach (array_chunk($latest_products->toArray(),4) as $item)

                    <div class="item">
                        <div class="row row-cols-1">
                            @foreach ($item as $prod)

                            <div class="col-lg-3 col-md-4 col-6 mb-1">
                                <div class="product type-product">
                                    <div class="product-wrapper">
                                        <div class="product-image">
                                            <a href="{{ route('front.product', $prod['slug']) }}" class="woocommerce-LoopProduct-link"><img class="lazy" data-src="{{ $prod['thumbnail'] ? asset('assets/images/thumbnails/'.$prod['thumbnail'] ):asset('assets/images/noimage.png') }}" alt="Product Image"></a>
                                            <div class="wishlist-view">
                                                <div class="quickview-button">
                                                    <a class="quickview-btn" href="{{ route('front.product', $prod['slug']) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Quick View" aria-label="Quick View">{{ __('Quick View') }}</a>
                                                </div>
                                                <div class="whishlist-button">
                                                    <a class="add_to_wishlist" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Add to Wishlist" aria-label="Add to Wishlist">{{ __('Wishlist') }}</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-info">
                                            <h3 class="product-title"><a href="{{ route('front.product', $prod['slug']) }}">{{ App\Models\Product::whereId($prod['id'])->first()->showName() }}</a></h3>
                                            <div class="product-price">
                                                <div class="price">
                                                    <ins>{{ App\Models\Product::whereId($prod['id'])->first()->showPrice() }}</ins>
                                                    <del>{{ App\Models\Product::whereId($prod['id'])->first()->showPreviousPrice() }}</del>
                                                </div>
                                                <div class="on-sale"><span>{{ round(App\Models\Product::whereId($prod['id'])->first()->offPercentage())}}</span><span>% off</span></div>
                                            </div>
                                            <div class="shipping-feed-back">
                                                <div class="star-rating">
                                                    <div class="rating-wrap">
                                                        <p><i class="fas fa-star"></i><span> {{ App\Models\Rating::ratings($prod['id']) }}</span></p>
                                                    </div>
                                                    <div class="rating-counts-wrap">
                                                        <p>({{ App\Models\Rating::ratingCount($prod['id']) }})</p>
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

                    @endforeach



                </div>
            </div>
        </div>



        </div>
    </div>
    {{-- @includeIf('partials.product.grid') --}}
    @includeIf('partials.global.common-footer')
@endsection
@section('script')
    <script>
        let check_view = '';
        $(document).on('click', '.check_view', function() {
            check_view = $(this).attr('data-shopview');
            filter();
            $('.check_view').removeClass('active');
            $(this).addClass('active');


        });


        // when dynamic attribute changes
        $(".attribute-input, .set-input, .color-input, .size-input, #sortby, #pageby").on('change', function() {
            $(".ajax-loader").show();
            filter();
        });


        function filter() {
            let filterlink = '';

            if ($("#prod_name").val() != '') {
                if (filterlink == '') {
                    filterlink +=
                        '{{ route('front.category', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')]) }}' +
                        '?search=' + $("#prod_name").val();
                } else {
                    filterlink += '&search=' + $("#prod_name").val();
                }
            }



            $(".attribute-input").each(function() {
                if ($(this).is(':checked')) {

                    if (filterlink == '') {
                        filterlink +=
                            '{{ route('front.category', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')]) }}' +
                            '?' + $(this).attr('name') + '=' + $(this).val();
                    } else {
                        filterlink += '&' + encodeURI($(this).attr('name')) + '=' + $(this).val();

                    }
                }
            });

            $(".set-input").each(function() {
      if ($(this).is(':checked')) {
        if (filterlink == '') {
          filterlink += '{{route('front.category', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')])}}' + '?'+$(this).attr('name')+'='+$(this).val();

        
        } else {
          filterlink += '&'+$(this).attr('name')+'='+$(this).val();
          
        }
      }
    });

              $(".color-input").each(function() {
      if ($(this).is(':checked')) {
        if (filterlink == '') {
          filterlink += '{{route('front.category', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')])}}' + '?'+$(this).attr('name')+'='+$(this).val();

        
        } else {
          filterlink += '&'+$(this).attr('name')+'='+$(this).val();
          
        }
      }
    });

        $(".size-input").each(function() {
      if ($(this).is(':checked')) {
        if (filterlink == '') {
          filterlink += '{{route('front.category', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')])}}' + '?'+$(this).attr('name')+'='+$(this).val();

        
        } else {
          filterlink += '&'+$(this).attr('name')+'='+$(this).val();
          
        }
      }
    });

      

            if ($("#sortby").val() != '') {
                if (filterlink == '') {
                    filterlink +=
                        '{{ route('front.category', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')]) }}' +
                        '?' + $("#sortby").attr('name') + '=' + $("#sortby").val();
                } else {
                    filterlink += '&' + $("#sortby").attr('name') + '=' + $("#sortby").val();
                }
            }


            if ($("#min_price").val() != '') {
                if (filterlink == '') {
                    filterlink +=
                        '{{ route('front.category', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')]) }}' +
                        '?' + $("#min_price").attr('name') + '=' + $("#min_price").val();
                } else {
                    filterlink += '&' + $("#min_price").attr('name') + '=' + $("#min_price").val();
                }
            }

            if ($("#max_price").val() != '') {
                if (filterlink == '') {
                    filterlink +=
                        '{{ route('front.category', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')]) }}' +
                        '?' + $("#max_price").attr('name') + '=' + $("#max_price").val();
                } else {
                    filterlink += '&' + $("#max_price").attr('name') + '=' + $("#max_price").val();
                }
            }


            if ($("#pageby").val() != '') {
                if (filterlink == '') {
                    filterlink +=
                        '{{ route('front.category', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')]) }}' +
                        '?' + $("#pageby").attr('name') + '=' + $("#pageby").val();
                } else {
                    filterlink += '&' + $("#pageby").attr('name') + '=' + $("#pageby").val();
                }
            }

            if (check_view) {

                filterlink += '&view_check=' + check_view;
            }
            $("#ajaxContent").load(encodeURI(filterlink), function(data) {
                // add query string to pagination
                addToPagination();
                $(".ajax-loader").fadeOut(1000);
            });
        }

        //   append parameters to pagination links
        function addToPagination() {


            // add to attributes in pagination links
            $('ul.pagination li a').each(function() {
                let url = $(this).attr('href');
                let queryString = '?' + url.split('?')[1]; // "?page=1234...."

                let urlParams = new URLSearchParams(queryString);
                let page = urlParams.get('page'); // value of 'page' parameter

                let fullUrl =
                    '{{ route('front.category', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')]) }}?page=' +
                    page + '&search=' + '{{ urlencode(request()->input('search')) }}';

                $(".attribute-input").each(function() {
                    if ($(this).is(':checked')) {
                        fullUrl += '&' + encodeURI($(this).attr('name')) + '=' + encodeURI($(this).val());
                    }
                });

                if ($("#sortby").val() != '') {
                    fullUrl += '&sort=' + encodeURI($("#sortby").val());
                }

                if ($("#min_price").val() != '') {
                    fullUrl += '&min=' + encodeURI($("#min_price").val());
                }

                if ($("#max_price").val() != '') {
                    fullUrl += '&max=' + encodeURI($("#max_price").val());
                }

                if ($("#pageby").val() != '') {
                    fullUrl += '&pageby=' + encodeURI($("#pageby").val());
                }


                $(this).attr('href', fullUrl);
            });
        }
    </script>
    <script type="text/javascript">
        (function($) {
            "use strict";

            $(function() {
                $("#slider-range").slider({
                    range: true,
                    orientation: "horizontal",
                    min: {{ $gs->min_price }},
                    max: {{ $gs->max_price }},
                    values: [{{ isset($_GET['min']) ? $_GET['min'] : $gs->min_price }},
                        {{ isset($_GET['max']) ? $_GET['max'] : $gs->max_price }}
                    ],
                    step: 1,

                    slide: function(event, ui) {
                        if (ui.values[0] == ui.values[1]) {
                            return false;
                        }

                        $("#min_price").val(ui.values[0]);
                        $("#max_price").val(ui.values[1]);
                    }
                });

                $("#min_price").val($("#slider-range").slider("values", 0));
                $("#max_price").val($("#slider-range").slider("values", 1));

            });

        })(jQuery);
    </script>
@endsection
