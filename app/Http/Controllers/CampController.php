<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use DB;
use App\Model\clients;
use App\Model\sms;
use App\Model\interesse;
use App\Model\sms_has_interesse;
use App\Cinetpay\Cinetpay; 

class CampController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

        public function camp(Request $request)
    {
        if (isset($_GET['id'])) {
            //Réception des données
             $id = $request->id;
             if ($id!='') {
                // Traitement des données
                $sms = sms::where('id','=',$id)->get();
                $nb = count($sms);
                if ($nb!=0) {
                    for ($i=0; $i < count($sms) ; $i++) { 
                     // Lancement de SMS
                     //Sendsms($sms[$i]->msg,$clients[$i]->contact,$sender);

                     $titre   = $sms[$i]->titre;
                     $datesms = $sms[$i]->datesms;
                     $descrpt = $sms[$i]->descrpt;
                     $prix    = $sms[$i]->prix;
                     $prixold = $sms[$i]->prixold;
                     $liv     = $sms[$i]->liv;
                     $msg     = $sms[$i]->msg;
                     $img     = $sms[$i]->img;
                     $idP     = $sms[$i]->id;
                    }

                    $shareLink = env('APP_URL').'/camp?id='.$idP;

                    return view('layouts.camp')
                     ->with('titre',$titre)
                     ->with('datesms',$datesms)
                     ->with('descrpt',$descrpt)
                     ->with('prix',$prix)
                     ->with('prixold',$prixold)
                     ->with('liv',$liv)
                     ->with('msg',$msg)
                     ->with('img',$img)
                     ->with('idprd',$idP)
                     ->with('shareL',$shareLink);
                }else{
                   return redirect('/');  
                }
                
             }else{
               return redirect('/'); 
             }
            
        }else{
          return redirect('/');
        }
    }


    public function comd(Request $request)
    {
        // Réception des données
         $nom  = $request->nom;
         $tel  = $request->tel;
         $lieu = $request->lieu;
         $qte  = $request->qte;
         $prod = $request->prod;
         $dateComd = date('d/m/yy');

        // Sélection en fonction de l'id Produit
         $sms = DB::table('sms')->where('id','=',$prod)->first();
           $titre   = $sms->titre;
           $prix    = $sms->prix;
           $liv     = $sms->liv;
         
        // Traitement des données
         if ($nom!=''AND $tel!=''AND $lieu!='') {
            $regnom  = preg_match('#(^([a-zA-z ])+$)#',$nom);
            $regtel  = preg_match('#(^([0-9 ])+$)#',$tel);
            $reglieu = preg_match('#(^([a-zA-z ]+)(\d+)?$)#', $lieu);
            if ($regnom!=0 AND $regtel!=0 AND $reglieu!=0) {

                // Enregistrement de la commandes 
                 $dataP  = [ 'nom'  => $nom,
                             'tel'  => $tel,
                             'lieu' => $lieu
                           ];
                 $inters = interesse::create($dataP);
                 $idInt = $inters->id;

                 $dataInt = [ 'sms_id'       => $prod,
                              'interesse_id' => $idInt,
                              'qte'          => $qte,
                              'montant'      => ($prix*$qte)+$liv,
                              'code'         => date("YmdHis"),
                              'statut'       =>0,
                              'etat'         =>0,
                              'dateCmd'      =>  $dateComd
                            ];
                 $smsRes = sms_has_interesse::create($dataInt);

                // Lancement de l'opération d'achat cinetpay
                 return response()->json([
                    'code' => 0,
                    'message' => 'success',
                    'command' => [
                        'code' => $smsRes->code,
                        'amount' => $smsRes->montant,
                        'designation' => 'Acheter '.$sms->titre.' avec Meneya'
                    ]
                 ], 200);
                    
            }else{

                if ($regnom==0) {
                    $error = "Votre nom doit contenir uniquement que des lettres";
                }
                else if($regtel==0)
                {
                    $error = "Votre numéro de téléphone doit contenir uniquement que de chiffres";
                }
                else if($reglieu==0)
                {
                    $error = "Le champ lieu doit contenir obligatoirement des lettres";
                }

               return response()->json([
                    'code' => '-1',
                    'message' => $error
                ], 500);
            }
         }else{
            return response()->json([
                    'code' => '-1',
                    'message' => 'Veuillez bien remplir le formulaire'
                ], 500);
         }
           

    }	


    // Methode de notification cinetpay
    public function cinetpay_notify(Request $request)
    {
        // Réception des données
         $id_transaction = $request->get("cpm_trans_id");
         
         if ($id_transaction!=null) {
           $apiKey  = config('cinetpay.apiKey');
           $site_id = config('cinetpay.site_id');
           $plateform = config('cinetpay.plateform');
           // Création de l'objet cinetpay
           $CinetPay = new CinetPay($site_id, $apiKey, $plateform);
           // Reprise exacte des bonnes données chez CinetPay
           $CinetPay->setTransId($id_transaction)->getPayStatus();
           $cpm_site_id = $CinetPay->_cpm_site_id;
            $signature = $CinetPay->_signature;
            $cpm_amount = $CinetPay->_cpm_amount;
            $cpm_trans_id = $CinetPay->_cpm_trans_id;
            $cpm_custom = $CinetPay->_cpm_custom;
            $cpm_currency = $CinetPay->_cpm_currency;
            $cpm_payid = $CinetPay->_cpm_payid;
            $cpm_payment_date = $CinetPay->_cpm_payment_date;
            $cpm_payment_time = $CinetPay->_cpm_payment_time;
            $cpm_error_message = $CinetPay->_cpm_error_message;
            $payment_method = $CinetPay->_payment_method;
            $cpm_phone_prefixe = $CinetPay->_cpm_phone_prefixe;
            $cel_phone_num = $CinetPay->_cel_phone_num;
            $cpm_ipn_ack = $CinetPay->_cpm_ipn_ack;
            $created_at = $CinetPay->_created_at;
            $updated_at = $CinetPay->_updated_at;
            $cpm_result = $CinetPay->_cpm_result;
            $cpm_trans_status = $CinetPay->_cpm_trans_status;
            $cpm_designation = $CinetPay->_cpm_designation;
            $buyer_name = $CinetPay->_buyer_name;

            // Recuperation de la ligne de la transaction dans labdd
            $sms = DB::table('sms_has_interesses')->where('code','=',
                $id_transaction)->where('statut',0)->first();

            // Récupération de la ligne du produit dans la bdd
            $produit = DB::table('sms')
                       ->where('id','=',$sms->sms_id)->first();

            // Récupération de la ligne du client dans la bdd
             $client = DB::table('interesses')
                         ->where('id','=',$sms->interesse_id)->first();


            if ($sms) {
              // Vérification
                if ($sms->montant==$cpm_amount) {
                   if ($cpm_result=='00') {
                     // Paiement validé
                     DB::table('sms_has_interesses')->where('code','=',
                        $id_transaction)->update(['statut'=>1]);

                     // Envoie de sms de validation de la commande
                     $qte = $sms->qte;
                     $code = $sms->code;
                     $tel = $client->tel;
                     $produit = $produit->titre;
                     $comercant = getContact();
                     $sender = getSender();

                     $msg = "Nouvelle commande:".$code." /client".$tel."
                     /article:".$produit." /Qte:".$qte;

                     // Lancement du sms de validation
                     Sendsms($msg,$comercant,$sender);

                   }else{
                     // Paiement echoué
                     DB::table('sms_has_interesses')->where('code','=',$id_transaction)->update(['statut'=>-1]);
                   }
                }else{
                    // Vérification echouée
                     DB::table('sms_has_interesses')->where('code','=',$id_transaction)->update(['statut'=>-1]);  
                }

            }
            return 'ok';
         }
    }
}

?>