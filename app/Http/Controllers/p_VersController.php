<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\versement;
use App\Model\ventes_succursales;
use App\Model\versement_historiques;
use App\Model\succursale;
use  App\Mail\AlertVers;
use DB;
use Validator;
use Mail;


class p_VersController extends Controller
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


    // public function p_NewVers()
    // {
    //     $sucrL = succursale::where('id','>',1)->get();
    //     // dd($sucrL);
    //     return view('pages.principale.Versement.p_NewVers')->with('sucrL',$sucrL);
    // }

    //Liste des versement génére
        public function p_LVer(Request $request)
        {
            $pagePath =  $request->path();
            $perPage = setDefault($request->perPage,25);
            $versL=  versement::orderBy('id', 'desc')->paginate($perPage);
            return view('pages.succursale.p_LVer')->with('versL',$versL)
                                           ->with('pagePath',$pagePath)
                                           ->with('perPage',$perPage);
        }

    // Generer Rapprot de ventes des succursae
        public function rapportSuc()
        {
            $succ = succursale::where('id','>',1)->get();
            return view('pages.succursale.rapportSuc')->with('succ',$succ);
        }

    //Lancer lanalyse du rapport de versement
        public function rapAnlyz( Request $request)
            {

       $dateBP  = $request->dateInterval;
        $periode = explode(" to ", $dateBP);
        $debut   = $periode[0];
        $fin     = $periode[1];
        $fin2     = $periode[1];
       /* dd($debut);*/
        // dd($fin);
        // Selection distincte

                $collection = collect([]);
                $sucrL = succursale::where('id','>',1)->get();
                $succursales = $sucrL;
                for ($i=0; $i <count($sucrL) ; $i++) 
                { 
                    $mesIdSuc[$i] = $sucrL[$i]->id;
                }
                
                for ($i=0; $i<count($mesIdSuc); $i++) 
                { 
                    $re2 = DB::table('ventes_succursales')
                            ->where('succursale_id','=',$mesIdSuc[$i])
                            ->whereBetween('dateV', [$debut, $fin])
                            ->get();
                $coutAcha = $re2->sum('cout_achat_total');
                $prixV = $re2->sum('prix_vente_total');
                $bnfBrut = $re2->sum('mg_benef_brute');
                $bnfRel = $re2->sum('mg_benef_rel');
                $livraison = $re2->sum('livraison');
                $nbrVnt = $re2->count();
                    $table= [ 'Idsucu' =>$mesIdSuc[$i],
                            'coutAcha'=>$coutAcha,
                            'prixV'=>$prixV,
                            'bnfBrut'=>$bnfBrut,
                            'bnfRel'=>$prixV-$coutAcha ,
                            'livraison'=>$livraison,
                            'nbrVnt'=>$nbrVnt
                            ];

                $collection->push($table);
                }
                // dd($collection);

                //Trier par le prix
                // dd($collection);
                    $orderByPrice = $collection->sortByDesc('coutAcha')->values(); 
          
                //Cadre de classement
                $output='<div class="card-deck">';
                if(count($orderByPrice)<3){$fin = count($orderByPrice); }
                  else{$fin = 3;}
            for ($i=0; $i <$fin ; $i++) { 
               $output.='
                    <div class="card mb-3 overflow-hidden" style="min-width: 12rem">
                      <div class="bg-holder bg-card" 
                       style="background-image:url(assets/img/illustrations/corner-1.png);">
                      </div>
                      <div class="card-body position-relative">
                        <h6>'.formatPrice($orderByPrice[$i]['coutAcha']).'<span class="badge badge-soft-warning rounded-capsule  ml-2"> <i class="far fa-star"></i></span></h6>
                        <div class="display-6 fs-3 mb-2 font-weight-normal text-sans-serif text-warning">'.readSurc($orderByPrice[$i]['Idsucu'])->succursaleLibelle.'</div>
                        <a class="font-weight-semi-bold fs-1 text-nowrap ReSMS" href="#!" id="'.$orderByPrice[$i]['coutAcha'].'">';
                        if($i == 0)
                        {
                            $output.='<span class="text-success">Classé Meilleur</span>';
                        }
                        else
                        {
                            $output.='<span class="text-warning">Classé '.($i+1).'ième </span>';

                        }



                         $output.='</a>
                      </div>
                    </div>
                ';
            }
            $output.='</div>';

            $output.='<div class="d-flex justify-content-center" >
                        <h5 class="mb-4 text-primary position-relative">
                        <span class="bg-200 pr-3">Rapport des agences pour la période du <strong class="text-danger">'.$debut.' au '.$fin2.'</strong> </span>
                        <span class="border position-absolute absolute-vertical-center w-100 z-index--1 l-0">
                        </span>
                        </h5></div>';

            $output.='<div class="col-lg-12 col-sm-12 col-md-12 pl-lg-2 ">
            <div class="card mb-3">
              <div class="card-body">
                <div class="table-responsive fs--1">
                  <table class="table table-striped border-bottom">
                    <thead class="bg-200 text-900" >
                      <tr>   
                              <th scope="col">Succursale</th>
                              <th scope="col">Vente total </th>
                              <th scope="col">Bénéfice Suc.</th>
                              <th scope="col">Nombre Vente</th>
                              <th class="white-space-nowrap" scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>';

                        if(count($collection) !=0)
                        {

                      if($request->succ !=0)
                        {
                          $oneSuc = $orderByPrice->where('Idsucu','=',$request->succ)->first();
                          $output.='<tr>
                                      <td class="fs-1">'.readSurc($oneSuc['Idsucu'])->succursaleLibelle.'</td>
                                      <td class="fs-1">'. $oneSuc['prixV'] .'</td>
                                      <td class="fs-1">'.$oneSuc['bnfRel'].'</td>
                                      <td class="fs-1">'.$oneSuc['nbrVnt'].'</td>
                                      <td class="pr-0 d-flex">
                                        <button class="btn btn-warning mr-1 mb-1 dmdVers" type="button" 
                                          idSucVrs="'.$oneSuc['Idsucu'].'" 
                                          nomSucVrs="'.readSurc($oneSuc['Idsucu'])->succursaleLibelle.'" 
                                          mntanVrs="'.$oneSuc['coutAcha'].'"mntanVrsFrm="'.formatPrice($oneSuc['coutAcha']).'"
                                          debutVers="'.$debut.'"
                                          finVers="'.$fin2.'">
                                          Reclamer versement
                                          </button>
                                

                                      </td>

                                    </tr>';
                          // dd("iviii");

                        }
                        else
                          {

                          foreach($orderByPrice as $orderByBnf)
                            {
                               $output.='<tr>
                                      <td class="fs-1">'.readSurc($orderByBnf['Idsucu'])->succursaleLibelle.'</td>
                                      <td class="fs-1">'. formatPrice($orderByBnf['coutAcha']) .'</td>
                                      <td class="fs-1">'.formatPrice($orderByBnf['bnfRel']).'</td>
                                      <td class="fs-1">'.formatQte($orderByBnf['nbrVnt']).'</td>
                                      <td class="pr-0 d-flex">
                                        <button class="btn btn-warning mr-1 mb-1 dmdVers" type="button" 
                                          idSucVrs="'.$orderByBnf['Idsucu'].'" 
                                          nomSucVrs="'.readSurc($orderByBnf['Idsucu'])->succursaleLibelle.'" 
                                          mntanVrs="'.$orderByBnf['coutAcha'].'"mntanVrsFrm="'.formatPrice($orderByBnf['coutAcha']).'"
                                          debutVers="'.$debut.'"
                                          finVers="'.$fin2.'">
                                          Reclamer versement
                                          </button>
                                        <button class="btn btn-primary mr-1 mb-1 lVers" type="button" 
                                          idSucVrs="'.$orderByBnf['Idsucu'].'" >
                                          Voir les versements
                                          </button>

                                      </td>

                                    </tr>';


                            }
                          }                         

                          
                        }
               $output.=' </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>';

          //SCRIPT DU OUTPUT
          $output .='<script type="text/javascript">
                          $(function()
                          {
                            //Cliquer sur liste versement
                            $(".lVers").click(function()
                            {
                              $("#p_LVer").click();
                            })


                            $(".dmdVers").click(function()
                            {
                              var btnCliquer = $(this);
                              var idSucVrs  = $(this).attr("idSucVrs");
                              var nomSucVrs  = $(this).attr("nomSucVrs");
                              var mntanVrs  = $(this).attr("mntanVrs");
                              var mntanVrsFrm  = $(this).attr("mntanVrsFrm");
                              var  debutVers = $(this).attr("debutVers");
                              var  finVers = $(this).attr("finVers");
                              var msgText ="Confirmez la demande de versement de "+mntanVrsFrm+" auprès de la "+nomSucVrs+"  pour la durée d\'exercice allant du "+debutVers+" au "+finVers+" ?"
                                    Swal.fire({
                                        title: "Demande de versement",
                                        text: msgText,
                                        icon: "warning",
                                        showCancelButton: true,
                                        confirmButtonColor: "#d33",
                                        cancelButtonColor: "#3085d6",
                                        cancelButtonText: "Annuler",
                                        confirmButtonText: "oui , Confirmez!",
                                         backdrop: "rgba(240,15,83,0.4)",
                                      }).then((result) => {
                                          if (result.value) {
                                            $.ajax({
                                              url:"mbo/addVers",
                                              method:"GET",
                                              data:{succursale_id:idSucVrs,
                                                    versMnt: mntanVrs,
                                                    dateDebut :debutVers,
                                                    dateFin:finVers},
                                              dataType:"text",
                                              success:function(data){
                                                  btnCliquer.attr("class","d-none");
                                                  
                                                    if (data == 0) 
                                                    {
                                                      Swal.fire(
                                                       "Date Invalide!",
                                                       "L\'intervalle de date  sélectionnés existe déja dans une demande de versement enregistré. Consulter vos versements!",
                                                       "error"
                                                      );
                                                    }
                                                    else
                                                    {
                                                      Swal.fire(
                                                       "Versement!",
                                                       "Demande de versement fait avec succès. Vous pouvez consulter vos versements",
                                                       "success"
                                                      );
                                                    }
                                                // $("#main_content").load("mbo/listSuc");
                                              },
                                              error:function(){
                                                Swal.fire("Problème de connexion internet");
                                              }
                                            });
                                          }
                                      })
                            })
                          })
                        </script>';
        
         return $output;

            }


    //Demande de versement
      public function addVers(Request $request)
      {

          // Versement
           $id = versement::max('id') + 1;
            $matV = "Vers#0".$id;
              $dataV  = [ 'succursale_id'   => $request->succursale_id,
                          'versMnt'  => $request->versMnt,
                          'dateDebut'   =>$request->dateDebut,
                          'dateFin' =>  $request->dateFin,
                          'versMat' =>$matV,
                          'versStatu' =>0,
                          'versDate' =>date('d/m/Y'),
                        ];
              //Rquestte de selection des versement de la succursalles
                $versDebu = DB::table('versements')
                            ->where('succursale_id','=',$request->succursale_id)
                            ->get();

                //Verifie si des demandende de versement exite deja
              if(!$versDebu->isEmpty())
              {
                      if ( $request->dateFin< $versDebu->min('dateDebut')) 
                      {
                        versement::create($dataV);
                        $output =1;  //Nouveau versemen ajoute
                      }
                      else
                      {
                        if ($request->dateDebut > $versDebu->max('dateFin') ) 
                        {
                          versement::create($dataV);
                          $output =1; 
                        }
                        else
                        {
                          $output =0;  
                        }
                      }
              }
              else
              {
                versement::create($dataV);
                $output =1;   
              }

              //L'ajout de demande de versementa été efectue
              //Envoie de mail au gerant
              if ($output == 1) {
                  $gerant = gerantSuc(readSurc($request->succursale_id)->user_id);
                  // Alert versement
                      Mail::to($gerant->email)->queue(new AlertVers('Demande',$dataV));
              }
              
          // Retour JSON
           return $output; 

      }

    
    //Paiement d'un versement
      public function payVers(Request $request)
      {

          $valeur =['nomAgent' =>$request->agent ,
                    'montantPaye'=>$request->montant ,
                    'datePaiement' =>$request->datePayVers,
                    'typepaiement' =>$request->moyen ,
                    'versement_id' =>$request->idVers
                  ];
          $vers = versement::find($request->idVers);
          versement_historiques::create($valeur);
          $mntDejaPaye = getHistVers($request->idVers)->sum('montantPaye');
          if($mntDejaPaye >= $vers->versMnt )
          {
            $vers->versStatu = 1;
            $vers->save();
          }

           $gerant = gerantSuc(readSurc($vers->succursale_id)->user_id);
          //Déclenchement d'alert
              //Msg alert
           $elemnt = ['montantPaye'=>$request->montant,
                    'datePaiement' =>$request->datePayVers,
                    'typepaiement' =>$request->moyen,
                    'matVers' =>$vers->versMat,
                    'mntVers' =>$vers->versMnt,
                    'mntRst' =>$vers->versMnt - $mntDejaPaye
                  ];
              Mail::to($gerant->email)
              ->queue(new AlertVers('paiement',$elemnt));

        return response()->json();
      }

    public function histPayVers(Request $request)
    {
      $hist = getHistVers($request->idVers);
             $total =0;
             $output ='';
             if($hist->isEmpty())
             {
              $output .='<div>
                          <p class="text-warning fs-2 text-center"> Aucun paiement enregistré pour ce versement</p>
              </div>';

             }
             else
             {

                $output.='
                <div class="table-responsive fs--1">
                    <table class="table table-striped border-bottom">
                      <thead class="bg-200 text-900">
                        <tr>
                          <th class="border-0 text-center">Date</th>
                          <th class="border-0">Caissier</th>
                          <th class="border-0 text-center">Moyen </th>
                          <th class="border-0 text-center">Montant Payer </th>

                        </tr>
                      </thead>
                      <tbody>';

                    for ($i=0; $i < count($hist) ; $i++){
                     $output.='
                        <tr>
                          <td class="align-middle">'.$hist[$i]->datePaiement.'</td>
                          <td class="text-center">'.$hist[$i]->nomAgent.'</td>
                          <td class="text-center">'.$hist[$i]->typepaiement.'</td>
                          <td class=" text-right">'.formatPrice($hist[$i]->montantPaye).'</td>
                        </tr>';
                        $total += $hist[$i]->montantPaye; 
                     }
                $output.='
                      </tbody>
                    </table>
                  </div>
                  <div class="row no-gutters justify-content-end">
                    <div class="col-auto">
                      <table class="table table-sm table-borderless fs--1 text-right">';
                    $output.='
                        <tr class="text-danger">
                          <th class="text-900 text-danger">Total( '.getMyDevise().'):</th>
                          <td class="font-weight-semi-bold">'.formatPrice($total).'</td>
                        </tr>';
                    $output.='    
                      </table>
                    </div>
                  </div>';
             }

      return $output;
    }

  //Suprimer des versements
    public function delVers(Request $request)
    {
        versement::where('id','=',$request->idVers)->delete();
      return response()->json();

    }



}
