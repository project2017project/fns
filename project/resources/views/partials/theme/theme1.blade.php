
@extends('layouts.front')
@section('css')
<link rel="stylesheet" href="{{ asset('assets/front/css/category/classic.css') }}">
@endsection
@section('content')

@include('partials.global.subscription-popup')

<header>
    {{-- Top header currency and Language --}}
    @include('partials.global.top-header')
    {{-- Top header currency and Language  end--}}
    @include('partials.global.responsive-menubar')

</header>
 <!--home Slider-->
                   @if($ps->slider == 1)
                <section class="section banner-slide-wrapper pt-4">
                    <div class="container-fluid">
                      
                        <div class="banner-column-slide">
                             @foreach($sliders as $data)
                            <div class="home-item">
                               <div class="slide-home-pic lazyload">
                                <img class="lazyload" data-src="{{asset('assets/images/sliders/'.$data->photo)}}" src="{{asset('assets/images/sliders/'.$data->photo)}}" alt="MAKING BRAND VISIBLE" title="MAKING BRAND VISIBLE" />
                               
                            </div>
                            </div>
                            @endforeach

                            
                            
                         
                        </div>
                      
                    </div>
                </section>
                 @endif
                <!--End homeSlider-->



<div id="extraData">
    <div class="text-center">
        <img  src="{{asset('assets/images/'.$gs->loader)}}">
    </div>
</div>


 <!--Quickview Popup-->
 <div id="quick-details" class="row product-details-page py-0">
        <div class="loadingBox"><div class="an-spin"><i class="icon an an-spinner4"></i></div></div>
            <div id="quickView-modal" class="mfp-with-anim mfp-hide">
                <button title="Close (Esc)" type="button" class="mfp-close">×</button>
                 <div class="row quick-view-modaln">



                      </div>
            </div>
          </div>
            <!--End Quickview Popup-->





    @if(isset($visited))
    @if($gs->is_cookie == 1)
        <div class="cookie-bar-wrap show">
            <div class="container d-flex justify-content-center">
                <div class="col-xl-10 col-lg-12">
                    <div class="row justify-content-center">
                        <div class="cookie-bar">
                            <div class="cookie-bar-text">
                                {{ __('The website uses cookies to ensure you get the best experience on our website.') }}
                            </div>
                            <div class="cookie-bar-action">
                                <button class="btn btn-primary btn-accept">
                                {{ __('GOT IT!') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @endif
<!-- Scroll to top -->
<a href="#" class="scroller text-white" id="scroll"><i class="fa fa-angle-up"></i></a>
<!-- End Scroll To top -->




@endsection
@section('script')
	<script>
		let checkTrur = 0;
		$(window).on('load', function(){

		if(checkTrur == 0){
			$('#extraData').load('{{route('front.extraIndex')}}');
			checkTrur = 1;
		}
		});
        var owl = $('.home-slider').owlCarousel({
        loop: true,
        nav: false,
        dots: true,
        items: 1,
        autoplay: true,
        margin: 0,
        animateIn: 'fadeInDown',
        animateOut: 'fadeOutUp',
        mouseDrag: false,
    })
    $('.nextBtn').click(function() {
        owl.trigger('next.owl.carousel', [300]);
    })
    $('.prevBtn').click(function() {
        owl.trigger('prev.owl.carousel', [300]);
    })
	</script>
@endsection
