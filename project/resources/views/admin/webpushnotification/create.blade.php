@extends('layouts.load')

@section('content')
    <div class="content-area">
        <div class="add-product-content1">
            <div class="row">
                <div class="col-lg-12">
                    <div class="product-description">
                        <div class="body-area">
                            @include('alerts.admin.form-error')
                            <form id="geniusformdata-pushnotification" action="{{route('admin-webpushnotification-create')}}" method="POST" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h6 class="heading"><small>{{ __('Title') }} *</small></h6>
                                        <input type="text" class="input-field" name="title" maxlength="100" minlength="1" required placeholder="{{ __('Title') }}" value="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h6 class="heading"><small>{{ __('Message') }} *</small></h6>
                                        <textarea class="input-field" name="message" placeholder="{{ __('Target Url') }}" maxlength="250" minlength="1" required></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h6 class="heading"><small>{{ __('Target Url') }}</small></h6>
                                        <input type="text" class="input-field" name="target_url" placeholder="{{ __('Target Url') }}" value="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h6 class="heading"><small>{{ __('Image') }}</small></h6>
                                        <div class="img-upload full-width-img">
                                            <div id="image-preview" class="img-preview" style="background: url({{ asset('assets/admin/images/upload.png') }});">
                                                <label for="image-upload" class="img-label" id="image-label"><i class="icofont-upload-alt"></i>{{ __('Upload Image') }}</label>
                                                <input type="file" name="image" class="img-upload" id="image-upload">
                                            </div>
                                            <p class="text">{{ __('Prefered Size: (600x600) or Square Sized Image') }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="left-area"></div>
                                    </div>
                                    <div class="col-lg-7">
                                        <button class="addPushNotificationSubmit-btn mt-4 btn btn-secondary" type="submit">Send Notification</button>
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
