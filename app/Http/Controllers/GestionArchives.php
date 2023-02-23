<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Model\dossier;
use  App\Model\document;
use DB;
use Auth;
use Validator;

session_start();

class GestionArchives extends Controller
{
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

    //Page d'Ajout de doc
    public function addDoc()
    {
    	$dossiers = dossier::all();
    	return view('pages.principale.Archive.addDoc')->with('dossiers',$dossiers);
    }
    //Page d'Ajout de doc
    public function listDoc(Request $request)
    {

        $pagePath =  $request->path();
        $perPage = setDefault($request->perPage,25);
        $elmts=  dossier::orderBy('id', 'desc')->paginate($perPage);
        return view('pages.principale.Archive.listDoc')->with('dossiers',$elmts)
                                       ->with('pagePath',$pagePath)
                                       ->with('perPage',$perPage);

    }

    //Page d'enregistrement de doc
    public function saveDoc(Request $request)
    {
        
      $validator = $this->validDoc($request->all())->validate();

    //  !!!!!!!!!!!!!!!!  Lien des image  !!!!!!!!!!!!!!!! 
      
          // $lien = 'myapp/storage/app/public/';  //en ligne
          $lien = 'storage/';                // en local

        //  !!!!!!!!!!!!!!!!  Lien des image  !!!!!!!!!!!!!!!!!!
   
        // Récupération images
          if(!empty($request->file('docFile')))
          {
            // Récupération du name file  
             $imgP = $request->file('docFile');
            // dossier de stockage
             $path = $imgP->store('document','public');
            // Chemin d'accès de l'image 
             $logoP = $lien.$path;        
          }

          //Enregistrement du fichier
	      	$valeur = array(
	                "titre"=>$request->titre,
	                'commentaire'=>$request->commentaire,
	                'joint'=>$logoP,
	                'ref'=>$request->datepicker,
	                'session'=>Auth::id(),
	                'dossier_id'=>$request->dossier,
			);
	       	$doc = document::create($valeur);
	       	$doc = dossier::find($request->dossier);
	       	$doc->nbrefichier += 1;
	       	$doc->save();
	    	return response()->json();
    }

    // fonction de validation 
        protected function validDoc(array $data)
            {
              return Validator::make($data, [
                    'dossier'        => 'required',
                    'titre'     => 'required',
                    'datepicker'       => 'required|min:3',
                    'commentaire'       => 'required',
                                  ]);
            }
    //Enregster Dossier de archives
	    public function saveFolder(Request $request)
	    {
	      	$valeur = array(
	                "nomdossier"=>$request->titre,
	                'nbrefichier'=>0,
	                'dateCreation'=>date('d/m/Y'),
	                'ref'=>$request->com,
	                'session'=>Auth::id(),
			);
	       	$doc = dossier::create($valeur);
	    	return response()->json();
	    }

	 //Modification d'un dossier 
	    public function updDoc(Request $request)
	    {

	      	$valeur = array(
	                "nomdossier"=>$request->titre,
	                'dateCreation'=>date('d/m/Y'),
	                'ref'=>$request->commentaire,
			);

			//Mis a jour du dossier 
			dossier::find($request->idDoc)->update($valeur);
			return response()->json();

	    }

   //Modification d'un fichier 
      public function updFile(Request $request)
      {
  
            $valeur = array(
                    "titre"=>$request->titre,
                    'ref'=>$request->datepicker,
                    'commentaire'=>$request->commentaire,
                  );

        document::find($request->idDoc)->update($valeur);
        return response()->json();

      }

	//SUPRESSION DE PLUSIEUR FICHIER 
	   public function delDoc(Request $request)
	   {

	   	if ($request->idDoc != 0) 
	   	{
			$doc = dossier::find($request->idDoc);
			$doc->delete();
	   	}
	   	else
	   	{
			$doc = dossier::where('id','>', 0)->delete();;
	   	}
	   	return response()->json();
	   }

  //SUPRESSION DE FICHIER
     public function delFile(Request $request)
     {
        if ($request->idDoc != 0) 
        {
        document::find($request->idDoc)->delete();
        $dossier = dossier::find($request->idFolder);
        $dossier->nbrefichier -= 1;
        $dossier->save();
        }
        else
        {
        $doc = document::where('dossier_id','=',$request->idFolder)->delete();
        $dossier = dossier::find($request->idFolder)->update(['nbrefichier' => 0]);
        }
        return response()->json();
     }

  //consulter un dossier 
     public function viewFolder(Request $request)
     {

       $idDoc = isset($request->idDoc) ? $request->idDoc : $request->idPage;
      
        if ($idDoc != 0) 
        {
          //Recuperation du dossier 
          $doc = dossier::find($idDoc);

          //Parametre de recuperation des documents par paginate 
          $pagePath =  $request->path();
          $perPage = setDefault($request->perPage,25);
          $elmts=  document::where('dossier_id','=',$doc->id)->orderBy('id', 'desc')
                                                            ->paginate($perPage);

          //Retourne la view 
          return view('pages.principale.Archive.viewFolder')
                                          ->with('files',$elmts)
                                         ->with('pagePath',$pagePath)
                                         ->with('perPage',$perPage)
                                         ->with('folder',$doc);
        }
        else
        {
          return '<script> window.location.href="/login"</script>';
        }
     }
}
