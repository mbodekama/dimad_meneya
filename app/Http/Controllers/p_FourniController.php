<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use App\Model\fournisseur;

use App\Model\echeance;
use App\Model\echeancehistorique;

use Validator;

use PDF;
use DB;
use Schema;




class p_FourniController extends Controller

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



    public function p_newF()

    {

        return view('pages.principale.Fournisseur.p_newF');

    }


    //Affiche le formulaire Affectation d'echeance 
    public function p_Eche()

    {

        $Fl = fournisseur::all()->sortByDesc('id');
        //dd($Fl);
        return view('pages.principale.Fournisseur.EcheFour')->with('fours',$Fl);

    }

//Valide le formulaire Affectation d'echeance 

    public function EcheFour(Request $request)
    {
        $info = ['echeanceDate'=>$request->echeance,
                  'echeanceMontant' => $request->montant,
                  'echeanceStatut' =>'en cours', 
                  'fournisseurs_id' =>$request->idFour, 
                  'dateAchat'=> $request->dateAchat
                ];

        echeance::create($info);

        return response()->json();

    }

    

    

    protected function ControlData(array $data)

    {

        //Control  des données envoyées

        return Validator::make($data,['contact' => 'required',

                                      'name'     => 'required',

                                      'respo'  => 'required',

                                      'email'  => 'required|email',

                                   ]);

    }





    public function p_AddF(Request $request)

    {   

        // Validation

         $validation = $this->ControlData($request->all())->validate();

        

         // Fournisseur

         $matF   = rand().'F';

         $dataF  = [ 'fournisseurContact' => $request->contact,

                     'fournisseurNom'     => $request->name,

                     'fournisseurRespo'    => $request->respo,

                     'fournisseurMail'    => $request->email,

                     'fournisseurMat'     => $matF

                   ];



         // Ajout Fournisseur

          $idF = fournisseur::create($dataF);

         return response()->json(); 

    }

        //Form d'edition Fourniseur
    public function editF(Request $request)
    {
        $four = fournisseur::find($request->idF);

        return view('pages.principale.Fournisseur.editF')->withfour($four);

    }

        //Valide d'edition Fourniseur
    public function updateF(Request $request)
    {
        // Validation

         $validation = $this->ControlData($request->all())->validate();

        

         // Fournisseur

    

         $dataF  = [ 'fournisseurContact' => $request->contact,

                     'fournisseurNom'     => $request->name,

                     'fournisseurRespo'    => $request->respo,

                     'fournisseurMail'    => $request->email

            

                   ];


        Fournisseur::where('id','=',$request->fourId)->update($dataF);
        return response()->json();

        
    }


    public function p_listF(Request $request)
    {
        //$fournisseurs = Fournisseur::all();
        $pagePath =  $request->path();
        $perPage  =  setDefault($request->perPage,25);
        $fournisseurs = Fournisseur::orderBy('id','desc')->paginate($perPage);

        return view('pages.principale.Fournisseur.p_listF')
               ->with('fournisseurs',$fournisseurs)
               ->with('pagePath',$pagePath)
               ->with('perPage',$perPage);
    }

    public  function showFour(Request $request)
    {

        //Lecture des echeance d'un fournisseur
         $four = Fournisseur::find($request->idFour);
         
         $EchF = DB::table('fournisseurs')
            ->join('echeances', 'echeances.fournisseurs_id', '=', 'fournisseurs.id')
            ->select('echeances.*', 'fournisseurs.*','fournisseurs.id as is idFour', 'echeances.id as idEch')
            ->where('fournisseurs.id','=',$request->idFour)
            ->get();
        //dd($EchF);
        return view('pages.principale.Fournisseur.showF')
               ->with('EchF',$EchF)
               ->with('four',$four);


    }

    //Paiement fournisseur Historiqe
    public function histEch(Request $request)
    {

        $idEch = (int)$request->idEch;
        $hists = EcheanceHistorique::where('echeance_id','=',$idEch)->get();

        if(count($hists) >= 1)
        {
             $output ='<div class="table-responsive mt-4 fs--1">
                <table class="table table-striped border-bottom">
                  <thead>
                    <tr class="bg-primary text-white">
                     
                      <th class="border-0 text-center">Nom Agent</th>
                      <th class="border-0 text-center">Type </th>
                      <th class="border-0 text-center">Montant</th>
                      <th class="border-0 text-banque">Banque</th>

                    </tr>
                  </thead>
                  <tbody>';
                  foreach ($hists as $hist) 
                  {
                  $output.='<tr>
                      <td class="align-middle">
                        <h6 class="mb-0 text-nowrap">'.$hist->nomAgent.'</h6>
                        <p class="mb-0">'.$hist->datePaiement.'</p>
                        
                      </td>
                      <td class="align-middle text-center">'.$hist->typepaiement.'</td>
                      <td class="align-middle text-center">'.$hist->montantPaye.'</td>
                      <td class="align-middle text-center">'.$hist->banque.'</td>
                    </tr>';   
                  }


                  $output.='</tbody>
                </table>
              </div>';
        }
        else
        {
            $output= '<h2 class="text-warning text-center">Aucun paiement fait pour cette echeance</h2>';
        }
       


        return $output;
    }


    public function p_EchOK(Request $request)
    {
        $idEch= (int)$request->idEch;

        $info = ['nomAgent' =>$request->name ,
                 'montantPaye' =>$request->montant,
                 'datePaiement' =>$request->date,
                 'banque'=>$request->banque,
                 'typepaiement' => $request->typePaiement,
                 'echeance_id'=>$request->idEch
                ];

        $echeance = echeance::find($request->idEch);


        $totalPaye =  getSommePaye($idEch) + $request->montant;
        $histCr = EcheanceHistorique::create($info);

            if($totalPaye >= $echeance->echeanceMontant )
                {
                   
                    $echeance->echeanceStatut = 'Soldée';
                    $echeance->save();

                }

   
        return 0;

    }



    public function delEch(Request $request)

    {

        
        echeancehistorique::where('echeance_id','=',$request->idEch)->delete();

        echeance::where('id','=',$request->idEch)->delete();

          // fournisseur::where('id','=',$request->IdF)->delete();


    }


    //supression fournisseur

public function delFour(Request $request)
{
  Schema::disableForeignKeyConstraints();  //desactive contrainte cle étrangère
  $four = Fournisseur::find($request->idF);
  echeance::where('id','=',$request->idEch)->delete(); //suprime les echeance de fournisseur
  $four->delete();                           //suprime fournisseur
  Schema::enableForeignKeyConstraints();
  return response()->json();


}





    public function create_pdf()

    {

        //generer un PDF 



       $fournisseurs = fournisseur::all();



        //share data to view

        view()->share('fournisseurs', $fournisseurs);

        $pdf = PDF::loadView('pdf_view', $fournisseurs);

        // dd($pdf);

        // return $pdf->download('pdf_file.pdf');

        return view('pdf_view')->with('fournisseurs',$fournisseurs);

    }



}

