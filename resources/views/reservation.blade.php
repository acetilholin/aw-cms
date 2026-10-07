<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

    <!-- Sweet Alerts -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <link rel="stylesheet" type="text/css" href="{{ asset('css/custom-style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/reservation.css') }}">

    <!-- Flatpickr (Slovenian calendar) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <title>Avto Welt d.o.o.</title>
</head>
<body>
<x-navbar />
<div class="container mb-5" style="max-width: 1400px;">
    <div class="row">
        <div class="col-md-12">
            <div class="camper-switch-bar">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="camper-switch" @if($camperEnabled) checked @endif>
                    <label class="custom-control-label" for="camper-switch">
                        <strong id="camper-switch-state">{{ $camperEnabled ? 'prikazano na strani' : 'skrito na strani' }}</strong>
                    </label>
                </div>
            </div>
            @include('messages.info')
            @if ($errors->any())
                <div class="alert alert-danger" id="form-errors">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @yield('content')
            @php
                $seasonLabels = [1 => 'Nizka sezona', 2 => 'Srednja sezona', 3 => 'Visoka sezona', 4 => 'Brez najema'];
                $calendarPricingData = $calendars->map(function ($c) {
                    return [
                        'date_from' => $c->date_from,
                        'date_to' => $c->date_to,
                        'price' => (float) $c->price,
                        'type' => $c->season->type,
                    ];
                });
            @endphp
            <div class="section-head">
                <div>
                    <h5 class="section-title">Sezone</h5>
                    <div class="section-underline"></div>
                </div>
                <button type="submit" class="btn btn-calculate btn-sm" style="margin: 0" data-toggle="modal" data-target="#addCalendar">Dodaj sezono</button>
            </div>
            <div class="table-legend">
                <span class="legend-swatch legend-swatch-reservation"></span> aktivna/prihajajoča sezona &nbsp;&nbsp; <span class="legend-swatch legend-swatch-past"></span> sezona je potekla
            </div>
            <div class="table-card">
            <div @if($calendars->count() > 5) class="calendar-scroll" @endif>
            <table class="table table-font text-center table-hover data-table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Sezona</th>
                    <th scope="col">Datum od</th>
                    <th scope="col">Datum do</th>
                    <th scope="col">Cena</th>
                    <th scope="col">Uredi</th>
                </tr>
                </thead>
                <tbody>
                @php ( $calendarNumber = 1 )
                @forelse($calendars as $calendar)
                    @php ( $calendarUpcoming = strtotime($calendar->date_to) >= strtotime('today') )
                    <tr class="{{ $calendarUpcoming ? 'row-upcoming' : 'row-past' }}">
                        <th scope="row">{{ $calendarNumber++ }}</th>
                        <td><span class="season-badge season-{{ $calendar->season->type }}">{{ $seasonLabels[$calendar->season->type] ?? '-' }}</span></td>
                        <td>{{ date("d-m-Y", strtotime($calendar->date_from)) }}</td>
                        <td>{{ date("d-m-Y", strtotime($calendar->date_to)) }}</td>
                        <td class="price-cell">{{ $calendar->season->type == 4 ? '/' : number_format($calendar->price,2,',','.') . '€' }}</td>
                        <td>
                            <div class="btn-group dropright">
                                <button type="button" class="btn btn-white dropdown-toggle dropdown-toggle-split" id="dropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {!! Html::image('icons/settings.svg') !!}
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu">
                                    <a class="edit-calendar dropdown-item" id="{{ $calendar->id }}" style="cursor: pointer">
                                        <i class="far fa-edit edit-style" style="font-size: 1.3rem;" title="Uredi"></i>
                                        Uredi
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a href="#" id="{{ $calendar->id }}" class="dropdown-item delete-calendar"><i class="far fa-trash-alt remove" style="font-size: 1.3rem; cursor: pointer" title="Odstrani"></i>
                                        Odstrani
                                    </a>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Ni vnosov v koledarju.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            </div>
            </div>
            <div class="section-head section-head-spaced">
                <div>
                    <h5 class="section-title">Rezervacije</h5>
                    <div class="section-underline"></div>
                </div>
                <a href="#" id="print-reservations" title="Natisni tabelo"><i class="fas fa-print"></i></a>
            </div>
            <div class="table-legend">
                <span class="legend-swatch legend-swatch-reservation"></span> prihajajoča rezervacija &nbsp;&nbsp; <span class="legend-swatch legend-swatch-past"></span> pretekla rezervacija
            </div>
            <div id="print-wrapper">
            <h2 id="print-title" class="d-none">Rezervacije Kamperja</h2>
            <div class="table-card">
            <div @if($reservations->count() > 10) class="reservation-scroll" @endif>
            <table class="table table-font text-center table-hover data-table" id="reservations-table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col" class="text-left">Oseba</th>
                    <th scope="col" class="text-left">Email</th>
                    <th scope="col">Telefon</th>
                    <th scope="col">Termin</th>
                    <th scope="col">Dni</th>
                    <th scope="col">Cena</th>
                    <th scope="col">Dodatki</th>
                    <th scope="col" class="text-left">Sporočilo</th>
                    <th scope="col">Ustvarjeno</th>
                    <th scope="col" class="edit-column">Uredi</th>
                </tr>
                </thead>
                <tbody>
                @php ( $number = 1 )
                @forelse($reservations as $reservation)
                    @php ( $isUpcoming = strtotime($reservation->date_from) >= strtotime('today') )
                    <tr class="{{ $isUpcoming ? 'upcoming-row row-upcoming' : 'row-past' }}">
                        <th scope="row">{{ $number++ }}</th>
                        <td class="text-left">{{ $reservation->fullname }}</td>
                        <td class="text-left">{{ $reservation->email }}</td>
                        <td class="nowrap">{{ $reservation->phone }}</td>
                        <td class="nowrap">{{ date("j. n.", strtotime($reservation->date_from)) }} – {{ date("j. n. Y", strtotime($reservation->date_to)) }}</td>
                        <td>{{ $reservation->days }}</td>
                        <td class="price-cell">{{ number_format($reservation->price,2,',','.') }}€</td>
                        <td>
                            @foreach(array_filter(array_map('trim', explode(',', (string) $reservation->extras))) as $extra)
                                <span class="extra-pill">{{ $extra }}</span>
                            @endforeach
                        </td>
                        <td class="text-left message-cell" title="{{ $reservation->message }}">{{ $reservation->message }}</td>
                        <td class="muted-cell nowrap">{{ date("H:i d-m-Y", strtotime($reservation->created_at)) }}</td>
                        <td class="edit-column">
                            <div class="btn-group dropright">
                                <button type="button" class="btn btn-white dropdown-toggle dropdown-toggle-split" id="dropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {!! Html::image('icons/settings.svg') !!}
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu">
                                    <a class="edit dropdown-item" id="{{ $reservation->id }}" style="cursor: pointer">
                                        <i class="far fa-edit edit-style" style="font-size: 1.3rem;" title="Uredi"></i>
                                        Uredi
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a href="#" id="{{ $reservation->id }}" class="dropdown-item delete"><i class="far fa-trash-alt remove" style="font-size: 1.3rem; cursor: pointer" title="Odstrani"></i>
                                        Odstrani
                                    </a>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11">Ni rezervacij.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            </div>
            </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal add calendar -->
<div class="modal fade" id="addCalendar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-lg">
            <div class="modal-body">
                <form method="POST" action="{{ route('addCalendar') }}" id="form-add-calendar" novalidate>
                    <div class="form-group">
                        <label for="add-season" class="text">Sezona</label>
                        <select class="form-control" id="add-season" name="season_id" required>
                            @foreach($seasons as $season)
                                <option value="{{ $season->id }}" data-type="{{ $season->type }}">{{ $seasonLabels[$season->type] ?? $season->type }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">Izberite sezono.</div>
                    </div>
                    <div class="form-group">
                        <label for="add-date-from" class="text">Datum od</label>
                        <input type="text" class="form-control flatpickr-date" id="add-date-from" name="date_from" autocomplete="off" required>
                        <div class="invalid-feedback">Vnesite datum od.</div>
                    </div>
                    <div class="form-group">
                        <label for="add-date-to" class="text">Datum do</label>
                        <input type="text" class="form-control flatpickr-date" id="add-date-to" name="date_to" autocomplete="off" required>
                        <div class="invalid-feedback">Vnesite datum do.</div>
                    </div>
                    <div class="form-group">
                        <label for="add-price" class="text">Cena</label>
                        <input type="text" class="form-control" id="add-price" name="price" required>
                        <div class="invalid-feedback">Vnesite ceno.</div>
                    </div>
                    @csrf
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-gray">Shrani</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal update calendar -->
<div class="modal fade" id="updateCalendar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-lg">
            <div class="modal-body">
                <form method="POST" action="{{ route('updateCalendar') }}" id="modalupdatecalendar">
                    <div class="form-group">
                        <label for="update-calendar-season" class="text">Sezona</label>
                        <select class="form-control" id="update-calendar-season" name="season_id">
                            @foreach($seasons as $season)
                                <option value="{{ $season->id }}" data-type="{{ $season->type }}">{{ $seasonLabels[$season->type] ?? $season->type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="update-calendar-date-from" class="text">Datum od</label>
                        <input type="text" class="form-control flatpickr-date" id="update-calendar-date-from" name="date_from" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="update-calendar-date-to" class="text">Datum do</label>
                        <input type="text" class="form-control flatpickr-date" id="update-calendar-date-to" name="date_to" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="update-calendar-price" class="text">Cena</label>
                        <input type="text" class="form-control" id="update-calendar-price" name="price">
                    </div>
                    <input type="hidden" name="id" id="calendar-id">
                    @csrf
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-gray">Shrani</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal update -->
<div class="modal fade" id="update" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-lg">
            <div class="modal-body">
                <form method="POST" action="{{ route('updateReservation') }}" id="modalupdate">
                    <div class="form-group">
                        <label for="update-fullname" class="text">Ime in priimek</label>
                        <input type="text" class="form-control" id="update-fullname" name="fullname">
                    </div>
                    <div class="form-group">
                        <label for="update-email" class="text">Email</label>
                        <input type="email" class="form-control" id="update-email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="update-phone" class="text">Telefon</label>
                        <input type="text" class="form-control" id="update-phone" name="phone">
                    </div>
                    <div class="form-group">
                        <label for="update-date-from" class="text">Datum od</label>
                        <input type="text" class="form-control flatpickr-date" id="update-date-from" name="date_from" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="update-date-to" class="text">Datum do</label>
                        <input type="text" class="form-control flatpickr-date" id="update-date-to" name="date_to" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="update-days" class="text">Dni</label>
                        <input type="number" class="form-control" id="update-days" name="days" min="1" readonly>
                    </div>
                    <div class="form-group">
                        <label for="update-price" class="text">Cena</label>
                        <input type="text" class="form-control" id="update-price" name="price" readonly>
                    </div>
                    <div class="form-group">
                        <label class="text">Dodatki</label>
                        <div>
                            @foreach($extrasOptions as $extra)
                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input type="checkbox" class="custom-control-input update-extra" id="update-extra-{{ $extra['id'] }}" data-name="{{ $extra['name'] }}" data-price="{{ $extra['price'] }}">
                                    <label class="custom-control-label" for="update-extra-{{ $extra['id'] }}">{{ $extra['name'] }} ({{ $extra['price'] }}€)</label>
                                </div>
                            @endforeach
                        </div>
                        <input type="hidden" id="update-extras" name="extras">
                    </div>
                    <div class="form-group">
                        <label for="update-message" class="text">Sporočilo</label>
                        <textarea class="form-control" id="update-message" rows="4" name="message"></textarea>
                    </div>
                    <input type="hidden" name="id" id="id">
                    @csrf
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-gray">Shrani</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>

<!-- Vue src file (also bundles Bootstrap's JS - do not also load bootstrap.min.js, it registers duplicate dropdown/modal handlers) -->
<script src="{!! asset('js/app.js') !!}"></script>

<!-- Flatpickr (Slovenian calendar) -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/sl.js"></script>

<script>
    $(function() {
        $("#message").fadeTo(5000, 500).slideUp(500, function () {
            $("#message").slideUp(500);
        });
        $("#form-errors").fadeTo(5000, 500).slideUp(500, function () {
            $("#form-errors").slideUp(500);
        });
    });

    function linkDateRange(fromId, toId, onRangeChange) {
        var toPicker = flatpickr('#' + toId, {
            locale: "sl",
            dateFormat: "Y-m-d",
            allowInput: true,
            onChange: function () {
                if (onRangeChange) onRangeChange();
            }
        });
        var fromPicker = flatpickr('#' + fromId, {
            locale: "sl",
            dateFormat: "Y-m-d",
            allowInput: true,
            onChange: function (selectedDates) {
                if (!selectedDates[0]) return;
                toPicker.set('minDate', selectedDates[0]);
                if (toPicker.selectedDates[0] && toPicker.selectedDates[0] < selectedDates[0]) {
                    toPicker.clear();
                }
                if (onRangeChange) onRangeChange();
            }
        });
        return {from: fromPicker, to: toPicker};
    }

    $('#camper-switch').on('change', function () {
        var $switch = $(this);
        var enabled = $switch.is(':checked');
        $switch.prop('disabled', true);
        $.ajax({
            url: '{{ route('toggleCamper') }}',
            method: 'POST',
            data: { _token: '{{ csrf_token() }}', enabled: enabled ? 1 : 0 },
            dataType: 'json'
        }).done(function (data) {
            $('#camper-switch-state').text(data.enabled ? 'prikazano' : 'skrito');
        }).fail(function () {
            $switch.prop('checked', !enabled);
            swal({ title: 'Napaka pri shranjevanju.', icon: 'error' });
        }).always(function () {
            $switch.prop('disabled', false);
        });
    });

    linkDateRange('add-date-from', 'add-date-to');
    linkDateRange('update-calendar-date-from', 'update-calendar-date-to');
    linkDateRange('update-date-from', 'update-date-to', computeReservationTotals);

    // Season pricing used to auto-calculate the reservation total when dates/extras change.
    var calendarData = @json($calendarPricingData);

    function lowSeasonPrice() {
        var entry = calendarData.find(function (c) { return c.type === 1; });
        return entry ? entry.price : 90;
    }

    function priceForDay(dateStr) {
        var entry = calendarData.find(function (c) { return dateStr >= c.date_from && dateStr <= c.date_to; });
        return entry ? entry.price : lowSeasonPrice();
    }

    function formatDate(d) {
        var pad = function (n) { return (n < 10 ? '0' : '') + n; };
        return d.getFullYear() + '-' + pad(d.getMonth() + 1) + '-' + pad(d.getDate());
    }

    function computeReservationTotals() {
        var extrasTotal = 0;
        var extrasNames = [];
        $('.update-extra:checked').each(function () {
            extrasTotal += parseFloat($(this).data('price'));
            extrasNames.push($(this).data('name'));
        });
        $('#update-extras').val(extrasNames.join(', '));

        var fromPicker = document.getElementById('update-date-from')._flatpickr;
        var toPicker = document.getElementById('update-date-to')._flatpickr;
        var from = fromPicker.selectedDates[0];
        var to = toPicker.selectedDates[0];

        if (!from || !to || to < from) {
            return;
        }

        var days = Math.round((to - from) / 86400000) + 1;
        var rentalPrice = 0;
        for (var d = new Date(from); d <= to; d.setDate(d.getDate() + 1)) {
            rentalPrice += priceForDay(formatDate(d));
        }

        $('#update-days').val(days);
        $('#update-price').val((rentalPrice + extrasTotal).toFixed(2));
    }

    $(document).on('change', '.update-extra', computeReservationTotals);

    $('#print-reservations').on('click', function (e) {
        e.preventDefault();
        window.print();
    });

    $('#form-add-calendar').on('submit', function (e) {
        if (this.checkValidity() === false) {
            e.preventDefault();
            e.stopPropagation();
        }
        $(this).addClass('was-validated');
    });

    function togglePriceRequired(selectId, priceId) {
        var select = document.getElementById(selectId);
        var price = document.getElementById(priceId);
        var selected = select.options[select.selectedIndex];
        var type = selected ? selected.dataset.type : null;
        if (type == 4) {
            price.removeAttribute('required');
        } else {
            price.setAttribute('required', 'required');
        }
    }

    $('#add-season').on('change', function () {
        togglePriceRequired('add-season', 'add-price');
    });
    togglePriceRequired('add-season', 'add-price');

    $('#update-calendar-season').on('change', function () {
        togglePriceRequired('update-calendar-season', 'update-calendar-price');
    });

    $(document).on('click','.edit', function () {
        var id = $(this).attr("id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:'{{ url('/load-reservation') }}',
            method: "GET",
            data: { id: id },
            dataType: "json",
            success: function(data){
                let reservation = data.reservation

                $('#update-fullname').val(reservation.fullname)
                $('#update-email').val(reservation.email)
                $('#update-phone').val(reservation.phone)

                var selectedExtras = (reservation.extras || '').split(',').map(function (s) { return s.trim(); }).filter(Boolean)
                $('.update-extra').each(function () {
                    $(this).prop('checked', selectedExtras.indexOf($(this).data('name')) !== -1)
                })

                document.getElementById('update-date-from')._flatpickr.setDate(reservation.date_from, true)
                document.getElementById('update-date-to')._flatpickr.setDate(reservation.date_to, true)
                $('#update-message').val(reservation.message)
                $('#id').val(reservation.id)
                $('#update').modal('show');
            }
        })
    });

    $('.delete').on('click',function(e) {
        e.preventDefault();
        var id = $(this).attr("id");
        return swal({
            title: "Želite izbrisati vnos?",
            icon: "warning",
            buttons: "Izbriši",
            textColor: "#212529"
        }).then(response => {
            if (response) {
                window.location.href = "/delete-reservation/" + id;
            }
        })
    });

    $(document).on('click','.edit-calendar', function () {
        var id = $(this).attr("id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:'{{ url('/load-calendar') }}',
            method: "GET",
            data: { id: id },
            dataType: "json",
            success: function(data){
                let calendar = data.calendar

                $('#update-calendar-season').val(calendar.season_id)
                togglePriceRequired('update-calendar-season', 'update-calendar-price')
                document.getElementById('update-calendar-date-from')._flatpickr.setDate(calendar.date_from, true)
                document.getElementById('update-calendar-date-to')._flatpickr.setDate(calendar.date_to, true)
                $('#update-calendar-price').val(calendar.price)
                $('#calendar-id').val(calendar.id)
                $('#updateCalendar').modal('show');
            }
        })
    });

    $('.delete-calendar').on('click',function(e) {
        e.preventDefault();
        var id = $(this).attr("id");
        return swal({
            title: "Želite izbrisati vnos?",
            icon: "warning",
            buttons: "Izbriši",
            textColor: "#212529"
        }).then(response => {
            if (response) {
                window.location.href = "/delete-calendar/" + id;
            }
        })
    });
</script>
