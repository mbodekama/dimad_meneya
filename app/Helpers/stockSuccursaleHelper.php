
<?php
use App\Model\succursale;
use App\Model\ventes_succursale;
use App\User;

if(!function_exists('recupInfoProduitSucu'))
{

}



	/*----------------------------------------------
		Recuperation du client de la commande
	-------------------------------------------------*/

	if(!function_exists('getComdQte'))
	{
		function getComdQte($NumComd)
		 {
		  	//Lecture de la quantité en fonction du numéro de commandes
		  	 $comd = ventes_succursale::where('NumVente','=',$NumComd)->get();
		  	 //recup quantite total
		  	 $qte =0;
			 for ($i=0; $i <count($comd) ; $i++) 
			  { 
				 $qte += $comd[$i]['qte'];
			  }

		  	 return $qte;
		  }
	}



	/*----------------------------------------------
		Recuperation du prix globale de la commande
	-------------------------------------------------*/

	if(!function_exists('getCmdMnt'))
	{
		function getCmdMnt($NumComd)
		 {
		  	//Lecture de la quantité en fonction du numéro de commandes
		  	 $comd = ventes_succursale::where('NumVente','=',$NumComd)->get();
		  	 //recup quantite total
		  	 $prix = 0;
			 for ($i=0; $i <count($comd) ; $i++) 
			  { 
				 $prix += $comd[$i]['prix'];
			  }

		  	 return $prix;
		  }
	}



	/*----------------------------------------------
		Recuperation du client de la commande
	-------------------------------------------------*/

	if(!function_exists('getComdClient'))
	{
		function getComdClient($NumComd)
		 {
		  	//Lecture de la quantité en fonction du numéro de commandes
		  	 $idclient = ventes_succursale::where('NumVente','=',$NumComd)->get()->first();

		  	 $infoClient = succursale::findOrfail($idclient->succursale_id);

		  	 

		  	 return $infoClient;
		  }
	}


		if (!function_exists('getPrixPrdInStockSuc')) 
		{
		function getPrixPrdInStockSuc($id_suc)
			{
				$stock = DB::table('stock_succursales')
				->where('stock_succursales.succursale_id','=',$id_suc)
				->select('stock_succursales.*')
				->get();
				$stockprice = 0;
				foreach ($stock as $key => $value) 
				{
					$stockprice+= $value->sucCoutAchat* $value->stock_Qte;
				}
				return $stockprice;


			}
		}




		if(!function_exists("gerantSuc"))
		{
			function gerantSuc($id)
			{
				$gerant = User::find($id);
				return $gerant;
			}
		}


if(!function_exists('isAdminSuc'))
{
	function isAdminSuc($idUser)
	{
		$isAdmin = succursale::where('user_id','=',$idUser)->get();
		if (count($isAdmin) == 0) 
		{
			return 0;
		}
		else
		{
			return 1;
		}

	}
}


// if(!function_exists('getPrdCoutAchat'))
// {
// 	function getStockSuc($idSuc)
// 	{
// 		$stock = stock_succursales::where('$idSuc','=',$idUser)->get();

// 	}
// }

		

	






?>