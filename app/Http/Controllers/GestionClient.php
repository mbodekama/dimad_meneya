<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Model\clients;
use App\Model\succursale_has_clients;
use App\Model\ventes_succursales;
use App\Model\vente_principales;
use App\User;
use Hash;
use Auth;
use DB;
use Schema;

class GestionClient extends Controller
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

    // fonction de validation

        protected function validator(array $data)
            {
                return Validator::make($data, [
                    'name'        => 'required|min:5',
                    'contact'     => 'required|min:8',
                    'date'       => 'required',
                ]);
            
            }

    //Ajout d'un client
      public function AddClt(Request $request)
          {
            //Recuperation de l'entite (succursales /principale)
              if(getUserRole(Auth::id())->roleId == 1) 
                {
                  //Role 1 => Administrateur
                  //le client appartien a la principal
                    $stat = 0; //Peut etre un prospect 


                  $succursale_id = 1;
                }
                else                      
                {
                  //Role autre que admin => Gestionnaire
                  $suc = userHasSucc(Auth::id());
                  $succursale_id =$suc->id;
                  $stat = 1; //Un client et non un prospect 


                }


           $validator = $this->validator($request->all())->validate();
           $client = ['nom'=> $request->name,'contact'=> $request->contact,'lieu'=>$request->lieu,'date'=>$request->date,'statutClt'=>$stat];
           $clt = clients::create($client);
           // dd($clt->id);
           succursale_has_clients::create(['clients_id'=>$clt->id,'succursale_id'=>$succursale_id]);

              return response()->json();
          }


    //Affiche liste des clients

        public function listClt(Request $request)
            {
                //Recuperation valeur soumises
                    $pagePath =  $request->path();
                    $perPage = setDefault($request->perPage,25);
                    $suc = userHasSucc(Auth::id());
                //Recup Clients de  la succursale 
                $clts = DB::table('clients')
                    ->join('succursale_has_clients','clients.id','=','succursale_has_clients.clients_id')
                    ->select('clients.*', 'clients.id as clientId')
                ->where('succursale_has_clients.succursale_id','=',$suc->id)
                ->where('clients.statutClt','=',1)
                    ->orderBy('id', 'desc')->paginate($perPage);

                //Retourne le path de la vue selon de Principal / Sucursa
                if ($suc->id == 1) {$path = "pages.principale.vente_P.p_Client"; }
                else{$path = "pages.succursale.vente.s_Client";}

                //Retour avec les donnees
                return view($path)->with('clts',$clts)
                                ->with('pagePath',$pagePath)
                                ->with('perPage',$perPage);
            }

    //Recup liste des achat d'un client
        public function listAchatClt(Request $request)
        {
            $suc = userHasSucc(Auth::id());
                if ($suc->id == 1) 
                {
                    $listeAch = vente_principales::
                            where('clients_id','=',$request->idClt)
                            ->orderBy('id', 'desc')
                            ->get(); 
                }
                else
                {
                    $listeAch = ventes_succursales::
                            where('succursale_id','=',$suc->id)
                            ->where('clients_id','=',$request->idClt)
                            ->orderBy('id', 'desc')
                            ->get(); 
                }


            // Détails de la vente 
                $totalVnt= 0;
                $totalCou=0;
             $output ='';
             $output.='
                <div class="table-responsive fs--1">
                    <table class="table table-striped border-bottom">
                      <thead class="bg-200 text-900">
                        <tr>
                          <th class="border-0">N° vente</th>
                          <th class="border-0 text-center">Coût </th>
                          <th class="border-0 text-center">Qté Prd</th>
                          <th class="border-0 text-right">Date</th>
                        </tr>
                      </thead>
                      <tbody>';
                      foreach ($listeAch as $achat) {
                     $output.='
                        <tr>
                          <td class="align-middle">'.$achat->NumVente.'</td>
                      <td class="text-center text-danger">'.formatPrice($achat->prix_vente_total).'</td>
                          <td class="text-center">'.$achat->qte.'</td>
                          <td class=" text-right">'.$achat->dateV.'</td>
                        </tr>';
                        $totalVnt += $achat->prix_vente_total; 
                        $totalCou += $achat->cout_achat_total; 
                     }
                $output.='
                      </tbody>
                    </table>
                  </div>
                  <div class="row no-gutters justify-content-end">
                    <div class="col-auto">
                      <table class="table table-sm table-borderless fs--1 text-right">';

                    $output.='
                        <tr >
                          <th class=" text-primary">Total Achat:</th>
                          <td class="font-weight-semi-bold">'.formatPrice($totalVnt).'</td>
                        </tr>
                        <tr class="text-danger">
                          <th class=" text-danger"><b>Total Bénéf:</b></th>
                          <td class="font-weight-semi-bold">'.formatPrice($totalVnt - $totalCou).'</td>
                        </tr>
                        ';
                    $output.='    
                      </table>
                    </div>
                  </div>
             ';
             // dd($output);
             return $output;


        }


    //Modifier un client un client et ses ventes
        public function UpdClt(Request $request)
        {

            $tab = ['nom' =>$request->name,'contact'=>$request->contact,'lieu'=>$request->lieu,'date'=>$request->date];
             clients::where('id','=',$request->idClt)->update($tab);

            return response()->json();
        }


    // //Suprimer un client et ses ventes
    //     public function delClt(Request $request)
    //     {
    //         // Suppression de la vente
    //         Schema::disableForeignKeyConstraints();

    //          ventes_succursale::where('client_id','=',$request->idClt)->delete();
    //          clientEntite::where('client_id','=',$request->idClt)->delete();
    //          clients::where('id','=',$request->idClt)->delete();

    //         Schema::enableForeignKeyConstraints();

    //         return response()->json();
    //     }

   
}
