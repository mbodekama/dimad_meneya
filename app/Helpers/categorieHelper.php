<?php
use App\Model\categorie; 
use App\Model\produits;



//Recuperer les categorie
	if(!function_exists('getCatgo'))
	{
		function getCatgo()
		{
	 		 $ele = categorie::all();
	 		return $ele;

		}
	}




	if(!function_exists('getCatgoEle'))
	{
		function getCatgoEle($idCatgo)
		{
	 		 $ele = produits::where('categorie_id','=',$idCatgo)->get();
	 		return $ele;
		}
	}


//Recuperer une categorie particuliere 
	if(!function_exists('getOneCatgo'))
	{
		function getOneCatgo($idCat)
		{
	 		 $ele = categorie::where('id','=',$idCat)->first();
	 		return $ele;

		}
	}

?>