<?php
  // Vérification de l'existence d'opérations-opérateurs
   $nb = count($OpTion);
   if ($nb==0) {?>
             <div class="card">
            <div class="card-body overflow-hidden text-center pt-5">
              <div class="row justify-content-center">
                <div class="col-7 col-md-5"><img class="img-fluid" src="../assets/img/illustrations/modal-right.png" alt="" /></div>
              </div>
              <h3 class="mt-3 font-weight-normal fs-2 mt-md-4 fs-md-3">
                <b class="text-danger">Ouf!!!!!!</b>, cet opérateur ne dispose pas d'opérations
              </h3>
              <p class="lead">Veuillez créer une nouvelle opération pour cet opérateur .
                <br class="d-none d-md-block"/>
                <button class="ml-1 btn btn-outline-primary rounded-capsule mr-1 mb-1 newOp" 
                 type="button">   Nouvelle opération
                </button><br class="d-none d-md-block"/>
                <a class="Retour" href="#" id="{{$idOp}}">
                  <span class="text-danger"><i class="fas fa-angle-left"></i> Retour</span>
                </a>
              </p>
              
            </div>
            <div class="card-footer d-flex justify-content-center bg-light text-center pt-4">
              <div class="col-10">
                <p class="mb-2 fs--1">Gestion des opérations de vos opérateurs <a href="#!">en toute simplicité.</a></p>
              </div>
            </div>
          </div>

          <script type="text/javascript">
            // Nouvelle opération
             $('.newOp').click(function(){
               $("#main_content").load("/p_opetNew");
             });

            // Retour opérateur
             $('.Retour').click(function(){
               //loadingScreen();
               $("#main_content").load("/p_OpListe");
               /*var idOp = $("#IdOp").val();
               console.log('retour: '+idOp);*/
             });

          </script>
<?php     
   }else{
?>

<div class="card mb-3">
  <div class="bg-holder d-none d-lg-block bg-card" 
   style="background-image:url(../assets/img/illustrations/corner-4.png);">
  </div>
  <!--/.bg-holder-->

    <div class="card-body">
      <div class="row">
        <div class="col-lg-8">
          {{-- {{dd($oper)}} --}}
          <?php foreach ($oper as $key => $value){?>
          
           <h3 class="mb-0 text-primary">
              <a href="#" class="operateurs"><span>
                <i class="fas fa-briefcase"></i> 
                Opérateurs ></span></a>
              <?php echo $value->operateurNom; ?>
           </h3>
           {{-- recuperation de l'Id de l'operateur --}}
           <input type="hidden" id="idOperateur"  value="{{ $value->id }}">
          <p class="mt-2">
            <span class="fas fa-blender-phone"></span>
            <b>Contact</b>: <?php echo $value->operateurContact; ?>
   
            <span class="fas fa-map-marker-alt ml-2"></span>
            <b>Lieu</b>: <?php echo $value->operateurLieu;?>

            <span class="fas fas fa-barcode ml-2"></span>
            <b>Matricule</b>: <?php echo $value->operateurMat;?>
          </p>
          
          <br>
           <button class="btn btn-falcon-danger mr-3 mb-1 refresh" 
            id="<?php echo $value->id;?>" type="button">
             <span class="fab fa-battle-net fa-2x"  data-fa-transform="shrink-3"></span>Actualiser
           </button>
            <button class="btn btn-falcon-danger mr-1 mb-1  bntSortie"
                    id="<?php echo $value->id;?>" type="button">
             <span class="fas fa-plus "  data-fa-transform="shrink-3" ></span>Nouvelle sortie
           </button>


                    <button class="btn btn-falcon-default btn-sm newOpera" type="button">
                      <span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span>
                      <span class="d-none d-sm-inline-block ml-1">
                        Nouvelle opération
                      </span>
                    </button>
           <?php } ?>
        </div>
      </div>
    </div>
</div>

          <div class="card mb-3">
            <div class="card-header">

              <div class="row align-items-center justify-content-between">
                <div class="col-4 col-sm-auto d-flex align-items-center pr-0">
                   <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">
                     Opérations
                   </h5>
                </div>
                   <!-- Pagination -->
                   @include('pages/dash/pagnMod')

                {{-- <div class="col-8 col-sm-auto ml-auto text-right pl-0">
                </div> --}}
              </div>

              

            </div>
            <div class="card-body p-0" id="loaderContent">
              <div class="falcon-data-table">
                <table class="mytable table table-sm mb-0 table-striped table-dashboard fs--1 data-table border-bottom border-200" data-options='{"searching":true,"responsive":false,"info":false,"lengthChange":false,"sWrapper":"falcon-data-table-wrapper","dom":"<&#39;row mx-1&#39;<&#39;col-sm-12 col-md-6&#39;l><&#39;col-sm-12 col-md-6&#39;f>><&#39;table-responsive&#39;tr><&#39;row no-gutters px-1 py-3 align-items-center justify-content-center&#39;<&#39;col-auto&#39;p>>","language":{"paginate":{"next":"<span class=\"fas fa-chevron-right\"></span>","previous":"<span class=\"fas fa-chevron-left\"></span>"}}}'>
                  <thead class="bg-200 text-900">
                    <tr>
                      <th class="align-middle no-sort">
                        <div class="custom-control custom-checkbox">
                          <input class="custom-control-input checkbox-bulk-select" id="checkbox-bulk-purchases-select" type="checkbox" data-checkbox-body="#orders" data-checkbox-actions="#orders-actions" data-checkbox-replaced-element="#dashboard-actions">
                          <label class="custom-control-label" for="checkbox-bulk-purchases-select">
                          </label>
                        </div>
                      </th>
                      <th class="align-middle sort">Matr.</th>
                      <th class="align-middle sort">Opérat.</th>

                      <th class="align-middle sort">Dépôt initial.</th>

                      <th class="align-middle sort">Dépôt Total
                      </th>
                      <th class="align-middle sort">Montant Restant
                      </th>
                      <th class="align-middle sort">Date</th>
                      <th class="no-sort"></th>
                    </tr>
                  </thead>
                  <tbody id="orders">
                   <?php foreach ($OpTion as $key => $value){?>
                     {{-- {{dd($value)}} --}}
                    <tr class="btn-reveal-trigger">
                      <td class="py-2 align-middle">
                        <div class="custom-control custom-checkbox">
                          <input class="custom-control-input checkbox-bulk-select-target" 
                           type="checkbox" id="checkbox-0" />
                          <label class="custom-control-label" for="checkbox-0"></label>
                        </div>
                      </td>
                      
                      <td class="py-2 align-middle white-space-nowrap">
                        <a href="#">
                        <strong><?php echo $value->opeOperat;?></strong><br />
                      </td>
                      <td class="py-2 align-middle white-space-nowrap"><a href="#">
                        <strong><?php echo $value->OperationLibele;?></strong><br />
                      </td>
                      <td class="py-2 align-middle">
                        <span class="badge badge-pill badge-secondary" style="font-size: 15px">
                          <?php echo formatPrice($value->depot_init);?>
                          </span>
                      </td>
                      <td class="py-2 align-middle">
                        <span class="badge badge-pill badge-secondary" style="font-size: 15px">
                          <?php echo formatPrice($value->montant);?>

                          </span>
                      </td>
                      <td class="py-2 align-middle">
                        @if($value->montantrestant<0)
                         <span class="badge badge-pill badge-danger" style="font-size: 15px">
                          <?php echo formatPrice($value->montantrestant);?>
                          </span>
                        @else
                          <span class="badge badge-pill badge-primary" 
                             style="font-size: 15px">
                          <?php echo formatPrice($value->montantrestant);?>
                          </span>
                        @endif
                      </td>
                      <td class="py-2 align-middle">
                        <p class="mb-0 text-500">
                         <?php echo $value->date;?>
                        </p>
                      </td>

                      <td class="py-2 align-middle white-space-nowrap">
                        
                        <button class="btn btn-falcon-info rounded-capsule mr-1 mb-1 sorties" 
                          type="button" 
                          id="{{$value->opeOperat}}"
                          operation="{{$value->OperationLibele}}"
                          operationcode="{{$value->operationCode}}"
                          operationcoment="{{$value->Operationcomt}}"
                          >Sorties
                        </button>

                        <button class="btn btn-falcon rounded-capsule 
                                      mr-1 mb-1 story bg-danger text-light" 
                                type="button"
                                id="{{$value->opeOperat}}">
                          Historique
                        </button>

                        <span class="addCreditBtn" 
                              type="button" 
                              data-toggle="modal"
                              data-target="#addCredit"
                              id="{{$value->opeOperat}}" 
                              title='{{$value->OperationLibele}}' 
                              operations= '{{$value->IDoperation}}'
                              montantRst = '{{formatprice($value->montantrestant)}}'
                              >
                          <i class="fas fa-money-check-alt fa-2x text-warning">
                          </i>
                       </span>


                        <a href="#" class="delete" 
                           id="<?php echo $value->opeOperat;?>">
                          <i class="far fa-trash-alt fa-2x text-danger">
                          </i>
                        </a>

                        {{-- <a href="#" class="edit" 
                           id="<?php echo $value->opeOperat;?>">
                          <i class="far fa-edit fa-2x text-infos">
                          </i>
                        </a> --}}
                      </td>
                    </tr> 
                   <?php } ?>
                      
                  </tbody>
                </table>
                <!-- Paginate -->
                <div class="row no-gutters px-1 py-3 align-items-center justify-content-center">
                   {{ $OpTion->links() }}
                   <input type="hidden" id='lastPrd' 
                   value="{{ $OpTion->last()->id }}"> 
                </div>

              </div>
            </div>
          </div>


<!-- Modal-->

<!-- Modal de paiement -->
<div class="modal fade" id="addCredit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Paiement de Credit > {{ $oper[0]->operateurNom }}</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span class="font-weight-light" aria-hidden="true">&times;</span></button>
      </div>
      
            <form class="modal-body" id="payVersForm">
               @csrf
              <div class="form-group">
                 <label for="infoVers"><b>Montant restant => 
                  <span class="montaRest"></span></b>
                 </label>
                 <input class="form-control operationT" type="text" disabled>
              </div>

              <div class="form-row">
                <div class="col-6">
                 <div class="form-group">
                 <label for="agent" class="text-danger">Agent (Nom du caissier)
                  <span class="fas fa-times-circle " data-fa-transform="shrink-1"></span>
                 </label>
                 <input class="form-control" id="agent" name="agent" value="{{ Auth::user()->name }}"  type="text" readonly="">
                </div>                 
                </div>

                <div class="col-6">
                  <div class="form-group">
                    <label for="agent">Type paiement</label>
                    <select class="form-control" id="moyen"  name="moyen">
                          <option value="Mobile money" >Mobile money</option> 
                          <option value="Chèques" >Chèques</option>
                          <option value="Espèce" >Espèce</option>
                          <option value="Virement Bancaire" >Virement Bancaire</option>
                    </select>
                  </div>                 
                </div>

                <div class="col-6">
                  <div class="form-group ">
                   <label for="montant " class="text-danger">
                      Montant 
                      <span class="fas fa-times-circle text-danger" data-fa-transform="shrink-1"></span>
                   </label>
                   <input class="form-control" id="montantPay" type="number" 
                   name='montant' value="" min='1' max="">
                  </div>
                </div> 

                <div class="col-6">
                  <div class="form-group">
                    <label for="datePayVers">Date (date de paiement) </label>
                    <input class="form-control form-control-sm datetimepicker flatpickr-input"
                     id="datePayVers"
                     required="" 
                     name="datePayVers" type="text" 
                     placeholder="d/m/Y" 
                     value="{{ date('d/m/Y') }}" >
                  </div>
                </div>
                <input type="hidden" 
                       name="Operation_operateur" 
                       id="operaOperation">
              </div>

      </form>


      <div class="modal-footer">
        <button class="btn btn-secondary btn-sm closeBtn" type="button" data-dismiss="modal">Fermer</button>
        <button class="btn btn-primary btn-sm" type="button" id="appliquer">Appliquer</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal de paiement -->
<div class="modal fade" id="story" tabindex="-1" role="dialog" 
    aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Historique de paiement  > {{ $oper[0]->operateurNom }}</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span class="font-weight-light" aria-hidden="true">&times;</span></button>
      </div>
      
      <div class="modal-body corps_story">

      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary btn-sm closeBtn" type="button" data-dismiss="modal">Fermer</button>
      </div>

    </div>
  </div>
</div>

<!-- Champ inactif -->
<?php foreach ($OpTion as $key => $value){?>
<input type="hidden" id="operate" value="<?php echo $value->operateurs_id;?>" name="operate">
<?php } ?>
@csrf


     {{-- <script src="{{ asset('assets/js/theme.js') }}"></script> --}}
     <script type="text/javascript">
        $(function(){

          //Affectation de valeur
            $('#val1').val({{$idOp}});


          // Faire disparaitre les paginate de Javascript
           $(".mytable").parent().next().hide();
        });
         

        // Story de paiement
        $(".story").click(function(){
           var idOperaOperat = $(this).attr("id");
           $.ajax({
             url:'story',
             method:'GET',
             data:{idOperaOperat:idOperaOperat},
             dataType:'text',
             success:function(data){
               console.log(data);
               $(".corps_story").html(data);
               $("#story").modal('show');
             },
             error:function(data){
               console.log(data);
             }
           });
        });      

        // Lancement du modal
        $('.addCreditBtn').click(function()
         {
           var idOp      = $(this).attr('id');
           var operation = $(this).attr('title');
           var montantR  = $('.addCreditBtn').attr("montantRst");
           console.log("Idop:"+idOp);
           console.log("operation:"+operation);
           console.log("montantR:"+montantR);

           $(".montaRest").text(montantR);
           $(".operationT").val(operation);
           $("#operaOperation").val(idOp);
            
         });

        // Lancement du paiement
         $('#appliquer').click(function()
         {

          $.ajax({
             url:'addCredit',
             method:'GET',
             data: $('#payVersForm').serialize(),
             dataType:'text',
             success:function(data){
              toastr.success('Montant mis à jour avec succès');
              $('.closeBtn').click();
              $('.refresh').click();
             },
             error:function(){
              Swal.fire('Problème de connection internet');
             }

           }); 
         })



       
        // Edit
         $(".edit").click(function(){
           var idOp = $(this).attr("id");
           console.log(idOp);
         });


        //Valider 
         $('.valider').click(function(){
            var idV     = $(this).attr('id');
            var action = 'OkVers';
            Swal.fire({
             title: 'Versement',
             text: "Voulez vous solder le versement ?",
             icon: 'warning',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             cancelButtonText: 'Annuler',
             confirmButtonText: 'oui , solder!'
            }).then((result) => {
              if (result.value) {
                $.ajax({
                  url:'/p_versOk',
                  method:'GET',
                  data:{idV:idV,action:action},
                  dataType:'text',
                  success:function(){
                    $("#main_content").load("/p_LVer");
                    Swal.fire(
                     'Solder!',
                     'Versement solder avec succès',
                     'success'
                    );
                  },
                  error:function(){
                    Swal.fire('Problème de connection internet');
                  }
                });
              }
          })
         });

        //Supprimer
        $('.delete').click(function(){
          var idV = $(this).attr('id');
          var action = 'Del';
          Swal.fire({
            title: 'Opérateurs',
            text: "Voulez-vous supprimer ses opérations ?",
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Annuler',
            confirmButtonText: 'oui , supprimer!',
            backdrop: `rgba(240,15,83,0.4)`
          }).then((result) => {
              if (result.value) {
                $.ajax({
                  url:'/p_OptnDel',
                  method:'GET',
                  data:{idV:idV,action:action},
                  dataType:'text',
                  success:function(){
                    Swal.fire(
                     'Supprimer!',
                     'Supression validé avec succès',
                     'error'
                    );
                    $(".refresh").click();
                  },
                  error:function(){
                    Swal.fire('Problème de connection internet');
                  }
                });
              }
          })
        });

       

        // Gestion des opérations
         $(".operat").click(function(){
           var idV = $(this).attr('id');
           var token = $('input[name=_token]').val();
           $("#main_content").load("/p_OpTion",{idV:idV,_token:token});
         }); 
        
        // Refresh
         $('.refresh').click(function(){
           var idV = $(this).attr('id');
           var token = $('input[name=_token]').val();
           $("#main_content").load("/p_OpTion",{val1:idV,_token:token});
         });

        //Ajouter une sortie
         $('.bntSortie').click(function()
         {
           var idV = $(this).attr('id');
           var token  = $('input[name=_token]').val();
           $("#main_content").load("p_OpSortie",{idV:idV,_token:token});
           //alert(token);

         });

        //Ajouter une sortie2
         $('.bntSortie2').click(function()
         {
           var idV = $(this).attr('id');
           var token  = $('input[name=_token]').val();
           $("#main_content").load("p_OpSortie2",{idV:idV,_token:token});
           //alert(token);

         });



        // Nouvelle opération
         $('.newOpera').click(function(){
           loadingScreen();
           $("#main_content").load("/p_opetNew");
         });


        //  Listes des Sorties des opérations
        $('.sorties').click(function()
        {
          var idOp = $('#idOperateur').val();
          var idOpt = $(this).attr('id');
          var operation = $(this).attr("operation");
          var operationcode = $(this).attr("operationcode");
          var operationcoment = $(this).attr("operationcoment");
          var token = $('input[name=_token]').val();
          $("#main_content").load("/p_listeSortie",
                {idOp : idOp, 
                 idOpt:idOpt, 
                 _token :token,
                 operation:operation,
                 operationcode:operationcode,
                 operationcoment:operationcoment
                });
        })


        // Retour sur les opérateurs
         $('.operateurs').click(function(){
           $("#main_content").load("/p_OpListe");
         });




     </script>

<?php } ?>