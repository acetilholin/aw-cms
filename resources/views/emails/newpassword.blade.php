<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/custom-style.css') }}" >
    <title>Avto Welt d.o.o.</title>
</head>
<body>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<div class="container">
    <div class="row">
        <div class="col-md-4 offset-4">
            <div class="center">
                    <span>
                        <img src="{{ asset('pictures/logo-1.png') }}" class="img-spacing" style="height: 60px">
                    </span>
                <h4>Ponastavitev gesla</h4>
                <h3 style="margin: 1rem"><i>{{ $token }}</i></h3>
                <small>Kopirajte žeton. Po 60 minutah bo žeton neveljaven!</small>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<style>
    .center {
        margin-top: 50%;
    }
    body {
        background-color: #e9ecef;
    }
    img {
        display: block;
        margin-left: auto;
        margin-right: auto;
    }
    .img-spacing {
        margin-bottom: 2rem;
    }
    .form-control:focus {
        border-color: #ed1c24;
        box-shadow: 0 0 0 0.2rem rgba(237, 28, 36, 0.25);
    }
    .page-links {
        color: #505962 !important;
    }
</style>
