@extends('emails.master')
@section('content')
    <h3>Ponastavitev gesla</h3>
    Kopirajte žeton. Po 60 minutah bo žeton neveljaven!<br><br>
    <p style="padding-top: 1rem;">
        <b>{{ $token }}</b><br>
    </p>
    <div class="text-center">
        <a href="http://avtowelt.com/token" class="custom-red">Vnesi žeton</a>
    </div>
@endsection
