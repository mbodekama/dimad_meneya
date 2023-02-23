<?php
  use App\Model\credit;
use App\Model\credits_historiques;

if(!function_exists('getSommeCrdPaye'))
{
	function getSommeCrdPaye($idCrd)
	{
 		 $histPaiement = credits_historiques::where('credit_id','=',$idCrd)->sum('montantPaye');
 		return $histPaiement;

	}
}


?>