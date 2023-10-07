@extends('layouts.front')

@section('content')
    @include('partials.global.common-header')
    
    @php $refundedProducts = array();  @endphp
    @if(isset($order->is_refund) && $order->is_refund == 1)
        @php 
            $refunded_products = json_decode($order->refunded_products);
        @endphp
        
        @if(isset($refunded_products) && count($refunded_products)>0)
            @foreach($refunded_products as $dt)
                @php $refundedProducts[$dt->item_id] = $dt->refund_qty;  @endphp
            @endforeach
        @endif
        
    @endif
    <style>
        .stars_new {
            border-bottom: none !important;
            padding: 0px 0 !important;
        }
    </style>
    <!-- breadcrumb -->
    <div class="full-row bg-light overlay-dark py-5"
        style="background-image: url({{ $gs->breadcrumb_banner ? asset('assets/images/' . $gs->breadcrumb_banner) : asset('assets/images/noimage.png') }}); background-position: center center; background-size: cover;">
        <div class="container">
            <div class="row text-center text-white">
                <div class="col-12">
                    <h3 class="mb-2 text-white">{{ __('Purchased Items') }}</h3>
                </div>
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 d-inline-flex bg-transparent p-0">
                            <li class="breadcrumb-item"><a href="{{ 'user-dashboard' }}">{{ __('Dashboard') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Purchased Items') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->



    <!--==================== Blog Section Start ====================-->
    <div class="full-row">
        <div class="container">
            <div class="mb-4 d-xl-none">
                <button class="dashboard-sidebar-btn btn bg-primary rounded">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            <div class="row">
                <div class="col-xl-3">
                    @include('partials.user.dashboard-sidebar')
                </div>
                <div class="col-xl-9">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="widget border-0 p-40 widget_categories bg-light account-info">
                                <div class="process-steps-area">
                                    @include('partials.user.order-process')

                                </div>

                                <h4 class="widget-title down-line mb-30">{{ __('Purchased Items') }}</h4>
                                <div class="view-order-page">
                                    <h3 class="order-code">{{ __('Order#') }} {{ $order->order_number }}
                                        [{{ $order->status }}]
                                    </h3>
                                    <div class="print-order text-right">
                                        <a href="{{ route('user-order-print', $order->id) }}" target="_blank"
                                            class="print-order-btn">
                                            <i class="fa fa-print"></i> {{ __('Print Order') }}
                                        </a>
                                    </div>
                                    <p class="order-date">{{ __('Order Date') }}
                                        {{ date('d-M-Y', strtotime($order->created_at)) }}
                                    </p>

                                    @if ($order->dp == 1)

                                        <div class="billing-add-area">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h5>{{ __('Shipping Address') }}</h5>
                                                    <address>
                                                        {{ __('Name:') }} {{ $order->customer_name }}<br>
                                                        {{ __('Email:') }} {{ $order->customer_email }}<br>
                                                        {{ __('Phone:') }} {{ $order->customer_phone }}<br>
                                                        {{ __('Address:') }} {{ $order->customer_address }}<br>
                                                        {{ $order->customer_city }}-{{ $order->customer_zip }}
                                                    </address>
                                                </div>
                                                <div class="col-md-6">
                                                    <h5>{{ __('Shipping Method') }}</h5>

                                                    <p>{{ __('Payment Status:') }}
                                                        @if ($order->payment_status == 'Pending')
                                                            <span class='badge badge-danger'>{{ __('Unpaid') }}</span>
                                                        @else
                                                            <span class='badge badge-success'>{{ __('Paid') }}</span>
                                                        @endif
                                                    </p>

                                                    <p>{{ __('Tax :') }}
                                                        {{ \PriceHelper::showOrderCurrencyPrice($order->tax / $order->currency_value, $order->currency_sign) }}
                                                    </p>
                                                    <p>{{ __('Paid Amount:') }}
                                                        {{ \PriceHelper::showOrderCurrencyPrice($order->pay_amount * $order->currency_value, $order->currency_sign) }}
                                                    </p>
                                                    <p>{{ __('Payment Method:') }} {{ $order->method }}</p>

                                                    @if ($order->method != 'Cash On Delivery')
                                                        @if ($order->method == 'Stripe')
                                                            {{ $order->method }} {{ __('Charge ID:') }} <p>
                                                                {{ $order->charge_id }}</p>
                                                        @endif
                                                        {{ $order->method }} {{ __('Transaction ID:') }} <p
                                                            id="ttn">{{ $order->txnid }}</p>
                                                        <a id="tid" style="cursor: pointer;"
                                                            class="mybtn2">{{ __('Edit Transaction ID') }}</a>

                                                        <form id="tform">
                                                            <input style="display: none; width: 100%;" type="text"
                                                                id="tin"
                                                                placeholder="{{ __('Enter Transaction ID & Press Enter') }}"
                                                                required="" class="mb-3">
                                                            <input type="hidden" id="oid"
                                                                value="{{ $order->id }}">

                                                            <button
                                                                style="display: none; padding: 5px 15px; height: auto; width: auto; line-height: unset;"
                                                                id="tbtn" type="submit"
                                                                class="mybtn1">{{ __('Submit') }}</button>
                                                            <a style="display: none; cursor: pointer;  padding: 5px 15px; height: auto; width: auto; line-height: unset;"
                                                                id="tc" class="mybtn1">{{ __('Cancel') }}</a>
                                                            {{-- Change 1 --}}
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="shipping-add-area">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    @if ($order->shipping == 'shipto')
                                                        <h5>{{ __('Shipping Address') }}</h5>
                                                        <address>
                                                            {{ __('Name:') }}
                                                            {{ $order->shipping_name == null ? $order->customer_name : $order->shipping_name }}<br>
                                                            {{ __('Email:') }}
                                                            {{ $order->shipping_email == null ? $order->customer_email : $order->shipping_email }}<br>
                                                            {{ __('Phone:') }}
                                                            {{ $order->shipping_phone == null ? $order->customer_phone : $order->shipping_phone }}<br>
                                                            {{ __('Address:') }}
                                                            {{ $order->shipping_address == null ? $order->customer_address : $order->shipping_address }}<br>
                                                            {{ $order->shipping_city == null ? $order->customer_city : $order->shipping_city }}-{{ $order->shipping_zip == null ? $order->customer_zip : $order->shipping_zip }}
                                                        </address>
                                                    @else
                                                        <h5>{{ __('PickUp Location') }}</h5>
                                                        <address>
                                                            {{ __('Address:') }} {{ $order->pickup_location }}<br>
                                                        </address>
                                                    @endif

                                                </div>
                                                <div class="col-md-6">
                                                    <h5>{{ __('Shipping Method') }}</h5>
                                                    @if ($order->shipping == 'shipto')
                                                        <p>{{ __('Ship To Address') }}</p>
                                                    @else
                                                        <p>{{ __('Pick Up') }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="billing-add-area">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h5>{{ __('Billing Address') }}</h5>
                                                    <address>
                                                        {{ __('Name:') }} {{ $order->customer_name }}<br>
                                                        {{ __('Email:') }} {{ $order->customer_email }}<br>
                                                        {{ __('Phone:') }} {{ $order->customer_phone }}<br>
                                                        {{ __('Address:') }} {{ $order->customer_address }}<br>
                                                        {{ $order->customer_city }}-{{ $order->customer_zip }}
                                                    </address>
                                                </div>
                                                <div class="col-md-6">
                                                    <h5>{{ __('Payment Information') }}</h5>

                                                    <p>{{ __('Payment Status') }}
                                                        @if ($order->payment_status == 'Pending')
                                                            <span class='badge badge-danger'>{{ __('Unpaid') }}</span>
                                                        @else
                                                            <span class='badge badge-success'>{{ __('Paid') }}</span>
                                                        @endif
                                                    </p>

                                                    <p>{{ __('Tax :') }}
                                                        {{ \PriceHelper::showOrderCurrencyPrice($order->tax / $order->currency_value, $order->currency_sign) }}
                                                    </p>
                                                    <p>{{ __('Paid Amount:') }}
                                                        {{ \PriceHelper::showOrderCurrencyPrice($order->pay_amount * $order->currency_value, $order->currency_sign) }}
                                                    </p>
                                                    <p>{{ __('Payment Method:') }} {{ $order->method }}</p>

                                                    @if ($order->method != 'Cash On Delivery')
                                                        @if ($order->method == 'Stripe')
                                                            {{ $order->method }} {{ __('Charge ID:') }} <p>
                                                                {{ $order->charge_id }}</p>
                                                        @endif
                                                        {{ $order->method }} {{ __('Transaction ID:') }} <p
                                                            id="ttn"> {{ $order->txnid }}</p>

                                                        <a id="tid" style="cursor: pointer;"
                                                            class="mybtn2">{{ __('Edit Transaction ID') }}</a>

                                                        <form id="tform">
                                                            <input style="display: none; width: 100%;" type="text"
                                                                id="tin"
                                                                placeholder="{{ __('Enter Transaction ID & Press Enter') }}"
                                                                required="" class="mb-3">
                                                            <input type="hidden" id="oid"
                                                                value="{{ $order->id }}">

                                                            <button
                                                                style="display: none; padding: 5px 15px; height: auto; width: auto; line-height: unset;"
                                                                id="tbtn" type="submit"
                                                                class="mybtn1">{{ __('Submit') }}</button>

                                                            <a style="display: none; cursor: pointer;  padding: 5px 15px; height: auto; width: auto; line-height: unset;"
                                                                id="tc" class="mybtn1">{{ __('Cancel') }}</a>

                                                            {{-- Change 1 --}}
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <br>

                                    @if(isset($order->shiprocket_awb_code) && !empty($order->shiprocket_awb_code))
                                        <h6>AWB Code: {{ $order->shiprocket_awb_code }}</h6><br>
                                    @endif
                                    
                                    <div class="table-responsive">
                                        <h5>{{ __('Ordered Products:') }}</h5>
                                        <table class="table veiw-details-table">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('ID#') }}</th>
                                                    <th>{{ __('Name') }}</th>
                                                    <th>{{ __('Details') }}</th>
                                                    @if(isset($order->is_refund) && $order->is_refund == 1) <th>Refund</th> @endif
                                                    <th>{{ __('Price') }}</th>
                                                    <th>{{ __('Total') }}</th>
                                                    <th>{{ __('Action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($cart['items'] as $product)
                                                    <tr>
                                                        <td data-label="{{ __('ID#') }}">
                                                            <div>
                                                                {{ $product['item']['id'] }}
                                                            </div>
                                                        </td>
                                                        <td data-label="{{ __('Name') }}">
                                                            <div>

                                                                <input type="hidden" value="{{ $product['license'] }}">

                                                                @if ($product['item']['user_id'] != 0)
                                                                    @php
                                                                        $user = App\Models\User::find($product['item']['user_id']);
                                                                    @endphp
                                                                    @if (isset($user))
                                                                        <a target="_blank"
                                                                            href="{{ route('front.product', $product['item']['slug']) }}">{{ mb_strlen($product['item']['name'], 'UTF-8') > 50 ? mb_substr($product['item']['name'], 0, 50, 'UTF-8') . '...' : $product['item']['name'] }}</a>
                                                                    @else
                                                                        <a target="_blank"
                                                                            href="{{ route('front.product', $product['item']['slug']) }}">
                                                                            {{ mb_strlen($product['item']['name'], 'UTF-8') > 50 ? mb_substr($product['item']['name'], 0, 50, 'UTF-8') . '...' : $product['item']['name'] }}
                                                                        </a>
                                                                    @endif
                                                                @else
                                                                    <a target="_blank"
                                                                        href="{{ route('front.product', $product['item']['slug']) }}">
                                                                        {{ mb_strlen($product['item']['name'], 'UTF-8') > 50 ? mb_substr($product['item']['name'], 0, 50, 'UTF-8') . '...' : $product['item']['name'] }}
                                                                    </a>
                                                                @endif
                                                                @if ($product['item']['type'] != 'Physical' && $product['item']['type'] != 'License')
                                                                    @if ($order->payment_status == 'Completed')
                                                                        @if ($product['item']['file'] != null)
                                                                            <a href="{{ route('user-order-download', ['slug' => $order->order_number, 'id' => $product['item']['id']]) }}"
                                                                                class="btn btn-sm btn-primary">
                                                                                <i class="fa fa-download"></i>
                                                                                {{ __('Download') }}
                                                                            </a>
                                                                        @else
                                                                            <a target="_blank"
                                                                                href="{{ $product['item']['link'] }}"
                                                                                class="btn btn-sm btn-primary">
                                                                                <i class="fa fa-download"></i>
                                                                                {{ __('Download') }}
                                                                            </a>
                                                                        @endif
                                                                    @endif
                                                                @endif
                                                                @if ($product['license'] != '')
                                                                    <a href="javascript:;" data-toggle="modal"
                                                                        data-target="#confirm-delete"
                                                                        class="btn btn-sm mybtn1 product-btn"
                                                                        id="license"><i class="fa fa-eye"></i> Your
                                                                        License : {{ $product['license'] }}</a>
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td data-label="{{ __('Details') }}">
                                                            <div>

                                                                <b>{{ __('Quantity') }}</b>: {{ $product['qty'] }} <br>
                                                                @if (!empty($product['size']))
                                                                    <b>{{ __('Size') }}</b>:
                                                                    {{ $product['item']['measure'] }}{{ str_replace('-', ' ', $product['size']) }}
                                                                    <br>
                                                                @endif
                                                                @if (!empty($product['color']))
                                                                    <div class="d-flex mt-2">
                                                                        <b>{{ __('Color') }}</b>: <span id="color-bar"
                                                                            style="width: 20px; height: 20px; display: inline-block; vertical-align: middle; border-radius: 50%; background: #{{ $product['color'] }};"></span>
                                                                    </div>
                                                                @endif

                                                                @if (!empty($product['keys']))
                                                                    @foreach (array_combine(explode(',', $product['keys']), explode(',', $product['values'])) as $key => $value)
                                                                        <b>{{ ucwords(str_replace('_', ' ', $key)) }} :
                                                                        </b> {{ $value }} <br>
                                                                    @endforeach
                                                                @endif
                                                            </div>

                                                        </td>
                                                        @if(isset($order->is_refund) && $order->is_refund == 1)
                                                        <td>
                                                            @if(isset($refundedProducts[$product['item']['id']])) {{$refundedProducts[$product['item']['id']]}} @else {{'--'}} @endif
                                                        </td>
                                                        @endif
                                                        <td data-label="{{ __('Price') }}">
                                                            <div>
                                                                {{ \PriceHelper::showCurrencyPrice($product['item_price'] * $order->currency_value) }}
                                                            </div>
                                                        </td>
                                                        <td data-label="{{ __('Total') }}">
                                                            <div>
                                                                {{ \PriceHelper::showCurrencyPrice($product['item_price'] * $product['qty'] * $order->currency_value) }}
                                                                <small>{{ $product['discount'] == 0 ? '' : '(' . $product['discount'] . '% ' . __('Off') . ')' }}</small></small>
                                                            </div>
                                                        </td>
                                                        <td data-label="{{ __('Action') }}">
                                                            @php
                                                                $orderProductReviewData = \PriceHelper::checkOrderProductReivew($order->id, Auth::user()->id, $product['item']['id']);
                                                            @endphp

                                                            @if ($orderProductReviewData['status'] == 'no')
                                                                <a href="javascript:;" data-bs-toggle="modal"
                                                                    data-bs-target="#exampleModal_{{ $product['item']['id'] }}"
                                                                    data-bs-whatever="@mdo"
                                                                    class="back-btn theme-bg">Write
                                                                    Review</a>
                                                            @endif
                                                            @if ($orderProductReviewData['status'] == 'yes')
                                                                <a href="javascript:;" data-bs-toggle="modal"
                                                                    data-bs-target="#viewExampleModal_{{ $product['item']['id'] }}"
                                                                    data-bs-whatever="@mdo" class="back-btn theme-bg">View
                                                                    Review</a>
                                                            @endif

                                                        </td>
                                                    </tr>
                                                    @if ($orderProductReviewData['status'] == 'no')
                                                        <div class="modal fade"
                                                            id="exampleModal_{{ $product['item']['id'] }}"
                                                            tabindex="-1" aria-labelledby="exampleModalLabel"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                                            Product
                                                                            Reviews</h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="alert alert-success reviewSuccessAlert_{{ $product['item']['id'] }}"
                                                                            role="alert" style="display: none;">
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <div class="review-area">
                                                                                <div class="star-area">
                                                                                    <ul class="star-list">
                                                                                        <li class="stars_new"
                                                                                            data-val="1"
                                                                                            data-attr="{{ $product['item']['id'] }}">
                                                                                            <i class="fas fa-star"></i>
                                                                                        </li>
                                                                                        <li class="stars stars_new"
                                                                                            data-val="2"
                                                                                            data-attr="{{ $product['item']['id'] }}">
                                                                                            <i class="fas fa-star"></i>
                                                                                            <i class="fas fa-star"></i>
                                                                                        </li>
                                                                                        <li class="stars_new"
                                                                                            data-val="3"
                                                                                            data-attr="{{ $product['item']['id'] }}">
                                                                                            <i class="fas fa-star"></i>
                                                                                            <i class="fas fa-star"></i>
                                                                                            <i class="fas fa-star"></i>
                                                                                        </li>
                                                                                        <li class="stars_new"
                                                                                            data-val="4"
                                                                                            data-attr="{{ $product['item']['id'] }}">
                                                                                            <i class="fas fa-star"></i>
                                                                                            <i class="fas fa-star"></i>
                                                                                            <i class="fas fa-star"></i>
                                                                                            <i class="fas fa-star"></i>
                                                                                        </li>
                                                                                        <li class="stars_new active"
                                                                                            data-val="5"
                                                                                            data-attr="{{ $product['item']['id'] }}">
                                                                                            <i class="fas fa-star"></i>
                                                                                            <i class="fas fa-star"></i>
                                                                                            <i class="fas fa-star"></i>
                                                                                            <i class="fas fa-star"></i>
                                                                                            <i class="fas fa-star"></i>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="message-text"
                                                                                class="col-form-label">Message:</label>
                                                                            <textarea class="form-control border product_message_{{ $product['item']['id'] }}" id="message-text"></textarea>
                                                                        </div>
                                                                        <input type="hidden" id="rating"
                                                                            class="rating_new_{{ $product['item']['id'] }}"
                                                                            name="rating" value="5">
                                                                        <input type="hidden"
                                                                            class="user_id_{{ $product['item']['id'] }}"
                                                                            name="user_id"
                                                                            value="{{ Auth::user()->id }}">
                                                                        <input type="hidden" name="product_id"
                                                                            class="product_id_{{ $product['item']['id'] }}"
                                                                            value="{{ $product['item']['id'] }}">
                                                                        <input type="hidden" name="order_id"
                                                                            class="order_product_id_{{ $product['item']['id'] }}"
                                                                            value="{{ $order->id }}">
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Close</button>
                                                                        <button type="button"
                                                                            class="btn btn-primary submitProductReivew"
                                                                            data-ref="{{ $product['item']['id'] }}">Sumbit
                                                                            Review</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if ($orderProductReviewData['status'] == 'yes')
                                                        <div class="modal fade"
                                                            id="viewExampleModal_{{ $product['item']['id'] }}"
                                                            tabindex="-1" aria-labelledby="viewExampleModal"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="viewExampleModal">
                                                                            Product
                                                                            Reviews</h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="alert alert-success reviewSuccessAlert_{{ $product['item']['id'] }}"
                                                                            role="alert" style="display: none;">
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <div class="review-area">
                                                                                <div class="star-area">
                                                                                    <ul class="star-list">
                                                                                        <li class="stars_new @if ($orderProductReviewData['reviewData']->rating == 1) {{ 'active' }} @endif"
                                                                                            data-val="1"
                                                                                            data-attr="{{ $product['item']['id'] }}">
                                                                                            <i class="fas fa-star"></i>
                                                                                        </li>
                                                                                        <li class="stars_new @if ($orderProductReviewData['reviewData']->rating == 2) {{ 'active' }} @endif"
                                                                                            data-val="2"
                                                                                            data-attr="{{ $product['item']['id'] }}">
                                                                                            <i class="fas fa-star"></i>
                                                                                            <i class="fas fa-star"></i>
                                                                                        </li>
                                                                                        <li class="stars_new @if ($orderProductReviewData['reviewData']->rating == 3) {{ 'active' }} @endif"
                                                                                            data-val="3"
                                                                                            data-attr="{{ $product['item']['id'] }}">
                                                                                            <i class="fas fa-star"></i>
                                                                                            <i class="fas fa-star"></i>
                                                                                            <i class="fas fa-star"></i>
                                                                                        </li>
                                                                                        <li class="stars_new @if ($orderProductReviewData['reviewData']->rating == 4) {{ 'active' }} @endif"
                                                                                            data-val="4"
                                                                                            data-attr="{{ $product['item']['id'] }}">
                                                                                            <i class="fas fa-star"></i>
                                                                                            <i class="fas fa-star"></i>
                                                                                            <i class="fas fa-star"></i>
                                                                                            <i class="fas fa-star"></i>
                                                                                        </li>
                                                                                        <li class="stars_new @if ($orderProductReviewData['reviewData']->rating == 5) {{ 'active' }} @endif"
                                                                                            data-val="5"
                                                                                            data-attr="{{ $product['item']['id'] }}">
                                                                                            <i class="fas fa-star"></i>
                                                                                            <i class="fas fa-star"></i>
                                                                                            <i class="fas fa-star"></i>
                                                                                            <i class="fas fa-star"></i>
                                                                                            <i class="fas fa-star"></i>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="message-text"
                                                                                class="col-form-label">Message:</label>
                                                                            <textarea readonly class="form-control border product_message_{{ $product['item']['id'] }}" id="message-text">{{ $orderProductReviewData['reviewData']->review }}</textarea>
                                                                        </div>
                                                                        <input type="hidden" id="rating"
                                                                            class="rating_new_{{ $product['item']['id'] }}"
                                                                            name="rating" value="5">
                                                                        <input type="hidden"
                                                                            class="user_id_{{ $product['item']['id'] }}"
                                                                            name="user_id"
                                                                            value="{{ Auth::user()->id }}">
                                                                        <input type="hidden" name="product_id"
                                                                            class="product_id_{{ $product['item']['id'] }}"
                                                                            value="{{ $product['item']['id'] }}">
                                                                        <input type="hidden" name="order_id"
                                                                            class="order_product_id_{{ $product['item']['id'] }}"
                                                                            value="{{ $order->id }}">
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Close</button>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                                @if(isset($order->is_refund) && $order->is_refund==1)
                                    <div class="card">
                                        <div class="card-header" style="background-color: #df292b!important;">
                                            <h6 style="color:#FFF; padding:0px; margin:0px">Refund Request Details</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label><i>Refund Request On: </i>{{date('jS M, Y h:i A', strtotime($order->refund_proceed_on))}}</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label><i>Refund Status: </i>{{'--'}}</label>
                                                </div>
                                                <div class="col-lg-12"><label><i>Refund Reason:</i></label><p>{{$order->refund_reason}}</p></div>
                                                <div class="col-lg-12"><label></label><p>{{nl2br($order->refund_text)}}</p></div>
                                            </div>
                                        </div>
                                    </div>
                                    <br/>
                                @endif

                                <a class="back-btn theme-bg" href="{{ route('user-orders') }}">{{ __('Back') }}</a>
                                @if(isset($order->is_refund) && $order->is_refund==2)
                                    <br/>
                                    <br/>
                                    <a class="btn btn-sm btn-danger ReturnBoxPanel" href="javascript:void(0)" onclick="ReturnCompleteOrderPopUp();">Return Complete Order</a>
                                    @if(isset($cart['items']) && count($cart['items'])>1)
                                        <a class="btn btn-sm btn-danger ReturnBoxPanel" href="javascript:void(0)" onclick="ReturnSpecificProductsPopUp();">Return Specific Products</a>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!--==================== Blog Section End ====================-->

    {{-- Modal --}}
    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-block text-center">
                    <h4 class="modal-title d-inline-block">{{ __('License Key') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-center">{{ __('The Licenes Key is :') }} <span id="key"></span></p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('Close') }}</button>
                </div>
            </div>
        </div>
    </div>
    
    
    <div class="modal fade" id="ReturnCompleteOrderPopUpModal" tabindex="-1" role="dialog" aria-labelledby="ReturnCompleteOrderPopUpLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="ReturnCompleteOrderForm" class="form-horizontal" action="" method="POST"> 
                @csrf
                <div class="modal-content">
                    <div class="modal-header d-block">
                        <h4 class="modal-title d-inline-block">Return Complete Order</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Return Reason</label>
                                    <select id="refund_reason" name="refund_reason" class="form-select form-control" required>
                                        <option value="">Select Return Reason</option>
                                        <option value="Poor Quality">Poor Quality</option>
                                        <option value="Damaged Products">Damaged Products</option>
                                        <option value="Not Ordered Products">Not Ordered Products</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Enter Other Reason</label>
                                    <textarea id="refund_text" name="refund_text" class="form-control" rows="5" placeholder="Enter Specific Return Reason"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-success ReturnCompleteOrder" role="alert" style="display: none;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="order_id" id="order_id" value="{{$order->id}}"/>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="ClosePupUpModal('ReturnCompleteOrderPopUpModal');">{{ __('Close') }}</button>
                        <button type="button" class="btn btn-success" data-dismiss="modal" onclick="ReturnCompleteOrderFormSubmit();">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <div class="modal fade" id="ReturnSpecificProductsPopUpModal" tabindex="-1" role="dialog" aria-labelledby="ReturnSpecificProductsPopUpLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="ReturnSpecificProductsForm" class="form-horizontal" action="" method="POST"> 
                @csrf
                <div class="modal-content">
                    <div class="modal-header d-block">
                        <h4 class="modal-title d-inline-block">Return Specific Products</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Return Reason</label>
                                    <select id="refund_reason" name="refund_reason" class="form-select form-control" required>
                                        <option value="">Select Return Reason</option>
                                        <option value="Poor Quality">Poor Quality</option>
                                        <option value="Damaged Products">Damaged Products</option>
                                        <option value="Not Ordered Products">Not Ordered Products</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Enter Other Reason</label>
                                    <textarea id="refund_text" name="refund_text" class="form-control" rows="5" placeholder="Enter Specific Return Reason"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <h6>Select Products</h6>
                                    <table class="table veiw-details-table">
                                        <thead>
                                            <tr>
                                                <th>{{ __('ID#') }}</th>
                                                <th>{{ __('Name') }}</th>
                                                <th>{{ __('Quantity') }}</th>
                                                <th>{{ __('Price') }}</th>
                                                <th>{{ __('Total') }}</th>
                                                <th>{{ __('Return') }}</th>
                                                <th style="width:8%">Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($cart['items'] as $product)
                                                <tr>
                                                    <td data-label="{{ __('ID#') }}"><div>{{ $product['item']['id'] }}</div></td>
                                                    <td data-label="{{ __('Name') }}"><div>{{ mb_strlen($product['item']['name'], 'UTF-8') > 50 ? mb_substr($product['item']['name'], 0, 50, 'UTF-8') . '...' : $product['item']['name'] }}</div></td>
                                                    <td data-label="{{ __('Quantity') }}"><div><b id="order-units-{{$product['item']['id']}}">{{$product['qty']}}</b></div></td>
                                                    <td data-label="{{ __('Price') }}">
                                                        <div>{{ \PriceHelper::showCurrencyPrice($product['item_price'] * $order->currency_value) }}</div>
                                                    </td>
                                                    <td data-label="{{ __('Total') }}"><div>
                                                        {{ \PriceHelper::showCurrencyPrice($product['item_price'] * $product['qty'] * $order->currency_value) }}
                                                    </div></td>
                                                    <td data-label="{{ __('Action') }}">
                                                        <input type="checkbox" class="order-units-check" data-index="{{$product['item']['id']}}" style="display:block !important" id="item_id_{{$product['item']['id']}}" value="{{$product['item']['id']}}" onclick="UpdateOrderProductQtyForReturn(this, {{$product['item']['id']}}, {{$order->id}});"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="item_qty_{{$product['item']['id']}}" class="text-right order-units" disabled="disabled" style="height:30px !important;" name="item[{{$product['item']['id']}}]" value="{{$product['qty']}}"/>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-success ReturnSpecificProductsOrder" role="alert" style="display: none;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="order_id" id="order_id" value="{{$order->id}}"/>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="ClosePupUpModal('ReturnSpecificProductsPopUpModal');">{{ __('Close') }}</button>
                        <button type="button" class="btn btn-success" data-dismiss="modal" onclick="ReturnSpecificProducts();">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @includeIf('partials.global.common-footer')

@endsection
@section('script')
    <script type="text/javascript">
        function ReturnCompleteOrderPopUp(){
            $('#ReturnCompleteOrderPopUpModal').modal('show');
        }
        function ReturnSpecificProductsPopUp(){
            $('#ReturnSpecificProductsPopUpModal').modal('show');
        }
        function ClosePupUpModal(ModalId){
            $('#'+ModalId).modal('hide');    
        }
        function UpdateOrderProductQtyForReturn(thisObj, productId, orderId){
            if($(thisObj).prop('checked') == true)
                $('#item_qty_'+productId).removeAttr('disabled');
            else
                $('#item_qty_'+productId).attr('disabled', 'disabled');
        }
        
        function ReturnCompleteOrderFormSubmit(){
            $.ajax({
                type: "POST",
                url: "{{route('order.refund.request-submit')}}",
                data: $('#ReturnCompleteOrderForm').serialize(),
                success: function(data) {
                    $('.ReturnCompleteOrder').html('Your Order refund Request Successfully submitted to administrator.');    
                    $('.ReturnCompleteOrder').show();
                    $('.ReturnBoxPanel').remove();
                }
            });    
        }
        
        function ReturnSpecificProducts(){
            var ifAnyError = false;
            $('.order-units-check').each(function(){
                
                if($(this).prop('checked') == true){
                    var checkProId = $(this).attr('data-index');  
                    var item_qty_refund = parseInt($('#item_qty_'+checkProId).val());
                    var order_units = parseInt($('#order-units-'+checkProId).html());
                    
                    if(item_qty_refund>order_units){
                        ifAnyError = true;
                        $('#item_qty_'+checkProId).addClass('border-danger');
                    }
                    else {
                        if(item_qty_refund==0 || item_qty_refund==''){
                            ifAnyError = true;
                            $('#item_qty_'+checkProId).addClass('border-danger');    
                        }
                    }
                }     
            });
            if(ifAnyError == false){
                $.ajax({
                    type: "POST",
                    url: "{{route('order.refund-specific.request-submit')}}",
                    data: $('#ReturnSpecificProductsForm').serialize(),
                    success: function(data) {
                        $('.ReturnSpecificProductsOrder').html('Your Order refund Request Successfully submitted to administrator.');    
                        $('.ReturnSpecificProductsOrder').show();
                        $('.ReturnBoxPanel').remove();
                    }
                });   
            }
        }
        
    
        (function($) {
            "use strict";

            $('#example').dataTable({
                "ordering": false,
                'paging': false,
                'lengthChange': false,
                'searching': false,
                'ordering': false,
                'info': false,
                'autoWidth': false,
                'responsive': true
            });

        })(jQuery);
    </script>
    <script>
        (function($) {
            "use strict";

            $(document).on("click", "#tid", function(e) {
                $(this).hide();
                $("#tc").show();
                $("#tin").show();
                $("#tbtn").show();
            });
            $(document).on("click", "#tc", function(e) {
                $(this).hide();
                $("#tid").show();
                $("#tin").hide();
                $("#tbtn").hide();
            });
            $(document).on("submit", "#tform", function(e) {
                var oid = $("#oid").val();
                var tin = $("#tin").val();
                $.ajax({
                    type: "GET",
                    url: "{{ URL::to('user/json/trans') }}",
                    data: {
                        id: oid,
                        tin: tin
                    },
                    success: function(data) {
                        $("#ttn").html(data);
                        $("#tin").val("");
                        $("#tid").show();
                        $("#tin").hide();
                        $("#tbtn").hide();
                        $("#tc").hide();
                    }
                });
                return false;
            });

        })(jQuery);
    </script>
    <script type="text/javascript">
        (function($) {
            "use strict";

            $(document).on('click', '#license', function(e) {
                var id = $(this).parent().find('input[type=hidden]').val();
                $('#key').html(id);
            });

        })(jQuery);
    </script>

    <script type="text/javascript">
        (function($) {
            "use strict";
            $('button.submitProductReivew').click(function(e) {
                e.preventDefault();
                var buttonProductID     =   $(this).attr('data-ref');
                var productMessageVal   =   $('.product_message_' + buttonProductID).val();
                var productRatingVal    =   $('.rating_new_' + buttonProductID).val();
                var productUserVal      =   $('.user_id_' + buttonProductID).val();
                var productOrderIdVal   =   $('.order_product_id_' + buttonProductID).val();
                if (buttonProductID != '') {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('front.order.review.submit') }}",
                        data: {
                            buttonProductID: buttonProductID,
                            productMessageVal: productMessageVal,
                            productRatingVal: productRatingVal,
                            productUserVal: productUserVal,
                            productOrderIdVal: productOrderIdVal
                        },
                        dataType: "json",
                        success: function(response) {
                            if(response.status = 'success') {
                                $('.reviewSuccessAlert_' + buttonProductID).show().html(response.message);
                                setTimeout(function() {
                                    window.location.reload();
                                }, 2000);
                            }
                        }

                    })
                }

            });
        })(jQuery);

        $(document).on("click", ".stars_new", function() {
            $(".stars_new").removeClass("active");
            var productID = $(this).attr('data-attr');
            var ratingValue = $(this).attr('data-val');
            $(this).addClass("active");
            $('.rating_new_' + productID).val(ratingValue);
        });
        
        
        
    </script>
@endsection
