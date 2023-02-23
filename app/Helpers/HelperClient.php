<?php

use App\Model\clients;
use App\Model\ventes_succursales;
use App\Model\vente_principales;
if(!function_exists('getClient'))
{
	function getClient($idC)
	{

	return clients::find($idC);
	}
}

if(!function_exists('getClientNbr'))
{
	function getClientNbr()
	{

	return clients::all();
	}
}


if(!function_exists('allCltSuc'))
{
	function allCltSuc($idSuc)
	{
		$cltSuc =DB::table('succursale_has_clients')
	                    ->join('clients','clients.id','=','succursale_has_clients.clients_id')
	                    ->select('clients.*', 'clients.id as clientId')
	                    ->where('succursale_has_clients.succursale_id','=',$idSuc)
	                    ->where('clients.statutClt','=',1)
	                    ->orderBy('id','desc')->get();



	                    
		return $cltSuc;
	}
}


if(!function_exists('getBestClt'))
{
	function getBestClt()
	{
		$suc = userHasSucc(Auth::id());
		$list = allCltSuc($suc->id);
		$collection = collect();
		foreach ($list as $ele) 
		{
			if ($suc->id !=1) 
			{
			$vent = ventes_succursales::where('succursale_id','=',$suc->id)
								->where('clients_id','=',$ele->clientId)
								->sum('prix_vente_total');
			}
			else
			{
			$vent = vente_principales::where('clients_id','=',$ele->clientId)
								->sum('prix_vente_total');
			}

			$collection->push(["idClient"=>$ele->clientId, "montant"=>$vent,"nom" =>$ele->nom,"contact" =>$ele->contact]);

		}
		$elet = $collection->where('montant', $collection->max('montant'))->first();
		return $elet;
	}
}




?>