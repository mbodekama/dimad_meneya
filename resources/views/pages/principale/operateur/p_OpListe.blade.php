<div class="card mb-3">
  <div class="bg-holder d-none d-lg-block bg-card" 
   style="background-image:url(../assets/img/illustrations/corner-4.png);">
  </div>
  <!--/.bg-holder-->

    <div class="card-body">
      <div class="row">
        <div class="col-lg-8">

          <h3 class="mb-0 text-primary"> <i class="fas fa-briefcase"></i> Opérateur >Liste</h3>
          <p class="mt-2"><b>Contrôler et Gérer les opérations de vos opérateurs
          </b></p>
          <br>
           <button class="btn btn-falcon-danger mr-1 mb-1" id="refresh" type="button">
             <span class="fab fa-battle-net fa-2x"  data-fa-transform="shrink-3"></span>Actualiser
           </button>
        </div>
      </div>
    </div>
</div>

          <div class="card mb-3">
            <div class="card-header">

              <div class="row align-items-center justify-content-between">
                <div class="col-4 col-sm-auto d-flex align-items-center pr-0">
                  <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Nos pérateurs</h5>
                </div>
                <div class="col-8 col-sm-auto ml-auto text-right pl-0">
                </div>
              </div>

              <div id="dashboard-actions">

                    <button class="btn btn-falcon-default btn-sm newOpera" type="button">
                      <span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span>
                      <span class="d-none d-sm-inline-block ml-1">
                       Opération-Opérateur
                      </span>
                    </button>

                    <button class="btn btn-falcon-default btn-sm newOperateur" type="button">
                      <span class="fas fa-user-plus" data-fa-transform="shrink-3 down-2"></span>
                      <span class="d-none d-sm-inline-block ml-1">
                        Nouvel opérateur
                      </span>
                    </button>
              </div>
              <br><br>

               <div class="row align-items-center justify-content-between">
                 <!-- Pagination -->
                 @include('pages/dash/pagnMod')
               </div>

              
              
            </div>
            @if(!$opera->isEmpty())
            <div class="card-body p-0" id="loaderContent">
              <div class="falcon-data-table">
                <table class="mytable table table-sm mb-0 table-striped table-dashboard fs--1 data-table border-bottom border-200" data-options='{"searching":true,"responsive":false,"pageLength":100,"info":false,"lengthChange":false,"sWrapper":"falcon-data-table-wrapper","dom":"<&#39;row mx-1&#39;<&#39;col-sm-12 col-md-6&#39;l><&#39;col-sm-12 col-md-6&#39;f>><&#39;table-responsive&#39;tr><&#39;row no-gutters px-1 py-3 align-items-center justify-content-center&#39;<&#39;col-auto&#39;p>>"}'>
                  <thead class="bg-200 text-900">
                    <tr>
                      <th class="align-middle no-sort">
                        <div class="custom-control custom-checkbox">
                          <input class="custom-control-input checkbox-bulk-select" id="checkbox-bulk-purchases-select" type="checkbox" data-checkbox-body="#orders" data-checkbox-actions="#orders-actions" data-checkbox-replaced-element="#dashboard-actions">
                          <label class="custom-control-label" for="checkbox-bulk-purchases-select"></label>
                        </div>
                      </th>
                      <th class="align-middle sort" style="min-width: 12.5rem;">Date</th>
                      <th class="align-middle sort">Mat.</th>
                      <th class="align-middle sort" style="min-width: 12.5rem;">Nom</th>
                      <th class="align-middle sort">Contact</th>
                      <th class="align-middle sort text-right">Lieu</th>
                      <th class="no-sort"></th>
                    </tr>
                  </thead>
                  <tbody id="orders">
                   <?php $i =0;
                   foreach ($opera as $key => $value){?>
                    <tr class="btn-reveal-trigger">
                      <td class="py-2 align-middle">
                        <div class="custom-control custom-checkbox">
                          <input class="custom-control-input checkbox-bulk-select-target" 
                           type="checkbox" id="checkbox-0" />
                          <label class="custom-control-label" for="checkbox-0"></label>
                        </div>
                      </td>
                      <td class="py-2 align-middle">
                        <p class="mb-0 text-500">
                         {{ $value['operateurDate'] }} 
                        </p>
                      </td>
                      <td class="py-2 align-middle white-space-nowrap"><a href="#">
                        <strong>{{ $value['operateurMat'] }} </strong><br />
                      </td>
                      <td class="py-2 align-middle">{{ $value['operateurNom'] }} </td>
                      <td class="py-2 align-middle">
                        <p class="mb-0 text-500">
                         {{ $value['operateurContact'] }} 
                        </p>
                      </td>
                      
                      <td class="py-2 align-middle text-right fs-0 font-weight-medium ">
                       {{ $value['operateurLieu'] }} 
                      </td>

                      <td class="py-2 align-middle white-space-nowrap">
                        
                        <button class="btn btn-falcon-info rounded-capsule mr-1 mb-1 operat" 
                         type="button" id="{{ $value['id'] }} ">Opérations
                        </button>

                        <a href="#" class="delete" id="{{ $value['id'] }} ">
                          <i class="far fa-trash-alt fa-2x text-danger">
                          </i>
                        </a>
                       <a href="#" class="updOp" id="{{ $value['id'] }} ">
                        <i class="far far fa-edit fa-2x text-primary"></i>
                       </a>

                      </td>
                    </tr> 
                   <?php } ?>
                      
                  </tbody>
                </table>

                <!-- Paginate -->
                <div class="row no-gutters px-1 py-3 align-items-center justify-content-center">
                   {{ $opera->links() }}
                   <input type="hidden" id='lastPrd' 
                   value="{{ $opera->last()->id }}"> 
                </div>

              </div>
            </div>
            @else
             <div class="alert alert-warning">Aucun Opérateur enregistré</div>
            @endif
          </div>



<!-- Modal-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Opérateur > Mise à jour</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span class="font-weight-light" aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="ContentL"></div>

      </div>
      <div class="modal-footer">
        <button class="btn btn-danger btn-sm updVald" type="button">Valider</button>
        <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">
          Fermer
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Champ inactif -->
@csrf


     {{-- <script src="{{ asset('assets/js/theme.js') }}"></script> --}}
     <script type="text/javascript">
      $(function(){

        // Faire disparaitre les paginate de Javascript
          $(".mytable").parent().next().hide();

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
            text: "Voulez-vous supprimer ce opérateurs ?",
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
                  url:'/p_OpDele',
                  method:'GET',
                  data:{idV:idV,action:action},
                  dataType:'text',
                  success:function(){
                    Swal.fire(
                     'Supprimer!',
                     'Opérateurs supprimer avec succès',
                     'error'
                    );
                    $("#main_content").load("/p_OpListe");
                  },
                  error:function(){
                    Swal.fire('Problème de connection internet');
                  }
                });
              }
          })
        });

        // Modifier phase 1
         $('.updOp').click(function(){
           var idOp = $(this).attr('id');
           $.ajax({
             url:'p_OpUpd',
             method:'GET',
             data:{idOp:idOp},
             dataType:'html',
             success:function(data){
              $(".ContentL").html(data);
               $("#exampleModal").modal('show');
             },
             error:function(){
              Swal.fire('Problème de connection internet');
             }

           });
         });

        // Modifier phase 2
         $('.updVald').click(function(){
           var nom      = $("#nom").val();
           var contact  = $("#contact").val();
           var lieu     = $("#lieu").val();
           var IdOp     = $("#IdOp").val();
           $.ajax({
             url:'/p_OpUpval',
             method:'GET',
             data:{nom:nom,lieu:lieu,contact:contact,IdOp:IdOp},
             dataType:'html',
             success:function(){
                Swal.fire('Modifier avec succès');
               $("#exampleModal").modal('hide');
               $('#refresh').click();


              },
             error:function(){Swal.fire('Problème de connection internet');}
           });
         });

        // Gestion des opérations
         $(".operat").click(function(){
           loadingScreen();
           var idV = $(this).attr('id');
           var token = $('input[name=_token]').val();
           $("#main_content").load("/p_OpTion",{val1:idV,_token:token});
         }); 
        
        // Refresh
        $('#refresh').click(function(){
           $("#main_content").load("/p_OpListe");
        });

        // Nouvelle opération
         $('.newOpera').click(function(){
           $("#main_content").load("/p_opetNew");
         });

        // Nouveau operateur
         $('.newOperateur').click(function(){
           $('#main_content').load("/p_Opera");
         });

      });

        

     </script>