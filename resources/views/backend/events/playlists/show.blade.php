@extends('motor-backend::layouts.backend')
@section('view_styles')
    @include('partymeister-slides::layouts.partials.slide_fonts')
    <style type="text/css">
        .slidemeister-instance {
            zoom: 1;
            float: left;
            margin-right: 15px;
            margin-bottom: 15px;
        }
    </style>
@append
@section('htmlheader_title')
    {{ trans('motor-backend::backend/global.home') }}
@endsection

@section('contentheader_title')
    {{ trans('partymeister-core::backend/events.playlist_preview') }}
    <button class="btn btn-sm btn-success float-right event-playlist-save"
            disabled>{{trans('partymeister-core::backend/events.save_playlist')}}</button>
    {!! link_to_route('backend.events.index', trans('motor-backend::backend/global.back'), [], ['class' => 'float-right btn btn-sm btn-danger']) !!}
@endsection

@section('main-content')
    @if (isset($message))
        <div class="alert alert-warning">
            {{$message}}
        </div>
    @else
        <form id="event-playlist-save"
              action="{{route('backend.events.playlist.store', ['event' => $event->id])}}"
              method="POST">
            @csrf
            <div class="@boxWrapper box-primary" style="margin-bottom: 0;">
                <div class="@boxBody">
                    <partymeister-slides-elements :readonly="true" :name="'slidemeister-event-comingup'"
                                                  id="slidemeister-event-comingup"
                                                  class="slidemeister-instance slide"></partymeister-slides-elements>
                    <input type="hidden" name="slide[comingup]">
                    <input type="hidden" name="name[comingup]"
                           value="Coming up">
                    <input type="hidden" name="cached_html_preview[comingup]">
                    <input type="hidden" name="cached_html_final[comingup]">
                    <input type="hidden" name="type[comingup]" value="comingup">

                    <partymeister-slides-elements :readonly="true" :name="'slidemeister-event-now'"
                                                  id="slidemeister-event-now"
                                                  class="slidemeister-instance slide"></partymeister-slides-elements>
                    <input type="hidden" name="slide[now]">
                    <input type="hidden" name="name[now]"
                           value="Now">
                    <input type="hidden" name="cached_html_preview[now]">
                    <input type="hidden" name="cached_html_final[now]">
                    <input type="hidden" name="type[now]" value="now">

                    <partymeister-slides-elements :readonly="true" :name="'slidemeister-event-default'"
                                                  id="slidemeister-event-default"
                                                  class="slidemeister-instance slide"></partymeister-slides-elements>
                    <input type="hidden" name="slide[default]">
                    <input type="hidden" name="name[default]"
                           value="default">
                    <input type="hidden" name="cached_html_preview[default]">
                    <input type="hidden" name="cached_html_final[default]">
                    <input type="hidden" name="type[default]" value="default">


                    <partymeister-slides-elements :readonly="true" :name="'slidemeister-event-end'"
                                                  id="slidemeister-event-end"
                                                  class="slidemeister-instance slide"></partymeister-slides-elements>
                    <input type="hidden" name="slide[end]">
                    <input type="hidden" name="name[end]"
                           value="End">
                    <input type="hidden" name="cached_html_preview[end]">
                    <input type="hidden" name="cached_html_final[end]">
                    <input type="hidden" name="type[end]" value="end">
                </div>
            </div>
        </form>
    @endif
    <div class="loader loader-default"
         data-text="&hearts; {{ trans('partymeister-slides::backend/slides.generating') }} &hearts;"></div>
@endsection

@if (!isset($message))
    @section('view_scripts')
        <script>
            $(document).ready(function () {
                Vue.prototype.$eventHub.$emit('partymeister-slides:load-definitions', {
                    name: 'slidemeister-event-comingup',
                    elements: JSON.parse('{!! addslashes($comingupTemplate->definitions) !!}'),
                    type: 'event-support',

                    replacements: {headline: 'Coming up', entry: {!! json_encode($event) !!} },
                });

                Vue.prototype.$eventHub.$emit('partymeister-slides:load-definitions', {
                    name: 'slidemeister-event-now',
                    elements: JSON.parse('{!! addslashes($nowTemplate->definitions) !!}'),
                    type: 'event-support',
                    replacements: {headline: 'Now', entry: {!! json_encode($event) !!} },
                });

                Vue.prototype.$eventHub.$emit('partymeister-slides:load-definitions', {
                    name: 'slidemeister-event-default',
                    elements: JSON.parse('{!! addslashes($defaultTemplate->definitions) !!}'),
                });

                Vue.prototype.$eventHub.$emit('partymeister-slides:load-definitions', {
                    name: 'slidemeister-event-end',
                    elements: JSON.parse('{!! addslashes($endTemplate->definitions) !!}'),
                    type: 'event-support',
                    replacements: {headline: 'End', entry: {!! json_encode($event) !!} },
                });

                $('.event-playlist-save').prop('disabled', false);

                $('.event-playlist-save').on('click', function (e) {

                    $('.loader').addClass('is-active');

                    let saveCounter = 0;

                    Vue.prototype.$eventHub.$on('partymeister-slides:timetable-finished', () => {
                        console.log(saveCounter);
                        if (saveCounter === $('.slidemeister-instance.slide').length) {
                            $('#event-playlist-save').submit();
                        }
                    });

                    Vue.prototype.$eventHub.$on('partymeister-slides:receive-definitions', (data) => {
                        if (data.name === 'slidemeister-event-comingup') {
                            $('input[name="slide[comingup]"]').val(data.definitions_as_form_data);
                            $('input[name="cached_html_preview[comingup]"]').val($('#slidemeister-event-comingup').html());
                            $('input[name="cached_html_final[comingup]"]').val($('#slidemeister-event-comingup').html());
                            saveCounter++;
                        }
                        if (data.name === 'slidemeister-event-now') {
                            $('input[name="slide[now]"]').val(data.definitions_as_form_data);
                            $('input[name="cached_html_preview[now]"]').val($('#slidemeister-event-now').html());
                            $('input[name="cached_html_final[now]"]').val($('#slidemeister-event-now').html());
                            saveCounter++;
                        }
                        if (data.name === 'slidemeister-event-default') {
                            $('input[name="slide[default]"]').val(data.definitions_as_form_data);
                            $('input[name="cached_html_preview[default]"]').val($('#slidemeister-event-default').html());
                            $('input[name="cached_html_final[default]"]').val($('#slidemeister-event-default').html());
                            saveCounter++;
                        }
                        if (data.name === 'slidemeister-event-end') {
                            $('input[name="slide[end]"]').val(data.definitions_as_form_data);
                            $('input[name="cached_html_preview[end]"]').val($('#slidemeister-event-end').html());
                            $('input[name="cached_html_final[end]"]').val($('#slidemeister-event-end').html());
                            saveCounter++;
                        }
                        Vue.prototype.$eventHub.$emit('partymeister-slides:timetable-finished');
                    });

                    Vue.prototype.$eventHub.$emit('partymeister-slides:request-definitions', 'slidemeister-event-comingup');
                    Vue.prototype.$eventHub.$emit('partymeister-slides:request-definitions', 'slidemeister-event-now');
                    Vue.prototype.$eventHub.$emit('partymeister-slides:request-definitions', 'slidemeister-event-default');
                    Vue.prototype.$eventHub.$emit('partymeister-slides:request-definitions', 'slidemeister-event-end');
                });
            });
        </script>
    @append
@endif
