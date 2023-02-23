@component('mail::message')
# Hello !!!

<p>Chers collaborateurs un versement de <span>{{ formatPrice($elemnt['versMnt']) }}</span> 	a été reclamé par votre agence Principal concernant vos ventes du {{ $elemnt['dateDebut'] }} au {{ $elemnt['dateFin'] }} .
</p>
Montant Reclamé	   : {{ formatPrice($elemnt['versMnt']) }}<br>
Date 		   : {{ $elemnt['versDate'] }}<br>



<br>
{{ config('app.name') }}
@endcomponent
