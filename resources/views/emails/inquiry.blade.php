@extends('emails.master')
@section('content')
    <div style="width: 140%; background-color: #e9ecef">
        <h3>Novo povpraševanje</h3>
        Iz strani avtowelt.com ste prejeli novo povpraševanje:<br><br>
        <p style="padding-top: 1rem;">
        <span class="text-red">
            Osebni podatki
        </span>
        </p>
        <hr>
        {{ $data['imePriimek'] }}<br>
        {{ $data['email'] }}<br>
        {{ $data['telefon'] }}<br>
        <p style="padding-top: .2rem;">
        <span class="text-red">
            Osnovni podatki o vozilu
        </span>
        </p>
        <hr>
        Pričakovana cena: <b>{{ $data['cena'] }} €</b><br><br>
        Znamka: <b> {{ $data['znamka'] }} </b><br>
        @if(isset($data['oprema']))
            Oprema: <b> {{ $data['oprema'] }} </b><br>
        @endif
        Letnik: od <b> {{ $data['letaMin'] }}</b> do <b>{{ $data['letaMax'] }} km</b><br>
        Kilometri: <b> {{ $data['kilometri'] }} </b><br>
        @if(isset($data['sedezi']))
            Sedeži: <b> {{ $data['sedezi'] }} </b><br>
        @endif
        @if(isset($data['vrata']))
            Vrata: <b> {{ $data['vrata'] }} </b><br>
        @endif
        @if(isset($data['karoserija']))
            Karoserija: <b> {{ $data['karoserija'] }} </b><br>
        @endif
        @if(isset($data['barva']))
            Barva: <b> {{ $data['barva'] }} </b><br>
        @endif
        @if(isset($data['moc']))
            Moč: <b> {{ $data['moc'] }} </b><br>
        @endif
        @if(isset($data['menjalnik']))
            Menjalnik: <b> {{ $data['menjalnik'] }} </b><br>
        @endif
        @if(isset($data['gorivo']))
            Gorivo: <b> {{ $data['gorivo'] }} </b><br>
        @endif
        <p style="padding-top: .2rem;">
        <span class="text-red">
           Dodatne opcije
        </span>
        </p>
        <hr>
        <div class="column1">
            <b>Notranja oprema</b><br>
            @if(isset($data['notranja1']))
                {{ $data['notranja1'] }}<br>
            @endif
            @if(isset($data['notranja2']))
                {{ $data['notranja2'] }}<br>
            @endif
            @if(isset($data['notranja3']))
                {{ $data['notranja3'] }}<br>
            @endif
            @if(isset($data['notranja4']))
                {{ $data['notranja4'] }}<br>
            @endif
            @if(isset($data['notranja5']))
                {{ $data['notranja5'] }}<br>
            @endif
            @if(isset($data['notranja6']))
                {{ $data['notranja6'] }}<br>
            @endif
            @if(isset($data['notranja7']))
                {{ $data['notranja7'] }}<br>
            @endif
        </div>
        <div class="column1">
            <b>Varnost</b><br>
            @if(isset($data['varnost1']))
                {{ $data['varnost1'] }}<br>
            @endif
            @if(isset($data['varnost2']))
                {{ $data['varnost2'] }}<br>
            @endif
            @if(isset($data['varnost3']))
                {{ $data['varnost3'] }}<br>
            @endif
            @if(isset($data['varnost4']))
                {{ $data['varnost4'] }}<br>
            @endif
            @if(isset($data['varnost5']))
                {{ $data['varnost5'] }}<br>
            @endif
            @if(isset($data['varnost6']))
                {{ $data['varnost6'] }}<br>
            @endif
            <br>
        </div>
        <div class="column1">
            <b>Pomoč pri parkiranju</b><br>
            @if(isset($data['pomoc1']))
                {{ $data['pomoc1'] }}<br>
            @endif
            @if(isset($data['pomoc2']))
                {{ $data['pomoc2'] }}<br>
            @endif
            @if(isset($data['pomoc3']))
                {{ $data['pomoc3'] }}<br>
            @endif
            <br><br><br><br>
        </div>
        <br>
        <br>
        <div class="column2">
            <b>Klimatizacija</b><br>
            @if(isset($data['klima1']))
                {{ $data['klima1'] }}<br>
            @endif
            @if(isset($data['klima2']))
                {{ $data['klima2'] }}<br>
            @endif
        </div>
        <div class="column2">
            <b>Ostalo</b><br>
            @if(isset($data['ostalo1']))
                {{ $data['ostalo1'] }}<br>
            @endif
            @if(isset($data['ostalo2']))
                {{ $data['ostalo2'] }}<br>
            @endif
        </div>
        <div class="column2">
        </div>
    </div>
    <style>
        .column1 {
            float: left;
            width: 33.33%;
            text-align: center;
        }
        .row:after {
            content: "";
            display: table;
            clear: both;
        }
        .column2 {
            margin-top: 30px;
            margin-bottom: 30px;
            float: left;
            text-align: center;
            width: 33.33%;
        }
        .row:after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
@endsection
