@extends('layouts.app')
@section('content')
    <div class="col-md-4 offset-4">
        <div class="center">
                    <span>
                        <a href="{{ route('welcome') }}"><img src="{{ asset('pictures/logo-1.png') }}" class="img-spacing" style="height: 60px" alt=""></a>
                    </span>
            <form method="POST" action="{{ route('resetPassword') }}">
                <div class="form-group">
                    <label for="token">Žeton</label>
                    <input type="text" class="form-control" id="token" aria-describedby="emailHelp" name="token" placeholder="Žeton">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="email" placeholder="Email">
                </div>
                <div class="form-group">
                    <label for="password1">Geslo</label>
                    <small id="emailHelp" class="form-text text-muted">Minimalna dolžina 6 znakov</small>
                    <input type="password" class="form-control" id="password1" name="password" placeholder="Geslo">
                </div>
                <div class="form-group">
                    <label for="password2">Geslo</label>
                    <input type="password" class="form-control" id="password2" name="password_confirmation" placeholder="Ponovite geslo">
                </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                @include('messages.login-register')
                @yield('content')
                <div class="text-center" style="padding-top: 10px;">
                    &nbsp;<a href="{{ url('/login') }}" class="page-links" style="text-decoration: none">Prijava</a> | <a href="{{ url('/change-password') }}" class="page-links" style="text-decoration: none">Pozabljeno geslo</a>
                </div>
                <button type="submit" class="btn btn-red btn-sm" style="margin: 1rem 0">Spremeni</button>
            </form>
        </div>
    </div>
@endsection
