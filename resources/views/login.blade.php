@extends('layouts.app')
@section('content')
    <div class="col-md-4 offset-4">
        <div class="center">
                    <span>
                        <a href="{{ route('welcome') }}"><img src="{{ asset('pictures/logo-1.png') }}" class="img-spacing" style="height: 60px" alt=""></a>
                    </span>
            <form method="POST" action="{{ route('loginUser') }}">
                @if(isset($email))
                    <div class="text-center mb-2">
                        Zdravo <span class="text-red">{{ $name }}</span>
                        <input type="hidden" name="email" value="{{ $email }}">
                    </div>
                    @else
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="email" placeholder="Email">
                    </div>
                    @endif
                <div class="form-group">
                    <label for="password">Geslo</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Geslo">
                </div>
                    @csrf
                @include('messages.login-register')
                @yield('content')
                <div class="text-center" style="padding-top: 10px;">
                    &nbsp;<a href="{{ url('/register') }}" class="page-links" style="text-decoration: none">Registracija</a> | <a href="{{ url('/change-password') }}" class="page-links" style="text-decoration: none">Pozabljeno geslo</a>
                </div>
                <button type="submit" class="btn btn-red btn-sm" style="margin: 1rem 0">Prijava</button>
            </form>
        </div>
    </div>
@endsection
