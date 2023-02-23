<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\clients;
use App\Model\besoins;
use App\Model\clients_has_besoins;
use App\Model\sms_prospect;
use App\Model\prospects_has_sms;
use Validator;
use DB;

class p_prospController extends Controller
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

    public function p_prospNew()
    {
        return view('pages.principale.Prospects.new');
    }

    public function p_prospStat()
    {
        return view('pages.principale.Prospects.stats');
    }

    public function p_prstBesoin(Request $request)
    {
        $pagePath =  $request->path();
        $perPage  =  setDefault($request->perPage,25);
        //$BespL    =  DB::table('besoins')->latest()->get();
        $BespL    =  besoins::orderBy('id','desc')->paginate($perPage);
        return view('pages.principale.Prospects.besoins')
        ->with('BespL',$BespL)
        ->with('pagePath',$pagePath)
        ->with('perPage',$perPage);
    }

    public function p_DelPB(Request $request){
        besoins::where('id','=',$request->idP)->delete();
    }

    public function p_DelBesAll(Request $request)
    {
        DB::table('besoins')->delete();
    }



    public function p_PrUpdB(Request $request){
        // Lecture des besoins en fonction de l'id
         $BesOL = besoins::where('id','=',$request->idp)->get();
         $output = '';
         for ($i=0; $i < count($BesOL) ; $i++){
            $output.='
                <div class="form-group">
                 <label for="name">Nom</label>
                 <input class="form-control" id="nom" type="text" 
                 value="'.$BesOL[$i]->nom.'">
                </div>
                <input type="hidden" id="IdOp" value="'.$BesOL[$i]->id.'">
            ';
          }
          return $output;
    }

    public function prosBUp(Request $request)
    {
     $besoins = besoins::find($request->IdP)->update(['nom'  => $request->nom]);
    }

    public function p_besAdd(Request $request)
    {
     $img ="";
     $details="";
     $dateV="";
     $dataB = ['nom'=>$request->besN,'image'=>$img,'details'=>$details,'dateV'=>$dateV];
     besoins::create($dataB);
    }

    // Analyse statistique des besoins
    public function statBes(Request $request)
    {
        
        $fg = $request->dateS;
        $dateBP  = $request->dateS;
        $output  = '';
        
        //$output .='<input type="hidden" value='.$dateBP.' class="datBPros">';
        $periode = explode(" to ", $dateBP);
        $debut   = $periode[0];
        $fin     = $periode[1];


        // Selection distincte
        $re = DB::table('clients_has_besoins')
                ->whereBetween('dateD', [$debut, $fin])
                ->get();
        $besSta = $re->unique(['besoins_id']);

        // Nombre de besoins
        $nb = $re->countBy('besoins_id');

        // Ordre décroissant
        $besOrd = $nb->sortDesc();
        
        $output.='<div class="card-deck">';
        $bes = $besOrd->keys();
        // Les trois premiers produits les plus demandés
        $nBes = count($bes);
        if ($nBes>3) {
           for ($i=0; $i < 3; $i++) { 
            $id = (int)$bes[$i];
             $dataBes = besoins::find($id);
             $output.='
             <div class="card-deck col-lg-4">
                <div class="card mb-3 overflow-hidden" style="min-width: 12rem">
                    <div class="bg-holder bg-card" 
                     style="background-image:url(assets/img/illustrations/corner-1.png);">
                    </div>
                    <!--/.bg-holder-->

                    <div class="card-body position-relative">
                      <h6>'.$dataBes->nom.'</h6>
                      <div class="display-4 fs-4 mb-2 font-weight-normal text-sans-serif text-warning">
                        '.$besOrd[$bes[$i]].' Demandes
                      </div>
                      <a class="font-weight-semi-bold fs--1 text-nowrap ReSMS" href="#!" id="'.$dataBes->id.'">Relance SMS
                        <span class="fas fa-angle-right ml-1" data-fa-transform="down-1">
                        </span>
                      </a>
                    </div>
                </div>
              </div>';
            }
        }else{
           for ($i=0; $i < $nBes; $i++) { 
             $id = (int)$bes[$i];
             $dataBes = besoins::find($id);
             $output.='
             <div class="card-deck col-lg-4">
                <div class="card mb-3 overflow-hidden" style="min-width: 12rem">
                    <div class="bg-holder bg-card" 
                     style="background-image:url(assets/img/illustrations/corner-1.png);">
                    </div>
                    <!--/.bg-holder-->

                    <div class="card-body position-relative">
                      <h6>'.$dataBes->nom.'</h6>
                      <div class="display-4 fs-4 mb-2 font-weight-normal text-sans-serif text-warning">
                        '.$besOrd[$bes[$i]].' Demandes
                      </div>
                      <a class="font-weight-semi-bold fs--1 text-nowrap ReSMS" href="#!" id="'.$dataBes->id.'">Relance SMS
                        <span class="fas fa-angle-right ml-1" data-fa-transform="down-1"></span>
                      </a>
                    </div>
                </div>
              </div>';
            } 
        }
            

           $output.='
            <div class="col-lg-12 pl-lg-2 mb-3">
              <div class="card h-lg-100 overflow-hidden">
                <div class="card-body p-0">
                  <table class="table table-dashboard mb-0 table-borderless fs--1">
                    <thead class="bg-light">
                      <tr class="text-900">
                        <th>Autres produits demandés</th>
                        <th class="text-right">Nb Demande</th>
                        <th class="pr-card text-right ReSMS" style="width: 8rem">Relance SMS</th>
                      </tr>
                    </thead>
                    <tbody>';
            for ($i=0; $i < count($besOrd) ; $i++) 
            { 
                $id = (int)$bes[$i];
                $dataBes = besoins::find($id);
                $output.='
                    <tr class="border-bottom border-200">
                        <td>
                          <div class="media align-items-center position-relative">
                          <img class="rounded border border-200" src="assets/img/illustrations/falcon.png" width="60" alt="" />
                            <div class="media-body ml-3">
                              <h6 class="mb-1 font-weight-semi-bold">
                              <a class="text-dark stretched-link" href="#!">
                               '.$dataBes->nom.'</a></h6>
                              <p class="font-weight-semi-bold mb-0 text-500">Attirer</p>
                            </div>
                          </div>
                        </td>
                        <td class="align-middle text-right font-weight-semi-bold">
                         '.$besOrd[$bes[$i]].'
                        </td>
                        <td class="align-middle pr-card">
                          <a class="font-weight-semi-bold fs--1 text-nowrap ReSMS" href="#!" id="'.$dataBes->id.'">Relance SMS
                          <span class="fas fa-angle-right ml-1" data-fa-transform="down-1"></span></a>
                        </td>
                    </tr>
                ';
            }
            $output.='
                    </tbody>
                  </table>
                </div>
                <div class="card-footer bg-light py-2">
                </div>
              </div>
            </div>
            ';

        // Modal
            //Sender
             $setting = DB::table('settings')->where('cle','=','sender')->get();
             for ($i=0; $i < count($setting); $i++) { 
                $sender = $setting[$i]->valeur;
             }

        $output.='
        <div class="modal fade" id="SMSModal" tabindex="-1" aria-labelledby="SMSModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="SMSModalLabel">Prospects > SMS Markeing</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <span class="text-success"><i class="fas fa-bullhorn"></i> Attirer des nouveaux clients</span><br>
          
          <input type="hidden" name="Idpros" id="Idpros">

          <div class="form-group">
            <label for="basic-example">SENDER</label>
            <select class="selectpicker senderID" id="senderID">
              <option value='.$sender.'>'.$sender.'</option>
            </select>
          </div>

          <div class="form-group">
            <label for="smsP">Messages</label>
              <textarea class="form-control msgP" id="smsP" 
               rows="3"  onkeyup="count_up(this);"></textarea>
              <p class="text-danger mb-1" style="font-size:15px;">
              Caractères: <span id="compteur">0</span> | SMS: <span id="NbSMS">0</span></p>
              <p class="" style="font-size:12px;">NB: 1 SMS fait 160 caractères</p>
          </div>

      </div>
      <div class="modal-footer">

        <div class="spinner-border lod" role="status"><span class="sr-only">Loading...</span></div>

        <button type="button" class="btn btn-primary sendSMS">Envoyez
          <i class="far fa-paper-plane"></i>
        </button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer
        </button>
        <input type="hidden" value='.$debut.' class="debut">
        <input type="hidden" value='.$fin.' class="fin">
        <input type="hidden"  class="besoID">
      </div>
    </div>
  </div>
</div>
        ';

        // Script de gestion de la page
         $output.='
            <script type="text/javascript">
                $(".lod").hide();
                // Relance SMS
                 $(".ReSMS").click(function(){
                   var idBess = $(this).attr("id");
                   $(".besoID").val(idBess);
                   $("#SMSModal").modal("show");
                 });

                // Comptage  de caractères
                 function count_up(obj){
                   document.getElementById("compteur").innerHTML = obj.value.length;
                   var sms = $("#compteur").text();
                   var nbS = parseInt(sms)/160;
                   $("#NbSMS").text(parseInt(nbS));
                 }

                // Envoie de SMS
                 $(".sendSMS").click(function(){
                    $(".lod").show();
                    var debut    = $(".debut").val();
                    var fin      = $(".fin").val();
                    var besoID   = $(".besoID").val();
                    var msgP     = $(".msgP").val();
                    var senderID = $("#senderID").val();
                    console.log("msgP:"+msgP+"/ fin:"+fin+"/début:"+debut+"::Besoin:"+besoID+"/Sender:"+senderID);
                    $.ajax({
                      url:"ReProsSMS",
                      method:"get",
                      data:{debut:debut,fin:fin,msgP:msgP,SenderID:senderID,besoID:besoID},
                      dataType:"json",
                      success:function(data){
                        $(".msgP").val("");
                        if (data.success==1) {
                          Swal.fire(
                            "Message envoyé !",
                            "Le prospect a bien reçu le sms",
                            "success"
                          )
                        }else{
                          Swal.fire(
                           "Message echoué !",
                            data.error,
                           "error"
                          )
                        }
                        $(".lod").hide();
                      },
                      error:function(){
                        Swal.fire("Envoie de SMS echoué");
                        $(".lod").hide();
                      }
                    });
                 });

            </script>
         ';

         return $output;

    }

    public function SMSAn(Request $request)
    {
        echo "Relance SMS";
    }

    // Analyse statistiques Relance SMS
     public function ReProsSMS(Request $request){
        
        // Réception des données
         $IdBesP = $request->besoID;
         $msg    = $request->msgP;
         $Sender = $request->SenderID;
         $fin    = $request->fin;
         $debut  = $request->debut;

         //dd($debut.'-'.$fin.' :: '.$msg.' ::'.$SendID.' :: '.$IdBesP);

        // Traitement des données

        // Jointure prospect-besoins propsects
         $prospL = DB::table('clients_has_besoins')
            ->join('clients','clients.id','=','clients_has_besoins.clients_id')
            ->select('clients.*', 'clients.id as IdClients')
            ->where('clients_has_besoins.besoins_id','=',$IdBesP)
            ->whereBetween('dateD', [$debut, $fin])
            ->get();
           // dd($prospL);


         for ($i=0; $i < count($prospL) ; $i++) { 
           $sms =  Sendsms($msg,$prospL[$i]->contact,$Sender);
         }
         return $sms;
        
     }  

    public function p_RelSMS(Request $request)
    {

        // Jointure prospect_sms - prospect
         /*$prospL = DB::table('prospects_has_sms')
            ->join('prospects','prospects.id','=','prospects_has_sms.prospects_idprospects')
            ->join('sms_prospect','sms_prospect.id','=','prospects_has_sms.SMS_idSMS')
            ->select('prospects.*', 'prospects.tel', 'prospects.nom')
            ->get();*/

        return view('pages.principale.Prospects.relSMS');
    }

     
    protected function ControlData(array $data)
    {
        //Control  des données envoyées
        return Validator::make($data,['phone' => 'required']);
    }

    public function p_AddPros(Request $request)
    {
        // Validation
         $validation = $this->ControlData($request->all())->validate();

        //Ajout
          $stat = 0;
          $lieu = 'lieu';
          setlocale(LC_TIME, 'fra_fra');
          $now = date('d/m/Y'); 

          $dataP  = ['nom'      => $request->nom,
                     'contact'  => $request->pref.$request->phone,
                     'lieu'     => $lieu,
                     'date'     => $now,
                     'mail'     => $request->email,
                     'statutClt'=> $stat
                   ];

          clients::create($dataP);


        // Retour json
         return response()->json(); 
    }

    public function p_prospL(Request $request)
    {
        $pagePath =  $request->path();
        $perPage = setDefault($request->perPage,25);

        $prospL = DB::table('clients')
                   ->where('statutClt','=',0)
                   ->paginate($perPage);

        $BesExs  = besoins::all();
        $nb = count($prospL);

        //Sender
        $setting = DB::table('settings')
                     ->where('cle','=','sender')
                     ->get();

        for ($i=0; $i < count($setting); $i++) { 
            $sender = $setting[$i]->valeur;
        }

        return view('pages.principale.Prospects.list')
                ->with('prospL',$prospL)
                ->with('BesExs',$BesExs)
                ->with('nb',$nb)
                ->with('sender',$sender)
                ->with('pagePath',$pagePath)
                ->with('perPage',$perPage);;
    }

    public function p_DelP(Request $request)
    {
        clients::where('id','=',$request->idP)->delete();
        clients_has_besoins::where('clients_id','=',$request->idP)->delete();
    }

    public function p_DelPAll(Request $request)
    {
        clients::where('statutClt','=',0)->delete();
    }

    public function p_PrUpd(Request $request)
    {
        // Lecture des opérateurs en fonction de l'id
         $prosL = clients::where('id','=',$request->idp)->get();
         $output = '';

         for ($i=0; $i < count($prosL) ; $i++){
            $output.='
                <div class="form-group">
                 <label for="name">Nom</label>
                 <input class="form-control" id="nom" type="text" 
                 value="'.$prosL[$i]->nom.'">
                </div>

                <div class="form-group">
                 <label for="name">Téléphone</label>
                 <input class="form-control" id="phone" type="number" 
                 value="'.$prosL[$i]->contact.'">
                </div>

                <div class="form-group">
                 <label for="name">Email</label>
                 <input class="form-control" id="email" type="email" 
                 value="'.$prosL[$i]->mail.'">
                </div>
                <input type="hidden" id="IdOp" value="'.$prosL[$i]->id.'">
            ';
         }
         return $output;
    }

    public function prosUp(Request $request)
    {
       clients::where('id','=',$request->IdP)
              ->update(['nom'     => $request->nom,
                        'contact' => $request->phone,
                        'mail'    => $request->email ]);
    }

    public function p_PrBes(Request $request){

        //Lecture des besoins du prospects
         $BesL = DB::table('clients_has_besoins')
            ->join('besoins', 'besoins.id', '=', 'clients_has_besoins.besoins_id')
            ->select('besoins.*')
            ->where('clients_has_besoins.clients_id','=',$request->idp)
            ->get();
         
        
        $output='';

        for ($i=0; $i < count($BesL) ; $i++) {

           
            $output.='
             <li class="list-group-item d-flex justify-content-between align-items-center">'.$BesL[$i]->nom.' - le '.$BesL[$i]->dateV.'</li>
            ';
        }

        $output.='<input type="hidden" id="Idprosp" value="'.$request->idp.'"/>';

        return $output;
    }

     public function p_besoL(Request $request)
    {
        $NewBes = strtolower($request->besN);
        $AncBes = $request->besAc;
        $IdPors = $request->Idpro;

        if ($NewBes!='' && $AncBes=='no') {
             $dateV = date('d/m/Y');
            // Enregistrer le nouveau
            $dataB = ['nom'     =>$NewBes,
                      'details' =>'besoins clients',
                      'image'   =>'image',
                      'dateV'   => $dateV
                     ];

            // Vérification de l'existence du besoin
             $besoinsV = DB::table('besoins')
                           ->where('nom','=', $NewBes)
                           ->first();
             
             
             if ($besoinsV=='') {
                // Nouveau besoins
                $idB = besoins::create($dataB);
                $idF = $idB->id;
             }else{
                // Ancien besoin
                $idF = $besoinsV->id;
             }


            // Besoins-Prospect
             $idPros = $_GET['Idpro'];
             $dataPB = ['clients_id'=>$IdPors,
                        'besoins_id'=>$idF,
                        'dateD'=> date('d/m/yy')];
             clients_has_besoins::create($dataPB);
            
            $clBes  = clients_has_besoins::all();


            // Lecture Besoins-Prospect
            $BesL = DB::table('clients_has_besoins')
                      ->join('besoins','besoins.id','=','clients_has_besoins.besoins_id')
                      ->select('besoins.*','clients_has_besoins.*')
                      ->where('clients_has_besoins.clients_id','=',$IdPors)
                      ->get();
            $output='';
            $output.='<select class="custom-select mb-3" multiple="">';
            for ($i=0; $i < count($BesL) ; $i++) {
              $output.='<option>'.$BesL[$i]->nom.' - le '.$BesL[$i]->dateD.'
              </option>';

            }
            $output.='</select>';

             return $output;
        }

        if ($NewBes=='' && $AncBes!='') {
                // Besoins-Prospect
                 $dataPB = ['clients_id'  =>$request->Idpro,
                            'besoins_id'  =>$AncBes,
                            'dateD' => date('d/m/yy')
                           ];
                 clients_has_besoins::create($dataPB);

                // Lecture Besoins-Prospect
                  $BesL = DB::table('clients_has_besoins')
                    ->join('besoins', 'besoins.id', '=', 'clients_has_besoins.besoins_id')
                    ->select('besoins.*','clients_has_besoins.*')
                    ->where('clients_has_besoins.clients_id','=',$request->Idpro)
                    ->get();
                  $output='';
                  $output.='<select class="custom-select mb-3" multiple="">';
                   for ($i=0; $i < count($BesL) ; $i++) {
                    $output.='<option>'.$BesL[$i]->nom.
                     '- le '.$BesL[$i]->dateD.'</option>';
                   }
                  $output.='</select>';
                  $output.='<input type="hidden" id="Idprosp" value="'.$request->Idpro.'"/>';
                  return $output;
        }

        if ($NewBes!='' && $AncBes!='') {
            echo "bonjour";
        }

    }

    // Send SMS
    public function ProsSMS(Request $request)
    {
        // Filtrer le messages
         $msg    = $request->msg;
         $pros   = clients::find($request->IPros);
         $tel    = $request->contact;
         $sender = $request->SendID;


        // Envoie de sms
         $sms = Sendsms($msg,$pros->contact,$request->SendID);
         return $sms;

    }


    


}
