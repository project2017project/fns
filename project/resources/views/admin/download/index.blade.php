@extends('layouts.admin') 

@section('content') 

<div class="content-area">
        <div class="mr-breadcrumb">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="heading">{{ __('Download') }}</h4>
                    <ul class="links">
                        <li>
                            <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                        </li>
                        <li><a href="javascript:;">{{ __('Download Sales Report') }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="product-area">
            <div class="row">
                <div class="col-lg-12">
                    <div class="mr-table allproduct">
                        @include('alerts.admin.form-success')

                        <div class="">
                            <p>Start Date : {{$date[0]->startDate}}</p>
                            <p>End Date : {{$date[0]->endDate}}</p>
                        <form id="geniusformdata" action="{{route('admin-download-store')}}" method="POST" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <input type="date" name="startDate">
                            <input type="date" name="endDate">
                            <button class="addProductSubmit-btn" type="submit">{{ __('Save Date Range') }}</button>
                        </form>
                        <a href="{{route('front.index')}}/admin/download-excel-file/none" class="btn btn-primary btn-md">Download</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection    
