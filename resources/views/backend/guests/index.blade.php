@extends('motor-backend::layouts.backend')

@section('htmlheader_title')
    {{ trans('motor-backend::backend/global.home') }}
@endsection

@section('view_styles')
    <style type="text/css">
        #scan-tickets-form input {
            width: 100%;
            height: 100px;
            text-align: center;
            font-size: 40px;
            font-family: "Courier New", Courier, monospace;
            text-transform: uppercase;
        }

        #scan-tickets-info .alert-success,
        #scan-tickets-info .alert-danger,
        #scan-tickets-info .alert-info,
        #scan-tickets-info .card-body {
            text-align: center;
            font-size: 25px;
        }
    </style>
@append

@section('contentheader_title')
    {{ trans('partymeister-core::backend/guests.guests') }}
    @if (has_permission('guests.write'))
        {!! link_to_route('backend.guests.create', trans('partymeister-core::backend/guests.new'), [], ['class' => 'float-right btn btn-sm btn-success']) !!}
        <button type="button"
                class="float-right btn btn-sm btn-danger scan-tickets">{{trans('partymeister-core::backend/guests.scan_tickets')}}</button>
    @endif
@endsection

@section('main-content')
    <div class="@boxWrapper">
        <div class="@boxHeader">
            @include('motor-backend::layouts.partials.search')
        </div>
        <!-- /.box-header -->
        @if (isset($grid))
            @include('motor-backend::grid.table')
        @endif
    </div>
    <partymeister-core-guest-modal :api-token="'{{Auth::user()->api_token}}'"></partymeister-core-guest-modal>
    <div class="modal fade" id="scan-tickets-modal" tabindex="-1" role="dialog" aria-labelledby="">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        {{trans('partymeister-core::backend/guests.scan_tickets')}}
                    </h4>
                    <div class="float-right">
                        <button class="btn btn-default outline-secondary" data-dismiss="modal" aria-label="Close">
                            Cancel
                        </button>
                    </div>
                </div>
                <div class="modal-body">
                    <form id="scan-tickets-form">
                        <input type="text" name="ticket_code" class="scan-ticket-code">
                    </form>
                    <hr class="small"/>
                    <div id="scan-tickets-info">
                        <div class="alert alert-danger d-none"></div>
                        <div class="alert alert-success d-none"></div>
                        <div class="card d-none well">
                            <div class="card-body">
                            </div>
                        </div>
                        <div class="alert alert-info d-none"></div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection

@section('view_scripts')
    <script type="text/javascript">
        $('.delete-record').click(function (e) {
            if (!confirm('{{ trans('motor-backend::backend/global.delete_question') }}')) {
                e.preventDefault();
                return false;
            }
        });

        $('#scan-tickets-modal').on('shown.bs.modal', function () {
            $('.scan-ticket-code').trigger('focus')
        });

        $('.scan-tickets').click(function () {
            $('#scan-tickets-modal').modal('show');
        });

        $('#scan-tickets-modal button.modal-close').click(function () {

            // Empty data
            $('#scan-tickets-info .alert').addClass('d-none');
            $('#scan-tickets-info .well').addClass('d-none');
            $('#scan-tickets-modal').modal('hide');
        });

        $('#scan-tickets-form').submit(function (e) {

            $('#scan-tickets-info .alert').addClass('d-none');
            $('#scan-tickets-info .well').addClass('d-none');

            e.preventDefault();
            axios.post('{{route('ajax.guests.scan_tickets.index')}}', $(this).serialize())
                .then(function (response) {

                    if (response.data.success) {
                        $('#scan-tickets-info .alert-success').html(response.data.success);
                        $('#scan-tickets-info .alert-success').removeClass('d-none');
                    }

                    if (response.data.name) {
                        $('#scan-tickets-info .well .card-body').html(response.data.name);
                        $('#scan-tickets-info .well').removeClass('d-none');
                    }

                    if (response.data.info) {
                        $('#scan-tickets-info .alert-info').html(response.data.info);
                        $('#scan-tickets-info .alert-info').removeClass('d-none');
                    }

                    $('.scan-ticket-code').val('');
                })
                .catch(function (error) {
                    $('#scan-tickets-info .alert-danger').html(error.response.data.error);
                    $('#scan-tickets-info .alert-danger').removeClass('d-none');

                    $('.scan-ticket-code').val('');
                });

        });

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });

        let switchCssClass = function (that, value, cssClass1, cssClass2) {
            if (value == true) {
                $(that).removeClass(cssClass2);
                $(that).addClass(cssClass1);
            } else {
                $(that).removeClass(cssClass1);
                $(that).addClass(cssClass2);
            }
        };

        $('.change-has-arrived').click(function (e) {
            e.preventDefault();
            Vue.prototype.$eventHub.$emit('partymeister-core:update-guest-modal', {
                element: this,
                record: $(this).data('record')
            });
        });
    </script>
@append
