1
<html>
<head>
    <title>Partymeister - Countdown</title>
    <style type="text/css">
        body {
            background-color: black;
            color: black;
            font-family: Lucida Sans Unicode, Lucida Grande, sans-serif;
        }

        @keyframes blink {
            50% {
                opacity: 0.0;
            }
        }

        @-webkit-keyframes blink {
            50% {
                opacity: 0.0;
            }
        }

        .blink {
            animation: blink 1s step-start 0s infinite;
            -webkit-animation: blink 1s step-start 0s infinite;
            color: red;
            font-weight: bold;
        }

        #clock {
            text-align: center;
            font-weight: bold;
            font-size: 200px;
            margin-top: 30px;
        }

        #schedule {
            text-align: center;
            font-weight: bold;
            font-size: 24px;
        }

        .timeslots {
            margin-left: auto;
            margin-right: auto;
            margin-top: 10px;
        }

        td {
            font-size: 20px;
            background-color: #eee;
            padding: 4px;
            vertical-align: top;
        }

        div {
            margin: 0;
            padding: 4px;
        }

        #clock, #schedule {
            color: white;
        }
    </style>

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
<div id="app"></div>
<div id="schedule-container">
    <div id="clock">
        <clock></clock>
    </div>
    <div id="schedule">
        <table class="timeslots">
            <tr v-for="(event, index) in filteredEvents">
                <td>
                    <div v-if="events[index-1] == undefined || (events[index-1] != undefined && event.starts_at != events[index-1].starts_at)">
                        @{{ formatDate(event.starts_at) }}
                    </div>
                </td>
                <td :style="{'background-color': event.event_type.data.web_color}">
                    <div style="float:left;">@{{ event.name }}</div>
                    <div style="float: right;">@{{ event.event_type.data.name }}</div>
                </td>
                <td>
                    <countdown :class="event.blink ? 'blink' : ''" :date="event.starts_at" :index="index"></countdown>
                </td>
            </tr>
        </table>
    </div>
</div>
<script src="{{mix('js/motor-backend.js')}}"></script>
<script>
    let Clock = {
        template: "<div>@{{hours}}:@{{minutes}}:@{{seconds}}</div>",
        data: function data() {
            return {
                hours: '',
                minutes: '',
                seconds: '',
            };
        },
        mounted: function ready() {
            this.updateDateTime();
        },

        methods: {
            updateDateTime: function updateDateTime() {
                let self = this;
                let now = new Date();

                self.hours = now.getHours();
                self.minutes = self.getZeroPad(now.getMinutes());
                self.seconds = self.getZeroPad(now.getSeconds());

                setTimeout(self.updateDateTime, 1000);
            },
            getZeroPad: function getZeroPad(n) {
                return (parseInt(n, 10) >= 10 ? '' : '0') + n;
            }
        }
    };

    let Countdown = {
        template: '<div :class="cssClass">@{{hours}}:@{{minutes}}:@{{seconds}}</div>',
        props: ['date', 'index'],
        data: function data() {
            return {
                hours: '',
                minutes: '',
                seconds: '',
                cssClass: '',
            };
        },
        mounted: function ready() {
            this.updateDateTime();
        },

        methods: {
            updateDateTime: function updateDateTime() {
                let self = this;
                let now = new Date();
                let target = new Date(this.date);

                let seconds = Math.ceil(((target.getTime() - now.getTime()) / 1000));

                if (seconds < 1800) {
                    app.$emit('event-blink', {index: this.index});
                }

                let negative = false;
                if (seconds < 0) {
                    seconds = Math.abs(seconds);
                    negative = true;
                }

                let hours = Math.floor(seconds / 3600);
                seconds -= hours * 3600;
                let minutes = Math.floor(seconds / 60);
                seconds -= minutes * 60;

                self.hours = self.getZeroPad(hours);
                self.minutes = self.getZeroPad(minutes);
                self.seconds = self.getZeroPad(seconds);

                if (negative) {
                    self.hours = 'since ' + self.getZeroPad(hours);

                }

                setTimeout(self.updateDateTime, 1000);
            },
            getZeroPad: function getZeroPad(n) {
                return (parseInt(n, 10) >= 10 ? '' : '0') + n;
            }
        }
    };

    let app = new Vue({
        el: '#schedule-container',
        data: {
            events: [],
            filteredEvents: []
        },
        components: {
            Clock: Clock,
            Countdown: Countdown
        },
        methods: {
            formatDate: function (dateString) {
                let date = new Date(dateString);
                return date.getFullYear() + '-' + this.getZeroPad(date.getUTCMonth() + 1) + '-' + this.getZeroPad(date.getDate()) + ' ' + this.getZeroPad(date.getHours()) + ':' + this.getZeroPad(date.getMinutes());
            },
            getZeroPad: function getZeroPad(n) {
                return (parseInt(n, 10) >= 10 ? '' : '0') + n;
            },
            filterEvents: function () {
                this.filteredEvents = this.events.filter(function (event) {
                    let now = new Date();
                    let target = new Date(event.starts_at);
                    if (event.is_visible && (Math.ceil(((target.getTime() - now.getTime()) / 1000)) > (-3 * 3600))) {
                        return true;
                    }
                    return false;
                });
            }
        },
        mounted: function () {
            axios.get('{{ route('ajax.schedules.show', ['schedule' => $record ]) }}').then(function (response) {
                app.events = response.data.data.events.data;
                app.filterEvents();
            });
            this.$on('event-blink', function (data) {
                Vue.set(this.events[data.index], 'blink', true);
            });
            setInterval(function () {
                app.filterEvents();
            }, 1000 * 60 * 15);
        }

    });
</script>
</body>
</html>
