@component('mail::message')
# Houve uma nova movimentação no controle de produtos!

O Produto {{$product->name}} foi {{$product->wasChanged()?'alterado':'criado'}} com suceeso!

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
