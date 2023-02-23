<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use Mail;
use DB;
use App\Mail\MailAbonnement;
use App\Mail\AlertExpireAbonnement;
use App\Mail\MailSms;
use App\Model\offres;
use App\Model\abonnement;
use App\Model\paiement;
session_start();


class abonmntControl extends Controller
{

	//Pour le form de renouvellement abonnement  
        public function updForfait()
        {
            if(isSuperAdmin())
            {
                return view('pages.dash.abonnement.updForfait');
            }
            return '<script> window.location.href="/login"</script>';
        }

    //Page de notification du forfait expirer
        public function forfaitDown()
        {
            if(Auth::id())
            {
                return view('layouts.forfaitDown');
            }
            else
            {
              return redirect('/login');  
            }
        }


    //Envoi de mail d'alert d'expiration d'abonnement
        public function alertAbonmnt(Request $request)
        {
            $lastNotif = getSettingByName('notifExpiration');

            //Conversion de la date de derniere notification
            $lastNotif = date_create_from_format('d/m/Y', $lastNotif)
                ->format('d-m-Y');   
            //Calcul du timestamp de chaqe date
            $tstanpLast = strtotime($lastNotif);
            $tstanpNow = strtotime(date('d-m-Y'));
            //Calcul du temps ecouler entre today et lastNotif
            $ecart = $tstanpNow - $tstanpLast ; //Timestamp de l'ecart

            $ecart2J = 86400*2; //Timestamp de deux jour

            if ($ecart >=$ecart2J) 
            {
                //Le mail es envoyé ssi la date d'ancienne notification
                // et celle d'aujourdhui vaut 02
                $abn = offres::find($request->offre);
                $offre = $abn->libele; 
                $montant = $abn->montant; 
                $domaine ='http://'.getSettingByName('domaine');
                Mail::to(getSettingByName('alertMail'))->queue(new AlertExpireAbonnement($request->nbrJrst,$offre,$domaine)); 
                setSettingByName('notifExpiration',date('d/m/Y'));
            } 
            return response()->json();    
        }

    //Page de notification du forfait expirer
        public function suscribeTry(Request $request)
        {
            //Reception des données
            $email = Auth::user()->email;

            $abn = offres::find($request->offre);
            $offre = $abn->libele; 
            $domaine ='http://'.getSettingByName('domaine');
            $pass = Auth::user()->localite;


            //Lecture de l'offre selectionner
             $abn = offres::find($request->offre);
             $offre = $abn->libele; 
          

            //Traitement des données pour la transaction monétaire
              $amount;      
              $trans_id=date("YmdHis");    
              $designation="Ouverture de compte Meneya ".$offre;
              $date_debut=date('d/m/Y');  
              $date_fin=date('d/m/Y',strtotime('+1 month'));    

              // Verification du dernier abonnement
              if (isEssaie()) 
              {
                //Cas de l'essaie:: montant de l'inscription
                 $amount = $abn->prixInscription;
              }
              else
              {
                //Cas de l'offre:: montant de l'abonnement de l'offre
                 $amount = $abn->Coutabonnement;
              }

            // Data de  l'abonnement
              $_SESSION['dateDebut']     = $date_debut;
              $_SESSION['dateFin']       = $date_fin;
              $_SESSION['codepaiement']  = $trans_id;
              $_SESSION['offres_id']     = $abn->id;
              $_SESSION['amount']        = $amount;

            // Enregistrement du paiement
              $dataPay =[
                          'codepaiement'=>$trans_id,
                          'amount'=>$amount,
                          'statuPaiement'=>0
                        ];
             paiement::create($dataPay);

            
              
            // Lancement du paiement
             return response()
                   ->json([
                           'amount'=>$amount,
                           'trans_id'=>$trans_id,
                           'designation'=>$designation
                          ]);             
        }


    // Function de vérification de paiement_abonnement Meneya
     public function cinetpay_notify_abonment(Request $request)
     {
        //Reception des données
         $id_transaction = $request->get("cpm_trans_id");
         if ($id_transaction!=null)
         {
           $apiKey  = config('cinetpay.abonmentApikey');
           $site_id = config('cinetpay.abonmentSiteid');
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

            // Vérification de la transaction
             $paiement = DB::table('paiements')
                         ->where('codepaiement','=',$id_transaction)
                         ->first();
             if($paiement)
             {
                if ( $_SESSION['amount']==$cpm_amount) 
                {
                  // Paiement validé
                    if ($cpm_result=='00') {
                     // paiement validé
                        DB::table('paiements')->where('codepaiement','=',
                         $id_transaction)->update(['statuPaiement'=>1]);

                        // Vérification d'un abonnement actif
                         $abonActif = getAbnmnt();
                         if($abonActif)
                         {
                           $abonmnt = DB::table('abonnements')
                            ->where('id',$abon->id )
                            ->update(['statuPaiement' => 0]);
                         }


                     // Enregistrement de l'abonnement
                        $abon = [
                                 'dateDebut'=>$_SESSION['dateDebut'],
                                 'dateFin'=>$_SESSION['dateFin'],
                                 'statuPaiement'=>1,
                                 'codepaiement'=>$_SESSION['codepaiement'],
                                 'offres_id'=>$_SESSION['offres_id']
                                ];
                        abonnement::create();

                     // Notification mail au support
                        Mail::to(getSettingByName('supportMail'))->queue(new MailAbonnement($email,$offre,$domaine,$pass));

                    }
                }
             }
             else
             {
                echo "novalidate";
             }
            
         }
     }


    // Vérification de paiement abonnement_sms
     public function cinetpay_notify_sms(Request $request)
     {
        // Réception des données
         $id_transaction = $request->get("cpm_trans_id");
         if ($id_transaction!=null) 
         {
            $apiKey  = config('cinetpay.smsApikey');
            $site_id = config('cinetpay.smsSiteid');
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

            // Vérification de la transaction
              $paiement = DB::table('paiements')
                         ->where('codepaiement','=',$id_transaction)
                         ->first();
               if($paiement)
               {
                  // Paiement validé
                   if ($cpm_result=='00')
                   {
                      DB::table('paiements')->where('codepaiement','=',
                         $id_transaction)->update(['statuPaiement'=>1]);
                      // Notification mail au support
                       $montant = $_SESSION['sms_amount']." cfa";

                       Mail::to(getSettingByName('supportMail'))->send(new MailSms(Auth::user()->email,
                        getSettingByName('domaine'),
                        Auth::user()->localite,
                        getSettingByName('sms_mail'),
                        getSettingByName('sms_secret'),
                        $montant
                       ));
                   }

                  
               }
               else
               {

               }

         }
     }

    // apel ajax de formate price
        public function formatPriceJs(Request $request)
        {
            $prix = formatPrice($request->prix);
            return $prix;
        }
          
    //Vue de mon abonnement 
        public function myAbonmnt()
        {
            if(isSuperAdmin())
            {
                return view('pages.dash.abonnement.myAbonmnt');
            }
            return '<script> window.location.href="/login"</script>';

        }

    // Abonnement sms
     public function sms_credit(Request $request)
     {
        if(isSuperAdmin())
        {
         return view('pages.dash.abonnement.sms_credit');
        }
        return '<script> window.location.href="/login"</script>';
     }

    // Rechargement de sms
     public function suscribe_sms(Request $request)
     {
        // Réception des données
         $amount = $request->sms;
         $email = Auth::user()->email;
         $domaine =getSettingByName('domaine');
         $pass = Auth::user()->localite;
         $trans_id=date("YmdHis"); 
         $designation = "Rechargement  SMS";
         $_SESSION['sms_amount'] = $amount;
         $montant = $_SESSION['sms_amount']." cfa";


        // Enregistrement dans la table paiement
         $dataPay =['codepaiement'=>$trans_id,
                   'amount'=>$amount,
                   'statuPaiement'=>0
                  ];
         paiement::create($dataPay);


        // Traitement des données 
        return response()
                   ->json([
                           'amount'=>$amount,
                           'trans_id'=>$trans_id,
                           'designation'=>$designation
                          ]);
     }

}
