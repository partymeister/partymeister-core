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
            font-family: "Courier New", Courier;
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
    <div class="modal fade" id="guest-modal" tabindex="-1" role="dialog" aria-labelledby="">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        {{trans('partymeister-core::backend/guests.mark_as_arrived')}}
                    </h4>
                    <div class="float-right">
                        <button class="btn btn-default outline-secondary" data-dismiss="modal" aria-label="Close">
                            Cancel
                        </button>
                        <button class="btn btn-success" @click="confirm()" data-dismiss="modal">Confirm</button>
                    </div>
                </div>
                <div class="modal-body">
                    <div v-if="comment != ''" v-html="'<p>'+nl2br(comment)+'</p>'"></div>
                    <div class="alert alert-info">
                        <p v-if="has_badge" style="margin-bottom: 0; padding: 1rem 0;font-size: 20px;">
                            {!! trans('partymeister-core::backend/guests.badge_info_vue') !!}
                        </p>
                        <p v-if="ticket_code != ''" style="margin-bottom: 0; padding: 1rem 0;font-size: 20px;">
                            {!! trans('partymeister-core::backend/guests.ticket_code_info_vue') !!}
                        </p>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
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

        var apiToken = '{{Auth::user()->api_token}}';

        var switchCssClass = function (that, value, cssClass1, cssClass2) {
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
            element = this;

            axios.get('{{action('\Partymeister\Core\Http\Controllers\Api\GuestsController@index')}}/' + $(this).data('record') + '?api_token=' + apiToken).then(function (response) {

                showModal = app.update(element, response.data.data);

                if (!showModal) {
                    app.confirm();
                } else {
                    $('#guest-modal').modal('show')
                }

            });

        });

        app = new window.Vue({
            el: '#guest-modal',
            data: {
                id: '',
                element: '',
                ticket_code: '',
                comment: '',
                name: '',
                has_badge: false
            },
            methods: {
                nl2br: function (string) {
                    return (string + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1<br>$2');
                },
                update: function (element, data) {
                    this.element = element;
                    this.id = data.id;
                    this.ticket_code = data.ticket_code;
                    this.name = data.name;
                    this.has_badge = data.has_badge;
                    this.comment = data.comment;

                    if (data.has_arrived) {
                        return false
                    }

                    if (this.has_badge || this.comment != '' || this.ticket_code != '') {
                        return true;
                    }

                    return false;
                },
                confirm: function () {
                    axios.patch('{{action('\Partymeister\Core\Http\Controllers\Api\GuestsController@index')}}/' + this.id + '?api_token=' + apiToken, {arrived_at: new Date().toISOString(), has_arrived: $(this.element).data('has-arrived')})
                        .then(function (response) {
                            switchCssClass(app.element, response.data.data.has_arrived, $(app.element).data('class'), $(app.element).data('class-alternate'));
                            $(app.element).data('has-arrived', response.data.data.has_arrived ? 0 : 1);
                        });
                }
            }
        });
    </script>
@append