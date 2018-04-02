@extends('motor-backend::layouts.backend')
<div class="loading-overlay"></div>

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
    <button class="btn btn-sm btn-success float-right schedule-slides-save">{{trans('partymeister-core::backend/schedules.save_slides')}}</button>
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

                    <div class="render d-none">
                        <div id="slidemeister-timetable-{{$dayIndex}}-{{$eventBlockIndex}}-preview"
                             class="slidemeister-instance"></div>

                        <div id="slidemeister-timetable-{{$dayIndex}}-{{$eventBlockIndex}}-final"
                             class="slidemeister-instance"></div>
                    </div>

                        <input type="hidden" name="slide[{{$dayIndex}}-{{$eventBlockIndex}}]">
                        <input type="hidden" name="name[{{$dayIndex}}-{{$eventBlockIndex}}]"
                               value="Timetable {{$dayIndex}} {{$eventBlockIndex}}">
                        <input type="hidden" name="preview[{{$dayIndex}}-{{$eventBlockIndex}}]">
                        <input type="hidden" name="final[{{$dayIndex}}-{{$eventBlockIndex}}]">
                    @endforeach
                @endforeach
            </div>
        </div>
    </form>
@endsection

@section('view_scripts')
    @include('partymeister-slides::layouts.partials.slide_scripts')
    <script>
        $(document).ready(function () {
            var sm = [];
            var preview_slides = [];
            var final_slides = [];
            @foreach ($days as $dayIndex => $day)
                    @foreach ($day as $eventBlockIndex => $eventBlock)
                sm['{{$dayIndex}}-{{$eventBlockIndex}}'] = $('#slidemeister-timetable-{{$dayIndex}}-{{$eventBlockIndex}}').slidemeister('#slidemeister-properties', slidemeisterProperties);
            sm['{{$dayIndex}}-{{$eventBlockIndex}}'].data.load({!! $timetableTemplate->definitions !!}, {'day': '{{strtoupper($dayIndex)}}'}, false, true);
            sm['{{$dayIndex}}-{{$eventBlockIndex}}'].data.populateTimetable({!! json_encode($eventBlock) !!});

            preview_slides['{{$dayIndex}}-{{$eventBlockIndex}}'] = $('#slidemeister-timetable-{{$dayIndex}}-{{$eventBlockIndex}}-preview').slidemeister('#slidemeister-properties', slidemeisterProperties);
            preview_slides['{{$dayIndex}}-{{$eventBlockIndex}}'].data.load({!! $timetableTemplate->definitions !!}, {'day': '{{strtoupper($dayIndex)}}'}, false, true);
            preview_slides['{{$dayIndex}}-{{$eventBlockIndex}}'].data.populateTimetable({!! json_encode($eventBlock) !!});

            final_slides['{{$dayIndex}}-{{$eventBlockIndex}}'] = $('#slidemeister-timetable-{{$dayIndex}}-{{$eventBlockIndex}}-final').slidemeister('#slidemeister-properties', slidemeisterProperties);
            final_slides['{{$dayIndex}}-{{$eventBlockIndex}}'].data.load({!! $timetableTemplate->definitions !!}, {'day': '{{strtoupper($dayIndex)}}'}, false, true);
            final_slides['{{$dayIndex}}-{{$eventBlockIndex}}'].data.populateTimetable({!! json_encode($eventBlock) !!});
            @endforeach
            @endforeach

            $('.schedule-slides-save').on('click', function (e) {

                var tasks = [];

                $('.loading-overlay').addClass('loading');
                $('.render').removeClass('d-none');

                Object.keys(sm).forEach(function (key) {
                    $('input[name="slide[' + key + ']"]').val(JSON.stringify(sm[key].data.save(true)));

                    tasks.push(final_slides[key].data.export('final', key));
                    tasks.push(preview_slides[key].data.export('preview', key));

                });

                window.setTimeout(function() {
                    workMyCollection(tasks)
                        .then(() => {
                            for (let r of final) {
                                $('input[name="' + r[0] + '[' + r[1] + ']"]').val(r[2]);
                            }
                            $('form#schedule-slides-save').submit();
                        });
                }, 1000);

                return;
            });

            function asyncFunc(e) {
                return new Promise((resolve, reject) => {
                    setTimeout(() => resolve(e), e * 1000);
                });
            }

            let final = [];

            function workMyCollection(arr) {
                return arr.reduce((promise, item) => {
                    return promise
                        .then((result) => {
                            // console.log(result);
                            // console.log(`item ${item}`);
                            return asyncFunc(item).then(result => final.push(result));
                        })
                        .catch(console.error);
                }, Promise.resolve());
            }
        });
    </script>
@append
