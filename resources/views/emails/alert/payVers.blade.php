@component('mail::message')
# Hello !!!

<p>Chers collaborateurs votre paiement  de 
	<span>{{ formatPrice($elemnt['montantPaye']) }}</span> pour 
	le versement N° <span>{{ $elemnt['matVers'] }}</span> 
	de valeur <span>{{ formatPrice($elemnt['mntVers']) }}</span> 
	 demandé par votre agence Principal a été enregistré avec succès.
</p>
1. Montant Paye	   : {{ formatPrice($elemnt['montantPaye']) }}<br>
2. Montant Restant : {{ formatPrice($elemnt['mntRst']) }}<br>
3. Moyen Paiement  : {{ $elemnt['typepaiement'] }}<br>
4. Date 		   : {{ $elemnt['datePaiement'] }}<br>



<br>
{{ config('app.name') }}
@endcomponent
