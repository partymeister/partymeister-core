<div x-data="timetable()" x-cloak>
    <div class="mb-6 flex items-center gap-3">
        <label class="text-sm font-medium text-text">Timezone:</label>
        <select x-model="selectedTimezone"
                class="rounded-lg border border-border bg-surface px-3 py-1.5 text-sm text-text">
            <template x-for="tz in timezones" :key="tz.value">
                <option :value="tz.value" x-text="tz.label" :selected="tz.value === selectedTimezone"></option>
            </template>
        </select>
    </div>

    <template x-for="day in groupedTimetable" :key="day.day">
        <div class="mb-8 last:mb-0">
            <h4 class="mb-2" x-text="day.day"></h4>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <tbody>
                    <template x-for="(row, rowIndex) in day.rows" :key="rowIndex">
                        <tr>
                            <td class="align-top w-[10%] px-4 py-3 border-t border-border text-text">
                                <strong x-text="row.time"></strong>
                            </td>
                            <td class="px-4 py-3 border-t border-border">
                                <table class="w-full text-left mb-0 pb-0 [&_tbody]:border-none [&_tr]:border-b-0 [&_td]:pt-0 [&_td]:pb-1">
                                    <tbody>
                                    <template x-for="(event, eventIndex) in row.events" :key="eventIndex">
                                        <tr>
                                            <td class="w-[100px] border-t-0 align-top">
                                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium"
                                                      :style="{ color: 'black', backgroundColor: event.backgroundColor }"
                                                      x-text="event.category"></span>
                                            </td>
                                            <td class="border-t-0 text-text" x-html="lineBreaks(event.title)"></td>
                                        </tr>
                                    </template>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </template>
                    </tbody>
                </table>
            </div>
        </div>
    </template>
</div>

<script type="module">
document.addEventListener('alpine:init', () => {
    const timetableData = @json(json_decode($timetableJson))

    const tzCities = [
        { city: 'Baker Island',  value: 'Etc/GMT+12' },
        { city: 'Pago Pago',     value: 'Pacific/Pago_Pago' },
        { city: 'Honolulu',      value: 'Pacific/Honolulu' },
        { city: 'Anchorage',     value: 'America/Anchorage' },
        { city: 'Los Angeles',   value: 'America/Los_Angeles' },
        { city: 'Denver',        value: 'America/Denver' },
        { city: 'Chicago',       value: 'America/Chicago' },
        { city: 'New York',      value: 'America/New_York' },
        { city: 'Santiago',      value: 'America/Santiago' },
        { city: 'Buenos Aires',  value: 'America/Argentina/Buenos_Aires' },
        { city: 'South Georgia', value: 'Atlantic/South_Georgia' },
        { city: 'Azores',        value: 'Atlantic/Azores' },
        { city: 'London',        value: 'Europe/London' },
        { city: 'Saarbrücken',   value: 'Europe/Berlin' },
        { city: 'Helsinki',      value: 'Europe/Helsinki' },
        { city: 'Moscow',        value: 'Europe/Moscow' },
        { city: 'Dubai',         value: 'Asia/Dubai' },
        { city: 'Karachi',       value: 'Asia/Karachi' },
        { city: 'Mumbai',        value: 'Asia/Kolkata' },
        { city: 'Kathmandu',     value: 'Asia/Kathmandu' },
        { city: 'Dhaka',         value: 'Asia/Dhaka' },
        { city: 'Bangkok',       value: 'Asia/Bangkok' },
        { city: 'Shanghai',      value: 'Asia/Shanghai' },
        { city: 'Tokyo',         value: 'Asia/Tokyo' },
        { city: 'Sydney',        value: 'Australia/Sydney' },
        { city: 'Noumea',        value: 'Pacific/Noumea' },
        { city: 'Auckland',      value: 'Pacific/Auckland' },
        { city: 'Apia',          value: 'Pacific/Apia' },
        { city: 'Kiritimati',    value: 'Pacific/Kiritimati' },
    ]

    const now = new Date()
    const tzList = tzCities.map(tz => {
        let fmt = new Intl.DateTimeFormat('en-GB', { timeZone: tz.value, timeZoneName: 'shortOffset' })
        let parts = fmt.formatToParts(now)
        let offset = parts.find(p => p.type === 'timeZoneName').value
        return { label: tz.city + ' (' + offset + ')', value: tz.value }
    })

    function detectTimezone() {
        let localTz = Intl.DateTimeFormat().resolvedOptions().timeZone
        let localOffset = new Date().getTimezoneOffset()
        let match = tzList.find(tz => tz.value === localTz)
        if (!match) {
            match = tzList.find(tz => {
                let fmt = new Intl.DateTimeFormat('en-GB', { timeZone: tz.value, timeZoneName: 'shortOffset' })
                let parts = fmt.formatToParts(new Date())
                let offsetStr = parts.find(p => p.type === 'timeZoneName').value
                let m = offsetStr.match(/GMT([+-])(\d{1,2})(?::(\d{2}))?/)
                if (!m && offsetStr === 'GMT') return localOffset === 0
                if (!m) return false
                let mins = (parseInt(m[2]) * 60 + (m[3] ? parseInt(m[3]) : 0)) * (m[1] === '+' ? -1 : 1)
                return mins === localOffset
            })
        }
        return match ? match.value : 'Europe/Berlin'
    }

    Alpine.data('timetable', () => ({
        selectedTimezone: detectTimezone(),
        timezones: tzList,

        get groupedTimetable() {
            if (!timetableData?.timetable) return []
            let dayMap = new Map()
            let dayOrder = []

            for (const day of timetableData.timetable) {
                for (const event of day.events) {
                    let d = new Date(event.start)
                    let dayName = d.toLocaleDateString('en-GB', {
                        weekday: 'long',
                        day: 'numeric',
                        month: 'long',
                        timeZone: this.selectedTimezone
                    })
                    // Capitalize first letter to match "Friday, 3 April" style
                    dayName = dayName.replace(/^\w/, c => c.toUpperCase())
                    if (!dayMap.has(dayName)) {
                        dayMap.set(dayName, [])
                        dayOrder.push(dayName)
                    }
                    dayMap.get(dayName).push(event)
                }
            }

            return dayOrder.map(dayName => {
                // Group events by time for the nested table layout
                let timeMap = new Map()
                let timeOrder = []
                for (const event of dayMap.get(dayName)) {
                    let time = this.formatTime(event.start)
                    if (!timeMap.has(time)) {
                        timeMap.set(time, [])
                        timeOrder.push(time)
                    }
                    timeMap.get(time).push(event)
                }
                let rows = timeOrder.map(time => ({
                    time,
                    events: timeMap.get(time)
                }))
                return { day: dayName, rows }
            })
        },

        formatTime(dateStr) {
            return new Date(dateStr).toLocaleTimeString('en-GB', {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false,
                timeZone: this.selectedTimezone
            })
        },

        lineBreaks(str) {
            if (!str) return ''
            return str.replaceAll('\n', '<br>')
        }
    }))
})
</script>
