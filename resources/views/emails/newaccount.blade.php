@extends('emails.master')
@section('content')
    <h3>Nov uporabnik</h3>
    Ustvarjen je bil nov uporabnik z emailom:<br><br>
    <p style="padding-top: 1rem; text-align: left !important;">
        <b>Email:</b> {{ $email }} <br>
    </p>
@endsection
