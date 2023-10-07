@extends('layouts.front')
@section('content')
@include('partials.global.common-header')
<!-- breadcrumb -->
<div class="full-row bg-light overlay-dark py-5" style="background-image: url({{ $gs->breadcrumb_banner ? asset('assets/images/'.$gs->breadcrumb_banner):asset('assets/images/noimage.png') }}); background-position: center center; background-size: cover;">
   <div class="container">
      <div class="row text-center text-white">
         <div class="col-12">
            <h3 class="mb-2 text-white">{{ __('Contact') }}</h3>
         </div>
         <div class="col-12">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb mb-0 d-inline-flex bg-transparent p-0">
                  <li class="breadcrumb-item"><a href="{{ route('front.index') }}">{{ __('Home') }}</a></li>
                  <li class="breadcrumb-item active" aria-current="page">{{ __('Contact') }}</li>
               </ol>
            </nav>
         </div>
      </div>
   </div>
</div>
<!-- breadcrumb -->
<!--==================== Contact Section Start ====================-->
<div class="full-row">
   <div class="container">
      <div class="row justify-content-between">
        
         <div class="col-xl-7 col-lg-7 col-md-6">
            <h3 class="down-line mb-5">{{ __('Send Message') }}</h3>
            <div class="form-simple contact-page-wrap mb-5">
               <form class="contactform"  id="contact-form" action="#" method="POST">
                  @csrf
                  <div class="row">
                     <div class="col-md-6">
                        <div class="mb-3">
                           <label>{{ __('Full Name') }}:</label>
                           <input type="text" class="form-control bg-gray" name="name" placeholder="{{ __('Name *') }}" required="">
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="mb-3">
                           <label>{{ __('Your Email') }}:</label>
                           <input type="email" class="form-control bg-gray" name="email" placeholder="{{ __('Email Address *') }}" required="">
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="mb-3">
                           <label>{{ __('Phone Number') }}:</label>
                           <input type="text" class="form-control bg-gray" name="phone" placeholder="{{ __('Phone Number *') }}" required="">
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="mb-3">
                           <label>{{ __('Message') }}:</label>
                           <textarea class="form-control bg-gray" name="text" rows="8" placeholder="{{ __('Your Message *') }}" required=""></textarea>
                        </div>
                     </div>

                     @if($gs->is_capcha == 1)
                     <div class="form-input">
                        {!! NoCaptcha::display() !!}
                        {!! NoCaptcha::renderJs() !!}
                        @error('g-recaptcha-response')
                        <p class="my-2">{{$message}}</p>
                        @enderror
                     </div>
                     @endif
                     <input type="hidden" name="to" value="{{ $ps->contact_email }}">
                     <div class="col-md-12 mt-3">
                        <button class="btn btn-primary submit-btn mybtn1" name="submit" type="submit">{{ __('Send Message') }}</button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
         <div class="col-xl-5 col-lg-5 col-md-6 ps-lg-5">
            <h3 class="down-line mb-5">{{ __('Get In Touch') }}</h3>
            <div class="contact-info-wrap mb-3">
               <ul>
                  @if($ps->street != null)
                  <li class="mb-4">
                     <div class="left ">
                      <div class="icon">
                      <i class="icofont-google-map"></i>
                      </div>
                     </div>
                     <div class="contact-details">
                     <strong>{{ __('Office Address') }} :</strong><br> {{ $ps->street }}
                  </div>
                  </li>
                  @endif
                  @if($ps->phone != null )
                  <li class="mb-4">
                     <div class="left ">
                      <div class="icon">
                      <i class="icofont-smart-phone"></i>
                      </div>
                     </div>
                     <div class="contact-details">
                     <strong>Contact Number :</strong><br> {{ $ps->phone }}
                  </div>
                  </li>
                  @endif
                 <!--  @if($ps->fax != null )
                  <li class="mb-4">
                     <strong>Fax :</strong><br> {{ $ps->fax }}
                  </li>
                  @endif -->
                  @if($ps->email != null)
                  <li class="mb-4">
                     <div class="left ">
                      <div class="icon">
                      <i class="icofont-email"></i>
                      </div>
                     </div>
                     <div class="contact-details">
                     <strong>{{ __('Email Address') }} :</strong><br>
                     <p class="email">{{ $ps->email }}</p>
                  </div>
                  </li>
                  @endif
               </ul>
            </div>

            <div class="contact-social-links">
<h4>Find Us Here :</h4>
 <ul class="list-inline social-icons mt-1 pt-1">
                                 
                                    @if($socialsetting->f_status == 1)
                                <li class="list-inline-item">
                                    <a href="{{ $socialsetting->facebook }}">
                                        <i class="an an-facebook" aria-hidden="true"></i>
                                    </a>
                                </li>
                                 @endif

                                     @if($socialsetting->f_status == 1)
                                    <li class="list-inline-item">
                                        <a href="{{ $socialsetting->linkedin }}">
                                            <i class="an an-instagram" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                     @endif
                                       @if($socialsetting->f_status == 1)
                                    <li class="list-inline-item">
                                        <a href="{{ $socialsetting->linkedin }}">
                                            <i class="an an-linkedin" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                     @endif
                                     
                                

                                @if($socialsetting->f_status == 1)
                                    <li class="list-inline-item">
                                    <a href="{{ $socialsetting->twitter }}">
                                            <i class="an an-twitter" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                     @endif
                                    @if($socialsetting->f_status == 1)
                                    <li class="list-inline-item">
                                        <a href="{{ $socialsetting->dribble }}">
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

          <div class="col-12">
            <div class="fns-location-map">
               <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3499.9435451574373!2d77.14969272503578!3d28.691335331408844!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390d023476926fd7%3A0xf3db86e3867e163b!2sFns%20International!5e0!3m2!1sen!2sin!4v1695971245662!5m2!1sen!2sin" width="400" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
         </div>
      </div>
   </div>
</div>
<!--======================== Contact Section End ==========================-->
@include('partials.global.common-footer')
@endsection
@section('script')
@endsection
