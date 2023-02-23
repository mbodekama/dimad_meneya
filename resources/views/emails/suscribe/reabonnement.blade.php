@component('mail::message')
# Hello Support

le client suivant essaye de faire un reabonnement de sa souscription Meneya
Ci-dessous ses informations

@component('mail::table')
| Libelle       | Valeur        |
| ------------- |:-------------:|
| Email		    | 	{{ $email }}|
| Forfait	    |  {{ $offre }} |
| Domaine	    | {{ $domaine }}|
| Mot de passe  | {{ $pass }} 	|
@endcomponent


{{ config('app.name') }}
@endcomponent
