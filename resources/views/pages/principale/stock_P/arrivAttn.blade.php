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
         
          
           <h4 class="mb-0 text-primary">
              <a href="#" class="operateurs"><span><i class="fas fa-shipping-fast"></i> 
                Liste des arrivages  </span></a>
           </h4>         
    
        </div>
      </div>
    </div>
</div>

          <div class="card">
            <div class="card-header">
              <div class="row align-items-center justify-content-between">
                <div class="col-4 col-sm-auto d-flex align-items-center pr-0">
                  <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Liste des arrivages</h5>
                </div>
                <div class="col-8 col-sm-auto text-right pl-2">
                  <div class="d-none" id="customers-actions">
                    <div class="input-group input-group-sm">
                      <select class="custom-select cus" aria-label="Bulk actions">
                        <option selected="">Bulk actions</option>
                        <option value="Delete">Delete</option>
                        <option value="Archive">Archive</option>
                      </select>
                      <button class="btn btn-falcon-default btn-sm ml-2" type="button">Apply</button>
                    </div>
                  </div>
                  <div id="customer-table-actions">

                  </div>
                </div>
              </div>
            </div>
            <div class="card-body p-0 ml-3 mr-3">
              <div class="falcon-data-table">
                <table class="table table-sm mb-0 table-striped table-dashboard fs--1 data-table border-bottom border-200" data-options='{"searching":true,"responsive":false,"pageLength":50,"info":false,"lengthChange":false,"sWrapper":"falcon-data-table-wrapper","dom":"<&#39;row mx-1&#39;<&#39;col-sm-12 col-md-6&#39;l><&#39;col-sm-12 col-md-6&#39;f>><&#39;table-responsive&#39;tr><&#39;row no-gutters px-1 py-3 align-items-center justify-content-center&#39;<&#39;col-auto&#39;p>>","language":{"paginate":{"next":"<span class=\"fas fa-chevron-right\"></span>","previous":"<span class=\"fas fa-chevron-left\"></span>"}}}'>
                  <thead class="bg-200 text-900">
                    <tr >

                      <th class="align-middle no-sort ">Code</th>
                      <th class="align-middle sort pr-3">Libelle</th>
                      <th class="align-middle sort">Date </th>
                      {{-- <th class="align-middle sort">Quantite</th> --}}
                      <th class="align-middle sort">Montant TTC</th>
                      <th class="d-flex justify-content-center ">Action </th>

                    </tr>
                  </thead>
                  <tbody id="customers">
                    @foreach($arrivs as $arriv)


                    <tr class="btn-reveal-trigger fs-0">
                      <td class="py-2 align-middle white-space-nowrap">
                        {{ $arriv->MatArvg }}
                      </td>
                      <td class=" align-middle white-space-nowrap">
                        {{$arriv->arrivageLibelle}}

                      </td>

                     {{--  <td class="py-2 align-middle">
                        {{ formatQte($arriv->arrivageQte) }}
                      </td> --}}

                      <td class="py-2 align-middle sort">{{ $arriv->arrivageDate }}</td>
                      <td class="py-2 align-middle sort ">
                        <span class="badge badge rounded-capsule d-block badge-soft-secondary text-warning fs-1">
                        {{ formatPrice($arriv->arrivagePrix + $arriv->charge)}}
                        </span>
                      </td>
                      <td class="d-flex justify-content-end " style="cursor: pointer;">
                          <button class="ml-1 btn btn-outline-primary rounded-capsule mr-1 mb-1 liste" id="{{ $arriv->id }}"><i class="far fa-list-alt"></i> &nbsp; Liste
                          </button>
                          <button class="ml-1 btn btn-outline-warning rounded-capsule mr-1 mb-1 reçu" id="{{ $arriv->id }}"
                          alt="{{ $arriv->arrivageDate }}" title="{{ $arriv->arrivageLibelle}}" contenteditable="{{ $arriv->arrivageLibelle}}">
                            <i class="far fa-file-pdf"></i> &nbsp; Reçu
                          </button>

                          <button class="ml-1 btn btn-outline-success rounded-capsule mr-1 mb-1 arrivValid" id="{{ $arriv->id }}">
                            <i class="far fa-check-circle"></i> &nbsp; Valider
                          </button>
                        <span class='fas fa-edit fa-2x  text-info mr-2 editArriv' id="{{ $arriv->id }}"></span> 
                        <span class='fas fa-trash-alt fa-2x  text-danger mr-2 delete' id="{{ $arriv->id }}"></span> 
                      </td>

                    </tr>
                    @endforeach
                    
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <div id="mytoken">
            <input type="hidden" name="id_succursale" id="idSuc" >
            @csrf
          </div>
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

  
          <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->



    <script src="{{ asset('assets/js/theme.js') }}"></script>

    {{-- FIN MODAL DES DETAILS DE L'APPROVISIONNEMENT  --}}
        @include('pages/dash/facture/recuArriv')

    {{-- FIN MODAL DES DETAILS DE L'APPROVISIONNEMENT  --}}
<script type="text/javascript">
  $(function()
  {
          $('.liste').click(function(){
            // Id de l'opération
             var idArr = $(this).attr('id');

            // Envoie au controller
              ajaxArrivList(idArr);
            
         });

          $('.delete').click(function(){
            // Id de l'opération
             var idArr = $(this).attr('id');

            // Envoie au controller
              ajaxArrivarrivDel(idArr);
            
         });

          $('.arrivValid').click(function()
          {
            // Id de l'opération
             var idArr = $(this).attr('id');

            // Envoie au controller
              ajaxarrivValid(idArr);
            
         });
          
      $('.reçu').click(function()
      {
          //recuperation de valeur pour le recu
             var idOpVe = $(this).attr('id');
             var dateV = $(this).attr('alt');
             var gerant = $(this).attr('contenteditable');
             var sucName = $(this).attr('title');
            

        $.ajax({
               url:'mbo/detailArriv',
               method:'get',
               data:{idArr:idOpVe},
               dataType:'html',
               success:function(data)
               {
                //recuperation de valeur pour complete le recu

                   $('#recu_content').html('');
                   $('#recu_content').html(data);
                   $('.dateVente').html(dateV);
                  print();


               },
               error:function()
               {
                toastr.error('Erreur connexion internet de mauvaise qualité');
               },

             });
      });

      //Clic sur Editer 
      $('.editArriv').click(function()
      {
        var id = $(this).attr('id');
        var input = '#mytoken input[name=_token]';
        var token = $(input).attr('value');
         $('#main_content').load('mbo/editArriv',{idArr:id, _token:token});  
      })

      

      function ajaxArrivList(idArr)
      {

             $.ajax({
               url:'mbo/detailArriv',
               method:'get',
               data:{idArr:idArr},
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

      function ajaxarrivValid(idArr)
      {

             $.ajax({
               url:'mbo/arrivValid',
               method:'get',
               data:{idArr:idArr},
               dataType:'html',
               success:function(data)
               {
                toastr.success('Réception de produits validé ');
                $('#main_content').load('mbo/arrivAttn');

               },
               error:function()
               {
                toastr.error('Erreur ');
               }
             });
      }

      function ajaxArrivarrivDel(idArr)
      {

            Swal.fire({
              title: 'Supression Arrivage',
              text: "Voulez vous suprimer cet arrivage de produits ?",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#d33',
              cancelButtonColor: '#3085d6',
              cancelButtonText: 'Annuler',
              confirmButtonText: 'oui , Suprimer!'
            }).then((result) => {
                if (result.value) {
                   $.ajax({
                     url:'mbo/arrivDel',
                     method:'get',
                     data:{idArr:idArr},
                     dataType:'html',
                     success:function(data)
                     {
                        toastr.success('Supression fait avec success ');
                        $('#main_content').load('mbo/arrivAttn');

                     },
                     error:function()
                     {
                      toastr.error('Erreur ');
                     }
                   })
                }
            })
      }
      
  })
</script>