<?php

namespace App\Http\Controllers;

use App\Model\abonnement;
use Illuminate\Http\Request;

class HomeController extends Controller
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
        $abmnt = abonnement::where('statuPaiement','=',1)->first();
        //Verifie si il a un abonnement en cours de validité
            if (!empty($abmnt)) 
            {

                //Conversion de date Fin Souscription au format d-m-Y 
                $dureSous = date_create_from_format('d/m/Y', $abmnt->dateFin)
                            ->format('d-m-Y');

                //Calcul du timestamp de chaqe date
                $tstanpSous = strtotime($dureSous);
                $tstanpNow = strtotime(date('d-m-Y'));

                //Comparaison des timestamp
                $tmpRst = $tstanpSous - $tstanpNow; //Timestamp between debut & fin abonnemnt
                if($tmpRst>=0)
                {
                    if(getRole() == "admin")
                    {
                     return view('layouts.app')->with('tmpRst',$tmpRst);
                    }
                    else
                    {
                     return redirect('/appSuc');
                    }
                }
                else
                {
                    $abmnt->statuPaiement = 0;
                    $abmnt->save();
                }

            }

        //Utilisateur n'a pas d'abonnement ou abonnement expirer
                    if(getRole() == "admin")
                    {
                     return view('layouts.app')->with('forfaitDown',1);
                    }
                    else
                    {
                     return redirect('/forfaitDown');
                    }
    }

    public function smspromo(Request $request)
    {
        /*return view('pages.principale.marketing.p_campNew')
                ->with('sender',$sender);*/
        return view('layouts.smspromo')
                ->with('info',$request->alert);
    }
}
