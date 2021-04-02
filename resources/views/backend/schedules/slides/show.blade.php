@extends('motor-backend::layouts.backend')
@section('view_styles')
    @include('partymeister-slides::layouts.partials.slide_fonts')
    <style type="text/css">
        .slidemeister-instance {
            /*zoom: 0.75;*/
            float: left;
            margin-right: 15px;
            margin-bottom: 15px;
        }

        .weg {
            display: none !important;
        }
    </style>
@append
@section('htmlheader_title')
    {{ trans('motor-backend::backend/global.home') }}
@endsection

@section('contentheader_title')
    {{ trans('partymeister-core::backend/schedules.slides_preview') }}
    <button class="btn btn-sm btn-success float-right schedule-slides-save"
            disabled>{{trans('partymeister-core::backend/schedules.save_slides')}}</button>
    {!! link_to_route('backend.schedules.index', trans('motor-backend::backend/global.back'), [], ['class' => 'pull-right float-right btn btn-sm btn-danger']) !!}
@endsection

@section('main-content')
    <form id="schedule-slides-save"
          action="{{route('backend.schedules.slides.store', ['schedule' => $record->id])}}" method="POST">
        @csrf
        <div class="@boxWrapper box-primary" style="margin-bottom: 0;">
            <div class="@boxBody">
                @foreach ($days as $dayIndex => $day)
                    @foreach ($day as $eventBlockIndex => $eventBlock)
                        <partymeister-slides-elements :readonly="true" :name="'slidemeister-timetable-{{$dayIndex}}-{{$eventBlockIndex}}'" id="slidemeister-timetable-{{$dayIndex}}-{{$eventBlockIndex}}" class="slidemeister-instance"></partymeister-slides-elements>
                        <input type="hidden" name="slide[{{$dayIndex}}-{{$eventBlockIndex}}]">
                        <input type="hidden" name="name[{{$dayIndex}}-{{$eventBlockIndex}}]"
                               value="Timetable {{$dayIndex}} {{$eventBlockIndex}}">
                        <input type="hidden" name="cached_html_preview[{{$dayIndex}}-{{$eventBlockIndex}}]">
                        <input type="hidden" name="cached_html_final[{{$dayIndex}}-{{$eventBlockIndex}}]">
                    @endforeach
                @endforeach
            </div>
        </div>
    </form>
    <div class="loader loader-default"
         data-text="&hearts; {{ trans('partymeister-slides::backend/slides.generating') }} &hearts;"></div>
@endsection

@section('view_scripts')
    <script>
        $(document).ready(function () {
            @foreach ($days as $dayIndex => $day)
                @foreach ($day as $eventBlockIndex => $eventBlock)
                    Vue.prototype.$eventHub.$emit('partymeister-slides:load-definitions', {
                        name: 'slidemeister-timetable-{{$dayIndex}}-{{$eventBlockIndex}}',
                        elements: JSON.parse('{!! addslashes($timetableTemplate->definitions) !!}'),
                        type: 'timetable',
                        replacements: { headline: '{{strtoupper($dayIndex)}}', rows: JSON.parse('{!! addslashes(json_encode($eventBlock)) !!}' ) },
                    });
                @endforeach
            @endforeach

            $('.schedule-slides-save').prop('disabled', false);

            $('.schedule-slides-save').on('click', function (e) {

                $('.loader').addClass('is-active');

                let saveCounter = 0;

                Vue.prototype.$eventHub.$on('partymeister-slides:timetable-finished', () => {
                    if (saveCounter === $('.slidemeister-instance').length) {
                        $('#schedule-slides-save').submit();
                    }
                });

                @foreach ($days as $dayIndex => $day)
                    @foreach ($day as $eventBlockIndex => $eventBlock)

                        Vue.prototype.$eventHub.$on('partymeister-slides:receive-definitions', (data) => {
                            if (data.name === 'slidemeister-timetable-{{$dayIndex}}-{{$eventBlockIndex}}') {
                                console.log("receive definitions for slidemeister-timetable-{{$dayIndex}}-{{$eventBlockIndex}}");
                                $('input[name="slide[{{$dayIndex}}-{{$eventBlockIndex}}]"]').val(data.definitions_as_form_data);
                                $('input[name="cached_html_preview[{{$dayIndex}}-{{$eventBlockIndex}}]"]').val($('#slidemeister-timetable-{{$dayIndex}}-{{$eventBlockIndex}}').html());
                                $('input[name="cached_html_final[{{$dayIndex}}-{{$eventBlockIndex}}]"]').val($('#slidemeister-timetable-{{$dayIndex}}-{{$eventBlockIndex}}').html());
                                saveCounter++;
                                Vue.prototype.$eventHub.$emit('partymeister-slides:timetable-finished');
                            }
                        });

                        Vue.prototype.$eventHub.$emit('partymeister-slides:request-definitions', 'slidemeister-timetable-{{$dayIndex}}-{{$eventBlockIndex}}');
                    @endforeach
                @endforeach

            });
        });
    </script>
@append
