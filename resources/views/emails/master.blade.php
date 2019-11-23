<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Avto Welt d.o.o.</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="center">
             <span>
                <img src="{{ asset('pictures/logo-1.png') }}" class="img-spacing" style="height: 60px">
             </span>
            @yield('content')
        </div>
    </div>
</div>
</body>
</html>
<style>
    @import url('https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700,900&display=swap');
    .container {
        margin-top: 10%;
        text-align: center;
    }
    .center {
        margin: auto;
        width: 50%;
        padding: 10px;
    }
    body {
        background-color: #e9ecef;
        color: #505962;
        font-family: 'Montserrat', sans-serif;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
    }
    img {
        display: block;
        margin-left: auto;
        margin-right: auto;
    }
    .img-spacing {
        margin-bottom: 2rem;
    }
    .text-center {
        text-align: center;
    }
    .text-muted {
        padding: 1rem;
    }
    .custom-red {
        text-decoration: none;
        background: #ed1c24;
        border: 1px solid transparent;
        border-radius: 0;
        color: white;
        padding: .5rem 1.1rem;
        font-size: 1.2rem;
        margin: 1rem;
        cursor: pointer;
        display: inline-block;
        font-weight: 400;
        text-align: center;
        vertical-align: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        line-height: 1.5;
        transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    }
    .custom-red:hover {
        color: #212529;
        text-decoration: none;
    }
</style>
