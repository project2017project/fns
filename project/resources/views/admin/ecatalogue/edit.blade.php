@extends('layouts.admin')
@section('styles')
@endsection
@section('content')
    <div class="content-area">
        <div class="mr-breadcrumb">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="heading">{{ __('E-Catalogue') }}</h4>
                    <ul class="links">
                        <li>
                            <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                        </li>
                        <li><a href="{{ route('admin.ecatalogue.list') }}">{{ __('E-Catalogue') }}</a></li>
                        <li><a href="javascript:;">{{ __('Edit E-Catalogue') }}</a></li>
                        <li><a href="javascript:;">{{ $data->title }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="add-product-content1">
            <div class="row">
                <div class="col-lg-12">
                    <div class="product-description">
                        <div class="body-area">

                            @if (session('error_msg'))
                                <div class="alert alert-danger validation mb-2">
                                    <button type="button" class="close alert-close"><span>×</span></button>
                                    <p class="text-left">{{ session('error_msg') }}</p>
                                </div>
                            @endif

                            <form id="" action="{{ route('admin-update-e-catalogue', $data->id) }}" method="POST"
                                enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="row mt-5">
                                    <div class="col-lg-4">
                                        <div class="left-area">
                                            <h4 class="heading">{{ __('Title') }} *</h4>
                                            <p class="sub-heading">{{ __('(In Any Language)') }}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <input type="text" class="input-field" name="title"
                                            placeholder="{{ __('Enter Title') }}"
                                            value="{{ old('title', $data->title) }}">
                                        @if ($errors->has('title'))
                                            <span class="text-danger">{{ $errors->first('title') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="left-area">
                                            <h4 class="heading">{{ __('File') }} *</h4>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="img-upload">
                                            <input type="file" name="e_catalogue_file" id="e_catalogue_file">
                                            @if (!empty($data->e_catalogue_file))
                                                <a href="{{ asset('assets/images/e_catalogue/' . $data->e_catalogue_file) }}"
                                                    target="_blank"><i class="fa fa-file-download"></i> Download
                                                    File</a>
                                            @endif
                                        </div>
                                        @if ($errors->has('e_catalogue_file'))
                                            <span class="text-danger">{{ $errors->first('e_catalogue_file') }}</span>
                                        @endif
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
                                            type="submit">{{ __('Update E-Catalogue') }}</button>
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
@endsection
