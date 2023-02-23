@component('mail::message')
# Hello Support

Un client vient de réaliser sa première connexion à son interface et à changer ses identifiants.
Veuillez vous referer au tableau pour la mise à jour des coordonnées.

@component('mail::table')
| Libelle       | Valeur        |
| ------------- |:-------------:|
| Email		    | 	{{ $email }}|
| Domaine	    | {{ $domaine }}|
| Mot de passe  | {{ $pass }} 	|
@endcomponent

{{ config('app.name') }}
@endcomponent
