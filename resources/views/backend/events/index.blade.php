@extends('motor-backend::layouts.backend')

@section('htmlheader_title')
    {{ trans('motor-backend::backend/global.home') }}
@endsection

@section('contentheader_title')
    {{ trans('partymeister-core::backend/events.events') }}
    @if (has_permission('events.write'))
        {!! link_to_route('backend.events.create', trans('partymeister-core::backend/events.new'), [], ['class' => 'pull-right float-right btn btn-sm btn-success']) !!}
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
@endsection

@section('view_scripts')
    <script type="text/javascript">
        $('.delete-record').click(function (e) {
            if (!confirm('{{ trans('motor-backend::backend/global.delete_question') }}')) {
                e.preventDefault();
                return false;
            }
        });
        let apiToken = '{{Auth::user()->api_token}}';

        let updateEvent = function (that, recordId, data, callback) {
            $.ajax({
                type: 'PATCH',
                url: '{{action('\Partymeister\Core\Http\Controllers\Api\EventsController@index')}}/' + recordId + '?api_token=' + apiToken,
                data: data
            }).done(function (results) {
                callback(that, results);
            });
        };

        $('.change-sort-position').blur(function (e) {
            e.preventDefault();

            let data = {};
            data[$(this).data('field')] = $(this).val();

            updateEvent(this, $(this).data('record'), data, function (that, results) {
                toastr.options = {progressBar: true};
                toastr.success('{{trans('partymeister-core::backend/events.sort_position_updated')}}', '{{ trans('motor-backend::backend/global.flash.success') }}');
            });
        });
    </script>
@append