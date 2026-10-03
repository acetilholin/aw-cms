@component('mail::message')
# Novo povpraševanje

Iz strani avtowelt.com ste prejeli novo povpraševanje:

@component('mail::panel')
**Osebni podatki**

{{ $data['imePriimek'] }}<br>
{{ $data['email'] }}<br>
{{ $data['telefon'] }}
@endcomponent

@component('mail::table')
| Osnovni podatki o vozilu | |
| :------------------------ | --: |
| Pričakovana cena | **{{ $data['cena'] }} €** |
| Znamka | **{{ $data['znamka'] }}** |
@if(isset($data['oprema']))
| Oprema | **{{ $data['oprema'] }}** |
@endif
| Letnik | **od {{ $data['letaMin'] }} do {{ $data['letaMax'] }}** |
| Kilometri | **{{ $data['kilometri'] }} km** |
@if(isset($data['sedezi']))
| Sedeži | **{{ $data['sedezi'] }}** |
@endif
@if(isset($data['vrata']))
| Vrata | **{{ $data['vrata'] }}** |
@endif
@if(isset($data['karoserija']))
| Karoserija | **{{ $data['karoserija'] }}** |
@endif
@if(isset($data['barva']))
| Barva | **{{ $data['barva'] }}** |
@endif
@if(isset($data['moc']))
| Moč | **{{ $data['moc'] }}** |
@endif
@if(isset($data['menjalnik']))
| Menjalnik | **{{ $data['menjalnik'] }}** |
@endif
@if(isset($data['gorivo']))
| Gorivo | **{{ $data['gorivo'] }}** |
@endif
@endcomponent

**Dodatne opcije**

@if(isset($data['notranja1']) || isset($data['notranja2']) || isset($data['notranja3']) || isset($data['notranja4']) || isset($data['notranja5']) || isset($data['notranja6']) || isset($data['notranja7']))
**Notranja oprema**

@foreach(range(1, 7) as $i)
@if(isset($data['notranja'.$i]))
- {{ $data['notranja'.$i] }}
@endif
@endforeach

@endif
@if(isset($data['varnost1']) || isset($data['varnost2']) || isset($data['varnost3']) || isset($data['varnost4']) || isset($data['varnost5']) || isset($data['varnost6']))
**Varnost**

@foreach(range(1, 6) as $i)
@if(isset($data['varnost'.$i]))
- {{ $data['varnost'.$i] }}
@endif
@endforeach

@endif
@if(isset($data['pomoc1']) || isset($data['pomoc2']) || isset($data['pomoc3']))
**Pomoč pri parkiranju**

@foreach(range(1, 3) as $i)
@if(isset($data['pomoc'.$i]))
- {{ $data['pomoc'.$i] }}
@endif
@endforeach

@endif
@if(isset($data['klima1']) || isset($data['klima2']))
**Klimatizacija**

@foreach(range(1, 2) as $i)
@if(isset($data['klima'.$i]))
- {{ $data['klima'.$i] }}
@endif
@endforeach

@endif
@if(isset($data['ostalo1']) || isset($data['ostalo2']))
**Ostalo**

@foreach(range(1, 2) as $i)
@if(isset($data['ostalo'.$i]))
- {{ $data['ostalo'.$i] }}
@endif
@endforeach
@endif
@endcomponent
