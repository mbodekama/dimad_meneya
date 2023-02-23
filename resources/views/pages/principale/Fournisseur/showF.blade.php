<?php
  // Vérification de l'existence d'opérations-opérateurs
   $nb = count($EchF);
   if ($nb==0) {?>
             <div class="card">
            <div class="card-body overflow-hidden text-center pt-5">
              <div class="row justify-content-center">
                <div class="col-7 col-md-5"><img class="img-fluid" src="../assets/img/illustrations/modal-right.png" alt="" /></div>
              </div>
              <h3 class="mt-3 font-weight-normal fs-2 mt-md-4 fs-md-3">
                <b class="text-danger">Ouf!!!!!!</b>, cet fournisseur  ne dispose pas de débit
              </h3>
              <p class="lead">Veuillez lui affecter une nouvelle échéance  .
                <br class="d-none d-md-block"/>
                <button class="ml-1 btn btn-outline-primary rounded-capsule mr-1 mb-1 newEch" 
                 type="button">   Nouvelle échéance
                </button><br class="d-none d-md-block"/>
                <a class="retour" href="#">
                  <span class="text-danger"><i class="fas fa-angle-left"></i> Retour</span>
                </a>
              </p>
              
            </div>
            <div class="card-footer d-flex justify-content-center bg-light text-center pt-4">
              <div class="col-10">
                <p class="mb-2 fs--1">Gestion de fournisseurs </p>
              </div>
            </div>
          </div>

          <script type="text/javascript">
            // Nouvelle affectation d'echeance
             $('.newEch').click(function(){
               $("#main_content").load("/p_Eche");
             });

            // Retour liste fournisseur
             $('.retour').click(function(){
               $("#main_content").load("/p_listF");
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
  

           {{-- recuperation de l'Id de l'operateur --}}
           <input type="hidden" id="idOperateur"  value="{{ $four->id }}">
          </a>
          <p class="mt-2">
            <h3 class="mb-0 text-primary">
           <a href="#" class="fournisseur">
            <i class="fas fa-user-tie"></i>
            Fournisseurs ></a>Historique Achats
          </h3><br>
            <span><b>Nom: </b></span>
              {{ $four->fournisseurNom }}<br>
   
            <span class=""></span>
            <b>Responsable </b>: {{ $four->fournisseurRespo}}

            <br><span class=""></span>
            <b>Contact </b>: {{ $four->fournisseurContact }}<br>

            <span class=""></span>
            <b>Matricule</b>: <?php echo $four->fournisseurMat;?>
          </p>
          
          <br>
           <button class="btn btn-falcon-danger mr-3 mb-1 refresh" 
            id="<?=$four->id?>" type="button">
             <span class="fab fa-battle-net fa-2x"  data-fa-transform="shrink-3"></span>Actualiser
           </button>
{{--             <button class="btn btn-falcon-danger mr-1 mb-1  bntSortie" 
            id="<?=$four->id?>" type="button">
             <span class="fas fa-plus "  data-fa-transform="shrink-3" ></span>Ajouter sortie
           </button> --}}

                    <button class="btn btn-falcon-default btn-sm newOpera" type="button">
                      <span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span>
                      <span class="d-none d-sm-inline-block ml-1">
                        Nouvelle achat
                      </span>
                    </button>
  
        </div>
      </div>
    </div>
</div>

          <div class="card mb-3">
            <div class="card-header">
              <div class="row align-items-center justify-content-around">

                <button class="btn btn-falcon-danger btn-sm newOpera" type="button">
                    <i class="far fa-money-bill-alt" data-fa-transform="shrink-3 down-2"></i>
                      <span class="d-none d-sm-inline-block ml-1">
                        Total Montant Due : <span id="totMntDu"></span>
                      </span>
                </button>
                <button class="btn btn-falcon-default btn-sm newOpera" type="button">
                      <i class="fas fa-sort-amount-up" data-fa-transform="shrink-3 down-2"></i>
                      <span class="d-none d-sm-inline-block ml-1">
                        Total achat : {{ formatPrice($EchF->sum('echeanceMontant')) }}
                      </span>
                </button>
              </div>
            </div>
            <div class="card-body p-0">
              <div class="falcon-data-table">
                <table class="table table-sm mb-0 table-striped table-dashboard fs--1 data-table border-bottom border-200" data-options='{"searching":true,"responsive":true,"info":false,"lengthChange":false,"sWrapper":"falcon-data-table-wrapper","dom":"<&#39;row mx-1&#39;<&#39;col-sm-12 col-md-6&#39;l><&#39;col-sm-12 col-md-6&#39;f>><&#39;table-responsive&#39;tr><&#39;row no-gutters px-1 py-3 align-items-center justify-content-center&#39;<&#39;col-auto&#39;p>>","language":{"paginate":{"next":"<span class=\"fas fa-chevron-right\"></span>","previous":"<span class=\"fas fa-chevron-left\"></span>"}}}'>
                  <thead class="bg-200 text-900">
                    <tr>

                      <th class="align-middle sort">N°</th>
                      <th class="align-middle sort">Date d'achat
                      </th>
                      <th class="align-middle sort">Date Echeance
                      </th>
                      <th class="align-middle sort">Valeur d'achat
                      </th>
                      <th class="align-middle sort">Montant Dûe
                      </th>
                      <th class="align-middle sort text-center">Status</th>
                      <th class="align-middle text-center">Action</th>
                    
                    </tr>
                  </thead>
                  <tbody id="orders">
                    @php
                      $totalDue = 0;
                    @endphp
                   @foreach($EchF as $echF)

                   <tr class="btn-reveal-trigger">
                      <td class="py-2 align-middle">
                        {{ $loop->iteration }}
                      </td>
                      <td class="py-2 align-middle ">
                        {{ $echF->dateAchat }}
                      </td>
                      <td class="py-2 align-middle ">
                        {{ $echF->echeanceDate }}
                      </td>
                      <td class="py-2 align-middle">
                        <span class="badge badge-pill badge-secondary" style="font-size: 15px">
                          {{ formatPrice($echF->echeanceMontant) }}
                        </span>
                      </td>
                      <td class="py-2 align-middle">
                        <span class="badge badge-pill badge-primary" style="font-size: 15px">
                         @php
                          $montantDue = $echF->echeanceMontant - getSommePaye($echF->idEch);
                          $totalDue += $montantDue;
                          if ($montantDue<0) {
                            $montantDue = 0;
                          }
                         @endphp 
                         
                          {{formatPrice($montantDue)}}
                          </span>
                        </td>
                      <td>
                        @if ($echF->echeanceStatut == 'en cours')

                           <span class="badge badge rounded-capsule d-block badge-soft-danger">
                            {{$echF->echeanceStatut }}

                               <span class="ml-1 fas fa-redo-alt" data-fa-transform="shrink-2"></span>

                              </span>

                          @else
                              <span class="badge badge rounded-capsule d-block badge-soft-success">
                                {{ $echF->echeanceStatut }}

                               <span class="ml-1 fas fa-check" data-fa-transform="shrink-2"></span>

                              </span>
                          @endif
                      </td>

                      <td class="py-2 align-middle text-center">
                        @if($echF->echeanceStatut == 'en cours')
                        <button class="btn btn-falcon-info rounded-capsule mr-1 mb-1 payer" type="button" id="{{ $echF->idEch }}" data-toggle="modal" data-target="#payerMod">Payer
                        </button>
                        @endif
                       <a href="#" class="hist" 
                           id="{{ $echF->idEch }}" alt="Historique" data-toggle="modal" data-target="#histMod">
                          <i class="far fa-list-alt fa-2x text-warning">
                          </i>
                        </a>
                       <a href="#" class="delete" 
                           id="{{ $echF->idEch }}">
                          <i class="far fa-trash-alt fa-2x text-danger">
                          </i>
                        </a>
                      </td>
                    </tr> 
                @endforeach
                      
                  </tbody>
                </table>
              </div>
            </div>
          </div>


<!-- Modal-->


<!-- Champ inactif -->
<input type="hidden" id="totalMntDu" value="{{ formatPrice($totalDue) }}">
@csrf
<div class="d-none" id='spiner'>
<div class="spinner-border text-primary" role="status">
  <span class="sr-only">Loading...</span>
</div>
<div class="spinner-border text-secondary" role="status">
  <span class="sr-only">Loading...</span>
</div>
<div class="spinner-border text-success" role="status">
  <span class="sr-only">Loading...</span>
</div>
<div class="spinner-border text-info" role="status">
  <span class="sr-only">Loading...</span>
</div>
<div class="spinner-border text-warning" role="status">
  <span class="sr-only">Loading...</span>
</div>
<div class="spinner-border text-danger" role="status">
  <span class="sr-only">Loading...</span>
</div>
<div class="spinner-border text-light" role="status">
  <span class="sr-only">Loading...</span>
</div>
<div class="spinner-border text-dark" role="status">
  <span class="sr-only">Loading...</span>
</div>
  
</div>

<!-- Button trigger modal-->
{{-- <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#exampleModal">Launch demo modal</button> --}}
<!-- Modal-->
<!-- Button trigger modal-->
<!-- Modal-->
<div class="modal fade" id="histMod" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Paiement de fournisseur</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span class="font-weight-light" aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body histBody">


      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary btn-sm" type="button" id="histModClose" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="payerMod" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Paiement de fournisseur</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span class="font-weight-light" aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
          <form  id="payeEch" >
            <input type="hidden" id="myIdEch" name="idEch" value="">
            @csrf
              
                      <div class="form-row">
                        <div class="col-6">
                          <div class="form-group">
                            <label for="name">Versé par (Nom)</label>
                            <input class="form-control" id="name" name="name" type="text" required>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label for="datepicker">Date </label>
                            <input class="form-control datetimepicker" id="datepicker" name="date" type="text" data-options='{"dateFormat":"d/m/y"}'>
                          </div>
                        </div>
                        <div class="col-sm-6">
                        <div class="form-group">
                          <label for="exampleFormControlSelect1">Type de paiement</label>
                          <select class="form-control" id="exampleFormControlSelect1" name="typePaiement">
                            <option value="Banque">Banque</option>
                            <option value="Chèque">Chèque</option>
                            <option value="Espèce">Espèce</option>
                          </select>
                        </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label for="montant">Montant versement</label>
                            <input class="form-control " required id="montant" name="montant" type="number" >
                          </div>
                        </div>
                        <div class="col-sm-12">
                          <div class="form-group">
                            <label for="banque">Banque/ Recepteur</label>
                            <input class="form-control " id="banque" name="banque" type="text" required >
                          </div>
                        </div>



                      </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal" id="payeModClose" >Fermer</button>
        <button class="btn btn-primary btn-sm valider" type="button">Valider</button>
      </div>
    </div>
  </div>
</div>





     <script src="{{ asset('assets/js/theme.js') }}"></script>
     <script type="text/javascript">
        //Affectation du montant total Due 
          var mntDue = $('#totalMntDu').val();
          $('#totMntDu').text(mntDue);
        //Valider 
         $('.valider').click(function(){
            var idV     = $(this).attr('id');
            var action = 'OkVers';
            Swal.fire({
             title: 'Payer',
             text: "Voulez vous valider ce paiement ?",
             icon: 'warning',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             cancelButtonText: 'Annuler',
             confirmButtonText: 'oui , solder!'
            }).then((result) => {
              if (result.value) {
                $.ajax({
                  url:'/p_EchOK',
                  method:'GET',
                  data: $('#payeEch').serialize(),
                  dataType:'text',
                  success:function(){
                  Swal.fire(
                     'Echéance!',
                     'Paiement fait avec succès',
                     'success'
                    );

                  $('#payeModClose').click();
                  $('.refresh').click();
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
            title: 'Echeance',
            text: "Voulez-vous cet écheance du fournisseurs ?",
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
                  url:'/delEch',
                  method:'GET',
                  data:{idEch:idV},
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
           var idFour = $(this).attr('id');
           var token = $('input[name=_token]').val();
           $("#main_content").load("/showFour",{idFour:idFour,_token:token});
         });

         //Ajouter une sortie
         $('.bntSortie').click(function()
         {
          var idV = $(this).attr('id');
           var token = $('input[name=_token]').val();
           $("#main_content").load("/p_OpSortie",{idV:idV,_token:token});

         })

         //Ajout d'operaation 
                 // Nouvelle opération
         $('.newOpera').click(function(){
           $("#main_content").load("/p_Eche");
         });

        //Payer btn
        $('.payer').click(function(){
           var idEch = $(this).attr('id');
         
          $('#myIdEch').val(idEch);
        });

        $('.hist').click(function()
        {
          //Ajout spiner
          $('.histBody').html($('#spiner').html());

          var idEch = $(this).attr('id');
          //req ajax 
          ajaxHistEch(idEch);
        });


        //  Listes des Sorties des opérations
        $('.sorties').click(function()
        {
          var idOp = $('#idOperateur').val();
          var idOpt = $(this).attr('id');   //id de l'operation de l'operateur
           var token = $('input[name=_token]').val();
           $("#main_content").load("/p_listeSortie",{idOp : idOp, idOpt:idOpt, _token :token});
        })


        // Retour sur les fournisseurs
         $('.fournisseur').click(function(){
           $("#main_content").load("/p_listF");
         });


         function ajaxHistEch(idEch)
         {
         $.ajax({
                  url:'/histEch',
                  method:'GET',
                  data: {idEch:idEch},
                  dataType:'html',
                  success:function(data){
                  $('.histBody').html(data);         
                  },
                  error:function()
                  {
                    Swal.fire('Problème de connection internet');
                      $('.histBody').html("<h3 class='text-danger'>Problème de connection Internet. Reéssayer !! <h3>");

                  }
                });          

         }

     </script>

<?php } ?>