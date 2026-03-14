@foreach ($days as $dayKey => $times)
    <h4>{{$dayKey}}</h4>
    <table class="w-full text-left text-sm">
        <tbody>
        @foreach ($times as $hourKey => $events)
            <tr>
                <td class="align-top w-[10%] px-4 py-3 border-t border-border text-text"><strong>{{$hourKey}}</strong></td>
                <td class="px-4 py-3 border-t border-border">
                    <table class="w-full text-left text-sm mb-0 pb-0 [&_tbody]:border-none [&_tr]:border-b-0 [&_td]:pt-0 [&_td]:pb-1">
                        <tbody>
                        @foreach($events as $event)
                            <tr>
                                <td class="w-[100px] border-t-0">
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium"
                                          style="color: black;background-color: {{$event['web_color']}}">{{$event['type']}}</span>
                                </td>
                                <td class="border-t-0 text-text">
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
