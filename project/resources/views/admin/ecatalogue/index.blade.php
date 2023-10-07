@extends('layouts.admin')

@section('styles')
    <style type="text/css">
        td img {
            max-height: 500px;
            max-width: 500px;
        }
    </style>
@endsection
@section('content')
    <input type="hidden" id="headerdata" value="{{ __('ECATALOGUE') }}">
    <input type="hidden" id="attribute_data" value="{{ __('ADD NEW ATTRIBUTE') }}">
    <div class="content-area">
        <div class="mr-breadcrumb">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="heading">{{ __('E-Catalogue') }}</h4>
                    <ul class="links">
                        <li>
                            <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                        </li>
                        <li><a href="javascript:;">{{ __('E-Catalogue') }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="product-area">
            <div class="row">
                <div class="col-lg-12">
                    <div class="mr-table allproduct">
                        {{-- @include('alerts.admin.form-success') --}}
                        @if (session('sucess'))
                            <div class="alert alert-success validation">
                                <button type="button" class="close alert-close"><span>×</span></button>
                                <p class="text-left">{{ session('sucess') }}</p>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger validation">
                                <button type="button" class="close alert-close"><span>×</span></button>
                                <p class="text-left">{{ session('error') }}</p>
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th width="65%">{{ __('Title') }}</th>
                                        <th>{{ __('File') }}</th>
                                        <th>{{ __('Options') }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
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
                    <p class="text-center">
                        {{ __('You are about to delete this Category. Everything under this category will be deleted') }}.
                    </p>
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
    <script type="text/javascript">
        (function($) {
            "use strict";

            var table = $('#geniustable').DataTable({
                ordering: false,
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin-e-catalogue-datatables') }}',
                columns: [{
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'file',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'action',
                        searchable: false,
                        orderable: false
                    }

                ],
                language: {
                    processing: '<img src="{{ asset('assets/images/' . $gs->admin_loader) }}">'
                },
                drawCallback: function(settings) {
                    $('.select').niceSelect();
                }
            });

            $(function() {
                $(".btn-area").append('<div class="col-sm-4 table-contents">' +
                    '<a class="add-btn" href="{{ route('admin-add-e-catalogue') }}" id="add-data">' +
                    '<i class="fas fa-plus"></i> <span class="remove-mobile">{{ __('Add New') }}<span>' +
                    '</a>' +
                    '</div>');
            });

        })(jQuery);
    </script>
@endsection
