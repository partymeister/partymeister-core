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
                <td :style="{'background-color': event.event_type.web_color}">
                    <div style="float:left;">@{{ event.name }}</div>
                    <div style="float: right;">@{{ event.event_type.name }}</div>
                </td>
                <td>
                    <countdown :class="event.blink ? 'blink' : ''" :date="event.starts_at" :index="index"></countdown>
                </td>
            </tr>
        </table>
    </div>
</div>
@vite(['resources/assets/js/app.js'])
<script type="module">
    const Clock = {
        template: "<div>@{{hours}}:@{{minutes}}:@{{seconds}}</div>",
        data() {
            return {
                hours: '',
                minutes: '',
                seconds: '',
            };
        },
        mounted() {
            this.updateDateTime();
        },
        methods: {
            updateDateTime() {
                const now = new Date();
                this.hours = now.getHours();
                this.minutes = this.getZeroPad(now.getMinutes());
                this.seconds = this.getZeroPad(now.getSeconds());
                setTimeout(() => this.updateDateTime(), 1000);
            },
            getZeroPad(n) {
                return (parseInt(n, 10) >= 10 ? '' : '0') + n;
            }
        }
    };

    const Countdown = {
        template: '<div>@{{hours}}:@{{minutes}}:@{{seconds}}</div>',
        props: ['date', 'index'],
        data() {
            return {
                hours: '',
                minutes: '',
                seconds: '',
            };
        },
        mounted() {
            this.updateDateTime();
        },
        methods: {
            updateDateTime() {
                const now = new Date();
                const target = new Date(this.date);
                let seconds = Math.ceil(((target.getTime() - now.getTime()) / 1000));

                if (seconds < 1800) {
                    this.$root.setEventBlink(this.index);
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

                this.hours = this.getZeroPad(hours);
                this.minutes = this.getZeroPad(minutes);
                this.seconds = this.getZeroPad(seconds);

                if (negative) {
                    this.hours = 'since ' + this.getZeroPad(hours);
                }

                setTimeout(() => this.updateDateTime(), 1000);
            },
            getZeroPad(n) {
                return (parseInt(n, 10) >= 10 ? '' : '0') + n;
            }
        }
    };

    const app = Vue.createApp({
        data() {
            return {
                events: [],
                filteredEvents: []
            };
        },
        components: {
            Clock,
            Countdown
        },
        methods: {
            formatDate(dateString) {
                const date = new Date(dateString);
                return date.getFullYear() + '-' + this.getZeroPad(date.getUTCMonth() + 1) + '-' + this.getZeroPad(date.getDate()) + ' ' + this.getZeroPad(date.getHours()) + ':' + this.getZeroPad(date.getMinutes());
            },
            getZeroPad(n) {
                return (parseInt(n, 10) >= 10 ? '' : '0') + n;
            },
            filterEvents() {
                this.filteredEvents = this.events.filter(function (event) {
                    const now = new Date();
                    const target = new Date(event.starts_at);
                    return event.is_visible && (Math.ceil(((target.getTime() - now.getTime()) / 1000)) > (-3 * 3600));
                });
            },
            setEventBlink(index) {
                this.events[index].blink = true;
            }
        },
        mounted() {
            const self = this;
            axios.get('{{ route('ajax.schedules.show', ['schedule' => $record ]) }}').then(function (response) {
                self.events = response.data.data.events;
                self.filterEvents();
            });
            setInterval(function () {
                self.filterEvents();
            }, 1000 * 60 * 15);
        }
    }).mount('#schedule-container');
</script>
</body>
</html>
