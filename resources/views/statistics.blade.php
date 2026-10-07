<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
          integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"></script>

    <!-- Sweet Alerts -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Chart JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

    <!-- Datepicker -->
    <script type="text/javascript" src="{{ URL::asset('datepicker/gijgo.min.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/gijgo@1.9.6/css/gijgo.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/custom-style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/main.css') }}">

    <title>Avto Welt d.o.o.</title>
</head>
<body>
@include('components.navbar')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="section-head">
                <div>
                    <h5 class="section-title">Statistika</h5>
                    <div class="section-underline"></div>
                </div>
            </div>

            <div class="table-card stat-filter mb-3">
                <div class="form-row align-items-center">
                    <div class="col-md-3 mb-2 mb-md-0">
                        <input type="text" class="form-control" id="datepicker1" name="dateFrom" aria-describedby="emailHelp" placeholder="Datum od" required>
                    </div>
                    <div class="col-md-3 mb-2 mb-md-0">
                        <input type="text" class="form-control" id="datepicker2" name="dateTo" aria-describedby="emailHelp" placeholder="Datum do" required>
                    </div>
                    <div class="col-md-auto">
                        <button class="btn btn-calculate" id="getData" title="Išči"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>

            <div class="row stat-cards">
                <div class="col-md-4 mb-3">
                    <div class="table-card stat-card">
                        <div class="stat-label">Trenutno na strani</div>
                        <div class="stat-value">
                            <span class="badge badge-primary" role="button" data-toggle="popover" id="active-users" data-placement="bottom" title="Obiskovalci na strani"
                                  data-content=" @if($liveUsers > 0)
                                                @foreach($liveDetails as $details)
                                                    Država: {{ $details[0] }}<br>
                                                    Naprava: {{ strtolower($details[1]) }}<br>
                                                    <hr>
                                                @endforeach
                                                @else
                                                    Na strani ni obiskovalcev.
                                                @endif">{{ $liveUsers }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="table-card stat-card">
                        <div class="stat-label">Vseh obiskov</div>
                        <div class="stat-value">
                            <span id="total-visitors"></span>
                            <span id="visitors-hide">{{ $totalVisitors }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="table-card stat-card">
                        <div class="stat-label">Povprečno na dan</div>
                        <div class="stat-value">
                            <span id="average"></span>
                            <span id="average-hide">{{ $avg }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-card stat-chart mb-5">
            <canvas id="chartVisits" height="40vh" width="100vw"></canvas>
            </div>
        </div>
    </div>
</div>

</body>
</html>

<style>
    .btn-calculate {
        margin: 0 !important;
        padding: .2rem 1.1rem !important;
        font-size: unset !important;
    }
    .btn-outline-secondary {
        border-radius: 0 !important;
    }
    .active-users {
        margin-top: 1rem;
    }
    .badge-primary {
        background-color:  #ed1c24 !important;
        cursor: pointer;
    }
    .link-style {
        text-decoration: none;
        color: unset;
    }
    .link-style:hover {
        color: #1b1e21;
        text-decoration: none;
    }
    .section-width {
        width: 20%;
    }
</style>

<!-- Bootstrap min js -->
<script src="{!! asset('js/bootstrap.min.js') !!}"></script>

<script>

    $('#active-users').popover({ html:true});

    $(document).ready(function() {
        var labels =  @json($dates);
        var data = @json($visitors);
        var days = @json($days);

        createVisitsGraph(labels, data, days);
    });

    $(document).ready(function () {
        $('#datepicker1').datepicker({
            uiLibrary: 'bootstrap4',
            format: 'dd.mm.yyyy'
        });
        $('#datepicker2').datepicker({
            uiLibrary: 'bootstrap4',
            format: 'dd.mm.yyyy'
        });
    });

    $(document).on('click','#getData', function () {
        var datefrom = $('#datepicker1').val();
        var dateto = $('#datepicker2').val();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:'{{ url('/load-statistics') }}',
            method: "GET",
            data: { datefrom: datefrom, dateto: dateto },
            dataType: "json",
            success: function(results){
              var labels = results.dates;
              var data = results.visitors;
              var days = results.days;

              $('#total-visitors').html(results.totalVisitors);
              $('#average').html(results.avg);
              $('#visitors-hide').hide();
              $('#average-hide').hide();
                createVisitsGraph(labels,data, days);
            }
        })
    });

    function createVisitsGraph(labels, data, days) {

        var ctx = document.getElementById("chartVisits");
        if(window.bar !== undefined)
            window.bar.destroy();
        window.bar = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Obiskov na strani v obdobju ' + days + ' dni',
                    data: data,
                    borderWidth: 2,
                    lineTension: .3,
                    pointRadius: 2,
                    pointBackgroundColor: '#ed1c24',
                    backgroundColor: 'rgba(237, 28, 36, 0.08)',
                    borderColor: '#ed1c24'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            callback: function (value) {
                                if (value % 1 === 0) {
                                    return value;
                                }
                            }
                        }
                    }]
                }
            }
        });
    }
</script>
