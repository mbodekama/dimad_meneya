<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;

use Illuminate\Http\Request;
use Session;
use Validator;
use  App\Model\produits;
use App\Model\stock_principales;

use App\Model\arrivage;
use App\Model\arrivage_has_produits;

use DB;
use Auth;
session_start();


	//Controller des arrivages
class p_ArrivController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('AccesToArrivage');
    }

    //Form d'Ajout nouveau arrivage
        public function addArriv(Request $request)
        {

        	// $prd = produits::all();
            return view('pages/principale/stock_P/addArriv');

        }



    //Enregistrement d'un produit de l'arrivage en session
	    public function saveArrivPrd(Request $request)
	        {
	            // Ajax validation et retour
	            $validator = $this->validator($request->all())->validate();

	            //Generation de clé unique
	            $idProduit = $request->article.rand(0,10000);
	            
  	        	//Création des panier 
  	         	if (isset($_SESSION['arrivPrd'])) 
  	             {
  	                $count = count($_SESSION["arrivPrd"]);
  	                $item_array = array(
  	                 'qte'      => $request->quantite,
                     'prix'     => $request->prix,
  	                 'prixV'     => $request->prixV,
  	                 'article'     => $request->article,
  	                 'idArticle'     => $request->article,


  	                 );
  	                $_SESSION["arrivPrd"][$count] = $item_array;
  	              }
  	          else
  	          	{

  		            $item_array = array(
  		             'qte'      => $request->quantite,
  		             'prix'     => $request->prix,
                    'prixV'     => $request->prixV,
  		             'article'  => $request->article,
  		            'idArticle' => $request->idArticle,);

  		            //Création de session
  		             $_SESSION["arrivPrd"][0] = $item_array;
  		          }
	                if (empty($_SESSION["arrivName"])) 
	                {

	                   $_SESSION["arrivName"] = $request->arrivageLibelle;
	                }



	            return response()->json();
	        }

    protected function validator(array $data)
        {
            return Validator::make($data, [
                'quantite' => 'required',
                'article' => 'required',
            ]);
        }

    //Liste des produit de l'arrivage

       public function lArrivPrd()
	       {
	            return view('pages/principale/stock_P/lArrivPrd');
	       }

    //Supression d'un prd de la commande
        public function delPrdArriv(Request $request)
        {
          $vente= arrivage::find($request->idVnt);
          $prd= arrivage_has_produits::find($request->idPrd);
       

          //Soustraction du montant du prd  et upd de la vnt
            $coutAchaPrd = $prd->coutachat * $prd->qteproduits;
            $vente->arrivagePrix = $vente->arrivagePrix- $coutAchaPrd;

            $vente->arrivageQte = $vente->arrivageQte - $prd->qteproduits;

            $vente->save();
            
            $prd->delete();

            return response()->json();

        }

    //Update d'un produit de l'arrivage 
        public function updPrdArriv(Request $request)
        {
          $vente= arrivage::find($request->idVnt);
          $prd= arrivage_has_produits::find($request->idPrd);



          //Soustraction du montant du prd  et upd de la vnt
            $coutAchaPrd = $prd->coutachat * $prd->qteproduits;
            $vente->arrivagePrix = $vente->arrivagePrix- $coutAchaPrd;
            $vente->arrivageQte = $vente->arrivageQte - $prd->qteproduits;


          //update du produit
          $prd->qteproduits = $request->newQte;
          $prd->coutachat = $request->newPrix;

          //Ajout des nouveaux montants du prd a la vente
            $coutAchaPrd = $request->newPrix * $request->newQte;
            $vente->arrivageQte = $vente->arrivageQte + $request->newQte;
            $vente->arrivagePrix = $vente->arrivagePrix+ $coutAchaPrd;
         
          $prd->save();
          $vente->save();


            return response()->json(
                ['arrivPrix'=>$vente->arrivagePrix,'prdTotal'=>$request->newQte*$request->newPrix]);
        }

  //Edition des arrivages
        public function editArriv(Request $request)
        {
          $arriv = arrivage::find($request->idArr);
          $prd = DB::table('arrivage_has_produits')
              ->join('produits', 'produits.id', '=', 
                     'arrivage_has_produits.produits_id')
              ->select('produits.*', 'arrivage_has_produits.*','arrivage_has_produits.id as arrivPrdLine')
              ->where('arrivage_has_produits.arrivage_id', '=',$request->idArr)
              ->get();

              // dd($prd);
          return view('pages/principale/stock_P/editArriv')->with('prd',$prd)
                                                          ->with('arriv',$arriv);
        }
  //Detruit la session contenant l'arrivage et son name
    public function deleteArriv(Request $request)
        {
            unset($_SESSION['arrivPrd']); // vidage de session panier
            unset($_SESSION['arrivName']); // vidage de session panier
            return response()->json();

        }

  //Enregistrement de l'arrivage
      public function saveArriv(Request $request)
      {

                        $dateV = setDefault($request->dateV,date('d/m/Y'));
                        $charge = setDefault($request->charge,0);
                        $chargeDesc = setDefault($request->chargeDesc,'');
                if (!empty($_SESSION['arrivPrd']))
                    {
                        //insertion de l'approvisionnement dans table appro
                        $arrivage = arrivage::create([
                            'arrivageLibelle'=> $_SESSION['arrivName'],
                            'MatArvg'=> 'Arr#'.date('H_i_s'),
                            'arrivageDate'=> $dateV,
                            'charge' =>$charge,
                            'description_charge' => $chargeDesc,
                              'arrivageQte' => 0,
                              'arrivagePrix' => 0,
                              'statut'  =>0,
                                    
                                    ]);
                                $prixTotal = 0;
                                $qteTotal = 0;
                        foreach ($_SESSION['arrivPrd'] as $key => $value)
                            {
                               $arrayPrdArriv = [
                                                  "prixvente" => $value['prixV'],
                                                  "coutachat" => $value['prix'],
                                                  "qteproduits" => $value['qte'],
                                        "arrivage_id"  => $arrivage->id,
                                            "produits_id"  =>$value['article'],
                                                ];
                                    $prixTotal += $value['prix']*$value['qte'];
                                    $qteTotal += $value['qte'];
                                    arrivage_has_produits::create($arrayPrdArriv);

                            }
                                $arrivage->arrivageQte = $qteTotal;
                                $arrivage->arrivagePrix = $prixTotal;
                                $arrivage->save();
                    }


                return $this->deleteArriv($request);
      }

 // Liste de mes Arrivages en attente
       public function arrivAttn()
       {
        $arrivs = arrivage::where('statut','=',0)->orderBy('id','desc')->get();
        return view('pages/principale/stock_P/arrivAttn')->with('arrivs',$arrivs);
       }

 //Detail d'un arrivage 
       public function detailArriv(Request $request)
       {
        $myArriv= arrivage::find($request->idArr);
        //Lecture des approviionnements et de la liste des produits de l'approvisionnement
        $arriv = DB::table('arrivages')
            ->join('arrivage_has_produits', 'arrivages.id', '=',
             'arrivage_has_produits.arrivage_id')
            ->join('produits', 'produits.id', '=', 
                   'arrivage_has_produits.produits_id')
            ->select('produits.*', 'arrivage_has_produits.*', 'arrivages.id as arrivId')
            ->where('arrivages.id', '=',$request->idArr)
            ->get();

            $total= 0;
         $output ='';
         $output.='
            <div class="table-responsive fs--1">
                <table class="table table-striped border-bottom">
                  <thead class="bg-200 text-900">
                    <tr>
                      <th class="border-0">Article</th>
                      <th class="border-0 text-center">Cout d\'achat  </th>
                      <th class="border-0 text-center">Prix vente </th>
                      <th class="border-0 text-center">Qté</th>
                      <th class="border-0 text-right">Prix Net(Fcfa)</th>
                    </tr>
                  </thead>
                  <tbody>';
                for ($i=0; $i < count($arriv) ; $i++){
                 $output.='
                    <tr>
                      <td class="align-middle">'.$arriv[$i]->produitLibele.'</td>
                      <td class="text-center">'.$arriv[$i]->coutachat.'</td>
                      <td class="text-center">'.$arriv[$i]->prixvente.'</td>
                      <td class="text-center">'.$arriv[$i]->qteproduits.'</td>
                      <td class=" text-right">'.formatPrice($arriv[$i]->coutachat * $arriv[$i]->qteproduits) .'</td>
                    </tr>';
                    $total += $arriv[$i]->coutachat * $arriv[$i]->qteproduits; 
                 }
            $output.='
                  </tbody>
                </table>
              </div>
              <div class="row no-gutters justify-content-end">
                    <div class="col-auto">
                     <table class="table table-sm table-borderless fs--1 text-right">';
                    $total = $total+$myArriv->charge;
                    if($myArriv->charge !=0)
                    {
                    $output.='
                        <tr class="">
                          <th class="text-900 ">'.$myArriv->description_charge.':</th>
                          <td class="font-weight-semi-bold">'.formatPrice($myArriv->charge).'</td>
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
              </div>';
         // dd($output);
         return $output;
       }

  //Validation d'un arrivage
       public function arrivValid(Request $request)
       {

          $arriv = arrivage::find($request->idArr);
          $arriv->update(['statut'=> 1]);

          $prds = DB::table('arrivages')
              ->join('arrivage_has_produits', 'arrivages.id', '=',
               'arrivage_has_produits.arrivage_id')
              ->join('produits', 'produits.id', '=', 
                     'arrivage_has_produits.produits_id')
              ->select('produits.*', 'arrivage_has_produits.*', 'arrivages.id as arrivId')
              ->where('arrivages.id', '=',$request->idArr)
              ->get();
            foreach ($prds as $prd)
              {
                //Mis a jour prix de produits 
                    $myPrd = produits::find($prd->produits_id);
                    $myPrd->produitPrixFour = $prd->coutachat ;
                    $myPrd->produitPrix =  $prd->prixvente ;
                    $myPrd->save();
                // Mis a jour du stock principales
                        $produits = stock_principales::firstOrCreate(
                        ['produits_id' => $prd->produits_id],
                            ['stock_Qte' => 0]);
                            $produits->stock_Qte = $prd->qteproduits + $produits->stock_Qte;
                            $produits->save();
              }
          return response()->json();
       }       

  // Suprimer un arrivage
       public function arrivDel(Request $request)
       {

          arrivage_has_produits::where('arrivage_id','=',$request->idArr)->delete();
          arrivage::find($request->idArr)->delete();
          return response()->json();
       }    

   // Liste de mes Arrivages valide
       public function arrivOk(Request $request)
       {
        $pagePath =  $request->path();
        $perPage = setDefault($request->perPage,25);
        $arrivs=  arrivage::orderBy('id', 'desc')->paginate($perPage);
        return view('pages/principale/stock_P/arrivOk')->with('arrivs',$arrivs)
                                       ->with('pagePath',$pagePath)
                                       ->with('perPage',$perPage);
       }


  //Suprime un produit de l'arrivage  
    public function delArrivPrd(Request $request)
        {
            $nbr =(int)$request->NumArt; //convert to integer
            // dd($_SESSION['arrivPrd']);
            unset($_SESSION['arrivPrd'][$nbr]);
            return response()->json();
        }



  //Mis a jour d'un arrivage 
      public function updArriv(Request $request)
      {
            $arriv= arrivage::find($request->idVnt);
              $arriv->charge = $request->charge;
              $arriv->description_charge = $request->chargeLibelle;
              $arriv->arrivageDate = $request->dateV;
              $arriv->save();
                     return response()->json();
      }



}


