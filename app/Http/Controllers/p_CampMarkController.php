<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use DB;
use App\Model\clients;
use App\Model\sms;
use App\Model\interesse;
use App\Model\sms_has_interesse;


class p_CampMarkController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    // Formulaire pour créer une campagne marketing
    public function CampgNew()
    {
        //Sender
         $setting = DB::table('settings')->where('cle','=','sender')->get();
         for ($i=0; $i < count($setting); $i++) {
           $sender = $setting[$i]->valeur;
         }

        // Nombe Total de Clients
        $clients = DB::table('clients')->where('statutClt', 1)->get();
        $nbclient = count($clients);

        // Nombre total de prospects
        $prosp = DB::table('clients')->where('statutClt', 0)->get();
        $nbprosp = count($prosp);



         return view('pages.principale.marketing.p_campNew')
                ->with('sender',$sender)
                ->with('clients',$nbclient)
                ->with('prospect',$nbprosp);
    }


    // Envoie de SMS
    public function smsPro(Request $request)
    {
        // Récupération des données
         $lien = env('FILE_STORAGE_LINK_OFFLINE');
         $sender  = $request->sender;
         $photo   = $request->file('photo');
         $titre   = $request->titre;
         $prix    = $request->prix;
         $prixold = $request->prixold;
         $liv     = $request->liv;
         $descrp  = $request->descrp;
         $smsPr   = $request->smsPr;
         $cible   = $request->cible2ID;
         $date = date('d/m/Y');

        // Traitement des données
         $path = $photo->store('Product','public');
         $photoF = $lien.$path;

        // Save dans la table sms
         $data = ['datesms'=>$date,
                  'titre'  =>$titre,
                  'descrpt'=>$descrp,
                  'prix'   =>$prix,
                  'prixold'=>$prixold,
                  'liv'    =>$liv,
                  'msg'    =>$smsPr,
                  'img'    =>$photoF,
                 ];

         $product = sms::create($data);
         $idProduct = $product->id;
        // Liens de partages
         $shareLink = env('APP_URL').'/camp?id='.$idProduct;
         $MsgF = $smsPr.'.cliquez sur '.$shareLink." pour voir";

        // Lecture des numéros clients et envoie du message
         //$clients = clients::all();
         $clients = DB::table('clients')->where('statutClt', $cible)->get();
         $nb = count($clients);

         if ($nb!=0)
         {
           for ($i=0; $i < count($clients) ; $i++)
           {
             Sendsms($MsgF,$clients[$i]->contact,$sender);
           }

             if ($cible==0) {
               $alert="Vos prospects ont bien reçu la campagne";
             }
             else {
               $alert="Vos clients ont bien reçu la campagne";
             }


         }
         else {
           if ($cible==0) {
             $alert="Votre campagne a échoué car vous n'avez aucun prospects";
             DB::table('sms')->where('id', '=',$idProduct)->delete();

           }
           else {
             $alert="Votre campagne a échoué car vous n'avez aucun client";
             DB::table('sms')->where('id', '=',$idProduct)->delete();
           }
         }


         return redirect('/smspromo?alert='.$alert);

    }

    // Formulaire pour l'historique des campagnes
    public function CampgList()
    {
        $smsAll = sms::all();
        $shareL = '/camp?id=';
        return view('pages.principale.marketing.p_campList')
                ->with('smsL',$smsAll)
                ->with('shareL',$shareL);
    }


    // Campagne marketing SMS Groupée aux clients
    public function sendNSMS(Request $request)
    {
        // Réception des données
         $smsPn = $request->smsPn;
         $sender = $request->sender;
         $cible = $request->cible;
        // Filtre des clients
         $clients = DB::table('clients')->where('statutClt', $cible)->get();
         $nb = count($clients);
         // dd($clients);
         if ($nb!=0)
         {
           for ($i=0; $i < count($clients) ; $i++)
           {
             $datasms = Sendsms($smsPn,$clients[$i]->contact,$sender);
           }
            // dd($datasms);

             if ($cible==0) {
               echo "Vos prospects ont bien reçu la campagne";
             }
             else {
               echo "Vos clients ont bien reçu la campagne";
             }


         }else {
           if ($cible==0) {
             echo "Vous n'avez aucun prospects";
           }
           else {
             echo "Vous n'avez aucun client";
           }
         }

    }

    // Vider l'historique sms
    public function emptySMS(Request $request)
    {
      sms_has_interesse::where('sms_id','=',$request->idsms)->delete();
      sms::where('id','=',$request->idsms)->delete();
    }

    // Livrer une commande
    public function ComdLiv(Request $request)
    {
        // Réception des données
         $smsId   = $request->SMSID;
         $interID = $request->idInters;
         $etat    = 1;
        // Traitemente des données
         sms_has_interesse::where('sms_id','=',$smsId)
                        ->where('interesse_id','=',$interID)
                        ->update(['etat'=>$etat]);
         echo "Commandes livrées avec succès";
    }

    // Supprimer toutes les commandes
    public function p_DelCdAll(Request $request)
    {
        // Réception des données
         $action = $request->action;
         $new = 0;
         $livr = 1;
        // Traitement des données
         if ($action=='new') {
            sms_has_interesse::where('etat','=',$new)->delete();
         }else{
            sms_has_interesse::where('etat','=',$livr)->delete();
         }
         echo "Supprimer avec succès";
    }

    // Détails d'une commande
     public function comdShow(Request $request)
     {

        // Réception des données
         $idInters = $request->idInters;
         $SMSID    = $request->SMSID;

        // Traitement des données
         $comd = DB::table('sms_has_interesses')
                ->join('sms','sms_has_interesses.sms_id','=','sms.id')
                ->join('interesses','sms_has_interesses.interesse_id','=','interesses.id')
                ->select('sms.*','interesses.*','sms_has_interesses.*','sms.id as SMSID','interesses.id as InterID')
                ->where('sms.id','=',$SMSID)
                ->where('interesses.id','=',$idInters)
                ->get();
               // dd($comd);
        // Résultat du traitement
         foreach ($comd as $value) {
            if ($value->liv==null) {
                $liv = 0;
            }else{
                $liv= $value->liv;
            }
           echo '
           <div class="row">

                <div class="col-lg-12">
                    <h5>Produit: '.$value->titre.'</h5>

                    <a class="fs--1 mb-2 d-block text-warning" href="#!"><b>
                    Code commande: '.$value->code.'</b></a>

                    <a class="fs--1 mb-2 d-block text-dark" href="#!">
                    Qte commandé: '.$value->qte.'</a>

                    <a class="fs--1 mb-2 d-block text-dark" href="#!">
                    Prix promo: '.$value->prix.' '.getMyDevise().'</a>

                    <a class="fs--1 mb-2 d-block text-dark" href="#!">
                    Prix ancien:<del class="mr-1"> '.$value->prixold.' '.getMyDevise().'</del>
                    </a>


                    <a class="fs--1 mb-2 d-block text-dark" href="#!">
                     Livraison: '.$liv.' '.getMyDevise().'</a>

                    <a class="fs--1 mb-2 d-block text-dark" href="#!">
                    Montant: '.$value->montant.' '.getMyDevise().'</a>

                    <p class="fs--1">'.$value->descrpt.'</p>
                    --------------------------------------------------
                </div>
              </div>
            ';
         }


     }

    // Suppression d'une nouvelle commande
    public function ComdDel(Request $request)
    {
        // Réception des données
         $smsId   = $request->SMSID;
         $interID = $request->idInters;
        // Traitement des données
         sms_has_interesse::where('interesse_id','=',$interID ,'AND','sms_id','=',$smsId)->delete();
         echo "Supprimer avec succès";
    }

    // Nouvelle des commandes
    public function CommdNew(Request $request)
    {
        $pagePath =  $request->path();
        $perPage  =  setDefault($request->perPage,25);
        $comd = DB::table('sms_has_interesses')
                ->join('sms','sms_has_interesses.sms_id','=','sms.id')
                ->join('interesses','sms_has_interesses.interesse_id','=','interesses.id')
                ->select('sms.*','interesses.*','sms_has_interesses.*','sms.id as SMSID','interesses.id as InterID')
                ->where('sms_has_interesses.etat','=',0)
                ->paginate($perPage);
        $nbt = count($comd);
        return view('pages.principale.marketing.commd')
               ->with('comd',$comd)
               ->with('nbt',$nbt)
               ->with('pagePath',$pagePath)
               ->with('perPage',$perPage);
    }

    // Commandes livrées
    public function CommdLvr(Request $request)
    {
        $pagePath =  $request->path();
        $perPage  =  setDefault($request->perPage,25);
        $comd = DB::table('sms_has_interesses')
                ->join('sms','sms_has_interesses.sms_id','=','sms.id')
                ->join('interesses','sms_has_interesses.interesse_id','=','interesses.id')
                ->select('sms.*','interesses.*','sms_has_interesses.*','sms.id as SMSID','interesses.id as InterID')
                ->where('sms_has_interesses.etat','=',1)
                 ->paginate($perPage);;
        $nbt = count($comd);
        return view('pages.principale.marketing.commLivr')
               ->with('comd',$comd)
               ->with('nbt',$nbt)
               ->with('pagePath',$pagePath)
               ->with('perPage',$perPage);

    }





}
