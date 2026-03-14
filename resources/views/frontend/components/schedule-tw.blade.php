@foreach ($days as $dayKey => $times)
    <h4>{{$dayKey}}</h4>
    <table class="table">
        <tbody>
        @foreach ($times as $hourKey => $events)
            <tr>
                <td class="align-top w-[10%]"><strong>{{$hourKey}}</strong></td>
                <td>
                    <table class="table mb-0 pb-0 [&_tbody]:border-none [&_tr]:border-b-0 [&_td]:pt-0 [&_td]:pb-1">
                        <tbody>
                        @foreach($events as $event)
                            <tr>
                                <td class="w-[100px] border-t-0">
                                    <span class="badge"
                                          style="color: black;background-color: {{$event['web_color']}}">{{$event['type']}}</span>
                                </td>
                                <td class="border-t-0">
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
