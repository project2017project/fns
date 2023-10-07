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


<!--==================== Copyright Section End ====================-->

<!-- Scroll to top -->
<a href="#" class="scroller text-white" id="scroll"><i class="fa fa-angle-up"></i></a>
