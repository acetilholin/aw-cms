@extends('emails.master')
@section('content')
    <h3>Novo sporočilo</h3>
    Iz strani avtowelt.com vam je bilo poslano novo sporočilo:<br><br>
    <p style="padding-top: 1rem; text-align: left !important;">
        <b>Email:</b> {{ $email }} <br>
        <b>Pošiljatelj:</b> {{ $fullname }} <br>
        <b>Sporočilo:</b> {{ $msg }}<br>
        <b>Čas:</b> {{ $datetime }} <br>
    </p>
@endsection
