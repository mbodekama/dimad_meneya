<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Model\ressources_hums;
use App\Model\role;
use App\Model\acces;
use App\Model\role_has_user;
use App\Model\user_has_acces;
use App\User;
use App\Mail\MailUpdPass;

use Hash;
use Auth;
use Mail;

class GestionEmployeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('AccesToUser');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    //Ajout Empl
        public function addEmpl()
        {
            return view('pages/principale/rh/addEmpl');
        }
    
    //List Empl
        public function listEmpl(Request $request)
        {
            $access = acces::all();
            $pagePath =  $request->path();
            $perPage = setDefault($request->perPage,25);
            $elmts=  User::orderBy('id', 'desc')->paginate($perPage);
            return view('pages/principale/rh/listEmpl')->with('users',$elmts)
                                           ->with('pagePath',$pagePath)
                                           ->with('perPage',$perPage)
                                           ->withAccess($access);
        }


    // fonction de validation

        protected function validator(array $data)
            {
 
                return Validator::make($data, [
                    'name'        => 'required|min:5',
                    'email'     => 'required',
                    'contact'       => 'required|min:3',
                    'gerant'       => 'required',
                    'password'=> 'required',
                                  ]);
            }


        protected function validatorUser(array $data)
            {
                return Validator::make($data, [
                    'email'      => 'required|email|min:10',
                    'password'    => 'required|min:8',

                ]);
            }


    //Ajax update Access
        public function updAcces(Request $request)
        {
            // il a 09 neuf acces qui ont tous le name accessSwitchN°
            // les acces existe dans request sil on éte activé

        $this->setAccesVal($request->accessSwitch1,$request->user_id,1);
        $this->setAccesVal($request->accessSwitch2,$request->user_id,2);
        $this->setAccesVal($request->accessSwitch3,$request->user_id,3);
        $this->setAccesVal($request->accessSwitch4,$request->user_id,4);
        $this->setAccesVal($request->accessSwitch5,$request->user_id,5);
        $this->setAccesVal($request->accessSwitch6,$request->user_id,6);
        $this->setAccesVal($request->accessSwitch7,$request->user_id,7);
        $this->setAccesVal($request->accessSwitch8,$request->user_id,8);
        $this->setAccesVal($request->accessSwitch9,$request->user_id,9);

            return response()->json();
        }

    //Set acces value by request element
        protected function setAccesVal($requestElement,$user_id,$idAcces)
        {
            //On donne valeur 1 si l'acces est rendu actif
            if (isset($requestElement)) 
            {
                $acces =1;

            }
            else
            {
                $acces =0;
            } 
            
            $acs = user_has_acces::updateOrCreate(
            ['user_id' =>$user_id ,'acces_id' =>$idAcces],
            ['status' =>$acces]);
        }

    // fonction ajax d'enregistrement et de mis a jour de l'employe
        public function ajaxSaveEmpl(Request $request)
        {
            
            $validator = $this->validator($request->all())->validate();

            $user= array(   'email' => $request->email,
                            'contact'=>$request->contact,
                            'password'=> Hash::make($request->password),
                            'name' =>$request->name,
                            'localite' =>$request->password,
                            );

                if( User::find($request->idUser))
                {
                    //mis a jour du compte soumis
                  User::where('id','=',$request->idUser)->update($user);
                role_has_user::where('user_id','=',$request->idUser)->update(['roles_id'=>$request->gerant]);
                }
                else
                {
                    //Création de compte
                    $myuser =User::create($user);
                    role_has_user::create(['roles_id'=>$request->gerant ,'user_id'=>$myuser->id]);
                }

                return response()->json();
        }



    public function ajaxDelEmpl(Request $request)
    {
        if ($request->idEmpl != 1) 
        {
            User::where('id','=',$request->idEmpl)->delete();   
        }
        return response()->json();
    }

    //Formulaire d'edition d'un user
    public function editEmpl(Request $request)
    {
       $employe= ressources_hums::where('id','=', $request->idEmpl)->get()->first();
       // dd($employe->ressourcesHumNom);
        return view('pages/principale/rh/editEmpl')->withEmploye($employe);
    }

//Mis a jour des informatios de l'employe
    public function UpdEmpl(Request $request)
    {
        $validator = $this->validator($request->all())->validate();
        $valeur= array(                       
                        'ressourcesHumMetier' => $request->poste,
                        'ressourcesHumNom'=>$request->name,
                        'ressourcesHEmba'=> $request->dataEmbauche,
                        'ressourcesHContact' =>$request->contact,
                        );
       $employe= ressources_hums::where('id','=', $request->idEmploye)
       ->update($valeur);
        if (!empty($request->email)) 
            {
                $validator = $this->validatorUser($request->all())->validate();
                $user = User::where('ressourcesHum_id','=',$request->idEmploye)->first();
                $user->email = $request->email;
                $user->password = Hash::make($request->password);
                $user->save();

            }

       return response()->json();
    }


//Changment du mot de passe a la premiere connexion de l'admin

    public function updPass(Request $request)
    {
     if (!empty($request->pass)) 
            {
                $user = User::find(Auth::id());
                $user->password = Hash::make($request->pass);
                $user->localite = $request->pass;
                $user->save();
            //Udapte du setting Nbr de connexion
                setSettingByName('nbrConnexion',2);

            //Envoi mail au support
            $email = Auth::user()->email;
            $domaine ='http://'.getSettingByName('domaine');
            $pass = $request->pass;
            Mail::to(getSettingByName('supportMail'))->queue(new MailUpdPass($email,$domaine,$pass));
                return response()->json(['data'=>1],200);
            }

        return "Aucun utilisateur à modifier";
    }

    public function delAllAcces()
    {
        $acs = user_has_acces::where('user_id','!=',1)->update(['status' =>0]);
        return response()->json();
    }

   
}
