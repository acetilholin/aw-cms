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

    <link rel="stylesheet" type="text/css" href="{{ asset('css/custom-style.css') }}">

    <title>Avto Welt d.o.o.</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        <a class="navbar-brand" href="#"><img src="{{ asset('pictures/logo-1.png') }}" class="img-spacing" style="height: 40px"></a>
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('users') }}">Uporabniki<span class="sr-only">(current)</span></a>
            </li>
        </ul>
        <div class="form-inline my-2 my-lg-0">
            <span class="m-item"><a href="{{ route('main') }}"><i class="fas fa-car"></i></a></span>
            <form action="{{ route('logout') }}">
                <button class="btn btn-gray btn-sm" type="submit" style="margin: 0">Odjava</button>
            </form>
        </div>
    </div>
</nav>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @include('messages.info')
            @yield('content')
            <table class="table table-font text-center">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Email</th>
                    <th scope="col">Potrjen</th>
                    <th scope="col">Zadnja prijava</th>
                    <th scope="col">Država <i class="fas fa-info-circle" style="color: lightgray" data-toggle="country" title="Država iz katere se je uporabnik nazadnje prijavil." data-placement="top"></i></th>
                    <th scope="col">Online <i class="fas fa-info-circle" style="color: lightgray" data-toggle="online" title="Prisotni uporabniki zadnjih 5 minut." data-placement="top"></i></th>
                    <th scope="col">Uredi</th>
                </tr>
                </thead>
                <tbody>
                @php ( $index = 0 )
                @php ( $number = 1 )
                @foreach($users as $user)
                    <tr>
                        <th scope="row">{{ $number++ }}</th>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if ( $user->approved == '1' )
                                {!! Html::image('icons/check.svg','check', array('title' => 'Uporabnik je potrjen')) !!}
                            @else
                                {!! Html::image('icons/x.svg','x', array('title' => 'Uporabnik ni potrjen')) !!}
                            @endif
                        </td>
                        <td>{{ $user->last_seen }}</td>
                        <td>{!! Html::image('countries/'. strtolower($user->country) .'.svg','drzava', array('width' => '40px', 'height' => '40px')) !!}</td>
                        <td>
                            @if($onlineUsers[$index] == 'online')
                                <span class="green-dot"></span>
                            @endif
                            @php  ( $index ++ )
                        </td>
                        <td>
                            <div class="btn-group dropright">
                                <button type="button" class="btn btn-white dropdown-toggle dropdown-toggle-split" id="dropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {!! Html::image('icons/settings.svg') !!}
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu">
                                   @if($user->approved == '1')
                                        <a href="{{ route('lock', $user->id) }}" class="edit dropdown-item">
                                            <i class="fas fa-lock edit-style" style="font-size: 1.3rem; cursor: pointer" title="Zakleni"></i>
                                            Zakleni
                                        </a>
                                       @else
                                        <a href="{{ route('unlock', $user->id) }}" class="edit dropdown-item">
                                            {!! Html::image('icons/check.svg','check', array('title' => 'Potrdi')) !!}
                                            Potrdi
                                        </a>
                                       @endif
                                    <div class="dropdown-divider"></div>
                                    <a href="{{ route('deleteUser', $user->id) }}" class="dropdown-item"><i class="far fa-trash-alt remove" style="font-size: 1.3rem; cursor: pointer" title="Odstrani"></i>
                                        Odstrani
                                    </a>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>

<!-- Vue src file -->
<script src="{!! asset('js/app.js') !!}"></script>

<!-- Bootstrap min js -->
<script src="{!! asset('js/bootstrap.min.js') !!}"></script>

<script>
    $(function() {
        $('[data-toggle="online"]').tooltip();
        $('[data-toggle="country"]').tooltip();

        $("#message").fadeTo(2000, 500).slideUp(500, function () {
            $("#message").slideUp(500);
        });
    });
</script>



<style>
    .button-margin {
        margin: 1rem auto;
    }
    .btn-edit {
        border: 1px solid #ed1c24;
        border-radius: 0;
    }
    .btn-red:focus {
        border-color: #ed1c24;
        box-shadow: 0 0 0 0.2rem rgba(237, 28, 36, 0.25);
    }
    .btn-edit:focus {
        border-color: #ed1c24;
        box-shadow: 0 0 0 0.2rem rgba(237, 28, 36, 0.25);
    }
    .remove {
        color: #ed1c24;
    }
    .remove:hover {
        color: #c4191e;
    }
    .edit-style {
        color: #586168;
    }
    .edit-style:hover {
        color: #444c53;
    }
    .dropdown-menu {
        background-color: white;
        border: 1px solid lightgray !important;
    }
    .btn-white {
        border: 1px solid #ed1c24;
    }
    .btn-white:focus {
        border-color: #ed1c24;
        box-shadow: 0 0 0 0.2rem rgba(237, 28, 36, 0.25);
    }
</style>
