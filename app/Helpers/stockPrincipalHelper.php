
<?php

use App\Model\produits;
use App\Model\stock_principale;
use App\Model\vente_principales;
use App\Model\client_principale;
use App\Model\succursale;
use App\Model\ressourcesHum;
use App\User;

if(!function_exists('recupInfoProduitPrincipal'))
{
	function recupInfoProduitPrincipal($id_produit)
	{
		
		return  produits::where('id','=',$id_produit)->first();
	}
}


	/*----------------------------------------------
		Recuperation des produits manquant
	-------------------------------------------------*/

	if(!function_exists('produitManquant'))
	{
		function produitManquant($quantite)
		{
			if($quantite<= 0)
			{
				return  'bg-white text-danger h6';
			}
			elseif ($quantite<=10)
			 {
				return 'bg-white text-warning h6';
			}
			else
			{
				return 'h6';
			}
			
		}
	}


	if(!function_exists('getSeuilPrd'))
	{
		function getSeuilPrd($idPrd)
		{
			$prd = produits::find($idPrd);
			return $prd->seuilAlert;		
			
		}
	}




	/*----------------------------------------------
		Recuperation du client de la commande
	-------------------------------------------------*/

	if(!function_exists('getComdQteP'))
	{
		function getComdQteP($NumComd)
		 {
		  	//Lecture de la quantité en fonction du numéro de commandes
		  	 $comd = vente_principales::where('NumVente','=',$NumComd)->get();
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

	if(!function_exists('getCmdMntP'))
	{
		function getCmdMntP($NumComd)
		 {
		  	//Lecture de la quantité en fonction du numéro de commandes
		  	 $comd = vente_principales::where('NumVente','=',$NumComd)->get();
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

	if(!function_exists('getComdClientP'))
	{
		function getComdClientP($NumComd)
		 {
		  	//Lecture de la quantité en fonction du numéro de commandes
		  	 $idclient = vente_principales::where('NumVente','=',$NumComd)->get()->first();
		  	 $infoClient = client_principale::findOrfail($idclient->client_principale_id);
		  	 //recup quantite total
		  	 // var_dump($infoClient->client_principaleNom);
		  	 // die();
		  	 

		  	 return $infoClient;
		  }
	}

	if (!function_exists('getCountPrdInStockP')) 
	{
		function getCountPrdInStockP()
			{
				$qteArticle = stock_principale::all();
				return $qteArticle;


			}
	}

		if (!function_exists('getPrixPrdInStockP')) 
		{
		function getPrixPrdInStockP()
			{
				$stock = DB::table('stock_principales')
				->join('produits','stock_principales.produits_id','=','produits.id')
				->select('stock_principales.*', 'produits.produitPrix')
				->get();
				$stockprice = 0;
				foreach ($stock as $key => $value) 
				{
					$stockprice+= $value->produitPrix* $value->stock_Qte;
				}
				return $stockprice;


			}
		}

		if (!function_exists('getDiffPrdInStockP')) 
		{
		function getDiffPrdInStockP()
			{
				return $nbrCategorie = stock_principale::all()->count('produits_idproduits');


			}
		}



		if(!function_exists("gerantP"))
		{
			function gerantP($id)
			{
				$gerant = User::where('succursale_id','=',1)->get()->first();
				return $gerant;
			}
		}





		

	






?>