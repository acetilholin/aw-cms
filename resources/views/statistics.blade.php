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
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01"
            aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        <a class="navbar-brand" href="#"><img src="{{ asset('pictures/logo-1.png') }}" class="img-spacing" style="height: 40px"></a>
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('statistics') }}">Statistika<span class="sr-only">(current)</span></a>
            </li>
        </ul>
        <div class="form-inline my-2 my-lg-0">
            <span class="m-item"><a href="{{ route('main') }}"><i class="fas fa-car"></i></a></span>
            <span class="m-item"><a href="{{ route('users') }}"><i class="fas fa-users"></i></a></span>
            <form action="{{ route('logout') }}">
                <button class="btn btn-gray btn-sm" type="submit" style="margin: 0">Odjava</button>
            </form>
        </div>
    </div>
</nav>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="form-row mb-2 mt-1">
                <div class="col-md-3 mb-2 form-group">
                    <input type="text" class="form-control" id="datepicker1" name="dateFrom" aria-describedby="emailHelp" placeholder="Datum od" required>
                </div>
                <div class="col-md-3 mb-2 form-group">
                    <input type="text" class="form-control" id="datepicker2" name="dateTo" aria-describedby="emailHelp" placeholder="Datum do" required>
                </div>
            </div>
            <button class="btn btn-calculate" id="getData"><i class="fas fa-search"></i></button>
            <div class="text-center">
                <span class="text-red">Vseh obiskov:</span>
                <span id="total-visitors"></span>
                <span id="visitors-hide">{{ $totalVisitors }}</span>
            </div>
            <canvas id="chartVisits" height="40vh" width="100vw"></canvas>
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
    .visits-total {
        color: red;
        padding-bottom: 1rem;
    }
</style>

<!-- Bootstrap min js -->
<script src="{!! asset('js/bootstrap.min.js') !!}"></script>

<script>

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
              $('#visitors-hide').hide();
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
                    borderWidth: 1,
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
