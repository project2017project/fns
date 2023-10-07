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
                    <h4 class="heading">{{ __('Add New Coupon') }} <a class="add-btn"
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
                            <a href="{{ route('admin-coupon-create') }}">{{ __('Add New Coupon') }}</a>
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
                            <form id="geniusform" action="{{ route('admin-coupon-create') }}" method="POST"
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
                                            value="included" checked> Included
                                        &nbsp;
                                        &nbsp;
                                        <input type="radio" name="is_included_excluded" class="is_included_excluded"
                                            value="excluded">
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
                                                    placeholder="{{ __('Enter Code') }}" required="" value="">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="left-area">
                                                    <h4 class="heading">{{ __('Product / SKU') }}</h4>
                                                </div>
                                            </div>
                                            <div class="col-lg-7">
                                                <select multiple="multiple" name="product_skus[]" class="product_select2">
                                                    @foreach ($products as $product)
                                                        <option value="{{ $product->id }}">{{ $product->sku }}</option>
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
                                                    <option value="" selected>{{ __('Select Type') }}</option>
                                                    <option value="category">{{ __('Category') }}</option>
                                                    <option value="sub_category">{{ __('Sub Category') }}</option>
                                                    <option value="child_category">{{ __('Child Category') }}</option>

                                                </select>
                                            </div>
                                        </div>


                                        <div class="row d-none includeClass included_categoryDiv category"
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
                                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <br>
                                        </div>

                                        <div class="row d-none includeClass included_sub_categoryDiv sub_category"
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
                                                        <option value="{{ $scat->id }}">{{ $scat->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <br>
                                        </div>

                                        <div class="row d-none includeClass included_child_categoryDiv child_category"
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
                                                        <option value="{{ $ccat->id }}">{{ $ccat->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <br>
                                        </div>




                                        <div class="row d-none excludeClass category excluded_categoryDiv"
                                            style="margin-bottom: 50px !important;">
                                            <div class="col-lg-4" style="float: left;">
                                                <div class="left-area">
                                                    <h4 class="heading">{{ __('Category') }}*</h4>
                                                </div>
                                            </div>
                                            <div class="col-lg-7" style="float: left;">
                                                <select name="excluded_category[]" multiple="multiple"
                                                    class="excluded_category" style="width: 100%">
                                                    <option value="">{{ __('Select Category') }}</option>
                                                    @foreach ($categories as $cat)
                                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <br>
                                        </div>

                                        <div class="row d-none excludeClass sub_category excluded_sub_categoryDiv"
                                            style="margin-bottom: 50px !important;">
                                            <div class="col-lg-4" style="float: left;">
                                                <div class="left-area">
                                                    <h4 class="heading">{{ __('Subcategory') }}*</h4>
                                                </div>
                                            </div>
                                            <div class="col-lg-7" style="float: left;">
                                                <select name="excluded_sub_category[]" multiple="multiple"
                                                    class="excluded_sub_category" style="width: 100%">
                                                    <option value="">{{ __('Select Subcategory') }}</option>
                                                    @foreach ($sub_categories as $scat)
                                                        <option value="{{ $scat->id }}">{{ $scat->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <br>
                                        </div>

                                        <div class="row d-none excludeClass child_category excluded_child_categoryDiv"
                                            style="margin-bottom: 50px !important;">
                                            <div class="col-lg-4" style="float: left;">
                                                <div class="left-area">
                                                    <h4 class="heading">{{ __('Child Category') }}*</h4>
                                                </div>
                                            </div>
                                            <div class="col-lg-7" style="float: left;">
                                                <select name="excluded_child_category[]" multiple="multiple"
                                                    class="excluded_child_category" style="width: 100%">
                                                    <option value="">{{ __('Select Child Category') }}</option>
                                                    @foreach ($child_categories as $ccat)
                                                        <option value="{{ $ccat->id }}">{{ $ccat->name }}</option>
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
                                                <select class="type" name="type">
                                                    <option value="">{{ __('Choose a type') }}</option>
                                                    <option value="0">{{ __('Discount By Percentage') }}</option>
                                                    <option value="1">{{ __('Discount By Amount') }}</option>
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
                                                    placeholder="" required="" value=""><span></span>
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
                                                    <option value="0">{{ __('Unlimited') }}</option>
                                                    <option value="1">{{ __('Limited') }}</option>
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
                                                    placeholder="{{ __('Enter Value') }}" value=""><span></span>
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
                                                    <option value="cart_amount">{{ __('Min Cart Amount') }}</option>
                                                    <option value="cart_qty">{{ __('Min Cart Qty') }}</option>
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
                                                    placeholder="Used Type Value"
                                                    value="{{ old('used_type_value') }}"><span></span>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="left-area">
                                                    <h4 class="heading">{{ __(' Per User Uses') }} </h4>
                                                    <p class="sub-heading">{{ __('(In Any Language)') }}</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-7">
                                                <input type="number" min="1"
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
                                                <input type="text" class="input-field" id="from"
                                                    name="start_date" autocomplete="off"
                                                    placeholder="{{ __('Select a date') }}" required=""
                                                    value="">
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
                                                <input type="text" class="input-field" id="to" name="end_date"
                                                    autocomplete="off" placeholder="{{ __('Select a date') }}"
                                                    required="" value="">
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
                                        <button class="addProductSubmit-btn"
                                            type="submit">{{ __('Create Coupon') }}</button>
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
        {{-- Coupon Type --}}

        $('.type').on('change', function() {
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

            var checkedValS = $('input[name=is_included_excluded]:checked').val();
            if (checkedValS != '' && checkedValS == 'excluded') {
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

            $('.is_included_excluded').click(function() {
                var checkedVal = $('input[name=is_included_excluded]:checked').val();
                if (checkedVal != '' && checkedVal == 'excluded') {
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
