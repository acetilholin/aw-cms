@component('mail::message')
# Novo povpraševanje za najem kamperja

Iz strani avtowelt.com ste prejeli novo povpraševanje za najem kamperja:

@component('mail::panel')
**Osebni podatki**

{{ $data['fullname'] }}<br>
{{ $data['email'] }}<br>
{{ $data['phone'] }}
@endcomponent

@component('mail::table')
| Termin najema | |
| :------------ | --: |
| Od | **{{ date('d.m.Y', strtotime($data['dateFrom'])) }}** |
| Do | **{{ date('d.m.Y', strtotime($data['dateTo'])) }}** |
| Število dni | **{{ $data['days'] }}** |
| Skupna cena | **{{ number_format($data['price'], 2, ',', '.') }} €** |
@endcomponent

**Dodatna oprema**

@forelse(array_filter(array_map('trim', explode(',', (string) ($data['extras'] ?? '')))) as $extra)
- {{ $extra }}
@empty
/
@endforelse

**Sporočilo**

{!! !empty($data['message']) ? nl2br(e($data['message'])) : '/' !!}
@endcomponent
