<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

use App\Model\setting;
use App\User;
use Auth;
use DB;


class SettingController extends Controller
{

    public function __construct()
        {
            $this->middleware('auth');
        }

    public function setting()
    {

        return view('pages.dash.setting');
    }
    //Modif user info
	    public function updUser(Request $request)
		    {
		    	// $validator = $this->validator($request->all())->validate();
		        $valeur= array(
		                        'name'=>$request->name,
		                        'email'=> $request->email
		                        );
		       $user= user::where('id','=',Auth::id())->update($valeur);
		    	return response()->json();
		    }
    //Update taxe 
	    public function updTaxe(Request $request)
		    {

          //modif taxe devise
            if (isset($request->deviseId)) 
            {
            $taxe = setting::where('cle','=','devise')->first()
                    ->update(['valeur'=> $request->deviseId]);

                
            }

		    	//modif taxe douane
			    	if (isset($request->txDouane)) 
			    	{
						$taxe = setting::where('cle','=','dedouanement')->first()
										->update(['valeur'=> $request->txDouane]);

			    			
			    	}
		    	//modif taxe annexe
			    	if (isset($request->txAnexe)) 
			    	{
						$taxe = setting::where('cle','=','fraisAnnexe')->first()
										->update(['valeur'=> $request->txAnexe]);	
			    	}
			    //modif taxe portuaaire
			    	if (isset($request->txPort)) 
			    	{
			    		$taxe = setting::where('cle','=','taxePort')->first()
										->update(['valeur'=> $request->txPort]);
			    	}	
			    //modif marge vente
			    	if (isset($request->txMarge)) 
			    	{
			    		$taxe = setting::where('cle','=','margeVente')->first()
										->update(['valeur'=> $request->txMarge]);
			    	}	

		    	return response()->json();
		    }

	//Update Alert $ Mobile money
	    public function updAlert(Request $request)
		    {

          //Modif paiement Mobile Option           
            if (isset($request->mobileMoney)) 
            {
                $request->mobileMoney = 1;
            }
            else
            {
              $request->mobileMoney = 0;
            }

            $taxe = setting::where('cle','=','mobileMoney')->first()
                    ->update(['valeur'=> $request->mobileMoney]);     

		    	//modif alert numero
			    	if (!empty($request->alertTel)) 
			    	{
						$taxe = setting::where('cle','=','alertTel')->first()
										->update(['valeur'=> $request->alertTel]);

			    			
			    	}
		    	//modif alert Mail 
			    	if (!empty($request->alertMail)) 
			    	{
						$taxe = setting::where('cle','=','alertMail')->first()
										->update(['valeur'=> $request->alertMail]);	
			    	}
			    //modif seuil produit
			    	if (!empty($request->seuilPrd)) 
			    	{
			    		$taxe = setting::where('cle','=','seuilPrd')->first()
										->update(['valeur'=> $request->seuilPrd]);
			    	}	
			    //modif marge vente
			    	if (isset($request->etatAlert)) 
			    	{
			    		$taxe = setting::where('cle','=','etatAlert')->first()
										->update(['valeur'=> $request->etatAlert]);
			    	}	
		    	return response()->json();
		    }

    public function lSetting(Request $request)
    {
    	$output = '<table class="table table-borderless fs--1 mb-0">
                        <tr class="border-bottom">
                          <th class="pl-0 pt-0 text-left">
                          Etat alerte
                          </th>
                          <th class="pr-0 text-right pt-0">
                              <div class="badge badge-pill badge-soft-success fs--2">'.getAlertEtat().'
                                <span class="fas fa-check ml-1" data-fa-transform="shrink-2"></span>
                              </div>
                          </th>
                        </tr>
                        <tr class="border-bottom">
                          <th class="pl-0 pt-0 text-left">
                          Mail Alerté
                          </th>
                          <th class="pr-0 text-right pt-0">
                              <div class="fs--2">
                                '.getAlertMail() .'
                            
                              </div>
                          </th>
                        </tr>
                        <tr class="border-bottom">
                          <th class="pl-0 pt-0 text-left">
                          Numero Alerté
                          </th>
                          <th class="pr-0 text-right pt-0">
                              <div class=" fs--2">
                                '.getAlertTel() .'
                            
                              </div>
                          </th>
                        </tr>
                        <tr class="border-bottom">
                          <th class="pl-0 pt-0 text-left">
                          Seuil d\'alert
                          </th>
                          <th class="pr-0 text-right pt-0">
                              <div class=" fs--2">
                                '.getSeuil().' articles
                            
                              </div>
                          </th>
                        </tr>
                        <tr class="border-bottom">
                          <th class="pl-0 pt-0 text-left">
                          Taxe de dedouanement
                          </th>
                          <th class="pr-0 text-right pt-0">
                              <div class="badge badge-pill badge-soft-warning fs--2">
                                '.getTxDouane() .' %
                            
                              </div>
                          </th>
                        </tr>
                        <tr class="border-bottom">
                          <th class="pl-0 pt-0 text-left">
                          Taxe de Portuaire
                          </th>
                          <th class="pr-0 text-right pt-0">
                              <div class="badge badge-pill badge-soft-warning fs--2">
                                '.getTxPort().' %
                            
                              </div>
                          </th>
                        </tr>
                        <tr class="border-bottom">
                          <th class="pl-0 pt-0 text-left">
                          Marge de Vente
                          </th>
                          <th class="pr-0 text-right pt-0">
                              <div class="badge badge-pill badge-soft-warning fs--2">
                                '.getMgvente() .' %
                            
                              </div>
                          </th>
                        </tr>
                    </table> ';
    	return $output;
    }
  
  // Modification de sms_key
    public function updSms(Request $request)
    {
      $sms_email = $request->email_sms;
      $sms_key   = $request->sms_key;

      setting::where('cle','=','sms_mail')->first()
                    ->update(['valeur'=> $sms_email]);   
      setting::where('cle','=','sms_secret')->first()
                    ->update(['valeur'=> $sms_key]);     
      return response()->json();
    }


  // Modification de sms_key
    public function updEntp(Request $request)
    {
    //  !!!!!!!!!!!!!!!!  Lien des image  !!!!!!!!!!!!!!!! 
      
          // $lien = 'myapp/storage/app/public/';  //en ligne
          $lien = 'storage/';                // en local

        //  !!!!!!!!!!!!!!!!  Lien des image  !!!!!!!!!!!!!!!!!!
         
        // Récupération images
          if(!empty($request->file('imageP')))
          {
            // Récupération du name file  
             $imgP = $request->file('imageP');
            // dossier de stockage
             $path = $imgP->store('logo','public');
            // Chemin d'accès de l'image 
             $logoP = $lien.$path;
            $set = setting::where('cle','=','logo')->first()
                    ->update(['valeur'=> $logoP]);         
          }


          //modif sender SMS
            if (!empty($request->sender)) 
            {
            $taxe = setting::where('cle','=','sender')->first()
                    ->update(['valeur'=> $request->sender]); 
            }
          //modif FACEBOOK LINK
            if (!empty($request->facb)) 
            {
            $taxe = setting::where('cle','=','facebook')->first()
                    ->update(['valeur'=> $request->facb]); 
            }
          //modif whatsapp
            if (!empty($request->whatsAp)) 
            {
              $taxe = setting::where('cle','=','whatsApp')->first()
                    ->update(['valeur'=> $request->whatsAp]);
            } 
          //modif description
            if (isset($request->descrp)) 
            {
              $taxe = setting::where('cle','=','about')->first()
                    ->update(['valeur'=> $request->descrp]);
            } 

      return response()->json();
    }



}
