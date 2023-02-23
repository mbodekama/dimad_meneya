<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\categorie;
use App\Model\produits;
use DB;
use Validator;

class produitsControl extends Controller
{

    public function __construct()

    {

        $this->middleware('auth');

    }

	/*--------------
	   PRODUITS
	----------------*/

	//ajout de produits 
	    public function addPrd (Request $request)
	        {

      		//Generation de code Prduit
      		  	$id = produits::max('id') + 1;
	          	$mat = "Prd".$id.'#0'.rand(0,10);
	          	if(trim($request->codePrd) == ""){$request->codePrd = $mat;}
			    $validator = $this->validAddProd($request->all())->validate();
			    if ($request->categorie  == 'new'){$request->categorie = 1;} 
				$request->alertLevel = setDefault($request->alertLevel , getSeuil() );
				$request->unite = setDefault($request->unite , ' ' );
		    	if (!is_numeric($request->tva)) { $request->tva = 0;}
		    	if (!is_numeric($request->charge)) { $request->charge = 0;}
		    	$tva = setDefault($request->tva,0);
		    	$charge = setDefault($request->charge,0);
		
	            //calcul prix produit
	            $valeur = array(
	                "produitMat"=>$request->codePrd,
	                'produitLibele'=>$request->libelleProd,
	                'produitPrix'=>$request->prixPrd,
	                'produitPrixFour'=>$request->coutAchat,
	                "description" =>$request->libelleProd,
	                "categorie_id" =>$request->categorie,
	                "unite_mesure" =>$request->unite,
	                "tva" =>$tva,
	                "autre_charge" =>$charge,
	                "seuilAlert" =>$request->alertLevel,

	            );
	            if(!empty($request->idPrd))
	            {
	            produits::where('id','=',$request->idPrd)->update($valeur);
	            }
	            else
	            {
	            $prd = produits::create($valeur);
	            }

	            return response()->json();


	        }

	//Validation du form Ajout Prd
	    protected function validAddProd(array $data)
	        {
	            return Validator::make($data, [
	                'libelleProd' => 'required|min:3',
	                'prixPrd' => 'required',
	                'coutAchat' => 'required',
	            ]);
	        }

	//Calcul Prix de vente  automatiquement

	    public function calPrixAuto(Request $request)
	    {
	    	if (!is_numeric($request->tva)) { $request->tva = 0;}
	    	if (!is_numeric($request->charge)) { $request->charge = 0;}
	    	$tva = setDefault($request->tva,0);
	    	$charge = setDefault($request->charge,0);
	    	$prix = getPrixAuto($request->prix)+$charge+(($request->prix*$tva)/100) ;
	    	return $prix;

	    }

	//Supression produits 
	    public function delPrd(Request $request)
	    {
	    	produits::where('id','=', $request->idProduit)->delete();

	    	return response()->json();
	    }

   // ****************************************
    //       TEXT DE REUCPERATION IN SELECT2
    // ****************************************
          public function ajaxPrdAll(Request $request)
          {
            $search = htmlentities($request->q);
            $search = htmlspecialchars($search);
            $produits = DB::table('produits')
                ->select('produits.*')
                ->where('produits.produitLibele','LIKE','%'.$search.'%')
                ->get();
                $data = array();
                foreach ($produits as  $produit) 
                {
                  if ($produit->image =="") 
                  {
                    $produit->image = "assets/img/illustrations/falcon.png";
                  }
                  $data[] = array(
                          "id" => $produit->id,
                        "tva" =>$produit->tva,
                          "libelle" => $produit->produitLibele,
                          "text" => $produit->produitLibele,
                          "prixPrd" =>$produit->produitPrix ,
                          "prixFour" =>$produit->produitPrixFour,
                          "matricule" =>$produit->produitMat,
                        "prixPrdFormat" =>formatPrice($produit->produitPrix),
                        "prixFourFormat" =>formatPrice($produit->produitPrixFour),
                        'image' =>$produit->image,
                      );

                }

                $tab = ["total_count" => 1,"incomplete_results" => false,'items'=>$data];


             echo json_encode($tab);
             exit();
          }



















	/*--------------
	   CATEGORIE
	----------------*/

    //Liste des categorie
    	public function lCateg()
    	{
    		$categorie = categorie::all();
	        if(count($categorie) >= 1)
	        {
	        	 $i =0;
	             $output ='<div class="table-responsive mt-4 fs--1">
	                <table class="table table-striped border-bottom">
	                  <thead>
	                    <tr class="bg-primary text-white">
	                     
	                      <th class="border-0 text-center">N°</th>
	                      <th class="border-0 text-center">Titre </th>
	                      <th class="border-0 text-center">Nbre Articles</th>
	                      <th class="border-0 text-center">Action</th>

	                    </tr>
	                  </thead>
	                  <tbody>';
	                  foreach ($categorie as $catgo) 
	                  {
	                  	$i +=1;
	                  $output.='<tr>
	                      <td class="align-middle">
	                        <h6 class="mb-0 text-nowrap">'.$i.'</h6>
	                        
	                        </td>
                      		<td class="align-middle text-center h6">'.$catgo->libelle.'</td>
	                      <td class="align-middle text-center h6">'.getCatgoEle($catgo->id)->count().'</td>
	                      <td class="align-middle text-center h6 delCat" idCat="'.$catgo->id.'" ><span class="far fa-trash-alt text-danger mr-2"></span></td>
	                    </tr>';   
	                  }


	                  $output.='</tbody>
	                </table>
	              </div>';
	        }
	        else
		        {
		            $output= '<h2 class="text-warning text-center">Aucune catégorie enregistré</h2>';
		        }

		        //INSERTION DES SCRIPTS DANS LE OUTPUT 
		        $output .="<script type='text/javascript'>
						    $(function()
						    {
								        //Au clic de supression de la catgo
						        $('.delCat').click(function()
						          {
						            if ($(this).attr('idCat') == '1') {
						              Swal.fire('Supression impossible');
						            }
						            else
						            {
						            ajaxDelCatgo($(this).attr('idCat'));
						            }
						          });


						        //Ajax suprime categorie
						          function ajaxDelCatgo(idCatgo)
						          {


						                  Swal.fire({
						                    title: 'Catégorie',
						                    text: 'Voulez vous supprimer cette catégorie ?',
						                    icon: 'warning',
						                    showCancelButton: true,
						                    confirmButtonColor: '#3085d6',
						                    cancelButtonColor: '#d33',
						                    cancelButtonText: 'Annuler',
						                    confirmButtonText: 'oui , Supprimer!'
						                  }).then((result) => {
						                      if (result.value) {
						                        $.ajax({
						                          url: 'mbo/delCatgo',
						                          method:'GET',
						                          data:{idCatgo:idCatgo},
						                          dataType:'json',
						                          success:function(){
						                            Swal.fire(
						                             'Supression!',
						                             'Catégorie suipprimé avec succès',
						                             'success'
						                            );
						                            $('#clsCatgo').click();
						                            $('#main_content').load('mbo/allPrd');
						                          },
						                          error:function(){
						                            Swal.fire('La suppression de produits est impossible');
						                          }
						                        });
						                      }
						                  })
						          
						          } 
						    })
						    </script>";
		        return $output;
    	}


    //Suprimer une catégorie
    	public function delCatgo(Request $request)
    	{
    		produits::where('categorie_id','=',$request->idCatgo)->update(['categorie_id' => 1]);
    		categorie::find($request->idCatgo)->delete();

    		return response()->json();	
    	}
    //Trier produit par categorie donne
    	public function prdByCatg(Request $request)
    	{

           $produits = DB::table('categories')
                  ->join('produits','produits.categorie_id','=','categories.id')
                  ->select('produits.*','categories.*', 'produits.id as prdId')
                  ->where('produits.categorie_id','=',$request->idCat)
                  ->orderBy('produits.id','desc')->get();
                 
                  // dd($produits);
           return view('pages/principale/approvision/prdByCatg')->with('produits',$produits)->with('idCat',$request->idCat);
    	}

    //Ajouter une categorie de produit
    	public function addCatgo(Request $request)
    	{
			$this->validAddCatgo($request->all())->validate();
			$cat = ['libelle' => $request->newCatgo];
    		$catgo = categorie::create($cat);
            $output ='<option class="categorie" value="'.$catgo->id.'">'.$catgo->libelle.'</option>';
           return $output;
    	}

            
    protected function validAddCatgo(array $data)
        {
            return Validator::make($data, [
                'newCatgo' => 'required|min:4',
            ]);
        }






}
