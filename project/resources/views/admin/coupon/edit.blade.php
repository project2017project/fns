@extends('layouts.admin')

@section('styles')
    <link href="{{ asset('assets/admin/css/jquery-ui.css') }}" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        span.select2-selection--multiple {
            padding-bottom: 0px !important;
        }
    </style>
@endsection


@section('content')
    <div class="content-area">

        <div class="mr-breadcrumb">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="heading">{{ __('Edit Coupon') }} <a class="add-btn"
                            href="{{ route('admin-coupon-index') }}"><i class="fas fa-arrow-left"></i>
                            {{ __('Back') }}</a></h4>
                    <ul class="links">
                        <li>
                            <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                        </li>
                        <li>
                            <a href="{{ route('admin-coupon-index') }}">{{ __('Coupons') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('admin-coupon-edit', $data->id) }}">{{ __('Edit Coupon') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="add-product-content1 add-product-content2">
            <div class="row">
                <div class="col-lg-12">
                    <div class="product-description">
                        <div class="body-area">
                            <div class="gocover"
                                style="background: url({{ asset('assets/images/' . $gs->admin_loader) }}) no-repeat scroll center center rgba(45, 45, 45, 0.5);">
                            </div>
                            @include('includes.admin.form-both')
                            <form id="geniusform" action="{{ route('admin-coupon-update', $data->id) }}" method="POST"
                                enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="left-area">
                                            <h4 class="heading">{{ __('Coupon For Excluded / Included') }}*</h4>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <input type="radio" name="is_included_excluded" class="is_included_excluded"
                                            value="included" @if ($data->is_included_excluded == 'included') {{ 'checked' }} @endif>
                                        Included
                                        &nbsp;
                                        &nbsp;
                                        <input type="radio" name="is_included_excluded" class="is_included_excluded"
                                            value="excluded" @if ($data->is_included_excluded == 'excluded') {{ 'checked' }} @endif>
                                        Excluded
                                    </div>
                                </div>

                                <div class="row" id="included">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="left-area">
                                                    <h4 class="heading">{{ __('Code') }} *</h4>
                                                    <p class="sub-heading">{{ __('(In Any Language)') }}</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-7">
                                                <input type="text" class="input-field" name="code"
                                                    placeholder="{{ __('Enter Code') }}" required=""
                                                    value="{{ $data->code }}">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="left-area">
                                                    <h4 class="heading">{{ __('Product / SKU') }}</h4>
                                                </div>
                                            </div>
                                            <div class="col-lg-7">
                                                @php
                                                    $productIds = $data->product_sku_ids;
                                                    $productIdsArr = explode(',', $productIds);
                                                @endphp
                                                <select multiple="multiple" name="product_skus[]" class="product_select2">
                                                    @foreach ($products as $product)
                                                        <option
                                                            @if (in_array($product->id, $productIdsArr)) {{ 'selected' }} @endif
                                                            value="{{ $product->id }}">{{ $product->sku }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="left-area">
                                                    <h4 class="heading">{{ __('Allow Product Type') }} *</h4>
                                                </div>
                                            </div>
                                            <div class="col-lg-7">
                                                <select name="coupon_type" required="" class="select_type_coupon">
                                                    <option value="">{{ __('Select Type') }}</option>
                                                    <option value="category"
                                                        {{ $data->coupon_type == 'category' ? 'selected' : '' }}>
                                                        {{ __('Category') }}</option>
                                                    <option value="sub_category"
                                                        {{ $data->coupon_type == 'sub_category' ? 'selected' : '' }}>
                                                        {{ __('Sub Category') }}</option>
                                                    <option value="child_category"
                                                        {{ $data->coupon_type == 'child_category' ? 'selected' : '' }}>
                                                        {{ __('Child Category') }}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row includeClass {{ $data->category ? '' : 'd-none' }} category"
                                            style="margin-bottom: 50px !important;">
                                            <div class="col-lg-4" style="float: left;">
                                                <div class="left-area">
                                                    <h4 class="heading">{{ __('Category') }}*</h4>
                                                </div>
                                            </div>
                                            <div class="col-lg-7" style="float: left;">
                                                <select name="category">
                                                    <option value="">{{ __('Select Category') }}</option>
                                                    @foreach ($categories as $cat)
                                                        <option value="{{ $cat->id }}"
                                                            {{ $data->category == $cat->id ? 'selected' : '' }}>
                                                            {{ $cat->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <br>
                                        </div>

                                        <div class="row includeClass {{ $data->sub_category ? '' : 'd-none' }} sub_category"
                                            style="margin-bottom: 50px !important;">
                                            <div class="col-lg-4" style="float: left;">
                                                <div class="left-area">
                                                    <h4 class="heading">{{ __('Subcategory') }}*</h4>
                                                </div>
                                            </div>
                                            <div class="col-lg-7" style="float: left;">
                                                <select name="sub_category">
                                                    <option value="">{{ __('Select Subcategory') }}</option>
                                                    @foreach ($sub_categories as $scat)
                                                        <option value="{{ $scat->id }}"
                                                            {{ $data->sub_category == $scat->id ? 'selected' : '' }}>
                                                            {{ $scat->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <br>
                                        </div>

                                        <div class="row includeClass {{ $data->child_category ? '' : 'd-none' }} child_category"
                                            style="margin-bottom: 50px !important;">
                                            <div class="col-lg-4" style="float: left;">
                                                <div class="left-area">
                                                    <h4 class="heading">{{ __('Child Category') }}*</h4>
                                                </div>
                                            </div>
                                            <div class="col-lg-7" style="float: left;">
                                                <select name="child_category">
                                                    <option value="">{{ __('Select Child Category') }}</option>
                                                    @foreach ($child_categories as $ccat)
                                                        <option value="{{ $ccat->id }}"
                                                            {{ $data->child_category == $ccat->id ? 'selected' : '' }}>
                                                            {{ $ccat->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <br>
                                        </div>


                                        <div class="row {{ $data->excluded_category ? '' : 'd-none' }} excludeClass category excluded_categoryDiv"
                                            style="margin-bottom: 50px !important;">
                                            <div class="col-lg-4" style="float: left;">
                                                <div class="left-area">
                                                    <h4 class="heading">{{ __('Category') }}*</h4>
                                                </div>
                                            </div>
                                            <div class="col-lg-7" style="float: left;">
                                                @php
                                                    $CategoryIdsEx = $data->excluded_category;
                                                    $CategoryIdsExArr = explode(',', $CategoryIdsEx);
                                                @endphp
                                                <select name="excluded_category[]" multiple="multiple"
                                                    class="excluded_category" style="width: 100%">
                                                    <option value="">{{ __('Select Category') }}</option>
                                                    @foreach ($categories as $cat)
                                                        <option
                                                            @if (in_array($cat->id, $CategoryIdsExArr)) {{ 'selected' }} @endif
                                                            value="{{ $cat->id }}">{{ $cat->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <br>
                                        </div>

                                        <div class="row {{ $data->excluded_sub_category ? '' : 'd-none' }} excludeClass sub_category excluded_sub_categoryDiv"
                                            style="margin-bottom: 50px !important;">
                                            <div class="col-lg-4" style="float: left;">
                                                <div class="left-area">
                                                    <h4 class="heading">{{ __('Subcategory') }}*</h4>
                                                </div>
                                            </div>
                                            <div class="col-lg-7" style="float: left;">
                                                @php
                                                    $SubcategoryIdsEx = $data->excluded_sub_category;
                                                    $SubcategoryIdsExArr = explode(',', $SubcategoryIdsEx);
                                                @endphp
                                                <select name="excluded_sub_category[]" multiple="multiple"
                                                    class="excluded_sub_category" style="width: 100%">
                                                    <option value="">{{ __('Select Subcategory') }}</option>
                                                    @foreach ($sub_categories as $scat)
                                                        <option
                                                            @if (in_array($scat->id, $SubcategoryIdsExArr)) {{ 'selected' }} @endif
                                                            value="{{ $scat->id }}">{{ $scat->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <br>
                                        </div>

                                        <div class="row {{ $data->excluded_child_category ? '' : 'd-none' }} excludeClass child_category excluded_child_categoryDiv"
                                            style="margin-bottom: 50px !important;">
                                            <div class="col-lg-4" style="float: left;">
                                                <div class="left-area">
                                                    <h4 class="heading">{{ __('Child Category') }}*</h4>
                                                </div>
                                            </div>
                                            <div class="col-lg-7" style="float: left;">
                                                @php
                                                    $ChildcategoryIdsEx = $data->excluded_child_category;
                                                    $ChildcategoryIdsExArr = explode(',', $ChildcategoryIdsEx);
                                                @endphp
                                                <select name="excluded_child_category[]" multiple="multiple"
                                                    class="excluded_child_category" style="width: 100%">
                                                    <option value="">{{ __('Select Child Category') }}</option>
                                                    @foreach ($child_categories as $ccat)
                                                        <option
                                                            @if (in_array($ccat->id, $ChildcategoryIdsExArr)) {{ 'selected' }} @endif
                                                            value="{{ $ccat->id }}">{{ $ccat->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <br>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="left-area">
                                                    <h4 class="heading">{{ __('Type') }} *</h4>
                                                </div>
                                            </div>
                                            <div class="col-lg-7">
                                                <select id="type" name="type" required="">
                                                    <option value="">{{ __('Choose a type') }}</option>
                                                    <option value="0" {{ $data->type == 0 ? 'selected' : '' }}>
                                                        {{ __('Discount By Percentage') }}</option>
                                                    <option value="1" {{ $data->type == 1 ? 'selected' : '' }}>
                                                        {{ __('Discount By Amount') }}</option>
                                                </select>
                                            </div>
                                        </div>



                                        <div class="row hidden">
                                            <div class="col-lg-4">
                                                <div class="left-area">
                                                    <h4 class="heading"></h4>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <input type="text" class="input-field less-width" name="price"
                                                    placeholder="" required=""
                                                    value="{{ $data->price }}"><span></span>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="left-area">
                                                    <h4 class="heading">{{ __('Quantity') }} *</h4>
                                                </div>
                                            </div>
                                            <div class="col-lg-7">
                                                <select id="times" required="">
                                                    <option value="0" {{ $data->times == null ? 'selected' : '' }}>
                                                        {{ __('Unlimited') }}</option>
                                                    <option value="1" {{ $data->times != null ? 'selected' : '' }}>
                                                        {{ __('Limited') }}</option>
                                                </select>
                                            </div>
                                        </div>



                                        <div class="row hidden">
                                            <div class="col-lg-4">
                                                <div class="left-area">
                                                    <h4 class="heading">{{ __('Value') }} *</h4>
                                                </div>
                                            </div>
                                            <div class="col-lg-7">
                                                <input type="text" class="input-field less-width" name="times"
                                                    placeholder="{{ __('Enter Value') }}"
                                                    value="{{ $data->times }}"><span></span>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="left-area">
                                                    <h4 class="heading">{{ __('Used Type') }} </h4>
                                                    <p class="sub-heading">{{ __('(In Any Language)') }}</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-7">
                                                <select id="used_type" name="used_type">
                                                    <option value="">{{ __('Select Used Type') }}</option>
                                                    <option value="cart_amount"
                                                        {{ $data->used_type == 'cart_amount' ? 'selected' : '' }}>
                                                        {{ __('Min Cart Amount') }}</option>
                                                    <option value="cart_qty"
                                                        {{ $data->used_type == 'cart_qty' ? 'selected' : '' }}>
                                                        {{ __('Min Cart Qty') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="left-area">
                                                    <h4 class="heading">{{ __('Used Type Value') }} </h4>
                                                    <p class="sub-heading">{{ __('(In Any Language)') }}</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-7">
                                                <input type="number" min="0"
                                                    onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"
                                                    class="input-field" name="used_type_value"
                                                    value="{{ $data->used_type_value }}" placeholder="Used Type Value"
                                                    value="{{ old('used_type_value') }}"><span></span>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="left-area">
                                                    <h4 class="heading">{{ __('Per User Uses') }} </h4>
                                                    <p class="sub-heading">{{ __('(In Any Language)') }}</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-7">
                                                <input type="number" min="1" value="{{ $data->used_per_user }}"
                                                    onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"
                                                    class="input-field" name="used_per_user" placeholder="Per User Uses"
                                                    value="{{ old('used_per_user') }}"><span></span>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="left-area">
                                                    <h4 class="heading">{{ __('Start Date') }} *</h4>
                                                    <p class="sub-heading">{{ __('(In Any Language)') }}</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-7">
                                                <input type="text" class="input-field" name="start_date"
                                                    autocomplete="off" id="from"
                                                    placeholder="{{ __('Select a date') }}" required=""
                                                    value="{{ $data->start_date }}">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="left-area">
                                                    <h4 class="heading">{{ __('End Date') }} *</h4>
                                                    <p class="sub-heading">{{ __('(In Any Language)') }}</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-7">
                                                <input type="text" class="input-field" name="end_date" id="to"
                                                    autocomplete="off" placeholder="{{ __('Select a date') }}"
                                                    required="" value="{{ $data->end_date }}">
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <br>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="left-area">

                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <button class="addProductSubmit-btn" type="submit">{{ __('Save') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        {{-- Coupon Function --}}

            (function() {

                var val = $('#type').val();
                var selector = $('#type').parent().parent().next();
                if (val == "") {
                    selector.hide();
                } else {
                    if (val == 0) {
                        selector.find('.heading').html('{{ __('Percentage') }} *');
                        selector.find('input').attr("placeholder", "{{ __('Enter Percentage') }}").next().html('%');
                        selector.css('display', 'flex');
                    } else if (val == 1) {
                        selector.find('.heading').html('{{ __('Amount') }} *');
                        selector.find('input').attr("placeholder", "{{ __('Enter Amount') }}").next().html('$');
                        selector.css('display', 'flex');
                    }
                }
            })();

        {{-- Coupon Type --}}

        $('#type').on('change', function() {
            var val = $(this).val();
            var selector = $(this).parent().parent().next();
            if (val == "") {
                selector.hide();
            } else {
                if (val == 0) {
                    selector.find('.heading').html('{{ __('Percentage') }} *');
                    selector.find('input').attr("placeholder", "{{ __('Enter Percentage') }}").next().html('%');
                    selector.css('display', 'flex');
                } else if (val == 1) {
                    selector.find('.heading').html('{{ __('Amount') }} *');
                    selector.find('input').attr("placeholder", "{{ __('Enter Amount') }}").next().html('$');
                    selector.css('display', 'flex');
                }
            }
        });


        {{-- Coupon Qty --}}



            (function() {

                var val = $("#times").val();
                var selector = $("#times").parent().parent().next();
                if (val == 1) {
                    selector.css('display', 'flex');
                } else {
                    selector.find('input').val("");
                    selector.hide();
                }

            })();


        $(document).on("change", "#times", function() {
            var val = $(this).val();
            var selector = $(this).parent().parent().next();
            if (val == 1) {
                selector.css('display', 'flex');
            } else {
                selector.find('input').val("");
                selector.hide();
            }
        });
    </script>

    <script type="text/javascript">
        var dateToday = new Date();
        var dates = $("#from,#to").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            changeYear: true,
            minDate: dateToday,
            onSelect: function(selectedDate) {
                var option = this.id == "from" ? "minDate" : "maxDate",
                    instance = $(this).data("datepicker"),
                    date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults
                        .dateFormat, selectedDate, instance.settings);
                dates.not(this).datepicker("option", option, date);
            }
        });



        $(document).on('change', '.select_type_coupon', function() {
            let coupon_type = $(this).val();
            if (coupon_type == 'category') {
                $('.category').removeClass('d-none');
                $('.child_category').addClass('d-none');
                $('.sub_category').addClass('d-none');
            } else if (coupon_type == 'sub_category') {
                $('.category').addClass('d-none');
                $('.child_category').addClass('d-none');
                $('.sub_category').removeClass('d-none');
            } else {
                $('.category').addClass('d-none');
                $('.child_category').removeClass('d-none');
                $('.sub_category').addClass('d-none');
            }

            var checkedValSSSS = $('input[name=is_included_excluded]:checked').val();
            if (checkedValSSSS != '' && checkedValSSSS == 'excluded') {
                $('.excludeClass').show();
                $('.includeClass').hide();
            } else {
                $('.excludeClass').hide();
                $('.includeClass').show();
            }
        })
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.product_select2').select2({
                placeholder: 'Select SKU(s)'
            });

            $('.excluded_category').select2({
                placeholder: 'Select category'
            });
            $('.excluded_sub_category').select2({
                placeholder: 'Select sub category'
            });
            $('.excluded_child_category').select2({
                placeholder: 'Select child category'
            });

            var checkedVal = $('input[name=is_included_excluded]:checked').val();

            if (checkedVal != '' && checkedVal == 'excluded') {
                $('.includeClass').hide();
                $('.excludeClass').show();
            } else {
                $('.excludeClass').hide();
                $('.includeClass').show();
            }

            $('.is_included_excluded').click(function() {
                var checkedValSS = $('input[name=is_included_excluded]:checked').val();
                if (checkedValSS != '' && checkedValSS == 'excluded') {
                    $('.excludeClass').show();
                    $('.includeClass').hide();
                } else {
                    $('.excludeClass').hide();
                    $('.includeClass').show();
                }
            });
        });
    </script>
@endsection
