@component('mail::message')
# Hello !!!

<p>Chers utilisateur de MENEYA votre abonnement  
	<span>{{ $offre }}</span> expire dans  <span>{{ $nbrJrst }}</span> 
	Songez à le renouveller pour  béneficiez de vos fonctionnalités.
</p>
<strong>Offre en cours	 : <span style="color: blue">{{$offre }} </span></strong><br>
<strong>Expire dans  : <span style="color: red">{{ $nbrJrst }} Jours </span></strong><br>
<strong>Domaine		   : <span class="text-danger">{{ $domaine }} Jours</span></strong><br>

@component('mail::button', ['url' => $domaine])
Se connecter
@endcomponent
 {{ config('app.name') }} encore plus de clients<br>
@endcomponent