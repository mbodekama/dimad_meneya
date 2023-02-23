<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\credits;

use App\Model\produits;
use App\Model\versement;
use App\Model\credits_historiques;
use App\Model\ventes_succursales;
use App\Model\vente_principales;

use Auth;
use Schema;
use DB;


class s_CreditController extends Controller
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

    //Ajouter une creance succursale
      public function s_addCrd(Request $request)
        {
          $info =  ['creditDate' =>$request->dateCrd,'creditMontant' =>$request->montantCrd,'creditStatut' =>'en cours', 'client_id' =>$request->client_id,'creditEcheance' =>$request->dateEch,'succursale_id' =>Auth::user()->succursale_id];
          credit::create($info);
          return response()->json();
        }

    //Liste credit succursale 
        public function s_credits(Request $request)
            {
              //Info pour le paginate
                  $pagePath =  $request->path();
                  $perPage = setDefault($request->perPage,25);
              //Slection des credit liée a la suc
                $suc = userHasSucc(Auth::id());
                $clt = allCltSuc($suc->id);
                $credits = DB::table('credits')
                    ->join('ventes_succursales','ventes_succursales.id','=','credits.vente_id')
                    ->select('credits.id as creditId','credits.*', 'ventes_succursales.*')
                    ->where('credits.sucId','=',$suc->id)
                    ->orderBy('credits.id', 'desc')
                    ->paginate($perPage); 

              return view('pages.succursale.vente.s_credit')
                                        ->with('crds',$credits)
                                        ->with('Clt',$clt)                 
                                        ->with('pagePath',$pagePath)
                                       ->with('perPage',$perPage);

            }
    //Payement credit succursale 
        public function s_payCrd(Request $request)
            {
            $suc = userHasSucc(Auth::id());
            $idCredit= (int)$request->idCrd;
            $info = [
                      'montantPaye' =>$request->mntPaye,
                      'datePaiement' =>$request->date,
                      'typepaiement' =>$request->typePaiement,
                      'credit_id'    =>$request->idCrd,
                    ];

              $credit = credits::find($idCredit);
             $totalPaye =  getSommeCrdPaye($idCredit) + $request->mntPaye;
              $histCr = credits_historiques::create($info);

                  if($totalPaye >= $credit->creditMontant )
                      {
                          //Actualisation du statut du credit
                          $credit->creditStatut = 'Soldée';
                          $credit->save();
                          //Actualisation du statut de la vente
                            if ($suc->id == 1)  //Vente Principal 
                            {
                              $vente = vente_principales::find($credit->vente_id);
                            }
                            else                //Vente Succursal
                            {
                              $vente = ventes_succursales::find($credit->vente_id);
                            }

                            $vente->typevente = 1;
                            $vente->save();
                      }
             
              return response()->json();

            }

    //Historique de mes credits
            public function histCrd(Request $request)
              {
                 $idCrd = (int)$request->idCrd;
                  $hists = credits_historiques::where('credit_id','=',$idCrd)->get();

                  if(count($hists) >= 1)
                  {
                       $output ='<table class="table table-striped border-bottom">
                            <thead>
                              <tr class="bg-primary text-white">
                               
                                <th class="border-0 text-center">Date</th>
                                <th class="border-0 text-center">Montant</th>
                                <th class="border-0 text-center">Type paiement</th>

                              </tr>
                            </thead>
                            <tbody>';
                            foreach ($hists as $hist) 
                            {
                            $output.='<tr>
                                <td class="align-middle text-center">'.$hist->datePaiement.'</td>
                                <td class="align-middle text-center">'.formatPrice($hist->montantPaye).'</td>
                                <td class="align-middle text-center">'.$hist->typepaiement.'</td>
                              </tr>';   
                            }

                            $output.='</tbody>
                          </table>';
                  }
                  else
                  {
                      $output= '<h2 class="text-warning text-center">Aucun paiement fait pour cette echeance</h2>';
                  }
                 


                  return $output;

              }

            
    //Suprimer une creance
      public function delCrd(Request $request)

      {    
            credits::where('id','=',$request->idCrd)->delete();
            return response()->json();

      }





}



