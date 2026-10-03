<template>
    <div class="camper-form">
        <h3 class="h3-contact">Povpraševanje za najem</h3>
        <div class="row">
            <div class="col-md-5">
                <div class="mb-2 form-group">
                    <label for="camper-fullname">Ime in priimek</label>
                    <input type="text"
                           class="form-control"
                           id="camper-fullname"
                           placeholder="Ime in priimek"
                           v-model="fullname"
                           @blur="$v.fullname.$touch"
                           :class="{ 'is-invalid-input': $v.fullname.$error }"
                    >
                    <span class="is-invalid" v-if="$v.fullname.$error">Vpišite ime in priimek (min. {{ $v.fullname.$params.minLength.min }} znakov)</span>
                </div>
                <div class="mb-2 form-group">
                    <label for="camper-email">Email</label>
                    <input type="text"
                           class="form-control"
                           id="camper-email"
                           placeholder="Email"
                           v-model="email"
                           @blur="$v.email.$touch"
                           :class="{ 'is-invalid-input': $v.email.$error }"
                    >
                    <span class="is-invalid" v-if="$v.email.$error">Vpišite veljaven email naslov</span>
                </div>
                <div class="mb-2 form-group">
                    <label for="camper-phone">Telefon</label>
                    <input type="text"
                           class="form-control"
                           id="camper-phone"
                           placeholder="Telefon"
                           v-model="phone"
                           @blur="$v.phone.$touch"
                           :class="{ 'is-invalid-input': $v.phone.$error }"
                    >
                    <span class="is-invalid" v-if="$v.phone.$error">Vpišite veljavno telefonsko številko</span>
                </div>
                <div class="mb-2 form-group">
                    <label for="camper-message">Sporočilo</label>
                    <textarea class="form-control"
                              id="camper-message"
                              rows="3"
                              placeholder="Dodatno sporočilo (neobvezno)"
                              v-model="message"
                    ></textarea>
                </div>
                <div class="mb-2">
                    <a href="#" class="extras-toggle" @click.prevent="extrasOpen = !extrasOpen">
                        <small>Dodatna oprema {{ extrasOpen ? '▴' : '▾' }}</small>
                    </a>
                    <div class="extras-list" v-show="extrasOpen">
                        <div class="custom-control custom-checkbox" v-for="item in extrasOptions" :key="item.id">
                            <input type="checkbox" class="custom-control-input" :id="'camper-extra-' + item.id" :value="item.name" v-model="extras">
                            <label class="custom-control-label" :for="'camper-extra-' + item.id">{{ item.name }} ({{ item.price }}€)</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-7">
                <label>Izberite termin</label>
                <small class="calendar-min-days">Minimalen najem je <span class="font-weight-bolder">{{ minDays }} dni</span></small>
                <div class="calendar">
                    <div class="calendar-header">
                        <button type="button" class="calendar-nav" @click="changeMonth(-1)" :disabled="!canGoBack"
                                aria-label="Prejšnji mesec">&lsaquo;
                        </button>
                        <span class="calendar-title">{{ monthNames[viewMonth] }} {{ viewYear }}</span>
                        <button type="button" class="calendar-nav" @click="changeMonth(1)"
                                aria-label="Naslednji mesec">&rsaquo;
                        </button>
                    </div>
                    <div class="calendar-grid calendar-weekdays">
                        <span v-for="d in weekdays" :key="d">{{ d }}</span>
                    </div>
                    <div class="calendar-grid">
                        <div v-for="(cell, i) in cells" :key="i" class="calendar-cell-wrap">
                            <button v-if="cell"
                                    type="button"
                                    class="calendar-day"
                                    :class="dayClass(cell)"
                                    :disabled="cell.disabled"
                                    @click="selectDay(cell)"
                            >
                                <span class="calendar-day-num">{{ cell.day }}</span>
                                <span class="calendar-day-price" v-if="!cell.booked">{{ cell.price }}€</span>
                                <span class="calendar-day-price" v-else>Zasedeno</span>
                            </button>
                        </div>
                    </div>
                    <div class="calendar-legend">
                        <div v-for="s in legend" :key="s.label" class="legend-item" :class="'season-' + s.level">{{ s.label }}: {{ s.price }}€/dan</div>
                    </div>
                </div>

                <div class="calendar-summary" v-if="dateFrom">
                    <div v-if="dateTo">
                        <div>Termin: <strong>{{ format(dateFrom) }} – {{ format(dateTo) }}</strong></div>
                        <div>Število dni: <strong>{{ totalDays }}</strong></div>
                        <div v-if="extrasPrice">Dodatna oprema: <strong>{{ extrasPrice }}€</strong></div>
                        <div class="calendar-total">Skupaj: <strong>{{ totalPrice }}€</strong></div>
                        <div class="is-invalid" v-if="totalDays < minDays">Izbrati morate vsaj {{ minDays }} dni.</div>
                    </div>
                    <div v-else>Izberite še datum vrnitve.</div>
                </div>
                <div class="calendar-summary calendar-summary-empty" v-else>Izberite datum prevzema in vrnitve.</div>
            </div>
        </div>

        <VueLoadingButton class="btn btn-calculate"
                          aria-label="Send camper inquiry"
                          @click.native="send"
                          :loading="isLoading"
                          :disabled="$v.$invalid || !dateTo || totalDays < minDays"
        >{{ buttonText }}
        </VueLoadingButton>
    </div>
</template>

<script>
    import {required, minLength, email} from 'vuelidate/lib/validators'
    import VueLoadingButton from "vue-loading-button";

    const pad = n => (n < 10 ? '0' : '') + n;
    const key = d => d.getFullYear() + '-' + pad(d.getMonth() + 1) + '-' + pad(d.getDate());

    export default {
        name: "Camper",
        components: {VueLoadingButton},
        props: {
            calendar: {type: Array, default: () => []},
            reservations: {type: Array, default: () => []},
            extrasOptions: {type: Array, default: () => []}
        },
        data() {
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            return {
                liveCalendar: this.calendar.slice(),
                liveReservations: this.reservations.slice(),
                fullname: '', email: '', phone: '', message: '',
                extrasOpen: false,
                extras: [],
                today,
                viewYear: today.getFullYear(),
                viewMonth: today.getMonth(),
                dateFrom: null,
                dateTo: null,
                isLoading: false,
                buttonText: 'Pošlji povpraševanje',
                weekdays: ['Po', 'To', 'Sr', 'Če', 'Pe', 'So', 'Ne'],
                monthNames: ['Januar', 'Februar', 'Marec', 'April', 'Maj', 'Junij', 'Julij', 'Avgust',
                    'September', 'Oktober', 'November', 'December'],
                minDays: 3,
                basePrice: 90,
                specialDays: {}
            }
        },
        validations: {
            fullname: {required, minLength: minLength(5)},
            email: {required, email},
            phone: {required, minLength: minLength(6), phone: v => !v || /^[+0-9 \/-]+$/.test(v)}
        },
        computed: {
            canGoBack() {
                return true;
            },
            cells() {
                const first = new Date(this.viewYear, this.viewMonth, 1);
                const offset = (first.getDay() + 6) % 7; // Monday first
                const count = new Date(this.viewYear, this.viewMonth + 1, 0).getDate();
                const cells = [];
                for (let i = 0; i < offset; i++) cells.push(null);
                for (let d = 1; d <= count; d++) {
                    const date = new Date(this.viewYear, this.viewMonth, d);
                    const booked = this.isBooked(date);
                    cells.push({day: d, date, price: this.priceFor(date), level: this.levelFor(date), booked, disabled: date < this.today || booked});
                }
                return cells;
            },
            legend() {
                const typeLabels = {1: 'Nizka sezona', 2: 'Srednja sezona', 3: 'Visoka sezona'};
                const items = [];
                this.liveCalendar.forEach(c => {
                    const level = this.levelForType(c.type);
                    if (level !== 'blocked' && !items.find(i => i.level === level)) {
                        items.push({level, label: typeLabels[c.type] || 'Sezona', price: c.price});
                    }
                });
                if (!items.length) {
                    items.push({level: 'low', label: 'Nizka sezona', price: this.lowSeasonPrice});
                }
                return items.sort((a, b) => a.price - b.price);
            },
            lowSeasonPrice() {
                const entry = this.liveCalendar.find(c => c.type === 1);
                return entry ? entry.price : this.basePrice;
            },
            totalDays() {
                if (!this.dateFrom || !this.dateTo) return 0;
                return Math.round((this.dateTo - this.dateFrom) / 86400000) + 1;
            },
            rentalPrice() {
                if (!this.dateFrom || !this.dateTo) return 0;
                let sum = 0;
                for (let d = new Date(this.dateFrom); d <= this.dateTo; d.setDate(d.getDate() + 1)) {
                    sum += this.priceFor(d);
                }
                return sum;
            },
            extrasPrice() {
                return this.extrasOptions
                    .filter(o => this.extras.includes(o.name))
                    .reduce((sum, o) => sum + o.price, 0);
            },
            totalPrice() {
                return this.rentalPrice + this.extrasPrice;
            }
        },
        methods: {
            calendarEntryFor(k) {
                return this.liveCalendar.find(c => k >= c.date_from && k <= c.date_to);
            },
            levelForType(type) {
                if (type === 4) return 'blocked';
                return type === 3 ? 'high' : (type === 2 ? 'mid' : 'low');
            },
            priceFor(date) {
                const k = key(date);
                if (this.specialDays[k] !== undefined) return this.specialDays[k];
                const entry = this.calendarEntryFor(k);
                return entry ? entry.price : this.lowSeasonPrice;
            },
            levelFor(date) {
                const k = key(date);
                const entry = this.calendarEntryFor(k);
                return entry ? this.levelForType(entry.type) : 'unset';
            },
            isBooked(date) {
                const k = key(date);
                if (this.liveReservations.some(r => k >= r.date_from && k <= r.date_to)) return true;
                const entry = this.calendarEntryFor(k);
                return !!(entry && entry.type === 4);
            },
            fetchAvailability() {
                axios.get('/camper-availability').then(response => {
                    this.liveCalendar = response.data.calendar;
                    this.liveReservations = response.data.reservations;
                }).catch(() => {});
            },
            changeMonth(step) {
                const d = new Date(this.viewYear, this.viewMonth + step, 1);
                this.viewYear = d.getFullYear();
                this.viewMonth = d.getMonth();
                this.fetchAvailability();
            },
            selectDay(cell) {
                if (!this.dateFrom || this.dateTo || cell.date < this.dateFrom) {
                    this.dateFrom = cell.date;
                    this.dateTo = null;
                } else {
                    this.dateTo = cell.date;
                }
            },
            dayClass(cell) {
                const t = cell.date.getTime();
                const from = this.dateFrom && this.dateFrom.getTime();
                const to = this.dateTo && this.dateTo.getTime();
                return {
                    'is-start': t === from,
                    'is-end': t === to,
                    'in-range': from && to && t > from && t < to,
                    'is-today': t === this.today.getTime(),
                    'is-booked': cell.booked,
                    ['season-' + cell.level]: true
                };
            },
            format(d) {
                return d.getDate() + '. ' + (d.getMonth() + 1) + '. ' + d.getFullYear();
            },
            send() {
                this.$v.$touch();
                if (this.$v.$invalid || !this.dateTo) return;
                this.isLoading = true;
                axios.get('/camper-inquiry', {
                    params: {
                        fullname: this.fullname,
                        email: this.email,
                        phone: this.phone,
                        message: this.message,
                        extras: this.extras.join(', '),
                        dateFrom: key(this.dateFrom),
                        dateTo: key(this.dateTo),
                        days: this.totalDays,
                        price: this.totalPrice
                    }
                }).then(response => {
                    this.isLoading = response.data.loading;
                    this.buttonText = response.data.resp;
                }).catch(error => {
                    this.isLoading = false;
                    const data = error.response && error.response.data;
                    this.buttonText = (data && data.resp) ? data.resp : 'Napaka, poskusite znova';
                });
            }
        }
    }
</script>

<style>
    .camper-form .is-invalid-input {
        border-color: #dc3545;
    }

    .calendar {
        background: #fff;
        border: 1px solid #ced4da;
        padding: .75rem;
        max-width: 26rem;
    }

    .calendar-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: .5rem;
    }

    .calendar-title {
        font-weight: 700;
        text-transform: uppercase;
    }

    .calendar-nav {
        border: 0;
        background: transparent;
        font-size: 1.6rem;
        line-height: 1;
        padding: 0 .75rem;
        cursor: pointer;
        color: #ed1c24;
        outline: none !important;
        box-shadow: none !important;
        -moz-outline-style: none;
    }

    .calendar-nav:focus,
    .calendar-nav:focus-visible,
    .calendar-nav:active {
        outline: none !important;
        box-shadow: none !important;
    }

    .calendar-nav:disabled {
        color: #ccc;
        cursor: not-allowed;
    }

    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 2px;
    }

    .calendar-weekdays span {
        text-align: center;
        font-size: .8rem;
        color: #586168;
        padding-bottom: .25rem;
    }

    .calendar-day {
        width: 100%;
        border: 0;
        background: #f4f5f6;
        padding: .3rem 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        cursor: pointer;
    }

    .calendar-day:hover:not(:disabled) {
        background: #e9ecef;
    }

    .calendar-day:disabled {
        opacity: .35;
        cursor: not-allowed;
    }

    .calendar-day.is-booked .calendar-day-num {
        text-decoration: line-through;
    }

    .calendar-day-num {
        font-weight: 600;
        font-size: .95rem;
    }

    .calendar-day-price {
        font-size: .65rem;
        color: #586168;
    }

    .calendar-day.is-today .calendar-day-num {
        text-decoration: underline;
    }

    .calendar-day.in-range {
        background: #f9c4c6;
    }

    .calendar-day.is-start, .calendar-day.is-end {
        background: #ed1c24;
        color: #fff;
    }

    .calendar-day.is-start .calendar-day-price, .calendar-day.is-end .calendar-day-price {
        color: #fff;
    }

    .calendar-day {
        border-top: 2px solid transparent;
    }

    .calendar-day.season-low, .legend-item.season-low {
        border-color: #4caf50;
    }

    .calendar-day.season-mid, .legend-item.season-mid {
        border-color: #ffb300;
    }

    .calendar-day.season-high, .legend-item.season-high {
        border-color: #ed1c24;
    }

    .legend-item {
        border-left: 3px solid;
        padding-left: .4rem;
        margin-bottom: .2rem;
    }

    .extras-toggle {
        color: #ed1c24;
    }

    .extras-list {
        margin-top: .5rem;
    }

    .calendar-min-days {
        display: block;
        color: #586168;
        margin-bottom: .5rem;
    }

    .calendar-legend {
        margin-top: .5rem;
        font-size: .75rem;
        color: #586168;
    }

    .calendar-summary {
        margin-top: 1rem;
        padding: .75rem 1rem;
        max-width: 26rem;
        background: #fff;
        border-left: .25rem solid #ed1c24;
    }

    .calendar-summary-empty {
        color: #586168;
    }

    .calendar-total {
        font-size: 1.2rem;
    }

    .calendar-total strong {
        color: #ed1c24;
    }
</style>
