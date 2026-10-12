@extends('layouts.app')
@section('content')
    <div class="col-md-4 offset-4">
        <div class="center">
                    <span>
                         <a href="{{ route('welcome') }}"><img src="{{ asset('pictures/logo-1.png') }}" class="img-spacing" style="height: 60px" alt=""></a>
                    </span>
            <form method="POST" action="{{ route('registerUser') }}">
                <div class="form-group">
                    <label for="name">Ime</label>
                    <input type="text" class="form-control" id="name" aria-describedby="emailHelp" name="name" placeholder="Ime">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="email" placeholder="ime@avtowelt.com">
                </div>
                <div class="form-group">
                    <label for="password1">Geslo</label>
                    <small id="emailHelp" class="form-text text-muted">Minimalna dolžina 6 znakov</small>
                    <div class="position-relative">
                        <input type="password" class="form-control pr-5" id="password1" name="password" placeholder="Geslo">
                        <button type="button" class="btn btn-link p-0 text-muted toggle-password" data-target="password1"
                                aria-label="Prikaži geslo" aria-pressed="false"
                                style="position: absolute; top: 50%; right: .75rem; transform: translateY(-50%); line-height: 1; box-shadow: none;">
                            <i class="fas fa-eye" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password2">Geslo</label>
                    <div class="position-relative">
                        <input type="password" class="form-control pr-5" id="password2" name="password_confirmation" placeholder="Ponovite geslo">
                        <button type="button" class="btn btn-link p-0 text-muted toggle-password" data-target="password2"
                                aria-label="Prikaži geslo" aria-pressed="false"
                                style="position: absolute; top: 50%; right: .75rem; transform: translateY(-50%); line-height: 1; box-shadow: none;">
                            <i class="fas fa-eye" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
                @csrf
                @include('messages.login-register')
                @yield('content')
                <div class="text-center" style="padding-top: 10px;">
                    &nbsp;<a href="{{ url('/login') }}" class="page-links" style="text-decoration: none">Prijava</a> | <a href="{{ url('/change-password') }}" class="page-links" style="text-decoration: none">Pozabljeno geslo</a>
                </div>
                <button type="submit" class="btn btn-red btn-sm" style="margin: 1rem 0">Registracija</button>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.toggle-password').forEach(function (btn) {
                var input = document.getElementById(btn.dataset.target);
                btn.addEventListener('click', function () {
                    var show = input.type === 'password';
                    input.type = show ? 'text' : 'password';
                    btn.setAttribute('aria-pressed', show);
                    btn.setAttribute('aria-label', show ? 'Skrij geslo' : 'Prikaži geslo');
                    btn.querySelector('i').className = show ? 'fas fa-eye-slash' : 'fas fa-eye';
                });
            });
        });
    </script>
@endsection
