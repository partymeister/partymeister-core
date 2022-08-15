<div id="timetable-vue">

    <p>
        All times are displayed in your local time: [[new Date().toString().substr(new Date().toString().indexOf('GMT'))]]
    </p>

    <div v-for="day of timetable">
        <h4>[[day.day]]</h4>

        <table class="unstriped">
            <tr v-for="(event, index) in day.events">
                <td width="50" class="align-top" style="font-weight: bold;"><span v-if="index === 0 || event.start !== day.events[index-1].start">[[getDate(event.start)]]</span></td>
                <td width="100" style="border-top: none;">
<span class="label label-secondary"
      :style="{ color: 'black', backgroundColor: event.backgroundColor}">[[event.category]]</span>
                </td>
                <td v-html="lineBreaks(event.title)">
                </td>
            </tr>
        </table>


    </div>

</div>

{{--@foreach ($days as $dayKey => $times)--}}
{{--    <h4>{{$dayKey}}</h4>--}}
{{--    <table class="unstriped">--}}
{{--        <tbody>--}}
{{--        @foreach ($times as $hourKey => $events)--}}
{{--            <tr>--}}
{{--                <td class="align-top" style="width: 10%;"><strong>{{$hourKey}}</strong></td>--}}
{{--                <td>--}}
{{--                    <table class="inner-table">--}}
{{--                        <tbody>--}}
{{--                        @foreach($events as $event)--}}
{{--                            <tr>--}}
{{--                                <td style="border-top: none; width: 100px;">--}}
{{--                                    <span class="label label-secondary"--}}
{{--                                          style="color: black;background-color: {{$event['web_color']}}">{{$event['type']}}</span>--}}
{{--                                </td>--}}
{{--                                <td style="border-top: none;">--}}
{{--                                    {{$event['name']}}--}}
{{--                                </td>--}}
{{--                            </tr>--}}
{{--                        @endforeach--}}
{{--                        </tbody>--}}
{{--                    </table>--}}
{{--                </td>--}}
{{--            </tr>--}}
{{--        @endforeach--}}
{{--        </tbody>--}}
{{--    </table>--}}
{{--@endforeach--}}
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
<script src=https://unpkg.com/vue@next></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.1/axios.min.js" integrity="sha512-bPh3uwgU5qEMipS/VOmRqynnMXGGSRv+72H/N260MQeXZIK4PG48401Bsby9Nq5P5fz7hy5UGNmC/W1Z51h2GQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="module">

    let data = {};

    // GET request for remote image in node.js
    axios({
        method: 'get',
        url: 'https://2022.revision-party.net/timetable.json',
        responseType: 'stream'
    })
        .then(function (response) {
            data = response.data;

            var app = Vue.createApp({
                delimiters: ["[[", "]]"],
                data() {
                    return data;
                },
                methods: {
                    getDate(date) {
                        let d = new Date(date);
                        return String(d.getHours()).padStart(2, '0') + ':' + String(d.getMinutes()).padStart(2, '0');
                    },
                    lineBreaks(string) {
                        return string.replaceAll('\n', '<br>');
                    }
                }
            }).mount('#timetable-vue');
        });


</script>