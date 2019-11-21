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
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/main.css') }}" >

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
                <a class="nav-link" href="{{ route('main') }}">Vozila v ponudbi<span class="sr-only">(current)</span></a>
            </li>
        </ul>
        <div class="form-inline my-2 my-lg-0">
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
            <div class="button-margin">
                <button type="submit" class="btn btn-red btn-sm" style="margin: 0" data-toggle="modal" data-target="#add">Dodaj</button>
            </div>
            @include('messages.info')
            @yield('content')
            <table class="table table-font text-center">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Model</th>
                    <th scope="col">Oznaka</th>
                    <th scope="col">Cena</th>
                    <th scope="col">Opis</th>
                    <th scope="col">Novo</th>
                    <th scope="col">Slika</th>
                    <th scope="col">Uredi</th>
                </tr>
                </thead>
                <tbody>
                @php ( $number = 1 )
                @foreach($cars as $car)
                    <tr>
                        <th scope="row">{{ $number++ }}</th>
                        <td>{{ $car->title }}</td>
                        <td>{{ $car->subtitle }}</td>
                        <td>{{ $car->price }}€</td>
                        <td>{{ $car->description }}</td>
                        <td>
                            @if($car->new == 'true' )
                                {!! Html::image('icons/check.svg') !!}
                            @endif
                        </td>
                        <td><img src="../{{ $car->image }}" width="80px" height="50px"></td>
                        <td>
                            <div class="btn-group dropright">
                                <button type="button" class="btn btn-white dropdown-toggle dropdown-toggle-split" id="dropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {!! Html::image('icons/settings.svg') !!}
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu">
                                    <a href="#" class="edit dropdown-item" id="{{ $car->id }}">
                                        <i class="far fa-edit edit-style" style="font-size: 1.3rem; cursor: pointer" title="Uredi"></i>
                                        Uredi
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a href="{{ route('delete', $car->id) }}" id="{{ $car->id }}" class="dropdown-item delete"><i class="far fa-trash-alt remove" style="font-size: 1.3rem; cursor: pointer" title="Odstrani"></i>
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
<!-- Modal add -->
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nov vnos</h5>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('add') }}" enctype="multipart/form-data" id="modaladd">
                    <add></add>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
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
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Uredi vnos</h5>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('update') }}" enctype="multipart/form-data" id="modalupdate">
                    <div class="form-group">
                        <label for="update-title">Model</label>
                        <input type="text" class="form-control" id="update-title" aria-describedby="emailHelp" placeholder="Vnesite model" name="title">
                    </div>
                    <div class="form-group">
                        <label for="update-subtitle">Oznaka</label>
                        <input type="text" class="form-control" id="update-subtitle" aria-describedby="emailHelp" placeholder="Vnesite oznako" name="subtitle">
                    </div>
                    <div class="form-group">
                        <label for="update-price">Cena</label>
                        <small id="text-muted" class="form-text text-muted">Format e.g. 21.000, brez znaka za €</small>
                        <input type="text" class="form-control" id="update-price"  aria-describedby="emailHelp" placeholder="Vnesite ceno" name="price">
                    </div>
                    <div class="form-group">
                        <label for="update-description">Opis</label>
                        <textarea class="form-control" id="update-description" rows="4" name="description"></textarea>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" id="update-new" type="checkbox" value="checked" name="new">
                            <label class="form-check-label" for="update-new">
                                Novo vozilo
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlFile1">Slika</label>
                        <br>
                        <small class="text-muted">Slika bo avtomatsko zmanjšana na primerno velikost.</small>
                        <input type="file" class="form-control-file" name="file" id="file">
                    </div>
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
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

<!-- Vue src file -->
<script src="{!! asset('js/app.js') !!}"></script>

<!-- Bootstrap min js -->
<script src="{!! asset('js/bootstrap.min.js') !!}"></script>

<script>
    $(function() {
        $("#message").fadeTo(2000, 500).slideUp(500, function () {
            $("#message").slideUp(500);
        });
    });

    $(document).on('click','.edit', function () {
        var id = $(this).attr("id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:'{{ url('/load') }}',
            method: "GET",
            data: { id: id },
            dataType: "json",
            success: function(data){
                $('#update-title').val(data.title);
                $('#update-subtitle').val(data.subtitle);
                $('#update-price').val(data.price);
                $('#update-description').val(data.description);
                $('#id').val(data.id);
                if(data.new === "true") {
                    $('#update-new').prop('checked', true);
                } else {
                    $('#update-new').prop('checked', false);
                }

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
                window.location.href = "/delete/" + id;
            }
        })
    });
</script>
