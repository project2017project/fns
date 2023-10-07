@extends('layouts.front')
@section('content')
    @includeIf('partials.global.common-header')



    	<div class="full-row">
             <div class="container mb-5">
                <div class="row">
                    <div class="col-12">
                        <div class="deals-top-banner">
                            <a href="{{$gs->gift_link}}">
                            <img src="{{ asset('assets/images/' . $gs->gift_banner) }}">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <div class="container">
            <div class="row">
                @if (count($prods) > 0)
                    <div class="col-xl-12">
                        <div class="mb-4 d-xl-none">
                            <button class="dashboard-sidebar-btn btn bg-primary rounded">
                                <i class="fas fa-bars"></i>
                            </button>
                        </div>
                        <h4 class="text-center mb-0">Best Gifting Options</h4>
                        <div class="showing-products pt-30 pb-50 border-2 border-bottom border-light" id="ajaxContent">
                        	<div class="row row-cols-xl-4 row-cols-md-3 row-cols-sm-2 row-cols-1 product-style-1 e-title-hover-primary e-image-bg-light e-hover-image-zoom e-info-center">
  							 @foreach($prods as $product)
                            		@includeIf('partials.product.deals-prod')
                            @endforeach
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






    @includeIf('partials.global.common-footer')
@endsection
