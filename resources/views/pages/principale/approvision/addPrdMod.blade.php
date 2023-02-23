        {{-- MODAL D'AJOUT DE NOUVEAUX PRODUITS --}}
          <div class="modal fade" id="modalAddProd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Nouveau produits</h5>
                  <button class="close btnClse" type="button" data-dismiss="modal" aria-label="Close"><span class="font-weight-light" aria-hidden="true">&times;</span></button>
                </div>
                <form class="modal-body" id="formAddProd">
                  @csrf
                              <input type="hidden" value="" name="idPrd" id="idPrd" >
                                  <div class="form-group" id="catgoListDiv">
                                          <label for="listCatg">Catégorie</label>

                                      <select class="selectpicker" name="categorie" id="listCatg">
                                        {{-- <option value="new">-- Categorie --</option> --}}

                                        @foreach(getCatgo() as $catgo)
                                          <option class="categorie" value="{{ $catgo->id }}">
                                            {{ $catgo->libelle }}
                                          </option>
                                        @endforeach
                                       <option class="text-primary" value="new" >
                                        <span class="bg-warning">Nouvelle categorie</span>
                                      </option>
                                      </select>
                                    </div>
                                    <div class="form-row">
                                      <div class="col-5">
                                        <div class="form-group">
                                          <label for="codePrd">Code</label>
                                          <input class="form-control" id="codePrd" name="codePrd" type="text" required>
                                        </div>
                                      </div>
                                      <div class="col-7">
                                        <div class="form-group">
                                          <label for="libelleProd" class="text-danger">Libelle</label>
                                          <input class="form-control" id="libelleProd" name="libelleProd" type="text" required>
                                        </div>
                                      </div>

                                      <div class="col-5">
                                        <div class="form-group">
                                          <label for="alertLevel">Niveau d'alert</label>
                                          <input class="form-control " required id="alertLevel" name="alertLevel" type="number"  min="1">
                                        </div>
                                      </div>
                                      <div class="col-7">
                                        <div class="form-group">
                                          <label for="unite">Unite de mesure</label>
                                          <input class="form-control " required id="unite" name="unite" type="text"  >
                                        </div>
                                      </div>
                                      <div class="col-5">
                                        <div class="form-group">
                                          <label for="tva">TVA ( en %)</label>
                                          <input class="form-control " required id="tva" name="tva" type="number" placeholder="Ex 2.1%" min="1" >
                                        </div>
                                      </div>
                                      <div class="col-7">
                                        <div class="form-group">
                                          <label for="charge">Autres charges ( en {{ getMyDevise() }}) </label>
                                          <input class="form-control " required id="charge" name="charge" type="number" placeholder="Charge appliqués" min="1" >
                                        </div>
                                      </div>
                                      <div class="col-5">
                                        <div class="form-group">
                                          <label for="coutAchat" class="text-danger mb-3">Cout d'achat ( en {{ getMyDevise() }})</label>
                                          <input class="form-control " required id="coutAchat" name="coutAchat" type="number" placeholder="Prix du fournisseur" min="1" >
                                        </div>
                                      </div>

                                      <div class="col-7">
                                        <div class="form-group">
                                          <label for="prixPrd" class="text-danger">Prix de vente 
                                            <button class="btn btn-falcon-default btn-sm ml-2" id="calPrix" type="button">
                                            <i class="fas fa-calculator"></i>
                                            <span class="d-none d-sm-inline-block ml-1">Claculé</span>
                                            </button>
                                          </label>
                                          <input class="form-control " required id="prixPrd" name="prixPrd" type="number" placeholder="Prix de revente du produit" min="0" >
                                        </div>
                                      </div>
                                    </div>
                </form>
                <div class="modal-footer">
                  <button class="btn btn-secondary btn-sm btnClse" type="button" data-dismiss="modal">Fermer</button>

                  <button class="btn btn-primary btn-sm" id="addProdBtn" type="button">Enregistrer</button>
                </div>
              </div>
            </div>
          </div>
        {{--FIN  MODAL D'AJOUT DE NOUVEAUX PRODUITS --}}




        {{-- MODAL D'AJOUT DE NOUVEAUX CATEGORIE --}}
          <div class="modal fade" id="modalAddCatgo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Nouvelle catégorie</h5>
                  <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span class="font-weight-light" aria-hidden="true">&times;</span></button>
                </div>
                <form class="modal-body" id="formAddCatgo">
                  @csrf
                  <div class="form-group">
                    <label for="libelleProd">Nom catégorie</label>
                    <input class="form-control" id="newCatgo" name="newCatgo" type="text" placeholder="04 caractères minimum">
                  </div>
                </form>
                <div class="modal-footer">
                  <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Fermer</button>
                  <button class="btn btn-primary btn-sm" id="addCatgo" type="button">Ajouter</button>
                </div>
              </div>
            </div>
          </div>
        {{--FIN  MODAL D'AJOUT DE NOUVEAUX CATEGORIE --}}


        <script type="text/javascript">
          $(function()
          {

            //Au clic de ajouter Produits
              $('#addProdBtn').click(function()
              {
                if($('#libelleProd').val() != "")
                {

                  if($('#coutAchat').val() != "")
                  {
                      
                      if($('#prixPrd').val() != "")
                      {

                        if( parseInt($('#prixPrd').val()) < parseInt($('#coutAchat').val()))
                        {

                          Swal.fire({
                                title: 'Nouveau Produit',
                                text: "Le cout d'achat du produit saisis est supérieur au prix de vente ! Voulez-vous l'enregistré quand même ?",
                                icon: 'error',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                cancelButtonText: 'Non,Retour',
                                confirmButtonText: 'Oui, Enregistrer',
                                backdrop: `rgba(240,15,83,0.4)`

                              }).then((result) => {
                              if (result.value) 
                                {
                                 ajaxAddProduit();

                                }
                              })
                        }
                        else
                        {
                                 ajaxAddProduit();
                        }
                        

                      }
                      else
                      {
                       $('#prixPrd').addClass('is-invalid'); 
                      }

                  }
                  else
                  {
                   $('#coutAchat').addClass('is-invalid'); 
                  }

                }
                else
                {
                 $('#libelleProd').addClass('is-invalid'); 
                }
              });
   
            //Calcul du prix de revente automatiqe
              $('#calPrix').click(function()
              {
                 var prix  = $('#coutAchat').val();
                 var charge  = $('#charge').val();
                 var tva  = $('#tva').val();
                     $.ajax({
                              url: 'mbo/calPrixAuto',
                              method:'GET',
                              data: { prix:prix,charge:charge,tva:tva },
                              dataType:'text',
                              success:function(data){
                                    // alert(data);
                                   $('#prixPrd').val(parseInt(data));
                                      },
                              error:function(){
                                      toastr.error("Erreur de connexion ");
                                        
                                      }
                                    });
              })
            
            //Function Ajout produits
              function ajaxAddProduit()
                  {
                          $.ajax({
                                  url: 'mbo/addPrd',
                                  method:'POST',
                                  data: $('#formAddProd').serialize(),
                                  dataType:'json',
                                  success:function(){
                                          toastr.success("Opération fait avec succès");

                                           $("#formAddProd").trigger("reset");
                                            $("#idPrd").val('');
                                           
                                            //Actualiser la page
                                          },
                                  error:function(){
                                          toastr.error("Erreur lors de l'ajout ");
                                            
                                          }
                                        });


                  };

            //Au choix de New Categorie
              $('#listCatg').change(function()
              {
                if($('#listCatg option:selected').val() == "new")
                {
                  $('#modalAddCatgo').modal({backdrop:'static'});
                }
              })

            //Au clic Btn Ajouter categorie 
                    $('#addCatgo').click(function()
                    {
                  
                      if($('#newCatgo').val().length != 0) 
                      {
                        toastr.info('Patientez ...');
                        ajaxAddCatgo();

                      }
                      else
                      {
                        toastr.error('Aucune valeur saisir !!!');
                      }

                    })

            //Function Ajax AJout de la categorie
               function ajaxAddCatgo()
                 {
                   $.ajax({
                            url: 'mbo/addCatgo',
                            method:'POST',
                            data: $('#formAddCatgo').serialize(),
                            dataType:'html',
                            success:function(data){
                            toastr.success('Ajout effectué');
                            $('#modalAddCatgo').modal('hide');
                              $('#listCatg').prepend(data);

                            },
                            error:function()
                            {
                              Swal.fire('Problème de connection internet');
                                
                            }
                          });          

                 }

            //Btn fermer
            $('.btnClse').click(function()
                {
                  $('#btnActualiser').click();
                }
              )
          })
        </script>
