 <!--Header wrap-->
            <div class="header-main header-18">
                <!--Header-->
                <header id="header" class="header header-wrap d-flex align-items-center">
                    <div class="container">        
                        <div class="row">
                            <!--Logo / Menu Toggle-->
                            <div class="col-6 col-sm-6 col-md-6 col-lg-2 align-self-center justify-content-start d-flex">
                                <!--Mobile Toggle-->
                                <button type="button" class="btn--link site-header__menu js-mobile-nav-toggle mobile-nav--open me-3 d-lg-none"><i class="icon an an-times-l"></i><i class="icon an an-bars-l"></i></button>
                                <!--End Mobile Toggle-->
                                <!--Logo-->
                                <div class="logo"><a href="{{ route('front.index') }}"><img class="logo-img mh-100" src="{{ asset('assets/images/'.$gs->logo) }}" data-src="{{ asset('assets/images/'.$gs->logo) }}" alt="logo" title="logo" width="120" /><span class="logo-txt d-none">Fns</span></a></div>
                                <!--End Logo-->
                            </div>
                            <!--End Logo / Menu Toggle-->
                            <!--Search Inline-->
                            <div class="col-1 col-sm-1 col-md-1 col-lg-8 d-none d-lg-block">
                                <form class="form minisearch search-inline px-5" id="searchForm" action="{{ route('front.category', [Request::route('category'),Request::route('subcategory'),Request::route('childcategory')]) }}" method="GET">
                                    <label class="label d-none"><span>Search</span></label>
                                    <div class="control">
                                        <div class="searchField d-flex">
                                            <div class="search-category" id="catSelectForm">
                                                <select id="category_select" name="rgsearch[category]" data-default="All Categories" class="rounded-pill-start">
                                                    <option value="00" label="All Categories" selected="selected">{{ __('All Categories') }}</option>
                                                    <optgroup id="rgsearch-shop1" label="Shop">
                                                        @foreach(DB::table('categories')->where('language_id',$langg->id)->where('status',1)->get() as $data)
                                                        <option value="{{ $data->slug }}"{{ Request::route('category') == $data->slug ? 'selected' : '' }}>
                                    {{ $data->name }}
                                </option> 
                                 @endforeach                                                       

                                                    </optgroup>
                                                </select>
                                            </div>
                                            <div class="input-box d-flex w-100">
                                                @if (!empty(request()->input('sort')))
                            <input type="hidden" name="sort" value="{{ request()->input('sort') }}" class="input-text rounded-0 border-start-0 border-end-0">
                            @endif
                            @if (!empty(request()->input('minprice')))
                            <input type="hidden" name="minprice" value="{{ request()->input('minprice') }}" class="input-text rounded-0 border-start-0 border-end-0">
                            @endif
                            @if (!empty(request()->input('maxprice')))
                            <input type="hidden" name="maxprice" value="{{ request()->input('maxprice') }}" class="input-text rounded-0 border-start-0 border-end-0">
                            @endif
                            <input type="text" id="prod_name" class="input-text rounded-0 border-start-0 border-end-0" name="search" placeholder="Search Product For" value="{{ request()->input('search') }}">
                            <div class="autocomplete">
                                            <div id="myInputautocomplete-list" class="autocomplete-items search-list-wrap">
                                            </div>
                                        </div>
                                                
                                                <button type="submit" title="Search" name="submit" class="action search rounded-pill-end"><i class="icon an an-search-l"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!--End Search Inline-->
                            <!--Right Action-->
                            <div class="col-6 col-sm-6 col-md-6 col-lg-2 align-self-center icons-col text-right d-flex justify-content-end">
                                <!--Search-->
                                <div class="site-search iconset d-block d-lg-none"><i class="icon an an-search-l"></i><span class="tooltip-label">Search</span></div>
                                <!--End Search-->
                               
                                <!--Setting Dropdown-->
                                <div class="user-link iconset flex-lg-column">
                                   
                                    <i class="icon an an-user-expand"></i>
                                    <span class="text d-none d-lg-flex">MY ACCOUNT</span>
                                    
                                </div>
                                <div id="userLinks" class="mt-lg-3">

                                    <ul class="user-links">
                            @if (Auth::check())

                            <li><a href="{{ route('user-dashboard') }}">{{ ('User Panel') }}</a></li>
                            @if (Auth::user()->IsVendor())
                            <li><a href="{{ route('vendor.dashboard') }}">{{ __('Vendor Panel') }}</a></li>
                            @endif
                            <li><a href="{{ route('user-profile') }}">{{ __('Edit Profile') }}</a></li>
                            <li><a href="{{ route('user-logout') }}">{{ __('Logout') }}</a></li>

                            @else
                            <li><a href="{{ route('user.login') }}">{{ __('Sign in') }}</a></li>

                            <li><a href="{{ route('user.register') }}">{{ __('Join') }}</a></li>
                            @endif

                        </ul>

                                    
                                </div>
                                <!--End Setting Dropdown-->
                                <!--Minicart Drawer-->
                                <div class="header-cart iconset ">

                                    <a href="javascript:;" class="site-header__cart btn-minicart d-flex-justify-center" data-bs-toggle="modal" data-bs-target="#minicart-drawer">
                                        <i class="icon an an-sq-bag"></i>
                                        <span class="text d-none d-lg-flex">MY CART</span>
                                        <span class="site-cart-count counter d-flex-center justify-content-center position-absolute translate-middle rounded-circle cart-quantity" id="cart-count">{{ Session::has('cart') ? count(Session::get('cart')->items) : '0' }}</span>

                                    </a>
                                     
                                </div>

                                <!--End Minicart Drawer-->

                                <!--Wishlist-->
                               
                                   <div class="wishlist-link iconset flex-lg-column">
                        @if (Auth::check())
                        <a href="{{ route('user-wishlists') }}"><i class="icon an an-heart-l"></i>
                            <span class="text d-none d-lg-flex">Wishlist</span>
                             <span class="wishlist-count counter d-flex-center justify-content-center position-absolute rounded-circle" id="wishlist-count">{{ Auth::user()->wishlistCount() }}</span>
                        </a>
                        @else
                        <a href="{{ route('user.login') }}"><i class="icon an an-heart-l"></i>
                             <span class="text d-none d-lg-flex">Wishlist</span>
                         <span class="wishlist-count counter d-flex-center justify-content-center position-absolute rounded-circle" id="wishlist-count">{{ 0 }}</span>
                        </a>
                    @endif
                    </div>
                       <!--End Wishlist-->


                            </div>
                            <!--End Right Action-->
                        </div>
                    </div>
                    <!--Search Popup-->
                    <div id="search-popup" class="search-drawer">
                        <div class="container">
                            <span class="closeSearch an an-times-l"></span>
                            <form class="form minisearch" id="header-search" action="{{ route('front.category', [Request::route('category'),Request::route('subcategory'),Request::route('childcategory')]) }}" method="GET">
                                <label class="label"><span>Search</span></label>
                                <div class="control">
                                    <div class="searchField">
                                        <div class="search-category" id="catSelectForm">
                                            <select id="category_select" name="rgsearch[category]" data-default="All Categories">
                                                <option value="00" label="All Categories" selected="selected">{{ __('All Categories') }}</option>
                                                <optgroup id="rgsearch-shop" label="Shop">
                                                    @foreach(DB::table('categories')->where('language_id',$langg->id)->where('status',1)->get() as $data)
                                                    <option value="{{ $data->slug }}"{{ Request::route('category') == $data->slug ? 'selected' : '' }}>
                                    {{ $data->name }}
                                </option>
                                 @endforeach  
                                             
                                                </optgroup>
                                            </select>
                                        </div>
                                        <div class="input-box">
                                            <button type="submit" title="Search" name="submit" class="action search rounded-0"><i class="icon an an-search-l"></i></button>
                                           

                                                              @if (!empty(request()->input('sort')))
                            <input type="hidden" name="sort" class="input-text rounded-0" value="{{ request()->input('sort') }}" class="input-text rounded-0 border-start-0 border-end-0">
                            @endif
                            @if (!empty(request()->input('minprice')))
                            <input type="hidden" name="minprice" class="input-text rounded-0" value="{{ request()->input('minprice') }}" class="input-text rounded-0 border-start-0 border-end-0">
                            @endif
                            @if (!empty(request()->input('maxprice')))
                            <input type="hidden" name="maxprice" class="input-text rounded-0" value="{{ request()->input('maxprice') }}" class="input-text rounded-0 border-start-0 border-end-0">
                            @endif
                            <input type="text" id="prod_name" class="input-text rounded-0 border-start-0 border-end-0" name="search" placeholder="Search Product For" value="{{ request()->input('search') }}">
                             <div class="autocomplete">
                                            <div id="myInputautocomplete-list" class="autocomplete-items">
                                            </div>
                                        </div>


                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!--End Search Popup-->
                </header>
                <!--End Header-->
                <!--Main Navigation Desktop-->
                <div class="menu-outer d-none d-lg-block">
                    <div class="container">
                        <div class="row">
                            <div class="col-1 col-sm-1 col-md-1 col-lg-12 align-self-center d-menu-col">                            
                                <nav class="grid__item" id="AccessibleNav">
                                    <ul id="siteNav" class="site-nav medium center hidearrow">
                            <li class="lvl1 {{ request()->path() == '/' ? 'active':''}}">
                                <a href="{{ route('front.index') }}">{{ __('Home') }}</a>
                            </li>


                            @foreach (App\Models\Category::where('language_id',$langg->id)->where('status',1)->orderBy('id', 'DESC')->take(5)->get() as $category)
                            <li class="lvl1 parent dropdown big-submenu {{ $category->name }}">
                                <a href="{{route('front.category', $category->slug)}}{{!empty(request()->input('search')) ? '?search='.request()->input('search') : ''}}">{{ $category->name }}</a>
                                <ul class="dropdown">
                                     @if($category->subs->count() > 0)
                                                    @foreach (App\Models\Subcategory::where('category_id',$category->id)->get() as $subcategory)
                                    <li>
                                        <a class="site-nav" href="{{route('front.category', [$category->slug, $subcategory->slug])}}{{!empty(request()->input('search')) ? '?search='.request()->input('search') : ''}}">{{$subcategory->name}}</a>
                                        <div class="inner-img-sub-wrap">
                                            <img src="{{asset('assets/images/categories')}}/{{$subcategory->photo}}">
                                            </div>
                                    </li>
                                    @endforeach
                                                    @endif
                                </ul>
                            </li>
                             @endforeach

                             <li class="lvl1">
                                <a href="{{ route('front.index') }}/gifting">{{ __('Gifting') }}</a>
                            </li>
                            <li class="lvl1">
                                <a href="{{ route('front.index') }}/deals">{{ __('Deals') }}</a>
                            </li>
                             <li class="lvl1 parent dropdown">
                                <a href="#">{{ __('FNS Group') }}</a>
                                <ul class="dropdown">
                                    <li><a class="site-nav" href="javascript:void(0)">FNS Dealer & Distributor</a></li>
                                    <li><a class="site-nav" href="javascript:void(0)">FNS Hospitality</a></li>
                                    <li><a class="site-nav" href="javascript:void(0)">FNS Corporate Gifting</a></li>
                                    <li><a class="site-nav" href="javascript:void(0)">FNS Premium</a></li>
                                    <li><a class="site-nav" href="javascript:void(0)">FNS Promoters</a></li>

                                   
                                </ul>
                            </li>


                       <!--      <li class="lvl1 parent dropdown">
                                <a href="#">{{ __('Pages') }}</a>
                                <ul class="dropdown">
                                    @foreach(DB::table('pages')->where('language_id',$langg->id)->where('header','=',1)->get() as $data)
                                    <li><a class="site-nav" href="{{ route('front.vendor',$data->slug) }}">{{ $data->title }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            <li class="lvl1 {{ request()->path()=='blog' ? 'active' : '' }}">
                                <a href="{{ route('front.blog') }}">{{ __('Blog') }}</a>
                            </li>
                            <li class="lvl1 {{ request()->path()=='faq' ? 'active' : '' }}">
                                <a href="{{ route('front.faq') }}">{{ __('FAQ') }}</a>
                            </li>

                            <li class="lvl1 {{ request()->path()=='contact' ? 'active' : '' }}"><a href="{{ route('front.contact') }}">{{ __('Contact') }}</a></li> -->
                        </ul>
                                </nav>                                   
                            </div>
                        </div>
                    </div>
                </div>
                <!--End Main Navigation Desktop-->
            </div>
            <!--End Header wrap-->

 <!--Mobile Menu-->
            <div class="mobile-nav-wrapper" role="navigation">
                <div class="closemobileMenu"><i class="icon an an-times-l pull-right"></i> Close Menu</div>
                <ul id="MobileNav" class="mobile-nav medium">
                    <li class="lvl1"><a href="{{ route('front.index') }}">{{ __('Home') }} </a>                       
                    </li>

                     @foreach (App\Models\Category::where('language_id',$langg->id)->where('status',1)->orderBy('id', 'DESC')->take(5)->get() as $category)
                            <li class="lvl1 parent megamenu big-submenu {{ $category->name }}">
                                <a href="{{route('front.category', $category->slug)}}{{!empty(request()->input('search')) ? '?search='.request()->input('search') : ''}}">{{ $category->name }}<i class="an an-plus-l"></i></a>
                                <ul class="dropdown">
                                     @if($category->subs->count() > 0)
                                                    @foreach (App\Models\Subcategory::where('category_id',$category->id)->get() as $subcategory)
                                    <li>
                                        <a class="site-nav" href="{{route('front.category', [$category->slug, $subcategory->slug])}}{{!empty(request()->input('search')) ? '?search='.request()->input('search') : ''}}">{{$subcategory->name}}</a>
                                        <!-- <div class="inner-img-sub-wrap">
                                            <img src="{{asset('assets/images/categories')}}/{{$subcategory->photo}}">
                                            </div> -->
                                    </li>
                                    @endforeach
                                                    @endif
                                </ul>
                            </li>
                             @endforeach

                               <li class="lvl1">
                                <a href="{{ route('front.index') }}/gifting">{{ __('Gifting') }}</a>
                            </li>
                            <li class="lvl1">
                                <a href="{{ route('front.index') }}/deals">{{ __('Deals') }}</a>
                            </li>
                             <li class="lvl1 parent megamenu">
                                <a href="#">{{ __('FNS Group') }}<i class="an an-plus-l"></i></a>
                                <ul class="dropdown">
                                    <li><a class="site-nav" href="javascript:void(0)">FNS Dealer & Distributor</a></li>
                                    <li><a class="site-nav" href="javascript:void(0)">FNS Hospitality</a></li>
                                    <li><a class="site-nav" href="javascript:void(0)">FNS Corporate Gifting</a></li>
                                    <li><a class="site-nav" href="javascript:void(0)">FNS Premium</a></li>
                                    <li><a class="site-nav" href="javascript:void(0)">FNS Promoters</a></li>

                                   
                                </ul>
                            </li>


                </ul>
            </div>
            <!--End Mobile Menu-->




            

    <!--Sticky Menubar Mobile-->
    <div class="menubar-mobile d-flex align-items-center justify-content-between d-lg-none">
        <div class="menubar-shop menubar-item">
            <a href="{{ route('front.category') }}"><i class="menubar-icon an an-th-large-l"></i><span class="menubar-label">Shop</span></a>
        </div>
        <div class="menubar-account menubar-item">

            @if(!Auth::guard('web')->check())
            <a href="{{ route('user.login') }}"><span class="menubar-icon an an-user-expand"></span><span class="menubar-label">Account</span></a>

            @else

            <a href="{{ route('user-dashboard') }}"><span class="menubar-icon an an-user-expand"></span><span class="menubar-label">Account</span></a>

            @endif


        </div>
        <div class="menubar-search menubar-item">
            <a href="{{ route('front.index') }}"><span class="menubar-icon an an-home-l"></span><span class="menubar-label">Home</span></a>
        </div>
        <div class="menubar-wish menubar-item">
            @if(Auth::guard('web')->check())
            <a href="{{ route('user-wishlists') }}">
                <span class="span-count position-relative text-center"><span class="menubar-icon an an-heart-l"></span><span class="menubar-count counter d-flex-center justify-content-center position-absolute translate-middle rounded-circle">{{ Auth::user()->wishlistCount() }}</span></span>
                <span class="menubar-label">Wishlist</span>
            </a>
            @else
            <a href="javascript:;">
                <span class="span-count position-relative text-center"><span class="menubar-icon an an-heart-l"></span><span class="menubar-count counter d-flex-center justify-content-center position-absolute translate-middle rounded-circle">0</span></span>
                <span class="menubar-label">Wishlist</span>
            </a>
            @endif

        </div>
        <div class="menubar-cart menubar-item">
            <a href="javascript:;" class="cartBtn" data-bs-toggle="modal" data-bs-target="#minicart-drawer">
                <span class="span-count position-relative text-center"><span class="menubar-icon an an-sq-bag"></span><span class="menubar-count site-cart-count counter d-flex-center justify-content-center position-absolute translate-middle rounded-circle cart-quantity" id="cart-count1">{{ Session::has('cart') ? count(Session::get('cart')->items) : '0' }}</span></span>
                <span class="menubar-label">Cart</span>
            </a>
        </div>
    </div>
    <!--End Sticky Menubar Mobile-->

    <!--MiniCart Drawer-->
                           <div class="minicart-right-drawer modal right fade" id="minicart-drawer">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="my-dropdown-menu" id="cart-items">
                                            @include('load.cart')
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--End MiniCart Drawer-->

