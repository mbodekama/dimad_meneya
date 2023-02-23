<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\succursale;
use App\Model\produits;
use App\Model\approvisionnement;
use App\Model\produits_has_approvisionnement; 
use App\Model\stock_succursales; 
use App\Model\ressources_hums;

use DB;
use Auth;
use Validator;

session_start();

class ApprovisionnementController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('AccesToPrincipale');

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    //Approvisionnement page
        public function approvi()
        {

          // session_unset();
            $succursales = succursale::where("id",'>',1)->get();
            // $produits = produits::all();
            return view('pages/principale/approvision/approvi')->withSuccursales($succursales);

        }

    
    //Ajout produit approvisionnement
        public function addPrdAprovi(Request $request)
            {

                // Ajax validation et retour
                $validator = $this->validator($request->all())->validate();

                //Création des panier 
                 if (isset($_SESSION['approvSuc'])) 
                     {
                        // $count = count($_SESSION["approvSuc"]);
                        $item_array = array(
                         'qte'      => $request->quantite,
                         'prix'     => $request->prix,
                         'article'     => $request->article,
                         );
                        $_SESSION["approvSuc"][] = $item_array;
                      }
                  else{

                        $item_array = array(
                         'qte'      => $request->quantite,
                         'prix'     => $request->prix,
                         'article'  => $request->article,
                         );

                        //Création de session
                         $_SESSION["approvSuc"][] = $item_array;

                         //Enregistrement de la succursale
                          $_SESSION["sucId"] = $request->sucId;
                      }

                return response()->json();
            }

    //Regle de Validation du produit ajouter
        protected function validator(array $data)
            {
                return Validator::make($data, [
                    'quantite' => 'required',
                    'article' => 'required',
                ]);
            }
    //Liste Arrivage Prd approvisionnemen
        public function listAproviPrd(Request $request)
            {

                return view('pages/principale/approvision/listAproviPrd');
            }

    //Delete produit Approvisionn
        public function delAproviPrd(Request $request)
            {
                $nbr =(int)$request->NumArt; //conversion de la variable en entier
                //(-1) pour compter dans l'odre du tableau
                unset($_SESSION['approvSuc'][$nbr]);
                return response()->json();
            }

    //Delete Approvision
        public function delAprovi(Request $request)
            {
                unset($_SESSION['approvSuc']); // vidage de session panier
                unset($_SESSION['sucId']); // vidage de session panier
                return response()->json();

            }
    //sAve approvi
        public function saveAprovi (Request $request)
            {

                if (!empty($_SESSION['approvSuc']))
                    {
                        //Generation du matricule de l'approvisionnement
                        $matricule = "APR#".date("d/m/y")."#".rand(0,1000); 
                        $dateV = setDefault($request->dateV,date('d/m/Y'));
                        $charge = setDefault($request->charge,0);
                        $chargeDesc = setDefault($request->chargeDesc,'');
                        // dd($matricule);

                        //insertion de l'approvisionnement dans table appro
                        $arrivage = approvisionnement::create([
                                    'approvisionMat'=> $matricule,
                                    'succursale_id' => $_SESSION['sucId'],
                                    'dateApro'  => $dateV,
                                    'charge'    =>$charge,
                                    'description_charge' =>$chargeDesc,
                                    ]);
                                $prixTotal = 0;
                                $qteTotal = 0;
                        foreach ($_SESSION['approvSuc'] as $key => $value)
                            {

                               $arrayPrdArriv = [

                                            "coutachat" => $value['prix'],
                                            "prixvente" => $value['prix'],
                                            "qteproduits" => $value['qte'],
                                    "approvisionnement_id"  => $arrivage->id,
                                            "produits_id"  =>$value['article'],'succursale_id' => $arrivage->succursale_id
                                                ];
                                    $prixTotal += $value['prix']*$value['qte'];
                                    $qteTotal += $value['qte'];
                                    produits_has_approvisionnement::create($arrayPrdArriv);

                                    $produits = stock_succursales::where('succursale_id','=',$arrivage->succursale_id)->firstOrCreate(
                                    ['produits_id' => $value['article']],
                                        ['stock_Qte' => 0 ,'succursale_id' => $arrivage->succursale_id,'sucCoutAchat' =>$value['prix']]);

                                        $produits->stock_Qte = $value['qte'] + $produits->stock_Qte;
                                        $produits->sucCoutAchat = $value['prix'];
                                        $produits->save();

                            }
                                $arrivage->approvisionTotal = $qteTotal;
                                $arrivage->approvisionMontant= $prixTotal;
                                $arrivage->save();
                            }


                        return $this->delAprovi($request);


            }


    // Page Liste des approvision
      public function listAprovi(Request $request)
        {
          $pagePath =  $request->path();
          $perPage = setDefault($request->perPage,25);
          $approvi=  approvisionnement::orderBy('id', 'desc')->paginate($perPage);
          return view('pages/principale/approvision/listAprovi')
                                         ->withApprovisionnement($approvi)
                                         ->with('pagePath',$pagePath)
                                         ->with('perPage',$perPage);
        }


    //Liste des approvi
      public function approviList(Request $request)
        {
            //Lecture des approviionnements et de la liste des produits de l'approvisionnement
            $myAprov = approvisionnement::find($request->idApprovi);
            $aproV = DB::table('produits_has_approvisionnements')
                ->join('produits', 'produits.id', '=', 
                       'produits_has_approvisionnements.produits_id')
                ->select('produits.*', 'produits_has_approvisionnements.*')
                ->where('produits_has_approvisionnements.approvisionnement_id', '=',$request->idApprovi)
                ->get();
                $total= 0;
             $output ='';
             $output.='
                <div class="table-responsive fs--1">
                    <table class="table table-striped border-bottom">
                      <thead class="bg-200 text-900">
                        <tr>
                          <th class="border-0">Article</th>
                          <th class="border-0 text-center">Cout d\' achat </th>
                          <th class="border-0 text-center">Prix de vente </th>
                          <th class="border-0 text-center">Qté</th>
                          <th class="border-0 text-right">Prix Net(Fcfa)</th>
                        </tr>
                      </thead>
                      <tbody>';
                    for ($i=0; $i < count($aproV) ; $i++){
                     $output.='
                        <tr>
                          <td class="align-middle">'.$aproV[$i]->produitLibele.'</td>
                          <td class="text-center">'.$aproV[$i]->coutachat.'</td>
                          <td class="text-center">'.$aproV[$i]->prixvente.'</td>
                          <td class="text-center">'.$aproV[$i]->qteproduits.'</td>
                          <td class=" text-right">'.formatPrice($aproV[$i]->prixvente * $aproV[$i]->qteproduits ).'</td>
                        </tr>';
                        $total += $aproV[$i]->prixvente * $aproV[$i]->qteproduits; 
                     }
                $output.='
                      </tbody>
                    </table>
                  </div>
                  <div class="row no-gutters justify-content-end">
                    <div class="col-auto">
                     <table class="table table-sm table-borderless fs--1 text-right">';
                    $total = $total+$myAprov->charge;
                    if($myAprov->charge !=0)
                    {
                    $output.='
                        <tr class="">
                          <th class="text-900 ">'.$myAprov->description_charge.':</th>
                          <td class="font-weight-semi-bold">'.formatPrice($myAprov->charge).'</td>
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


    //Recu approvisionnement
      public function aprovRecu(Request $request)
        {
             $OpTion = DB::table('approvisionnements')
                ->join('produits_has_approvisionnements', 'approvisionnements.id', '=',
                        'produits_has_approvisionnements.approvisionnement_id')
                ->join('produits', 'produits.id', '=', 
                       'produits_has_approvisionnements.produits_id')
                ->select('produits.*', 'produits_has_approvisionnements.*', 'approvisionnements.id as approId')
                ->where('approvisionnements.id', '=',$request->idOpVe)
                ->get();

                //Variable contenant la somme total investir
                $somTotal = 0;


                  $output ='<div class="d-flex justify-content-center">
                            <h5 class="text-900">Reçu d\' approvisionnement</h5>
                          </div>
                          <div class="table-responsive fs--1">
                            <table class="table table-striped border-bottom">
                              <thead class="bg-200 text-900">
                                <tr>
                                  <th class="border-0">Produit</th>
                                  <th class="border-0 text-center">Cout d\'achat</th>
                                  <th class="border-0 text-center">Prix vente</th>
                                  <th class="border-0 text-right">Qte</th>
                                  <th class="border-0 text-right">Montant</th>
                                </tr>
                              </thead>
                              <tbody >';

                            for ($i=0; $i < count($OpTion) ; $i++){
                     $output .='<tr>
                                  <td class="align-middle">
                                    <h6 class="mb-0 text-nowrap"> '.$OpTion[$i]->produitLibele.' </h6>
                                  </td>
                                  <td class="align-middle text-center">'.$OpTion[$i]->coutachat.'</td>
                                  <td class="align-middle text-center">'.$OpTion[$i]->prixvente.'</td>
                                  <td class="align-middle text-right">'.$OpTion[$i]->qteproduits.'</td>
                                  <td class="align-middle text-right">'.$OpTion[$i]->prixvente * $OpTion[$i]->qteproduits.'</td>
                                </tr>';
                        $somTotal += $OpTion[$i]->prixvente * $OpTion[$i]->qteproduits;
                              }
                    $output .='</tbody>
                            </table>
                          </div>
                          <div class="row no-gutters justify-content-end">
                            <div class="col-auto">
                              <table class="table table-sm table-borderless fs--1 text-right">
                                <tr>
                                  <th class="text-900">Subtotal:</th>
                                  <td class="font-weight-semi-bold"> '.$somTotal.' </td>
                                </tr>
                                <tr>
                                  <th class="text-900">Tax 0%:</th>
                                  <td class="font-weight-semi-bold"> '.$somTotal.' </td>
                                </tr>
                                <tr class="border-top">
                                  <th class="text-900">Total:</th>
                                  <td class="font-weight-semi-bold text-danger"> '.$somTotal.' </td>
                                </tr>
                              </table>
                            </div>
                          </div>';

                  return $output;
        }


    public function allPrd(Request $request)
      {
        $pagePath =  $request->path();
        $perPage = setDefault($request->perPage,25);
        $produits=  produits::orderBy('id', 'desc')->paginate($perPage);
        return view('pages/principale/approvision/allPrd')
                                        ->with('produits',$produits)
                                       ->with('pagePath',$pagePath)
                                       ->with('perPage',$perPage);
      }


}