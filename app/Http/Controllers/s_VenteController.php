<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\ventes_succursales;
use App\Model\produits_has_ventes_succursales;
use App\Model\stock_succursales;
use App\Model\clients;
use App\Model\credits;
// use App\Model\produits_has_ventes_succursales;



use Auth;
use Schema;
use DB;
session_start();

class s_VenteController extends Controller
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




    // Toutes les ventes de succu
        public function s_Vente(Request $request)
        {
            // lecture de toute les vente de la succursale
          if(!isset($request->type)){$request->type =1;}
            switch ($request->type) {
              case 0:
                $type= 0;
                $typeName ='Factures proformat';
                $typeVnt = 'Facture proformat';
                break;
              case 1:
                $type= 1;
                $typeName ='Mes Ventes Soldées';
                $typeVnt = 'Facture d\'achat';
                break;
              case 2:
                $type= 2;
                $typeName ='Ventes Non Soldées';
                $typeVnt = 'Facture de crédit';
                break;
              default:
                $type= 1;
                $typeName ='Mes Ventes Soldées';
                $typeVnt = 'Facture d\'achat';

                break;
            }
            $suc = userHasSucc(Auth::id());     //Recup succursae info
            $pagePath =  $request->path();      //Recu path url for paginate
            $perPage = setDefault($request->perPage,25);

          //Selection des vente selon le type demande
            $ventes = ventes_succursales::where('typevente','=',$type)
                        ->where('succursale_id','=',$suc->id)
                        ->orderBy('id','desc')
                        ->paginate($perPage);
                        // dd($ventes);
          return view('pages.succursale.vente.s_Vente')
                              ->withVentes($ventes)
                              ->withTypevente($typeName)
                              ->withFactureTitre($typeVnt)
                              ->with('pagePath',$pagePath)
                              ->with('perPage',$perPage);
        }


    //Formulaire d'Ajout de vente 
        public function Addvente()
        {
                //Recup Clients de  la succursale 
                $suc = userHasSucc(Auth::id());
                $clt = allCltSuc($suc->id);
            return view('pages.succursale.vente.addVente')->with('Clt',$clt);
        }

    //Recuperation des prds
      public function ajaxRecupPrdSuc( Request $request)
        {

            $search = htmlentities($request->q);
            $search = htmlspecialchars($search);
            $produits = DB::table('stock_succursales')
                ->join('produits', 'produits.id', '=', 'stock_succursales.produits_id')
                ->select('produits.*','produits.id as prdId','stock_succursales.*')
                ->where('stock_Qte','>=',1)
                ->where('stock_succursales.succursale_id','=',userHasSucc(Auth::id())->id)
                ->where('produits.produitLibele','LIKE','%'.$search.'%')
                ->get();
                $data = array();
                foreach ($produits as  $produit) 
                {
                  if ($produit->image =="") 
                  {
                    $produit->image = "assets/img/illustrations/falcon.png";
                  }
                  $data[] = array(
                          "id" => $produit->prdId,
                        "node_id" =>'node'.$produit->prdId,
                          "libelle" => $produit->produitLibele,
                          "text" => $produit->produitLibele,
                          "prixPrd" =>$produit->sucCoutAchat ,
                          "sucId" =>$produit->succursale_id ,
                        "prixPrdFormat" =>formatPrice($produit->sucCoutAchat),
                        "qteInStck" => isInSession('achatP','article',$produit->prdId,$produit->stock_Qte),
                        'image' =>$produit->image,
                      );

                }

                $tab = ["total_count" => 1,"incomplete_results" => false,'items'=>$data];


             echo json_encode($tab);
             exit();




        }

    //Enregistrement d'un produit dns le panier
      public function savePrdAchatSuc(Request $request)
        {
            // Ajax validation et retour
            //Verification de la quantite du produit en stock
            //Création des panier 
             if (isset($_SESSION['achatP'])) 
                 {
                    $item_array = array(
                     'qte'      => $request->quantite,
                     'prix'     => $request->prix,
                     'article'     => $request->article,
                     );
                    $_SESSION["achatP"][] = $item_array;
                  }
              else{

                $item_array = array(
                     'qte'      => $request->quantite,
                     'prix'     => $request->prix,
                     'article'     => $request->article,
                 );

                //Création de session
                 $_SESSION["achatP"][] = $item_array;

                 //Info commande
                    $_SESSION["clientId"] = $request->clientId;
                    $_SESSION["clientNom"] = trim($request->clientNom);

                  }

                   return response()->json();
           }



    //Liste des produits de la vente en session
      public function lPrdAchat()
          {
             return view('pages/succursale/vente/lPrdAchat'); 
          }

    //Supression de la vente en session
      public function delAchatSuc()
        {
            unset($_SESSION['achatP']);
            unset($_SESSION['clientId']);
            unset($_SESSION['clientNom']);

            if(isset($_SESSION['typeVente']))
            {
                $tab =[
                        'idVnt' => $_SESSION['idVnt'],
                        'type'  => $_SESSION['typeVente'],
                      ];
                unset($_SESSION['idVnt']);
                unset($_SESSION['typeVente']);
                return json_encode($tab);
            }
            else
            {
              return response()->json();
            }

        }

    //Supression d'un produit de la  vente en session
      public function delPrdAchatSuc(Request $request)
        {
          $nbr =(int)$request->idPrd; //conversion de la variable en entier
          unset($_SESSION['achatP'][$nbr]);
          return response()->json();

        }


    //Enregistrer un achat 
      public function saveAchatSuc(Request $request)
          {
                $suc =userHasSucc(Auth::id());
                  if (!empty($_SESSION['achatP']))
                      {
                        //Generation du matricule vente                        
                          $id = ventes_succursales::max('id') + 1;
                          $mat = "Vnt".$id.'#'.date('d/m/y');
                          //creation de la vente
                            $vente = ventes_succursales::create([
                                      'NumVente'=> $mat,
                                      'clients_id' => $_SESSION['clientId'],
                                      'dateV' => $request->dateV,
                                      'charge' => setDefault($request->charge,0),
                                      'description_charge' => setDefault($request->chargeLibelle,""),
                                      'typevente' => setDefault($request->type,"0"),
                                      'succursale_id' =>$suc->id,
                                    ]);
                            

                          //Intialisation de variable pour les totaux
                                  $prix_vente_total = 0;
                                  $qte = 0;
                                  $cout_achat_total = 0;
                          foreach ($_SESSION['achatP'] as $key => $value)
                              {
                                //recuperation du stock du prd
                                  $produit = stock_succursales::where('succursale_id','=', $suc->id)->where('produits_id','=',$value['article'])->first();

                                        $prdVnte = ["prixvente" => $value['prix'],
                                                    "coutAchat"=>$produit->sucCoutAchat,
                                                          "qte"=> $value['qte'],
                                            "ventes_succursales_id" => $vente->id,
                                                "produits_id"  =>$value['article'],
                                                         "tva" => getPrd($value['article'])->tva,
                                                  ];
                                      //Cumul des valeur pour les totaux
                                        $prix_vente_total += $value['prix']*$value['qte'];
                                        $cout_achat_total += $produit->sucCoutAchat*$value['qte'];
                                        $qte += $value['qte'];


                                      //Enregistrement du produits vendu
                                      produits_has_ventes_succursales::create($prdVnte);

                                      //Verification du type d'operation
                                      // '0 => facture proformat / 1 => Vente'
                                      if($request->type == '1' || $request->type == '2' )
                                      {

                                        //mise a jour du stock de ce produit
                                          if( $produit->stock_Qte >= $value['qte'])
                                          {
                                            $produit->stock_Qte = $produit->stock_Qte - $value['qte'];

                                            //Compare le stock restant au seuil d'alert
                                              if ($produit->stock_Qte <= getPrd($value['article'])->seuilAlert ) 
                                              {
                                                  //Déclenchement d'alert

                                              }
                                          }
                                          else
                                          {
                                            $produit->stock_Qte = 0;
                                            //Declenchement d'alert
                                          }

                                      }

                                  $produit->save(); 


                              }


                            if ($request->type != '0') 
                            {
                              $clt = clients::find($_SESSION['clientId']);
                              $clt->statutClt = 1;
                              $clt->save();
                            }
                            //Type = 2  enregistrement du credit contracté
                            if($request->type == '2')
                                {
                                  $creditInfo = [
                                        'creditEcheance' =>$request->dateEch,
                                        'creditMontant' =>$request->mntCrd,
                                        'creditStatut'=>0,
                                        'creditDate' =>$request->dateV,
                                        'description' => 'Crédit pour la vente '.$mat,
                                        'vente_id' =>$vente->id,
                                        'sucId' =>$suc->id,
                                                          ];

                                          credits::create($creditInfo);
                                }

                            $vente->qte = $qte;
                            $vente->cout_achat_total = $cout_achat_total;
                            $vente->prix_vente_total = $prix_vente_total;
                            $vente->mg_benef_brute = $prix_vente_total - $cout_achat_total;
                            $vente->mg_benef_rel = $prix_vente_total - ($cout_achat_total);
                            $vente->save();
                      }

                  //Pour Retour front end     
                    $_SESSION['typeVente'] = $vente->typevente;
                    $_SESSION['idVnt'] = $vente->id;

                return $this->delAchatSuc();
            }


      //Impression reçu d'une vente
    public function recuVntSuc(Request $request)
    {

            $vente = ventes_succursales::find($request->NumVente);
            $cltNom = getClient($vente->clients_id);
             $prdVnt = DB::table('produits_has_ventes_succursales')
            ->join('produits', 'produits.id', '=', 'produits_has_ventes_succursales.produits_id')
            ->select('produits.*', 'produits_has_ventes_succursales.*')
            ->where('ventes_succursales_id','=',$vente->id)
            ->get();
                  //Variable contenant la somme total investir
                  $somTotal = 0;

            $output ='
              <div class="row justify-content-between align-items-center">
                <div class="col">
                  <h6 class="text-500">Facture à </h6>
                  <h5>'.$cltNom->nom.'</h5>
                  <p class="fs--1">
                   <b style="color:red"><u>'.$cltNom->contact.'</u></b>
                  </p>
                </div>
                <div class="col-sm-auto ml-auto">
                  <div class="table-responsive">
                    <table class="table table-sm table-borderless fs--1">
                      <tbody>
                        <tr>
                          <th class="text-sm-right">N° de commande:</th>
                          <td>'.$vente->NumVente.'</td>
                        </tr>
                        <!--<tr>
                          <th class="text-sm-right">Order Number:</th>
                          <td>AD20294</td>
                        </tr>-->
                        <tr>
                          <th class="text-sm-right">Date de la facture:</th>
                          <td>'.$vente->dateV.'</td>
                        </tr>
                        <!--<tr>
                          <th class="text-sm-right">Paiement dû:</th>
                          <td>Dès réception</td>
                        </tr>-->
                        <tr class="alert-success font-weight-bold">
                          <th class="text-sm-right">Montant dû:</th>
                          <td>'.formatPrice($vente->prix_vente_total+$vente->charge).'</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>


              <div class="table-responsive fs--1">
                <table class="table table-striped border-bottom">
                  <thead class="bg-200 text-900">
                    <tr>
                      <th class="border-0">Produit</th>
                      <th class="border-0 text-center">Qte</th>
                      <th class="border-0 text-center">Prix de vente unitaire</th>
                      <th class="border-0 text-right">Montant Total</th>
                    </tr>
                  </thead>
                  <tbody >';
            for ($i=0; $i < count($prdVnt) ; $i++){
              $output .='<tr>
                      <td class="align-middle">
                        <h6 class="mb-0 text-nowrap"> 
                        '.$prdVnt[$i]->produitLibele.' </h6>
                      </td>
                      <td class="align-middle text-center">
                       '.$prdVnt[$i]->qte.' 
                         '.$prdVnt[$i]->unite_mesure.'</td>
                      <td class="align-middle text-center">
                       '.$prdVnt[$i]->prixvente.' '.getMyDevise().'</td>
                      <td class="align-middle text-right">
                       '.formatPrice($prdVnt[$i]->qte * $prdVnt[$i]->prixvente).'
                      </td>
                    </tr>';
                     $somTotal += $prdVnt[$i]->prixvente * $prdVnt[$i]->qte;
                  }

      // Calcul de la charges liées à la sorties
           if ($vente->charge!= 0) 
            {
              $charges = $vente->charge;
              $charge_description = $vente->description_charge;
                    $out= '<tr>
                                <th class="text-900">'.$charge_description.'</th>
                                <td class="font-weight-semi-bold">'.
                                 formatPrice($charges).'
                                </td>
                              </tr>';

            }
           else{$out=''; $charges = 0; }


                // Calcul du montant total TTC
                  $ttc = $charges+$somTotal;
          $output .='</tbody>
                </table>
              </div>
              <div class="row no-gutters justify-content-end">
                <div class="col-auto">
                  <table class="table table-sm table-borderless fs--1 text-right">
                    
                    <tr>
                      <th class="text-900">Sous-total:</th>
                      <td class="font-weight-semi-bold">
                        '.formatPrice($somTotal).'
                       </td>
                    </tr>'.$out.'               
                    <tr class="border-top text-danger">
                      <th class="text-900">Montant TTC:</th>
                      <td class="font-weight-semi-bold text-danger"> '.formatPrice($ttc).'</td>
                    </tr>
                  </table>
                </div>
              </div>';

              return $output;

            
  }

    //Validation d'une facture proformat
      public function validVntSuc(Request $request)
          {

            $vente= ventes_succursales::find($request->idVnt);
            $vente->typevente = 1;    // '0 => facture proformat / 1 => Vente'
                    $clt = clients::find($vente->clients_id);
                    $clt->statutClt = 1;
                    $clt->save();
                //Recuperation des produits vendu
                $prdVnts = produits_has_ventes_succursales::where('ventes_succursales_id','=',$vente->id)->get();

                          //insertion de la vente
                          foreach ($prdVnts as $key => $value)
                              {
                                      //Creation ou mise a jour du stock de ce produit
                                          // dd($value);

                                          $produits = stock_succursales::firstOrCreate(
                                          ['produits_id' => $value['produits_id'],
                                          'succursale_id' =>$vente->succursale_id ],
                                          ['stock_Qte' => 0 ]);

                                          if( $produits->stock_Qte >= $value['qte'])
                                          {
                                            $produits->stock_Qte = $produits->stock_Qte - $value['qte'];

                                            //Compare le stock restant au seuil d'alert
                                              if ($produits->stock_Qte <= getPrd($value['produits_id'])->seuilAlert ) 
                                              {
                                                  //Déclenchement d'alert

                                              }
                                          }
                                          else
                                          {
                                            $produits->stock_Qte = 0;
                                            //Déclenchement d'alert
                                          }

                                            $produits->save();                                      
                                            $vente->save();


                              }

            return response()->json();
          }


  //Edition d'une vente 
      public function editVntSuc(Request $request)
      {
        $vente= ventes_succursales::find($request->idV);
        $clt = getClient($vente->clients_id);

             $prd = DB::table('produits_has_ventes_succursales')
            ->join('produits', 'produits.id', '=', 'produits_has_ventes_succursales.produits_id')
            ->select('produits.*', 'produits_has_ventes_succursales.*')
            ->where('ventes_succursales_id','=',$request->idV)
            ->get();
            return view('pages/succursale/vente/editVntSuc')->with('vente',$vente)
                                                            ->with('clt',$clt)
                                                            ->with('prd',$prd);
      }

    //Supression d'un produit dune vente deja enregistrer
      public function delPrdVntSuc(Request $request)
        {
          $vente= ventes_succursales::find($request->idVnt);
          $prd= produits_has_ventes_succursales::find($request->idPrd);

          //Soustraction du montant du prd  et upd de la vnt
            $prixVntPrd = $prd->prixvente * $prd->qte;
            $coutAchaPrd = $prd->coutAchat * $prd->qte;

            $vente->cout_achat_total = $vente->cout_achat_total- $coutAchaPrd;
            $vente->prix_vente_total = $vente->prix_vente_total - $prixVntPrd;

            $vente->mg_benef_brute = $vente->prix_vente_total - $vente->cout_achat_total;
            $vente->mg_benef_rel = $vente->prix_vente_total - ($vente->cout_achat_total);
            $vente->qte = $vente->qte- $prd->qte;

          //Verification du type de vente ( 0 => facture pro //  1 => vente)
            if ($vente->typevente==1) 
            {
              # Actualisation du stock principale
              $prdStck =stock_succursales::
                                  where('succursale_id','=',$vente->succursale_id)
                                  ->where('produits_id','=',$prd->produits_id)->first();
               
                $prdStck->stock_Qte = $prdStck->stock_Qte + $prd->qte;
                $prdStck->save(); 

            }


            $vente->save();
            
            $prd->delete();

            return response()->json();
        }  

    //Mis a jour d'un achat
      public function updAchatSuc(Request $request)
          {
            $vente= ventes_succursales::find($request->idVnt);
              $vente->charge = $request->charge;
              $vente->description_charge = $request->chargeLibelle;
              $vente->typevente = $request->type;
              $vente->dateV = $request->dateV;
              $vente->mg_benef_rel = $vente->prix_vente_total - ($vente->cout_achat_total + $request->charge);
              $vente->save();
                //Recuperation des produits vendu
                $prdVnts = produits_has_ventes_succursales::where('ventes_succursales_id','=',$vente->id)->get();
                          //insertion de la vente
                          foreach ($prdVnts as $key => $value)
                              {
                                     //Verification du type d'operation
                                      // '0 => facture proformat / 1 => Vente'
                                      if($request->type == '1')
                                      {

                                        //Creation ou mise a jour du stock de ce produit
                                          $produits = stock_succursales::firstOrCreate(
                                          ['produits_id' => $value['produits_id']],
                                          ['stock_Qte' => 0 ]);
                                          if( $produits->stock_Qte >= $value['qte'])
                                          {
                                            $produits->stock_Qte = $produits->stock_Qte - $value['qte'];

                                            //Compare le stock restant au seuil d'alert
                                              if ($produits->stock_Qte <= getPrd($value['produits_id'])->seuilAlert ) 
                                              {
                                                  //Déclenchement d'alert

                                              }
                                          }
                                          else
                                          {
                                            $produits->stock_Qte = 0;
                                            //Declenchement d'alert
                                          }

                                            $produits->save();                                      
                                      }


                              }



            return response()->json();
          }


  //supression vente de la pricipales
    public function delVntSuc(Request $request)
        {
             // produits_has_vente_principales::where('vente_principales_id', '=', $request->idVente)->delete();
             ventes_succursales::where('id','=',$request->idVente)->delete();

            return response()->json();
        }

    //Detail d'une vente de la principale
      public function ajaxDetailVntSuc(Request $request)
      {
        $vente= ventes_succursales::find($request->NumVente);

             $OpTion = DB::table('produits_has_ventes_succursales')
            ->join('produits', 'produits.id', '=', 'produits_has_ventes_succursales.produits_id')
            ->select('produits.*', 'produits_has_ventes_succursales.*')
            ->where('ventes_succursales_id','=',$request->NumVente)
            ->get();

                $total= 0;
             $output ='';
             $output.='
                <div class="table-responsive fs--1">
                    <table class="table table-striped border-bottom">
                      <thead class="bg-200 text-900">
                        <tr>
                          <th class="border-0">Article</th>
                          <th class="border-0 text-center">Cout d\'achat </th>
                          <th class="border-0 text-center">Prix de vente </th>
                          <th class="border-0 text-center">Qté</th>
                          <th class="border-0 text-right">Prix Net</th>
                        
                        </tr>
                      </thead>
                      <tbody>';
                    for ($i=0; $i < count($OpTion) ; $i++){
                     $output.='
                        <tr>
                          <td class="align-middle">'.$OpTion[$i]->produitLibele.'</td>
                          <td class="text-center">'.$OpTion[$i]->coutAchat.'</td>
                          <td class="text-center">'.$OpTion[$i]->prixvente.'</td>
                          <td class="text-center">'.$OpTion[$i]->qte.'</td>
                          <td class=" text-right">'.$OpTion[$i]->prixvente * $OpTion[$i]->qte .'</td>
                        </tr>';
                        $total += $OpTion[$i]->prixvente * $OpTion[$i]->qte; 
                     }
                $output.='
                      </tbody>
                    </table>
                  </div>
                  <div class="row no-gutters justify-content-end">
                    <div class="col-auto">
                      <table class="table table-sm table-borderless fs--1 text-right">';
                    $total = $total+$vente->charge;
                          if($vente->charge !=0)
                          {
                            $output.='
                                <tr class="">
                                  <th class="text-900 ">'.$vente->description_charge.' :</th>
                                  <td class="font-weight-semi-bold">'.formatPrice($vente->charge).'</td>
                                </tr>';
                          }
                    $output.='
                        <tr class="text-danger">
                          <th class="text-900 text-danger">Total TTC:</th>
                          <td class="font-weight-semi-bold">'.formatPrice($total).'</td>
                        </tr>';
                    $output.='    
                      </table>
                    </div>
                  </div>
             ';
             // dd($output);
             return $output;
      }

























    //Liste Produit de la vente
        public function listPrdV(Request $request)
        {

            $idV = (int)$request->idVente;

            // Lecture des sorties-opérations-opérateurs
             $OpTion = DB::table('produits_has_ventes_succursales')
                ->join('produits','produits.id','=','produits_has_ventes_succursales.produits_id')
                ->select('produits.*', 'produits_has_ventes_succursales.*')
                ->where('produits_has_ventes_succursales.vente_succursale_id','=',$idV)
                ->get();

            // Détails de la vente 
                $total= 0;
             $output ='';
             $output.='
                <div class="table-responsive fs--1">
                    <table class="table table-striped border-bottom">
                      <thead class="bg-200 text-900">
                        <tr>
                          <th class="border-0">Article</th>
                          <th class="border-0 text-center">Prix de vente </th>
                          <th class="border-0 text-center">Qté</th>
                          <th class="border-0 text-right">Prix Net(Fcfa)</th>
                        </tr>
                      </thead>
                      <tbody>';
                    for ($i=0; $i < count($OpTion) ; $i++){
                     $output.='
                        <tr>
                          <td class="align-middle">'.$OpTion[$i]->produitLibele.'</td>
                          <td class="text-center">'.$OpTion[$i]->prix.'</td>
                          <td class="text-center">'.$OpTion[$i]->qte.'</td>
                          <td class=" text-right">'.$OpTion[$i]->prix * $OpTion[$i]->qte .'</td>
                        </tr>';
                        $total += $OpTion[$i]->prix * $OpTion[$i]->qte; 
                     }
                $output.='
                      </tbody>
                    </table>
                  </div>
                  <div class="row no-gutters justify-content-end">
                    <div class="col-auto">
                      <table class="table table-sm table-borderless fs--1 text-right">';
                    // $total = 0;  
                    // for ($i=0; $i < count($OpTion) ; $i++){  
                    //     $total = $total+$OpTion[$i]->montant;
                    //  }
                    $output.='
                        <tr class="text-danger">
                          <th class="text-900 text-danger">Total(Fcfa):</th>
                          <td class="font-weight-semi-bold">'.$total.'</td>
                        </tr>';
                    $output.='    
                      </table>
                    </div>
                  </div>
             ';
             // dd($output);
             return $output;
        }

    //Suprimer vente de la sucu
        public function delVente(Request $request)
        {
            // Suppression de la vente
            Schema::disableForeignKeyConstraints();

             produits_has_ventes_succursale::where('vente_succursale_id', '=', $request->idV)->delete();
             ventes_succursale::where('id','=',$request->idV)->delete();

            Schema::enableForeignKeyConstraints();

            return response()->json();
        }



    //Enregistrement des produits de la vente en cour
        public function savePrdV(Request $request)
            {
                // Ajax validation et retour
                // $validator = $this->validator($request->all())->validate();
                //Generation de clé unique
        
                $idProduit = $request->article.rand(0,10000);
                //Verification de la quantite du produit en stock

                //Création des panier 
                 if (isset($_SESSION['achatP'])) 
                     {
                        $count = count($_SESSION["achatP"]);
                        $item_array = array(
                         'qte'      => $request->quantite,
                         'prix'     => $request->prix,
                         'article'     => $request->article,
                         'idArticle'     => $request->idArticle,
                         );
                        $_SESSION["achatP"][$count] = $item_array;
                      }
                  else
                    {

                        $item_array = array(
                             'qte'      => $request->quantite,
                             'prix'     => $request->prix,
                             'article'     => $request->article,
                             'idArticle'     => $request->idArticle,

                         );

                        //Création de session
                            $_SESSION["achatP"][0] = $item_array;
                    }

                if (empty($_SESSION["client_id"])) 
                        {

                           $_SESSION["client_id"] = $request->succursaleNom; //id du client
                        }
                        
                    $_SESSION["libelleCmd"] = "VENTE#".date("d/m/y")."#".rand(0,100); 
                       

                return response()->json();
            }

    //Show Liste produit de la vente
        public function showPrdL()
            {
               return view('pages/succursale/vente/listePrdV'); 
            }


    //Delete la commande 
        public function delCmd()
        {

            unset($_SESSION['achatP']);
            unset($_SESSION['client_id']);
            unset($_SESSION["libelleCmd"]);
            return response()->json();

        }

    //Delete produit de la commande
        public function delPrdCmd(Request $request)
            {
                $nbr =(int)$request->NumArt; //conversion en entier
                unset($_SESSION['achatP'][$nbr]);
                return response()->json();
            }






}



