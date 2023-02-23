@component('mail::message')
# Hello Gestionnaire
Ci dessous la liste des produits dont le stock a atteint le seuil de sécurité d'alerte suite à votre vente précédente 

@component('mail::table')
| Code                    | Libelle	                 | Qte Restante              |
| ----------------------- |:------------------------:| -------------------------:|
@foreach($liste as $elmnt)
| {{ $elmnt['code'] }}    | {{ $elmnt['article'] }}  | {{ $elmnt['qteRest'] }}   |
@endforeach
@endcomponent
@component('mail::button', ['url' => ''])
Se connecter
@endcomponent

<br>
{{ config('app.name') }}
@endcomponent
