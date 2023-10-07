@extends('layouts.admin')

@section('content')
    <input type="hidden" id="headerdata" value="Web Push Notification">
    <div class="content-area">
        <div class="mr-breadcrumb">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="heading">Web Push Notification</h4>
                    <ul class="links">
                        <li>
                            <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                        </li>
                        <li>
                            <a href="{{ route('admin-webpushnotification-index') }}">Web Push Notification</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 mb-3 text-right">
                <a class="add-btn" data-href="{{route('admin-webpushnotification-create')}}" id="add-data" data-toggle="modal" data-target="#modal1">
                    <i class="fas fa-plus"></i> {{ __('Add New') }}
                </a>
            </div>
        </div>
        <div class="product-area">
            <div class="row">
                <div class="col-lg-12">
                    <div class="mr-table allproduct">
                        @include('alerts.admin.form-success')
                        <div class="table-responsive">
                            <table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style="width:10%">{{ __('Image') }}</th>
                                        <th style="width:40%">{{ __('Title') }}</th>
                                        <th style="width:30%">{{ __('Link') }}</th>
                                        <th style="width:20%">Created On</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($datas) && count($datas)>0)
                                        @foreach ($datas as $data)
                                            <tr>
                                                <td>
                                                    @if(isset($data->image) && !empty($data->image))
                                                        @if(file_exists(public_path().'/assets/images/webpushnotification/'.$data->image))
                                                            <img src="{{asset('assets/images/webpushnotification/'.$data->image)}}" class="img-fluid w-50"/>
                                                        @else
                                                            {{'--'}}
                                                        @endif
                                                    @else
                                                        {{'--'}}
                                                    @endif
                                                </td>
                                                <td>{{$data->title}}</td>
                                                <td>
                                                    @if(isset($data->target_url) && !empty($data->target_url))
                                                        <a href="{{$data->target_url}}" target="_blank">{{$data->target_url}}</a>
                                                    @else
                                                        {{'--'}}
                                                    @endif
                                                </td>
                                                <td>{{date('jS M, Y h:i:A', strtotime($data->created_at))}}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="3" class="text-center"> <strong class="text-danger">No Records Found</strong></td>
                                        </tr>  
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="submit-loader">
                    <img  src="{{asset('assets/images/'.$gs->admin_loader)}}" alt="">
                </div>
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirm-delete-notification" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-block text-center">
                    <h4 class="modal-title d-inline-block">{{ __('Confirm Delete') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <p class="text-center">{{ __('You are about to delete this Record.') }}</p>
                    <p class="text-center">{{ __('Do you want to proceed?') }}</p>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <form action="" class="d-inline delete-form" method="POST">
                        <input type="hidden" name="_method" value="delete" />
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection
