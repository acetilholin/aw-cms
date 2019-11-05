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

    <link rel="stylesheet" type="text/css" href="{{ asset('css/custom-style.css') }}" >
    <title>Avto Welt d.o.o.</title>
</head>
<body>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
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
            @include('messages.main')
            @yield('content')
            <table class="table">
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
                            <a href="#" class="edit" id="{{ $car->id }}"><i class="far fa-edit edit-style" style="font-size: 1.3rem; cursor: pointer" title="Uredi"></i></a>
                            <a href="{{ route('delete', $car->id) }}"><i class="far fa-trash-alt remove" style="font-size: 1.3rem; cursor: pointer" title="Izbriši"></i></a>
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
                <form method="POST" action="{{ route('add') }}" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Model</label>
                        <input type="text" class="form-control" id="title" aria-describedby="emailHelp" placeholder="Vnesite model" name="title">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Oznaka</label>
                        <input type="text" class="form-control" id="subtitle" aria-describedby="emailHelp" placeholder="Vnesite oznako" name="subtitle">
                    </div>
                    <div class="form-group">
                        <label for="priceInEuros">Cena</label>
                        <small id="text-muted" class="form-text text-muted">Format e.g. 21.000</small>
                        <input type="text" class="form-control" id="price"  aria-describedby="emailHelp" placeholder="Vnesite ceno" name="price">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Opis</label>
                        <textarea class="form-control" id="description"  rows="2" name="description"></textarea>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" id="new" type="checkbox" value="checked" name="new">
                            <label class="form-check-label" for="gridCheck">
                                Novo vozilo
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlFile1">Slika</label>
                        <input type="file" class="form-control-file" name="file" id="file">
                    </div>
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
                <form method="POST" action="{{ route('update') }}" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Model</label>
                        <input type="text" class="form-control" id="update-title" aria-describedby="emailHelp" placeholder="Vnesite model" name="title">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Oznaka</label>
                        <input type="text" class="form-control" id="update-subtitle" aria-describedby="emailHelp" placeholder="Vnesite oznako" name="subtitle">
                    </div>
                    <div class="form-group">
                        <label for="priceInEuros">Cena</label>
                        <small id="text-muted" class="form-text text-muted">Format e.g. 21.000</small>
                        <input type="text" class="form-control" id="update-price"  aria-describedby="emailHelp" placeholder="Vnesite ceno" name="price">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Opis</label>
                        <textarea class="form-control" id="update-description"  rows="2" name="description"></textarea>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" id="update-new" type="checkbox" value="checked" name="new">
                            <label class="form-check-label" for="gridCheck">
                                Novo vozilo
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlFile1">Slika</label>
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
                console.log(data)
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
    })
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

</style>