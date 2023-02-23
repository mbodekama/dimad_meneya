<div class="no-print">
  {{-- la classe no print permet d'enlever ses elements de 
  l'apercu lors de l'impression ;; Son div ne joue aucun autre 
  role que d'englober la partie du site a ignorer lors du print --}}


<div class="card mb-3">
  <div class="bg-holder d-none d-lg-block bg-card" 
   style="background-image:url(../assets/img/illustrations/corner-4.png);">
  </div>
  <!--/.bg-holder-->

    <div class="card-body">
      <div class="row">
        <div class="col-lg-8">
         
          
           <h5 class="mb-0 text-primary">
              <a href="#" class="operateurs"><span><i class="fas fa-shipping-fast"></i> 
                Liste des approvisionnements </span></a>
           </h5>         
    
        </div>
      </div>
    </div>
</div>

@if(!$approvisionnement->isEmpty() )
          <div class="card">
            <div class="card-header">
              <div class="row align-items-center justify-content-between">
                <div class="col-4 col-sm-auto d-flex align-items-center pr-0">
                  <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Liste des approvisionnement</h5>
                </div>
                @include('pages/dash/pagnMod')
              </div>
            </div>
            <div class="card-body p-0 ml-3 mr-3">


              <div class="falcon-data-table" id="loaderContent">
                <table class="mytable table table-sm mb-0 table-striped table-dashboard fs--1 data-table border-bottom border-200" data-options='{"searching":true,"responsive":false,"pageLength":100,"info":false,"lengthChange":false,"sWrapper":"falcon-data-table-wrapper","dom":"<&#39;row mx-1&#39;<&#39;col-sm-12 col-md-6&#39;l><&#39;col-sm-12 col-md-6&#39;f>><&#39;table-responsive&#39;tr><&#39;row no-gutters px-1 py-3 align-items-center justify-content-center&#39;<&#39;col-auto&#39;p>>","language":{"paginate":{"next":"<span class=\"fas fa-chevron-right\"></span>","previous":"<span class=\"fas fa-chevron-left\"></span>"}}}'>
                  <thead class="bg-200 text-900">
                    <tr>

                      <th class="align-middle sort">Numéro</th>
                      <th class="align-middle sort pr-3">Date</th>
                      <th class="align-middle sort pr-3">Succursale </th>
                      {{-- <th class="align-middle sort">Quantite</th> --}}
                      <th class="align-middle sort ">Montant </th>
                      <th class="align-middle ">Action / Reçu</th>

                    </tr>
                  </thead>
                  <tbody id="customers">
                    @foreach($approvisionnement as $approvi)
                      {{-- Helper recuperant les informations de la succursale --}}
                          <?php $sucInfo = getSuccInfo($approvi->succursale_id) ?>
                      {{-- Helper recuperant les informations de la succursale --}}
                    <tr class="btn-reveal-trigger fs-0">
                      <td class="py-2 align-middle white-space-nowrap">
                        {{ $loop->iteration }}
                      </td>

                      <td class="py-2 align-middle sort">{{ $approvi->dateApro }}</td>
                      <td class=" align-middle  pr-3 sort">
                        {{$sucInfo->succursaleLibelle}}

                      </td>

                      <td class="py-2 align-middle sort">
                        <span class="badge badge rounded-capsule d-block badge-soft-secondary text-warning fs-1">
                        {{ formatPrice($approvi->approvisionMontant + $approvi->charge )}}
                      </span>
                      </td>

                      <th class="align-middle sort " style="cursor: pointer;">
                        <span class='fas fa-list-alt fa-2x  text-primary mr-2 liste' id="{{ $approvi->id }}"></span> 
                        <span class='far fa-file-pdf fa-2x text-warning reçu' alt="{{ $approvi->created_at }}" id="{{ $approvi->id }}" title="{{ $sucInfo->succursaleLibelle}}" contenteditable="{{ $sucInfo->name}}"></span> 
                      </th>

                    </tr>
                    @endforeach

 
                  </tbody>
                </table>

                {{ $approvisionnement->links() }}
              </div>
            </div>
          </div>
@else
<div class="alert alert-warning">Aucun approvisionnement </div>
@endif
      

    {{-- MODAL DES DETAILS DE L'APPROVISIONNEMENT  --}}

            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Approvisionnement > Détails</h5>
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
    {{-- FIN MODAL DES DETAILS DE L'APPROVISIONNEMENT  --}}

</div>

    {{-- FIN MODAL DES DETAILS DE L'APPROVISIONNEMENT  --}}
        @include('pages/dash/facture/aprovSuc')

    {{-- FIN MODAL DES DETAILS DE L'APPROVISIONNEMENT  --}}

  
          <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->

<script type="text/javascript">
  $(function()
  {

      // Faire disparaitre les paginate de Javascript
          $(".mytable").parent().next().hide();

      //Consulter liste des prds
          $('.liste').click(function(){
            // Id de l'opération
             var idApprovi = $(this).attr('id');

            // Envoie au controller
              ajaxApproviList(idApprovi);
            
         });
      $('.reçu').click(function()
      {
          //recuperation de valeur pour le recu
             var idOpVe = $(this).attr('id');
             var dateV = $(this).attr('alt');
             var gerant = $(this).attr('contenteditable');
             var sucName = $(this).attr('title');
            

        $.ajax({
               url:'mbo/aprovRecu',
               method:'get',
               data:{idOpVe:idOpVe},
               dataType:'html',
               success:function(data)
               {
                //recuperation de valeur pour complete le recu

                   $('#recu_content').html('');
                   $('#recu_content').html(data);
                   $('.dateVente').html(dateV);
                   $('.SucName').html("Succursale : "+sucName);
                   $('.gerant').html("Gérant: "+gerant);
                  print();


               },
               error:function()
               {
                toastr.error('Erreur ');
               },

             });
      });

      function ajaxApproviList(idApprovi)
      {

             $.ajax({
               url:'mbo/approviList',
               method:'get',
               data:{idApprovi:idApprovi},
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
  })
</script>