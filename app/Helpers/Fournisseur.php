<?php 
  use App\Model\echeance;
use App\Model\echeancehistorique;
use App\Model\fournisseur;



 	function recupFourniEch($id_fourni)
 	{
 		$echanceFourni = echeance::where('fournisseur_id','=',$id_fourni)->get()->first();
 		return $echanceFourni;
 	}

if(!function_exists('getTransF'))
{
	function getTransF($idF)
	{
		$transTotal = echeance::where('fournisseurs_id','=',$idF)->sum('echeanceMontant');
		return $transTotal;
	}
}

if(!function_exists('getSommePaye'))
{
	function getSommePaye($idEch)
	{
 		$histPaiement = echeancehistorique::where('echeance_id','=',$idEch)->sum('montantPaye');
 		return $histPaiement;

	}
}

if(!function_exists('getNbrFour'))
{
	function getNbrFour()
	{
 		 $nbrf = fournisseur::all();
 		return $nbrf;

	}
} 

?>
