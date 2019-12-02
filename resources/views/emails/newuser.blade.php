@extends('emails.master')
@section('content')
    <h3>Nov uporabnik</h3>
    Ustvarili ste novega uporabnika z emailom:<br><br>
    <p style="padding-top: 1rem;">
        <b>{{ $email }}</b><br>
    </p>
    <small class="text-muted">Prijavite se lahko, ko bo vaš račun potrjen.</small>
    <div class="text-center">
        <a href="http://avtowelt.com/login" class="custom-red">Prijava</a>
    </div>
@endsection
