<div class="no-print">

<div class="card mb-3">

  <div class="bg-holder d-none d-lg-block bg-card" 

   style="background-image:url(../assets/img/illustrations/corner-4.png);">

  </div>

  <!--/.bg-holder-->



    <div class="card-body">

      <div class="row">

        <div class="col-lg-8">

         

          

           <h3 class="mb-0 text-primary">
              {{-- {{dd($operateur)}} --}}
              <a href="#" class="operateurs" 
                 id="{{ $operateur->id }}">
                <span><i class="fas fa-briefcase"></i> 
                 {{-- {{dd($operateur)}} --}}
                 Opérateurs >
                </span>{{ $operateur->operateurNom }}
              </a>

           </h3>

           {{-- recuperation de l'Id de l'operateur --}}

           <input type="hidden" id="idOperateur"  value="{{ $operateur->id }}">

          </a>

          <p class="mt-2">

            <span class="fas fa-blender-phone"></span>
            <b>Contact</b>: {{  $operateur->operateurContact }}
            <span class="fas fa-map-marker-alt ml-2"></span>
            <b>Lieu</b>: {{  $operateur->operateurLieu }}

            <span class="fab fa-gg ml-2"></span>
            <b>Matricule</b>:  {{ $operateur->operateurMat }}
            <hr>
            <span class="fas fas fa-barcode ml-2 operaCode"
             operacode="{{$operationcode}}"></span>
            <b>Opération code</b>:  {{$operationcode}}<br>

            <span class="fas fas fa-barcode ml-2 operaName"
             operaname="{{$operation}}"
            ></span>
            <b>Opération</b>:  {{$operation}}<br>


            <span class="fas fas fa-barcode ml-2"></span>
            <b>Opération détails</b>:  {{$operationcoment}}

          </p>

           <button class="btn btn-falcon-danger mr-3 mb-1 refresh"        type="button"
                   operationcode="{{$operationcode}}"
                   operation="{{$operation}}"
                   operationcoment="{{$operationcoment}}"
                   idoperateurOperation="{{$idOpt}}"
                   idOp={{$idOp}}
           >
              <span class="fab fa-battle-net fa-2x"  data-fa-transform="shrink-3"></span>Actualiser
            </button>   

        </div>

      </div>

    </div>

</div>













  @if($sorties->isEmpty())



  {{-- // Vérification de l'existence d'opérations-opérateurs::sorties --}}



             <div class="card">

            <div class="card-body overflow-hidden text-center pt-5">

              <div class="row justify-content-center">

                <div class="col-7 col-md-5"><img class="img-fluid" src="../assets/img/illustrations/modal-right.png" alt="" /></div>

              </div>

              <h3 class="mt-3 font-weight-normal fs-2 mt-md-4 fs-md-3">

                <b class="text-danger">Ouf!!!!!!</b>, aucune sortie pour cette opération

              </h3>

              <p class="lead">Veuillez créer une nouvelle sortie pour cette opération .

                <br class="d-none d-md-block"/>

                <button class="ml-1 btn btn-outline-primary rounded-capsule mr-1 mb-1 newOp" 

                 type="button" id="{{ $operateur->id }}">   Nouvelle sortie

                </button><br class="d-none d-md-block"/>

                <a class="retour" href="#" id="{{ $operateur->id }}">

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

            // Nouvelle sortie

             $('.newOp').click(function(){
               var idV = $(this).attr('id');
               var token = $('input[name=_token]').val();
               $("#main_content").load("/p_OpSortie",{idV:idV,_token:token});

             });



            // Retour opérateur

             $('.retour').click(function(){
               var idV = $(this).attr('id');
               var token = $('input[name=_token]').val();
               $("#main_content").load("/p_OpTion",{idV:idV,_token:token});
             });



          </script>







  @else

          <div class="card mb-5 ">

            <div class="card-header">

              <div class="row align-items-center justify-content-between">

                <div class="col-6 col-sm-auto d-flex align-items-center pr-0">

                  <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Liste des sorties liées à l'opération<a href="" data-toggle="modal" data-target="#exampleModalRight"></a></h5>
                  
                  <!-- Pagination -->
                   @include('pages/dash/pagnMod')

                </div>

                <div class="col-8 col-sm-auto ml-auto text-right pl-0">



                  <div id="dashboard-actions">

                  </div>

                </div>

              </div>

            </div>

            <div class="card-body p-0">

              <div class="falcon-data-table" id="loaderContent">

                <table class="mytable table table-sm mb-0 table-striped table-dashboard fs--1 data-table border-bottom border-200" data-options='{"searching":true,"responsive":false,"info":false,"lengthChange":false,"sWrapper":"falcon-data-table-wrapper","dom":"<&#39;row mx-1&#39;<&#39;col-sm-12 col-md-6&#39;l><&#39;col-sm-12 col-md-6&#39;f>><&#39;table-responsive&#39;tr><&#39;row no-gutters px-1 py-3 align-items-center justify-content-center&#39;<&#39;col-auto&#39;p>>","language":{"paginate":{"next":"<span class=\"fas fa-chevron-right\"></span>","previous":"<span class=\"fas fa-chevron-left\"></span>"}}}'>

                  <thead class="bg-200 text-900">

                    <tr>

                      <th class="align-middle sort">Code Sortie</th>

                      <th class="align-middle sort" >Qte produits</th>

                      <th class="align-middle sort text-left">Montant Total</th>

                      <th class="align-middle sort text-left">Charges</th>

                      <th class="align-middle sort text-left">Détails de charges
                      </th>

                      <th class="align-middle sort text-left">Date 
                      </th>

                      <th class="align-middle sort text-left">Action </th>

                    </tr>

                  </thead>

                  <tbody>
                    {{-- {{dd($sorties)}} --}}

                    @foreach($sorties as $sortie)

                    <tr>

                      <th class="align-middle sort">

                        {{ $sortie->matSortie }}

                      </th>

                      <th class="align-middle sort" >

                        {{ $sortie->quantiteS }}

                      </th>

                      <th class="align-middle sort text-left">
                        @if($sortie->montantS!='')
                        {{ $sortie->montantS }} {{getMyDevise()}} 
                        @else 
                          0 {{getMyDevise()}}
                        @endif 
                      </th>

                      <th class="align-middle sort text-left">
                        @if($sortie->charges==0)
                          {{0}} {{getMyDevise()}} 
                        @else
                          {{ $sortie->charges }} {{getMyDevise()}}
                        @endif
                      </th>

                      <th class="align-middle sort text-left">
                       {{$sortie->chargesDesc}}
                      </th>

                      <th class="align-middle sort">

                        {{ $sortie->dateSortie }}

                      </th>

                      <th class="align-middle sort text-left" 
                          style="cursor: pointer;">

                        <span class='fas fa-list-alt fa-2x  text-primary mr-2 liste' 
                        id="{{ $sortie->id }}"></span> 

                        <span class='far fa-file-pdf fa-2x text-warning reçu' 
                         alt="{{ $sortie->dateSortie }}" 
                         id="{{ $sortie->id }}"></span> 

                         <span class='far fa-trash-alt fa-2x text-danger sup' 
                         alt="{{ $sortie->created_at }}" 
                         id="{{ $sortie->id }}"></span> 

                      </th>

                      

                    </tr>

                    @endforeach

                  </tbody>

                </table>

                <!-- Paginate -->
                <div class="row no-gutters px-1 py-3 align-items-center justify-content-center">
                   {{-- {{ $sorties->links() }} --}}
                </div>

              </div>

            </div>

          </div>




  @endif



</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title" id="exampleModalLabel">Opération > Détails</h5>

        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span class="font-weight-light" aria-hidden="true">&times;</span></button>

      </div>

      <div class="modal-body">

        <div class="ContentL"></div>



      </div>

      <div class="modal-footer">

        <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">

          Fermer

        </button>

      </div>

    </div>

  </div>

</div>





</div>







    <!-- ===============================================-->

    <!--    Fichier Facture pour operateur-->

    <!-- ===============================================-->



      @include('pages/dash/facture/sortieOp')



    <!-- ===============================================-->

    <!--    Fin Fichier Facture pour operateur -->

    <!-- ===============================================-->









<script type="text/javascript">



$(function()

{
   // Faire disparaitre les paginate de Javascript
    $(".mytable").parent().next().hide();

  // Actualiser la page
  $(".refresh").click(function(){
     var idOpt = $(this).attr('idoperateurOperation');
     var operation = $(this).attr("operation");
     var operationcode = $(this).attr("operationcode");
     var operationcoment = $(this).attr("operationcoment");
     var idOp = $(this).attr("idOp");
     var token = $('input[name=_token]').val();
     $("#main_content").load("/p_listeSortie",
       {idOp : idOp, 
        idOpt:idOpt, 
        _token :token,
        operation:operation,
        operationcode:operationcode,
        operationcoment:operationcoment
       });
  });

  // Supprimer une sortie
  $(".sup").click(function(){
    var idSort = $(this).attr("id");
    var action = 'supp';
    /*alert("supprimer");*/
    Swal.fire({
            title: 'Opérateurs',
            text: "Voulez-vous supprimer cette sortie ?",
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
                  url:'/p_SortieDel',
                  method:'GET',
                  data:{idST:idSort,action:action},
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

  //Retour liste des opérations-operateurs
    $(".operateurs").click(function(){
      var idV = $(this).attr('id');
      var token = $('input[name=_token]').val();
      console.log("Opérateur: "+idV);
      $("#main_content").load("/p_OpTion",{idV:idV,_token:token});
    });  

      $('.liste').click(function(){

            // Id de l'opération

             var idOpVe = $(this).attr('id');
             var operationcode = $('.operaCode').attr('operacode');
             var operation = $('.operaName').attr('operaname');
            

            // Envoie au controller

              ajaxRecupSortie(idOpVe,operationcode,operation);

            // console.log('operation_id:'+idOpera);

            // console.log('operateur_id:'+idOpe);

            

         });

      $('.reçu').click(function()

      {

        // alert('ok');

             var idOpVe = $(this).attr('id');

             var dateV = $(this).attr('alt');

            



        $.ajax({

               url:'p_opRecuSorti',

               method:'get',

               data:{idOpVe:idOpVe},

               dataType:'html',

               success:function(data)

               {

                 $('#recu_content').html('');

                 $('#recu_content').html(data);

                 $('.dateVente').html(dateV);

                  print();

               },

               error:function()

               {

                toastr.error('Erreur ');

               },



             });

      });



      function ajaxRecupSortie(idOpVe,operationcode,operation)

      {



             $.ajax({

               url:'p_opDet',

               method:'get',

               data:{idOpVe:idOpVe,operationcode:operationcode,operation:operation},

               dataType:'html',

               success:function(data)

               {

                 $('.ContentL').html(data);

                 $('#exampleModal').modal('show');

               },

               error:function()

               {

                toastr.error('Erreur ');

               }

             });

      }



      // $('.btnRetour').click(function()

      // {

      //   $('main_content').load('p_OpListe');

      // })



      // $('.btnNewOp').click(function(){

      //   $('main_content').load('p_opetNew');



      // })

})



  </script>





