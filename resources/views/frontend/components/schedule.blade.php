@foreach ($days as $dayKey => $times)
    <h4>{{$dayKey}}</h4>
    <table class="unstriped">
        <tbody>
        @foreach ($times as $hourKey => $events)
            <tr>
                <td class="align-top" style="width: 10%;"><strong>{{$hourKey}}</strong></td>
                <td>
                    <table class="inner-table">
                        <tbody>
                        @foreach($events as $event)
                            <tr>
                                <td style="border-top: none; width: 100px;">
                                    <span class="label label-secondary"
                                          style="color: black;background-color: {{$event['web_color']}}">{{$event['type']}}</span>
                                </td>
                                <td style="border-top: none;">
                                    {{$event['name']}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endforeach
@section('view_styles')
    <style type="text/css">
        td.align-top {
            vertical-align: top;
        }

        .inner-table {
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .inner-table tbody {
            border: none !important;
        }

        .inner-table tr {
            border-bottom: none !important;
        }

        .inner-table td {
            padding-top: 0;
            padding-bottom: 0.20rem;
        }
    </style>
@append
