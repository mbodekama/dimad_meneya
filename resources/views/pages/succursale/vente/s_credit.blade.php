
<div class="card mb-3">
  <div class="bg-holder d-none d-lg-block bg-card" 
   style="background-image:url(../assets/img/illustrations/corner-4.png);">
  </div>
  <!--/.bg-holder-->

    <div class="card-body">
      <div class="row">
        <div class="col-lg-8">
          <h3 class="mb-0 text-primary"><i class="fas fa-hand-holding-usd"></i>Succursales>Créancier</h3>
        </div>
                        <div class="col-auto">

                  <button class="btn btn-falcon-danger btn-sm mr-2" role="button"> 
                    <i class="fas fa-chart-pie mr-1 text-900 "></i>
                    Client total : {{number_format( 50,0,',',' .') }}
                  </button>
                  <button class="btn btn-falcon-danger btn-sm mr-2" role="button"> 
                    <i class="fas fa-money-check-alt mr-1 text-900 "></i>
                    Plus forte dette: {{number_format( 500000,0,',',' .') }}  FCFA
                  </button>
                  
                </div>
      </div>
    </div>
</div>


          @if(!$crds->isEmpty())
          <div class="card mb-3">
            <div class="card-header">
              <div class="row align-items-center justify-content-center">
                    @include('pages/dash/pagnMod')


              </div>
            </div>
            <div class="card-body p-0" id="loaderContent">

              <div class="falcon-data-table">
                <table class=" mytable table table-sm mb-0 table-striped table-dashboard fs--1 data-table border-bottom border-200" data-options='{"searching":true,"responsive":false,"pageLength":100,"info":false,"lengthChange":false,"sWrapper":"falcon-data-table-wrapper","dom":"<&#39;row mx-1&#39;<&#39;col-sm-12 col-md-6&#39;l><&#39;col-sm-12 col-md-6&#39;f>><&#39;table-responsive&#39;tr><&#39;row no-gutters px-1 py-3 align-items-center justify-content-center&#39;<&#39;col-auto&#39;p>>","language":{"paginate":{"next":"<span class=\"fas fa-chevron-right\"></span>","previous":"<span class=\"fas fa-chevron-left\"></span>"}}}'>
                  <thead class="bg-200 text-900">
                    <tr>
                      <th class="align-middle sort">Code Vente</th>
                      <th class="align-middle sort">Nom créancier</th>
                      <th class="align-middle sort text-center">Montant</th>
                      <th class="align-middle sort text-center">Montant Dûe</th>
                      <th class="align-middle sort">Depuis</th>
                      <th class="align-middle sort">Echéance</th>
                      <th class="align-middle text-center">Action</th>
                    </tr>
                  </thead>
                   <tbody id="customers">

                    @foreach($crds as $crd)
                        {{-- recup client via helper --}}
                        @php
                          $infoClt = getClient($crd->clients_id);
                          $mntDue =  $crd->creditMontant - getSommeCrdPaye($crd->creditId);
                        @endphp
                      <tr class="">
                        <td>
                           {{ $crd->NumVente}}
                        </td>
                        <td id="nomClt" class="text-left">
                         {{ $infoClt->nom }}
                          <div class="fs--1">
                            <span class="font-weight-semi-bold">Tel: {{ $infoClt->contact ?? "ND" }}</span><span class="font-weight-medium text-600 ml-2"> à {{ $infoClt->lieu ?? "ND" }} </span>
                          </div>
                        </td>
                        <td class="text-center">
                           <span class="badge badge-pill badge-default" style="font-size: 15px">
                          {{ formatPrice($crd->creditMontant) }}
                        </span>
                        </td>
                        <td class="text-center">
                           <span class="badge badge-pill badge-danger" style="font-size: 15px">
                          {{ formatPrice($mntDue) }}
                        </span>
                        </td>
                        <td>
                          {{ $crd->creditDate }}
                        </td>
                        <td>
                          {{ $crd->creditEcheance }}
                        </td>
                            <td class="text-center">
                              {{-- conditin d'affichage du btn payer --}}
                              @if($mntDue > 0)
                                <button class="btn btn-falcon-default btn-sm btnPay" title="Payer le crédit" 
                                idCrd="{{ $crd->creditId }}"
                                clientId='{{ $crd->clients_id }}'
                                clientNom='{{ $infoClt->nom }}'
                                montantCrd ='{{ $mntDue }}'
                                montantDuFormat = '{{ formatPrice($mntDue) }}'
                                type="button" data-toggle="modal" data-target="#payerMod">
                                  <span class="text-success fs-1" data-fa-transform="shrink-3 down-2"> Payer</span>
                                </button>
                              @endif
                                <button class="btn btn-falcon-default btn-sm btnHist" title="Voir les paiements" id="{{  $crd->creditId }}" type="button" data-toggle="modal" data-target="#histMod">
                                  <span class="far fa-eye text-primary fa-2x" data-fa-transform="shrink-3 down-2"></span>
                                </button>
                                <button class="btn btn-falcon-default btn-sm btnDel" id="{{ $crd->creditId }}" type="button">
                                  <span class="far fa-trash-alt fa-2x text-danger" data-fa-transform="shrink-3 down-2"></span> 
                                </button>

                            </td>

                      </tr>
                    @endforeach
                  </tbody>
                </table>

                  <div class="row no-gutters px-1 py-3 align-items-center justify-content-center">
                      {{ $crds->links() }}
                  </div>
              </div>
            </div>
          </div>
          @else
            <div class="alert alert-danger text-center h5">
                Aucun crédit enregistrer !.<br> Avec MENEYA gérer toutes les créances de vos clients et soyez alerter de pour des délais .
              </div>
          @endif


           
    {{-- **************************************
            FICHIER DES PAIEMENT ET HISTORIQUES
          ***************************************--}}
          @include('pages/dash/payDetail')


  <script type="text/javascript">
$(function()
  {
      // Faire disparaitre les paginate de Javascript
          $(".mytable").parent().next().hide();

      //Scroll l'affichage a la page charge
        scrollContent();

      //Btn payer cliquer => Action
          $('.btnPay').click(function()
          {
            //Recuperation des valeurs du credit
              var idCrd = $(this).attr('idCrd');
              var clientId = $(this).attr('clientId');
              var clientNom = $(this).attr('clientNom');
              var montantCrd = $(this).attr('montantCrd');
              var montantDuFormat = $(this).attr('montantDuFormat');

            //Affectation au champs du form de payement
            // Form dispo dans pages/dash/payDetail
              $('#idCrd').val(idCrd);
              $('#clientId').val(clientId);
              $('#clientNom').val(clientNom);
              $('#montantCrdFormat').text(montantDuFormat);
              $('#montantCrd').val(montantCrd);
            //req ajax 
            $('#idCrdF').val(idCrd);
            $('#clientF').val($.trim($('#nomClt').text()));
          });






  }) //Fin des scripts
</script>