<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\versement;
use  App\Mail\AlertVers;
use DB;
use Validator;
use Mail;

class GestionAlertController extends Controller
{
    


	//rAPPEL de paiement de demande de versement 
	    public function alertVers(Request $request)
	    {
	    	//Recoit l'Id du versement et on alert la succursale
		        $vers = versement::find($request->idVers);
		        $mntDejaPaye = 0;
	         if (getHistVers($request->idVers)) 
		        {
		        	$mntDejaPaye = getHistVers($request->idVers)->sum('montantPaye');
		        }
         $gerant = gerantSuc(readSurc($vers->succursale_id)->user_id);
        //Déclenchement d'alert
            //Msg alert
         $elemnt = [
                  'matVers' =>$vers->versMat,
                  'mntVers' =>$vers->versMnt,
                  'mntRst' =>$vers->versMnt - $mntDejaPaye
                ];
            Mail::to($gerant->email)
            ->queue(new AlertVers('Rappel',$elemnt));



      // return response()->json();
	    	//Envoie du mail
	    	//Envoie de sms
	    	//Ajout de notification dans la table notification
	    	
	    	return response()->json();
	    }
}
