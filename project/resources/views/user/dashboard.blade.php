@extends('layouts.front')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/front/css/datatables.css')}}">
@endsection
@section('content')
@include('partials.global.common-header')
<!-- breadcrumb -->
<div class="full-row bg-light overlay-dark py-5" style="background-image: url({{ $gs->breadcrumb_banner ? asset('assets/images/'.$gs->breadcrumb_banner):asset('assets/images/noimage.png') }}); background-position: center center; background-size: cover;">
   <div class="container">
      <div class="row text-center text-white">
         <div class="col-12">
            <h3 class="mb-2 text-white">{{ __('Dashboard') }}</h3>
         </div>
      </div>
   </div>
</div>
<!-- breadcrumb -->
<!--==================== Blog Section Start ====================-->
<div class="full-row pt-5 pb-5 user-dashboard-wrapper">
   <div class="container">
        <div class="mb-4 d-xl-none">
            <button class="dashboard-sidebar-btn btn bg-primary rounded">
                <i class="fas fa-bars"></i>
            </button>
        </div>


          <div class="dashboard-upper-info">
                        <div class="row align-items-center g-0">
                            <div class="col-xl-3 col-lg-3 col-sm-6 mt-2 mb-2">
                                <div class="d-single-info">
                                   <img class="user-fns-logo"src="../assets/images/fnslogo.png">
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-sm-6 mt-2 mb-2">
                                <div class="d-single-info">
                                    <p>Need Assistance? Customer service at.</p>
                                    <p><a href="mailto:info@revoue.com">info@fns.com</a></p>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-sm-6 mt-2 mb-2">
                                <div class="d-single-info">
                                    <p>E-mail them at </p>
                                    <p><a href="mailto:info@revoue.com">support@fns.com</a></p>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-sm-6 mt-2 mb-2">
                                <div class="d-single-info text-lg-center">
                                    <a class="link-underline fw-600 view-cart" href="https://fns.ourdevelopents.tech/carts"><i class="icon an an-sq-bag me-2"></i>View Cart</a>
                                </div>
                            </div>
                        </div>
                    </div>


      <div class="row">
         <div class="col-xl-4">
            @include('partials.user.dashboard-sidebar')
         </div>
         <div class="col-xl-8">
            @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
               <strong>{{__('Success')}}</strong> {{Session::get('success')}}
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            @endif
            <div class="row">
               <div class="col-lg-6">
                  <div class="widget border-0 p-20 widget_categories bg-light account-info">
                     <h4 class="widget-title down-line mb-30">{{ __('Account Information') }}</h4>
                     <div class="user-info">
                        <h5 class="title">{{ $user->name }}</h5>
                        <p><span class="user-title">{{ __('Email') }}:</span> {{ $user->email }}</p>
                        @if($user->phone != null)
                        <p><span class="user-title">{{ __('Phone') }}:</span> {{ $user->phone }}</p>
                        @endif
                        @if($user->fax != null)
                        <p><span class="user-title">{{ __('Fax') }}:</span> {{ $user->fax }}</p>
                        @endif
                        @if($user->city != null)
                        <p><span class="user-title">{{ __('City') }}:</span> {{ $user->city }}</p>
                        @endif
                        @if($user->zip != null)
                        <p><span class="user-title">{{ __('Zip') }}:</span> {{ $user->zip }}</p>
                        @endif
                        @if($user->address != null)
                        <p><span class="user-title">{{ __('Address') }}:</span> {{ $user->address }}</p>
                        @endif
                     </div>
                  </div>
               </div>
               <div class="col-lg-6">
                  <div class="widget border-0 p-20 widget_categories bg-light account-info">
                     <h4 class="widget-title down-line mb-30">{{ __('My Wallet') }}</h4>
                     <div class="user-info">
                        <h5 class="title mb-0">{{ __('Affiliate Bonus') }}:</h5>
                        <h5 class="title w-price mb-0">{{ App\Models\Product::vendorConvertPrice($user->affilate_income) }}</h5>
                        <hr>
                        <h5 class="title w-title mb-0">{{ __('Wallet Balance') }}</h5>
                        <h5 class="title w-price mb-3">{{ App\Models\Product::vendorConvertPrice(Auth::user()->balance) }}</h5>
                        <a href="{{ route('user-deposit-create') }}" class="mybtn1 sm "> <i class="fas fa-plus"></i> {{ __('Add Deposit') }}</a>
                     </div>
                  </div>
               </div>
            </div>
            {{-- Statistic section --}}
            <div class="row mt-3">
               <div class="col-lg-6">
                  <div class="widget border-0 p-20 widget_categories bg-light account-info card c-info-box-area">
                     <div class="c-info-box box2">
                        <p>{{ Auth::user()->orders()->count() }}</p>
                     </div>
                     <div class="c-info-box-content">
                        <h6 class="title">{{ __('Total Orders') }}</h6>
                        <p class="text">{{ __('All Time') }}</p>
                     </div>
                  </div>
               </div>
               <div class="col-lg-6">
                  <div class="widget border-0 p-20 widget_categories bg-light account-info card c-info-box-area">
                     <div class="c-info-box box1">
                        <p>{{ Auth::user()->orders()->where('status','pending')->count() }}</p>
                     </div>
                     <div class="c-info-box-content">
                        <h6 class="title">{{ __('Pending Orders') }}</h6>
                        <p class="text">{{ __('All Time') }}</p>
                     </div>
                  </div>
               </div>
            </div>
            {{-- Statistic section End--}}
       
         </div>
      </div>

           <div class="row table-responsive-lg mt-4">
               <div class="col-lg-12">
                  <div class="widget border-0 p-20 widget_categories bg-light account-info">
                     <h4 class="widget-title down-line mb-30">{{ __('Recent Orders') }}</h4>
                     <div class="table-responsive">
                        <table class="table order-table" cellspacing="0" width="100%">
                           <thead>
                              <tr>
                                 <th>{{ __('#Order') }}</th>
                                 <th>{{ __('Date') }}</th>
                                 <th>{{ __('Order Total') }}</th>
                                 <th>{{ __('Order Status') }}</th>
                                 <th>{{ __('View') }}</th>
                              </tr>
                           </thead>
                           <tbody>
                              @foreach(Auth::user()->orders()->latest()->take(5)->get() as $order)
                              <tr>
                                 <td data-label="{{ __('#Order') }}">
                                    <div>
                                       {{$order->order_number}}
                                    </div>
                                 </td>
                                 <td data-label="{{ __('Date') }}">
                                    <div>
                                       {{date('d M Y',strtotime($order->created_at))}}
                                    </div>
                                 </td>
                                 <td data-label="{{ __('Order Total') }}">
                                    <div>
                                       {{ \PriceHelper::showAdminCurrencyPrice(($order->pay_amount  * $order->currency_value),$order->currency_sign) }}
                                    </div>
                                 </td>
                                 <td data-label="{{ __('Order Status') }}">
                                    <div class="order-status {{ $order->status }}">
                                       {{ucwords($order->status)}}
                                    </div>
                                 </td>
                                 <td data-label="{{ __('View') }}">
                                    <div>
                                       <a class="mybtn1 sm1" href="{{route('user-order',$order->id)}}">
                                          {{ __('View Order') }}
                                       </a>
                                    </div>
                                 </td>
                              </tr>
                              @endforeach
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>

   </div>
</div>
<!--==================== Blog Section End ====================-->
@includeIf('partials.global.common-footer')
@endsection
