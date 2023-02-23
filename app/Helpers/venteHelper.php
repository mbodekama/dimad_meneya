<?php

use App\Model\vente_principales; 

if(!function_exists('venteJourP'))
{
	function venteJourP()
	{
		
		$venteJ = DB::table('vente_principales')->where('dateV','=', date('d/m/Y'))->get();
		return $venteJ;
	}
}


if(!function_exists('venteHierP'))
{
	function venteHierP()
	{
		$hier = date_create_from_format('d-m-Y', date('d-m-Y'))
		    ->modify('-1 day')
		    ->format('d/m/Y');
		$venteH = DB::table('vente_principales')
		->where('dateV','=', $hier)->get();
		return $venteH;
	}
}


if(!function_exists('venteTotalP'))
{
	function venteTotalP()
	{
		
		$venteT = DB::table('vente_principales')->get();
		return $venteT;
	}
}


if(!function_exists('vntMois'))
{
	function vntMois()
	{
		$debutMois = '01/'.date('m/Y');
		$dateActu = date('d/m/Y');
		$vntMois = DB::table('vente_principales')->whereBetween('dateV', [$debutMois, $dateActu])->get();

  $charData = [];

  for($i = 0; $i < date('d'); $i++) 
  {
  	$d =($i+1).'/'.date('m/Y');

  	if ($i<9){$d ='0'.($i+1).'/'.date('m/Y');} //Mettre en 02 chiffre

   $charData[$i] = $vntMois->where('dateV',$d)->sum('prix_vente_total');
  }

		return $charData;
	}
}

//Vente du mois
if(!function_exists('vntMoisSuc'))
{
	function vntMoisSuc()
	{


            //Recuperation de l'entite (succursales /principale)
              if(getUserRole(Auth::id())->roleId == 1) 
                {
                  //Role 1 => Administrateur

                  $succursale_id = 1;
                }
                else                      
                {
                  //Role autre que admin => Gestionnaire
                  $suc = userHasSucc(Auth::id());
                  $succursale_id =$suc->id;
                }		
		$debutMois = '01/'.date('m/Y');
		$dateActu = date('d/m/Y');
		$vntMois = DB::table('ventes_succursales')->where('succursale_id','=',$succursale_id)->whereBetween('dateV', [$debutMois, $dateActu])->get();

  $charData = [];

  for($i = 0; $i < date('d'); $i++) 
  {
  	$d =($i+1).'/'.date('m/Y');

  	if ($i<9){$d ='0'.($i+1).'/'.date('m/Y');} //Mettre en 02 chiffre

   $charData[$i] = $vntMois->where('dateV',$d)->sum('prix_vente_total');
  }

		return $charData;
	}
}




//Valeur de vente d'un mois quelqconque
if(!function_exists('vntOtherMois'))
{
	function vntOtherMois($mois= NULL,$annee=NULL)
	{
		$lastMois = date('m',strtotime('-1 month'));
		$myYear = date('Y');
		if ($lastMois == "12") {$myYear = date('Y',strtotime('-1 year'));}
		//Verifie s'il son nulle
		$mois = is_null($mois) ? $lastMois: $mois;
		$annee = is_null($annee) ? $myYear: $annee;

		//Traitement
		$debutMois = '01/'.$mois.'/'.$annee;
		//Calcul NBR de jour du mois
		$nbrJ = cal_days_in_month(CAL_GREGORIAN, $mois,$annee );
		//Formattage de la date de fin du mois
		$dateFin = $nbrJ.'/'.$mois.'/'.$annee;

		//Selection des vente compris entre le debut du mois et sa fin
		$vntMois = DB::table('vente_principales')->whereBetween('dateV', [$debutMois, $dateFin])->get();

		//initialisation du tableau de donnee 
  		$charData = [];

  		//Remplissage tableau avec la somme des vente de chaque jour ecoule
		  for($i = 0; $i < $nbrJ; $i++) 
		  {
		  	$d =($i+1).'/'.$mois.'/'.$annee;

		  	if ($i<9){$d ='0'.($i+1).'/'.$mois.'/'.$annee;} //Mettre en 02 chiffre

		   $charData[$i] = $vntMois->where('dateV',$d)->sum('prix_vente_total');
		  }

		return $charData;
	}
}



if(!function_exists('venteJourSuc'))
{
	function venteJourSuc()
	{
		$idSuc = userHasSucc(Auth::id())->id;
		// dd($idSuc->id);
		$venteJ = DB::table('ventes_succursales')->where('succursale_id','=',$idSuc)
										->where('dateV','=', date('d/m/Y'))
										->get();
		return $venteJ;
	}
}


if(!function_exists('venteTotalSuc'))
{
	function venteTotalSuc()
	{
		$idSuc =userHasSucc(Auth::id()); 
		$venteT = DB::table('ventes_succursales')->where('succursale_id','=',$idSuc)
													->get();
		return $venteT;
	}
}

//Recup meileur Vente
	if(!function_exists('bestVente'))
	{
		function bestVente()
		{
	
			$bVente = DB::table('vente_principales')->orderBy('prix_vente_total','desc')->get();
			return $bVente;
		}
	}

	
//Recherche un prd en session d'achat

	if(!function_exists('isInSession'))
	{
		function isInSession($mySessionIndex,$index,$idArticle,$qtInStck)
		{
			$qteInSession = 0;
			if (isset($_SESSION[$mySessionIndex])) 
			{
				foreach ($_SESSION[$mySessionIndex] as $sessionEl) 
				{
					if ($sessionEl[$index] ==$idArticle ) 
					{
						$qteInSession+=$sessionEl['qte'];
					}
				}

			}

			$qteRst = $qtInStck - $qteInSession;
			
			return $qteRst;
		}
	}
	

