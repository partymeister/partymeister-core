@extends('motor-backend::layouts.backend')
@section('view_styles')
    @include('partymeister-slides::layouts.partials.slide_fonts')
    <style type="text/css">
        .slidemeister-instance {
            zoom: 0.75;
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
                        <div id="slidemeister-timetable-{{$dayIndex}}-{{$eventBlockIndex}}"
                             class="slidemeister-instance"></div>

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
    @include('partymeister-slides::layouts.partials.slide_scripts')
    <script>
        $(document).ready(function () {
            let sm = [];

            @foreach ($days as $dayIndex => $day)
                @foreach ($day as $eventBlockIndex => $eventBlock)
                    sm['{{$dayIndex}}-{{$eventBlockIndex}}'] = $('#slidemeister-timetable-{{$dayIndex}}-{{$eventBlockIndex}}').slidemeister('#slidemeister-properties', slidemeisterProperties);
                    sm['{{$dayIndex}}-{{$eventBlockIndex}}'].data.load({!! $timetableTemplate->definitions !!}, {'day': '{{strtoupper($dayIndex)}}'}, false, true);
                    sm['{{$dayIndex}}-{{$eventBlockIndex}}'].data.populateTimetable({!! json_encode($eventBlock) !!});
                @endforeach
            @endforeach

            $('.schedule-slides-save').prop('disabled', false);

            $('.schedule-slides-save').on('click', function (e) {

                $('.loader').addClass('is-active');

                Object.keys(sm).forEach(function (key) {
                    console.log('Processing ' + key);
                    $('input[name="slide[' + key + ']"]').val(JSON.stringify(sm[key].data.save(true)));
                    $('input[name="cached_html_preview[' + key + ']"]').val($(sm[key].data.getTargetElement()).html());
                    sm[key].data.removePreviewElements();
                    $('input[name="cached_html_final[' + key + ']"]').val($(sm[key].data.getTargetElement()).html());
                    $('form#schedule-slides-save').submit();
                });
            });
        });
    </script>
@append
