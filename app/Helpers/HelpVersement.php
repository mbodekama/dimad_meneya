<?php 
  use App\Model\versement;
  use App\Model\succursale;
  use App\Model\versement_historiques;

  
  function readSurc($id)
  {
  	//Lecture de la succursale en fonction de l'id Succursale
  	 $sucurId = succursale::where('id','=',$id)->get()->first();
  	 return $sucurId;
  }

  function getHistVers($id)
  {
  	//LRecup l'historiques d'un versement
  	 	$histVers = versement_historiques::where('versement_id','=',$id)->get();
  	 	return $histVers;
  }

 	
?>
