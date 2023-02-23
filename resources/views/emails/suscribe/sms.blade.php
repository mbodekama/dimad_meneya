@component('mail::message')
# Meneya, Rechargement SMS

Un client vient de récharger son compte sms
Veuillez recharger son sous-compte texto.
Ci-dessous, ces coordonnées:
@component('mail::table')
| Libelle       | Valeur            |
| ------------- |:----------------: |
| Email		    | 	{{ $email }}    |
| Domaine	    | {{ $domaine }}    |
| Password      | {{ $pass }} 	    |
| Sms_key       | {{ $sms_key }} 	|
| Sms_mail      | {{ $sms_mail }} 	|
| Montant       | {{ $amount }} 	|
@endcomponent

{{ config('app.name') }}
@endcomponent
