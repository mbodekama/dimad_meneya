<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\operateur;
use App\Model\commandes;
use App\Model\stock_operateur;
use App\Model\operation;
use App\Model\operation_has_operateurs;
use App\Model\produits;
use App\Model\sortie_ops;
use App\Model\produits_has_sortie_ops;
use App\Model\operation_pay_historiques;
use Validator;
use DB;
use Schema;


session_start();

class p_OperaController extends Controller
{
    /**
     * Create a new controller instance. 
     *
     * @return void
     */
/*    public function __construct()
    {
        $this->middleware('auth');
    }*/

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    // Opération => Mise à jour phase 1
    public function p_OperaUpd(Request $request)
    {
        // Lecture des opérateurs en fonction de l'id
         $operL = operation::where('id','=',$request->idOp)->get();
         $output = '';

           for ($i=0; $i < count($operL) ; $i++){
              $output.='
                <div class="infos">
                </div>
        
                <div class="form-group">
                 <label for="libele">Libelé</label>
                 <input class="form-control" id="libele" type="text" value="'.$operL[$i]->OperationLibele.'">
                </div>

                <div class="form-group">
                 <label for="comment">Commentaire</label>
                  <textarea class="form-control comment" 
                   rows="3" value="'.$operL[$i]->Operationcomt.'"
                  >'.$operL[$i]->Operationcomt.'</textarea>
                </div>

                <input type="hidden" id="IdOp" value="'.$operL[$i]->id.'">
              ';
           }

          return $output;
    }

    // Opération => Mise à jour phase 2
    public function p_OperaUpd2(Request $request)
    {
        operation::where('id','=',$request->IdOp)
                ->update([ 'OperationLibele'  => $request->libele,
                           'Operationcomt'    => $request->comment
                       ]);
    }

    public function p_Opera()
    {
        return view('pages.principale.operateur.p_Opera');
    }

    public function p_OperaStock()
    {
        $opera = operateur::all()->sortByDesc('id');
        return view('pages.principale.operateur.p_OperaStock')->with('opera',$opera);
    }

    protected function ControlData(array $data)
    {
        //Control  des données envoyées
        return Validator::make($data,['nom'=> 'required']);
    }

    public function p_AddOpera(Request $request)
    {
        // Validation
         $validation = $this->ControlData($request->all())->validate();

        // Opérateur
         $matOp    = rand(4,20).'Ap';
         $dataOp   = ['operateurMat'=>$matOp,
                      'operateurNom'=>$request->nom,
                      'operateurContact'=>$request->contact,
                      'operateurLieu'=>$request->lieu,
                      'operateurDate' =>$request->date
                    ];

        // Ajout opérateur
         operateur::create($dataOp);

        // Retour JSON
         return response()->json();

    }

    //AddOperation 

    public function p_AddOperation(Request $request)
    {
        // Validation
         $validation = $this->ControlData($request->all())->validate();

        // Opérateur
         $matOp    = rand(4,20).'A';
         $dataOp   = ['OperationLibele'  => $request->nom,
                      'Operationcomt'    => $request->comment,
                      'operationCode'    => $matOp
                    ];

        // Ajout opérateur
         operation::create($dataOp);

        // Retour JSON
         return response()->json();

    }

    public function p_OpComd(Request $request)
    {
        //Lectures des opérations
        $pagePath =  $request->path();
        $perPage  =  setDefault($request->perPage,25);
        //$operat = operation::all()->sortByDesc('id')->paginate($perPage);
        $operat = operation::orderBy('id','desc')->paginate($perPage);

        return view('pages.principale.operateur.p_OpComd')
               ->with('operat',$operat)
               ->with('pagePath',$pagePath)
               ->with('perPage',$perPage);
    }



    public function p_cmdDOp(Request $request)
    {   
        // Suppression de l'opération
         operation::where('id','=',$request->idV)->delete();
    }

    public function p_DetCmd(Request $request)
    {
       
        //Lecture des détails de la commande
         $comL = DB::table('commandes')
            ->join('produits', 'commandes.produits_id', '=', 'produits.id')
            ->select('commandes.*', 'produits.produitLibele', 'produits.produitPrix')
            ->where('NmComd','=',$request->IdDet)
            ->get();
        $output = '';
        $output.= '<div class="table-responsive fs--1">
                <table class="table table-striped border-bottom">
                  <thead class="bg-200 text-900">
                    <tr>
                      <th class="border-0">Produits</th>
                      <th class="border-0 text-center">Quantité</th>
                      <th class="border-0 text-right">Prix unit.(fcfa)</th>
                      <th class="border-0 text-right">Prix Achat.(fcfa)</th>
                      <th class="border-0 text-right">Total(fcfa)</th>
                    </tr>
                  </thead>
                  <tbody>';
         for ($i=0; $i < count($comL) ; $i++) {
                $output.='<tr>
                      <td class="align-middle">
                        <h6 class="mb-0 text-nowrap">'.$comL[$i]->produitLibele.'</h6>
                      </td>
                      <td class="align-middle text-center">'.$comL[$i]->qte.'</td>
                      <td class="align-middle text-right">'.$comL[$i]->produitPrix.'</td>
                      <td class="align-middle text-right">'.$comL[$i]->prixAchat.'</td>
                      <td class="align-middle text-right">
                       '.$comL[$i]->qte*$comL[$i]->prixAchat.'
                      </td>
                    </tr>';
         }

        $output.='</tbody>
                </table>
              </div>';
        return $output;
    }

    public function p_stockDel(Request $request)
    {
        // Gestion des opérations des opérateurs
         return "listes des opérations";
    }

    public function p_DetStck(Request $request)
    {
       
    }

    public function p_OpListe(Request $request)
    {
        //Lectures des opérations-operateurs
         $pagePath =  $request->path();
         $perPage  =  setDefault($request->perPage,25);
         $opera    =  operateur::orderBy('id','desc')->paginate($perPage);

         return view('pages.principale.operateur.p_OpListe')
                ->with('opera',$opera)
                ->with('pagePath',$pagePath)
                ->with('perPage',$perPage);
    }

    public function p_OpDele(Request $request)
    {
        // Suppression d'opération lié à l'opérateur
         operation_has_operateurs::where('operateurs_id','=',$request->idV)->delete();
         operateur::where('id','=',$request->idV)->delete();
    }

    public function p_OpUpd(Request $request)
    {

        // Lecture des opérateurs en fonction de l'id
         $operL = operateur::where('id','=',$request->idOp)->get();
         $output = '';

           for ($i=0; $i < count($operL) ; $i++){
              $output.='
                <div class="infos">
                </div>
        
                <div class="form-group">
                 <label for="name">Nom</label>
                 <input class="form-control" id="nom" type="text" value="'.$operL[$i]->operateurNom.'">
                </div>

                <div class="form-group">
                 <label for="name">Contact</label>
                 <input class="form-control" id="contact" type="text" 
                  value="'.$operL[$i]->operateurContact.'">
                </div>

                <div class="form-group">
                 <label for="name">Lieu</label>
                 <input class="form-control" id="lieu" type="text" 
                  value="'.$operL[$i]->operateurLieu.'">
                </div>

                <input type="hidden" id="IdOp" value="'.$operL[$i]->id.'">
              ';
           }

          return $output;
    }

    public function p_OpUpval(Request $request)
    {
        operateur::where('id','=',$request->IdOp)
                ->update([ 'operateurNom'     => $request->nom,
                           'operateurContact' => $request->contact,
                           'operateurLieu'    => $request->lieu 
                       ]);
    }

    public function p_OpTion(Request $request)
    {
        // Réception des données
         $ipOp = !isset($request->val1) ? $request->idV: $request->val1;
         $pagePath =  $request->path();
         $perPage  =  setDefault($request->perPage,25);

        // Lecture des opérations-opérateurs
         $OpTion = DB::table('operateurs')
            ->join('operation_has_operateurs', 'operateurs.id', '=',
                    'operation_has_operateurs.operateurs_id')
            ->join('operations', 'operations.id', '=', 
                   'operation_has_operateurs.operations_id')
            ->select('operateurs.*', 'operation_has_operateurs.*', 'operations.*','operation_has_operateurs.id as opeOperat','operations.id as IDoperation')
            ->where('operateurs.id','=',$ipOp)
            ->paginate($perPage);


        
        // Lecture des  opérateurs
         $oper = operateur::where('operateurs.id','=',$ipOp)->get();
         for ($i=0; $i <count($oper) ; $i++) 
         { 
           $idOp = $oper[$i]->id;
         }
         
        // Valeur retournée
         return view('pages.principale.operateur.p_OpTion')
                ->with('OpTion',$OpTion)
                ->with('idOp',$idOp)
                ->with('oper',$oper)
                ->with('perPage',$perPage)
                ->with('pagePath',$pagePath);

    }

    public function p_opDet(Request $request)
    {
       // Réception des données
        $operation = $request->operation;
        $operationcode = $request->operationcode;
        $idsortie = $request->idOpVe;

        // Lecture de la soritie en fonction de l'id
        $sorties = DB::table('sortie_ops')
                   ->select('sortie_ops.*')
                   ->where('sortie_ops.id','=',$request->idOpVe)
                   ->first();
        //dd($sorties);

        // Lecture des produits liés  à  la sortie
        $prodSt = DB::table('produits_has_sortie_ops')
                  ->join('sortie_ops','produits_has_sortie_ops.sortie_ops_id','=','sortie_ops.id')
                  ->join('produits','produits_has_sortie_ops.produits_id','=','produits.id')
                  ->select('produits.*','produits.id as ProdID','sortie_ops.*','sortie_ops.id as sortieID','produits_has_sortie_ops.*','produits_has_sortie_ops.id as ProdSortID')
                  ->where('sortie_ops.id','=',$request->idOpVe)
                  ->get();
        /*dd($prodSt);*/
        
        // Détails de l'opération des opérateurs
         $total= 0;
         $output ='';
         $output.='
           <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">
               '.$operation.'_'.$operationcode.'</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">Date sortie le: '.$sorties->dateSortie.'</li>
            </ol>
           </nav>
         ';
         $output.='
            <div class="table-responsive fs--1">
                <table class="table table-striped border-bottom">
                  <thead class="bg-200 text-900">
                    <tr>
                      <th class="border-0">Matr.</th>
                      <th class="border-0">Article</th>
                      <th class="border-0 text-center">Qte</th>
                      <th class="border-0 text-center">Prix vente('.getMyDevise().')</th>
                      <th class="border-0 text-center">Prix Total('.getMyDevise().')</th>
                      <th class="border-0 text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>';
                  /*dd($prodSt);*/
                for ($i=0; $i < count($prodSt) ; $i++){
                 $output.='
                    <tr>
                      <td class="align-middle">
                       '.$prodSt[$i]->produitMat.'
                      </td>
                      <td class="text-center">
                       '.$prodSt[$i]->produitLibele.'

                        <span class="badge badge-pill badge-warning">Fournis :'.$prodSt[$i]->produitPrixFour.' '.getMyDevise().'</span>
                      </td>
                      <td class="text-center">'.$prodSt[$i]->qte.'</td>
                      <td class="text-center">'.$prodSt[$i]->prixvente.'</td>
                      <td class=" text-right">
                      '.$prodSt[$i]->prixvente*$prodSt[$i]->qte.'
                      </td>
                      <td>
                       <a href="#"><span class="badge badge-pill badge-danger supdet" id='.$prodSt[$i]->ProdSortID.'>Supprimer</span></a>
                      </td>
                    </tr>';
                    $total += $prodSt[$i]->prixvente * $prodSt[$i]->qte; 
                 }
            $output.='
                  </tbody>
                </table>
              </div><br><br>
              <div class="row no-gutters justify-content-end">
                <div class="col-auto">';

                $output.='
                  <div class="alert alert-info" role="alert">
                    Montant total payé : '.$total.' '.getMyDevise().'
                  </div>
                    ';
                $output.='  
                </div>
              </div>
         ';

        $output.='
          <script>
            $(".supdet").click(function(){
               var id = $(this).attr("id");
               if(confirm("Ce produit sera supprimé ?")){
                 $.ajax({
                   url:"delPrd",
                   method:"get",
                   dataType:"html",
                   data:{prodSortieID:id},
                   success:function(data){
                     Swal.fire(
                        "Succès !",
                        "Ce produit a été supprimer de la sortie, actualiser la page",
                        "success"
                      )
                   },
                   error:function(data){
                      alert("Error");
                   }
                 })
               }else{
                 console.log("echec");
               }
            });
          </script>
        ';
        return $output;
    }

    public function p_OptnDel(Request $request)
    {
        // Suppression de l'opération-opérateurs
        Schema::disableForeignKeyConstraints();

         $sortie = sortie_ops::where('option_opteur_id', '=', $request->idV);
         // sortieOp_has_produits::where('sortieOp_id','=',$sortie->id)->delete();
         operation_has_operateurs::where('id','=',$request->idV)->delete();

        Schema::enableForeignKeyConstraints();
    }

    public function p_opetNew(Request $request)
    {
        $operateurs = operateur::all();
        $operations = operation::all();
        return view('pages.principale.operateur.p_OpNew')->withOperateurs($operateurs)->withOperations($operations);
    }

    protected function ControlOpOpera(array $data)
    {
        // Control New operations-operateurs
        return Validator::make($data,[
                                 'opera'   => 'required',
                                 'operat'  =>  'required',
                                 'montant' => 'required'
                                ]);
    }


    public function p_opeOpNew(Request $request)
    {
      
       /* Ajout de nouvelle operation-operateur*/

        // Controle des données
         $validation = $this->ControlOpOpera($request->all())->validate();
         $dataOp   = ['operateurs_id'=>$request->operat,
                      'operations_id'=>$request->opera,
                      'depot_init'=>$request->montant,
                      'montant'=>$request->montant,
                      'montantrestant'=>$request->montant,
                      'date'=> $request->date,
                    ];


        // Ajout
         operation_has_operateurs::create($dataOp);

        // Retour JSON
         return response()->json();
    }


    public function  p_OpSortie(Request $request)
    {

        if(!empty($_SESSION['sortieIdOp']) )
        {
            if ($_SESSION['sortieIdOp'] != $request->idV) 
            {
                unset($_SESSION['sortieOp']); // vidage de session panier
                unset($_SESSION['sortieName']); // vidage de session panier
                unset($_SESSION['sortieid']); // vidage de session panier
                unset($_SESSION["sortieNameOp"]); //vidage du nom de l'operateur
                unset($_SESSION["sortieIdOp"]); // vidage de l'Id de la sortie
            }

        }
        $operateur = operateur::where('id','=',$request->idV)->first();
        // Lecture des opérations de l'opérateurs
         $operations = DB::table('operation_has_operateurs')
            ->join('operateurs', 'operation_has_operateurs.operateurs_id', '=', 'operateurs.id')
            ->join('operations', 'operation_has_operateurs.operations_id', '=', 'operations.id')
            ->select('operateurs.*','operations.*', 'operation_has_operateurs.*','operateurs.id as OperaID','operations.id as opetionID','operation_has_operateurs.id as operaOpt')
            ->where('operateurs.id','=',$request->idV)
            ->get();

        //Ajout de nouvelle sortie  pour un operateur 
         return view('pages.principale.operateur.p_OpSortie')
               ->withOperateur($operateur)
               ->withOperations($operations);
    }
    //Ajout de credit a une operation
    public function addCredit(Request $request)
    {
      $agent               = $request->agent;
      $moyen               = $request->moyen;
      $montant             = $request->montant;
      $datePayVers         = $request->datePayVers;
      $Operation_operateur = $request->Operation_operateur;
      echo " Operation_operateur:".$Operation_operateur.
           " | datePayVers: ".$datePayVers.
           " | montant:".$montant.
           " | moyen: ".$moyen.
           " | agent: ".$agent;
      $op = operation_has_operateurs::where('id','=',$Operation_operateur)
            ->first();

      // Mise à jour du solde   
      $op->montant = $op->montant+$montant;
      // Payer le crédit
      $op->montantrestant = $op->montantrestant+$montant;
      $op->save();
      // Enregistrement des l'historique de paiement
      $dataOp = ['nomAgent'=>$agent,
                 'montantPaye'=>$montant,
                 'datePaiement'=>$datePayVers,
                 'typepaiement'=>$moyen,
                 'optionOpteur_id'=>$Operation_operateur
                ];
      operation_pay_historiques::create($dataOp);
      return  response()->json();
    }

    // Story des paiement des crédits liés à une opération
    public function story(Request $request)
    {
        // Réception des données
         $idoperat = $request->idOperaOperat;
         $opt_has_ope = operation_pay_historiques::
                        where('optionOpteur_id','=',$idoperat)
                        ->orderBy('id','desc')
                        ->get();
         /*dd($opt_has_ope);*/
         $output='';

        $output.='
            <table class="table table-hover">
            
             <thead>
               <tr>

                 <th scope="col">Agent</th>
                 <th scope="col">Montant('.getMyDevise().')</th>
                 <th scope="col">Date</th>
                 <th>Type</th>

               </tr>
             </thead><tbody>';

                foreach ($opt_has_ope as $key => $value){
                 $output.='<tr>
                   <th scope="row">'.$value->nomAgent.'</th>
                   <td>'.$value->montantPaye.'</td>
                   <td>'.$value->datePaiement.'</td>
                   <td class="white-space-nowrap">'.$value->typepaiement.'</td>
                  </tr>';
                }
            $output.='</tbody></table>';

             return $output;
    }


    public function savePrdSortie(Request $request)
        {


            // Ajax validation et retour
            $validator = $this->validator($request->all())->validate();

            //Generation de clé unique
            $idProduit = $request->article.rand(0,10000);
            
            //Création des panier 
            if (isset($_SESSION['sortieOp'])) 
                 {
                    $count = count($_SESSION["sortieOp"]);
                    $item_array = array(
                     'qte'      => $request->quantite,
                     'prix'     => $request->prix,
                     'article'     =>getPrd($request->article)->produitLibele,
                     'idArticle'     => $request->article,

                     );
                    $_SESSION["sortieOp"][] = $item_array;
                  }
            else{

                $item_array = array(
                 'qte'      => $request->quantite,
                 'prix'     => $request->prix,
                 'article'     =>getPrd($request->article)->produitLibele,
                     'idArticle'     => $request->article,

                 );

                //Création de session
                 $_SESSION["sortieOp"][] = $item_array;
              }
                    if (empty($_SESSION["sortieName"])) 
                    {

                       $_SESSION["sortieName"] = $request->sortieLibelle;
                       $_SESSION["sortieid"] = $request->sortieNom;
                       $_SESSION["sortieIdOp"] = $request->sortieIdOp;
                       $_SESSION["sortieNameOp"] = $request->sortieNameOp;
                    }


            return response()->json();
        }


    protected function validator(array $data)
        {
            return Validator::make($data, [
                'quantite' => 'required|min:1',
                'article' => 'required',
                'prix' => 'required|min:1',
            ]);
        }
        

    public function listeSortiPrd(Request $request)
    {
        // Réception des données
         $idoperateur          = $request->idOp;
         $idoperationOperateur = $request->idOpt;
         $operation            = $request->operation;
         $operationcode        = $request->operationcode;
         $operationcoment      = $request->operationcoment;
         
        // liste des produits de la sortie;
         $option_opteur = operation_has_operateurs::find($_SESSION['sortieid']);

        return view('pages/principale/operateur/listPrdSortie')
                ->with('option_opteur',$option_opteur)
                ->with('operation',$operation)
                ->with('operationcode',$operationcode)
                ->with('operationcoment',$operationcoment)
                ->with('idoperateur',$idoperateur)
                ->with('idoperationOperateur',$idoperationOperateur);
    }

    public function saveSortie(Request $request)
    {
        
        // Réception des données
         $charges = $request->charges;
         $chgDesc = $request->chargeDesc;
         $tva = $request->tva;

        // Traitement des données reçues
         if ($chgDesc==null) {
           $chgDesc = "aucun";
         }

        // Enregistrement de la sortie
         if (!empty($_SESSION['sortieOp']))
          {
            //Generation du matricule de la sortie
            $matricule = "SRT#".date("d/m/Y")."#".rand(0,1000); 
            // dd($matricule);

            $dataS = ['matSortie'=> $matricule,
                      "libelleSortie" =>
                      'Sortie_'.$_SESSION['sortieName'],
                      "operationsOperateurs_id" =>
                      (int)$_SESSION["sortieid"],

                      "dateSortie" => $request->dateSortie,
                      "charges" => $charges,
                      "tva" => $tva,
                      "chargesDesc"=>$chgDesc
                     ];
            $sortie = sortie_ops::create($dataS);

            // Parcours du panier
             $prixTotal = 0;
             $qteTotal = 0;
             //dd($_SESSION['sortieOp']);
             foreach ($_SESSION['sortieOp'] as $key => $value)
             {
                $arrayPrdArriv = [
                   "prixvente" => $value['prix'],
                   "qte" => $value['qte'],
                   "sortie_ops_id"  => $sortie->id,
                   "produits_id"  =>$value['idArticle'],
                ];
                $prixTotal += $value['prix']*$value['qte'];
                $qteTotal += $value['qte'];

                //Enregistrement dans la table *sortie_ops*
                /* $sortie->quantiteS = $qteTotal;
                 $sortie->montantS= $prixTotal;
                 $sortie->save();*/

                // Enregistrement dans la table
                 produits_has_sortie_ops::create($arrayPrdArriv);
             }

            // Calcul de la TVA + montantTotal
             $tvaVal = ($prixTotal*$tva)/100;
             $prixTotal = $tvaVal+$charges+$prixTotal;


                 $sortie->quantiteS = $qteTotal;
                 $sortie->montantS= $prixTotal;
                 $sortie->save();
                 $opt_has_ope = operation_has_operateurs::where('id','=',(int)$_SESSION["sortieid"])->get()->first();
                  
                 $opt_has_ope->montantrestant = $opt_has_ope->montantrestant - $prixTotal;
                 $opt_has_ope->save();
          }
          return $this->suprSortie();

    }

    public function suprPrdSortie(Request $request)
    {
        //Supression d'un produits de la sortie

            $nbr =(int)$request->NumArt; //conversion en entier
            unset($_SESSION['sortieOp'][$nbr]);
            return response()->json();
    }
    public function suprSortie()
    {

            unset($_SESSION['sortieOp']); // vidage de session panier
            unset($_SESSION['sortieName']); // vidage de session panier
            unset($_SESSION['sortieid']); // vidage de session panier
            unset($_SESSION["sortieNameOp"]); //vidage du nom de l'operateur
            unset($_SESSION["sortieIdOp"]); // vidage de l'Id de la sortie
            return response()->json();

    }

    public function p_listeSortie(Request $request)
    {
        // Réception des données
        $operation = $request->operation;
        $operationcode = $request->operationcode;
        $operationcoment = $request->operationcoment;
        $idoperateurOperation = $request->idOpt;
        $idOp = $request->idOp;

        $ipOp = $request->idV;
        $pagePath =  $request->path();
        $perPage  =  setDefault($request->perPage,25);

        //Lecture de la sortie en fonction de l'id operationOperateur
        $sorties = sortie_ops::where('operationsOperateurs_id','=',
                        $request->idOpt)
                  ->orderBy('id','desc')->get();
        
        $operateur = operateur::find($request->idOp);

        return view('pages/principale/operateur/p_listeSortie')
               ->withOperateur($operateur)
               ->with('operation',$operation)
               ->with('operationcode',$operationcode)
               ->with('operationcoment',$operationcoment)
               ->with('idOpt',$idoperateurOperation)
               ->with('idOp',$idOp)
               ->with('pagePath',$pagePath)
               ->with('perPage',$perPage)
               ->with('sorties',$sorties);

    }

    // Suppression d'une sortie
    public function p_SortieDel(Request $request)
    {
      $idSortie = $request->idST;
       
      //Lecture de la sortie en fonction de l'id
      $sorties = DB::table('sortie_ops')
                  ->select('sortie_ops.*')
                  ->where('sortie_ops.id','=',$idSortie)
                  ->first();
       $operationOperateurId = $sorties->operationsOperateurs_id;

      // Mise à jour du montant restant::operationOperateur
       $operationOperateur = DB::table('operation_has_operateurs')
                  ->select('operation_has_operateurs.*')
                  ->where('operation_has_operateurs.id','=',
                    $operationOperateurId)
                  ->first();
        // Montant restant
        $newMontant = $sorties->montantS+
                      $operationOperateur->montantrestant;

        $operationOperateur = DB::table('operation_has_operateurs')
              ->where('id', $operationOperateurId)
              ->update(['montantrestant' => $newMontant]);

        // Suppression de la sortie
         DB::table('sortie_ops')->where('sortie_ops.id', '=', 
           $idSortie)->delete();

        // Suppression des produits liés à la sortie
         DB::table('produits_has_sortie_ops')
            ->where('produits_has_sortie_ops.sortie_ops_id', '=', 
              $idSortie)
            ->delete();

    }

    // Suppressions des produits d'une sortie donnée
     public function delPrd(Request $request)
     {
        // Réception des données
        $idSortieProd = $request->prodSortieID;

        // Lecture de l'id_sortie lié à la table produits_has_sortie_ops
         $SortieProd = DB::table('produits_has_sortie_ops')
                  ->select('produits_has_sortie_ops.*')
                  ->where('produits_has_sortie_ops.id','=',
                    $idSortieProd)
                  ->first();
         $sortieID = $SortieProd->sortie_ops_id;

         $SortieProdAll = DB::table('produits_has_sortie_ops')
                  ->select('produits_has_sortie_ops.*')
                  ->where('produits_has_sortie_ops.sortie_ops_id','=',
                    $sortieID)
                  ->get();
          $nb = count($SortieProdAll);
          
        // Lecture de la sortie en fonction de l'id recuperé
         $sorties = DB::table('sortie_ops')
                    ->select('sortie_ops.*')
                    ->where('sortie_ops.id','=',$sortieID)
                    ->first();
            $matSortie = $sorties->matSortie;
            $montantS  = $sorties->montantS;
            $quantiteS = $sorties->quantiteS;
            $charges   = $sorties->charges;
            $tva       = $sorties->tva;

          // Calcul du nouveau montant de la sortie
          $newMontantS = $sorties->montantS - 
                         ($SortieProd->prixvente*$SortieProd->qte);

          // Calcul de la nouvelle quantité de produit de la sortie
          $newqte = $sorties->quantiteS - $SortieProd->qte;

         /* // Nouvelle tva & Nouvelle charges
          if ($nb==1) {
            $tvaNew = 0;
            $charges = 0;
          }else{
            $charges = $sorties->charges;
            $tvaNew  = $sorties->tva;/*
            $newMontantS = $newMontantS1+$tvaNew+$charges;
          }*/

        // Mise à jour du montant restant lié à operation_operateur
          $operationOperateur = DB::table('operation_has_operateurs')
                  ->select('operation_has_operateurs.*')
                  ->where('operation_has_operateurs.id','=',
                    $sorties->operationsOperateurs_id)
                  ->first();
          
          // Nouveau montant du compte dépôt
          $newMontant = $operationOperateur->montantrestant+
                        ($SortieProd->prixvente*$SortieProd->qte);

          $operationOperateur = DB::table('operation_has_operateurs')
              ->where('id', $operationOperateur->id)
              ->update(['montantrestant' => $newMontant]);


          
        // Mise à jour du montant de la sortie
          $operationOperateur = DB::table('sortie_ops')
              ->where('id', $sortieID)
              ->update(['montantS' => $newMontantS,
                        'quantiteS'=> $newqte,
                      ]);

        // Suppression de produits_has_sortie_ops en fonction de l'id
         DB::table('produits_has_sortie_ops')
            ->where('produits_has_sortie_ops.id', '=', 
              $idSortieProd)
            ->delete();

        // Retour de la suppression
         echo "Supprimé avec succès, veuillez actualiser la page";

     }

    // Récupération des sorites d'une opération
    public function p_opRecuSorti(Request $request)

    {
        
      // Réception de l'id de la sortie
       $sortieID = $request->idOpVe;

      // Lecture de la sortie en fonction de l'id sortie
        $sortie = DB::table('sortie_ops')
                  ->select('sortie_ops.*')
                  ->where('sortie_ops.id','=',$sortieID)
                  ->first();

      // Lecture de l'opérateur lié à la sortie
        $operateurOperation = DB::table('operation_has_operateurs')
                  ->select('operation_has_operateurs.*')
                  ->where('operation_has_operateurs.id','=',
                    $sortie->operationsOperateurs_id)
                  ->first();

        $operateur = DB::table('operateurs')
          ->select('operateurs.*')
          ->where('operateurs.id','=',$operateurOperation->operateurs_id)
          ->first();
        //dd($operateur);


      //Lecture de la table produits_has_sortie_ops -> id
        $OpTion = DB::table('produits_has_sortie_ops')
                 ->join('produits','produits_has_sortie_ops.produits_id',     '=','produits.id')
            ->select('produits.*', 'produits_has_sortie_ops.*')
            ->where('produits_has_sortie_ops.sortie_ops_id','=',
                    $sortieID)
            ->get();

      // Montant total de la sortie
       $somTotal = 0;

      $output ='
              <div class="row justify-content-between align-items-center">
                <div class="col">
                  <h6 class="text-500">Facture à </h6>
                  <h5>'.$operateur->operateurNom.'</h5>
                  <p class="fs--1">'.$operateur->operateurLieu.'<br></p>
                  <p class="fs--1">
                   <a href="tel:'.$operateur->operateurContact.'">'.$operateur->operateurContact.'</a>
                  </p>
                </div>
                <div class="col-sm-auto ml-auto">
                  <div class="table-responsive">
                    <table class="table table-sm table-borderless fs--1">
                      <tbody>
                        <tr>
                          <th class="text-sm-right">N° de commande:</th>
                          <td>'.$sortie->matSortie.'</td>
                        </tr>
                        <!--<tr>
                          <th class="text-sm-right">Order Number:</th>
                          <td>AD20294</td>
                        </tr>-->
                        <tr>
                          <th class="text-sm-right">Date de la facture:</th>
                          <td>'.$sortie->dateSortie.'</td>
                        </tr>
                        <!--<tr>
                          <th class="text-sm-right">Paiement dû:</th>
                          <td>Dès réception</td>
                        </tr>-->
                        <tr class="alert-success font-weight-bold">
                          <th class="text-sm-right">Montant dû:</th>
                          <td>'.$sortie->montantS.' '.getMyDevise().'</td>
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

            for ($i=0; $i < count($OpTion) ; $i++){
              $output .='<tr>
                      <td class="align-middle">
                        <h6 class="mb-0 text-nowrap"> 
                        '.$OpTion[$i]->produitLibele.' </h6>
                      </td>
                      <td class="align-middle text-center">
                       '.$OpTion[$i]->qte.' 
                        ('.$OpTion[$i]->unite_mesure.')</td>
                      <td class="align-middle text-center">
                       '.$OpTion[$i]->prixvente.' '.getMyDevise().'</td>
                      <td class="align-middle text-right">
                       '.$OpTion[$i]->qte * $OpTion[$i]->prixvente.' '.getMyDevise().'
                      </td>
                    </tr>';
                     $somTotal += $OpTion[$i]->prixvente * $OpTion[$i]->qte;
                  }

        // Calcul de la charges liées à la sorties
                  /*dd($sortie);*/
         if ($sortie->charges!=null) {
           $charges = $sortie->charges;
         }else{
           $charges = 0;
         }

        // Calcul de la tva lié à la sortie
          if ($sortie->tva!=null) {
           $tva = $sortie->tva;
         }else{
           $tva = 0;
         }

        // Calcul du montant total TTC
         $tvaV = ($somTotal*$sortie->tva)/100;
         $ttc = $tvaV+$charges+$somTotal;

        $output .='</tbody>
                </table>
              </div>
              <div class="row no-gutters justify-content-end">
                <div class="col-auto">
                  <table class="table table-sm table-borderless fs--1 text-right">
                    
                    <tr>
                      <th class="text-900">Sous-total:</th>
                      <td class="font-weight-semi-bold">
                        '.$somTotal.' '.getMyDevise().'
                       </td>
                    </tr>

                    <tr>

                      <th class="text-900">Autres:</th>
                      <td class="font-weight-semi-bold">'.
                       $charges.' '.getMyDevise().'
                      </td>
                    </tr>

                    <!--<tr>
                      <th class="text-900">tva 
                      ('.$tva.'%) : </th>
                      <td class="font-weight-semi-bold">
                        '.($somTotal*$sortie->tva)/100 .' 
                        '.getMyDevise().'
                       </td>
                    </tr>-->

                    
                   
                    <tr class="border-top text-danger">
                      <th class="text-900">Montant TTC:</th>
                      <td class="font-weight-semi-bold text-danger"> '.$ttc.' '.getMyDevise().'</td>
                    </tr>
                  </table>
                </div>
              </div>';

              return $output;
    }


    // Récupération des sorites d'une opération
    public function p_editSortie(Request $request)

    {
        
      // Réception de l'id de la sortie
       $sortieID = $request->idOpVe;

      // Lecture de la sortie en fonction de l'id sortie
        $sortie = DB::table('sortie_ops')
                  ->select('sortie_ops.*')
                  ->where('sortie_ops.id','=',$sortieID)
                  ->first();

      // Lecture de l'opérateur lié à la sortie
        $operateurOperation = DB::table('operation_has_operateurs')
                  ->select('operation_has_operateurs.*')
                  ->where('operation_has_operateurs.id','=',
                    $sortie->operationsOperateurs_id)
                  ->first();

        $operateur = DB::table('operateurs')
          ->select('operateurs.*')
          ->where('operateurs.id','=',$operateurOperation->operateurs_id)
          ->first();
        //dd($operateur);


      //Lecture de la table produits_has_sortie_ops -> id
        $ligne_sortie = DB::table('produits_has_sortie_ops')
                 ->join('produits','produits_has_sortie_ops.produits_id',     '=','produits.id')
            ->select('produits.*', 'produits_has_sortie_ops.*')
            ->where('produits_has_sortie_ops.sortie_ops_id','=',
                    $sortieID)
            ->get();

            // dd($sortie);
            // dd($operateur);
            // dd($ligne_sortie);
          return view('pages/principale/operateur/p_editSortie')
                    ->with('sortie_info',$sortie)
                    ->with('operateur',$operateur)
                    ->with('ligne_sortie',$ligne_sortie);

    }








}

