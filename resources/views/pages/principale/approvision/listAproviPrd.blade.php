<div class="card mb-3">
  <div class="bg-holder d-none d-lg-block bg-card" 
   style="background-image:url(../assets/img/illustrations/corner-4.png);">
  </div>
  <!--/.bg-holder-->

    <div class="card-body">
      <div class="row">
        <div class="col-lg-12">
         
                <div class="form-row justify-content-start no-print">
                  <div class="form-group col-2">
                    <label for='dateV'> Date vente <span class="fas fa-times-circle text-danger" data-fa-transform="shrink-1"></span></label>

                    <input class="form-control datetimepicker" id="dateV" name="dateV" type="text" data-options='{"dateFormat":"d/m/Y"}'>
                  </div>  
                  <div class="form-group col-4">
                    <label for='chargeLibelle'> Description  charge</label>
                    <input class="form-control " id="chargeLibelle" name="chargeLibelle" type="text" placeholder="livraison, transport..." maxlength="100">
                  </div>
                  <div class="form-group col-2">
                    <label for='chargeVal'> Montant ( en {{ getMyDevise() }}) </label>
                    <input class="form-control " id="chargeVal" name="chargeVal" type="number" value="">
                  </div>
                  <div class="form-group col-2">
                    <label for='btnAddCharge'> Appliquer charges </label>
                  <button class="btn btn-sm btn-danger" id="btnAddCharge">Valider</button>
                  </div>
 
              </div>        
    
        </div>
      </div>
    </div>
</div>

          <div class="card">
            <div class="card-header">
              <div class="row justify-content-between">
                <div class="col-md-auto">
                  <h5 class="mb-3 mb-md-0">
                    @if($_SESSION['sucId'])
                    {{ getSuccInfo($_SESSION['sucId'])->succursaleLibelle }}
                    @endif
                  </h5>
                </div>
                <div class="col-md-auto">
                  <button class="btn btn-sm btn-outline-secondary border-300 mr-2" id="retourArrivage" > 
                    <span class="fas fa-chevron-left mr-1"  data-fa-transform="shrink-4"></span>
                      Retour à l'ajout
                    </button>
                  <button class="btn btn-sm btn-primary" id="deleteArrivage">Supprimer</button>
                </div>
              </div>
            </div>

              <div class="card-body p-0">
                <div class="falcon-data-table">
                  <table class="table table-sm mb-0 table-striped table-dashboard fs--1 data-table border-bottom border-200" data-options='{"searching":false,"responsive":false,"pageLength":50,"info":false,"lengthChange":false,"sWrapper":"falcon-data-table-wrapper","dom":"<&#39;row mx-1&#39;<&#39;col-sm-12 col-md-6&#39;l><&#39;col-sm-12 col-md-6&#39;f>><&#39;table-responsive&#39;tr><&#39;row no-gutters px-1 py-3 align-items-center justify-content-center&#39;<&#39;col-auto&#39;p>>","language":{"paginate":{"next":"<span class=\"fas fa-chevron-right\"></span>","previous":"<span class=\"fas fa-chevron-left\"></span>"}}}'>
                    <thead class="bg-200 text-900">
                      <tr>
                        <th class="align-middle sort">Id</th>
                        <th class="align-middle sort">Produits</th>
                        <th class="align-middle sort">Qte</th>
                        <th class="align-middle sort">Prix/Unit</th>
                        <th class="align-middle no-sort">Prix Net</th>
                        <th class="no-sort pr-1 align-middle data-table-row-action">Action</th>

                      </tr>
                    </thead>
                    <tbody id="customers">
                      <?php if (!empty($_SESSION['approvSuc'])){
                        $i=0;
                        $total = 0;
                        $qteT = 0;
                          foreach ($_SESSION['approvSuc'] as $key => $value)
                           {$i +=1; ?>  
                      <tr>
                        <th class="align-middle sort">{{ $i }}</th>
                        <th class="align-middle sort">{{ getPrd($value['article'])->produitLibele  }}</th>
                        <th class="align-middle sort">{{ $value['qte']  }}</th>
                        <th class="align-middle sort">{{ $value['prix']  }}</th>
                        <th class="align-middle no-sort">{{ formatPrice($value['prix']* $value['qte']) }}</th>
                        <td class="align-middle text-center fs-0 deleteBtn" id="{{ $key }}" style="cursor: pointer;" ><input type="hidden" id="key" value="">
                          <span class="badge badge rounded-capsule badge-soft-danger"> &nbsp;<span class="mr-2 fas fa-trash ml-1 fa-2x" data-fa-transform="shrink-2"></span> &nbsp;</span>
                        </td>
                      </tr>
                       <?php
                       $qteT +=$value['qte'];
                       $total += $value['prix']* $value['qte'];
                        } }else{
                         echo "<div class='alert alert-warning'>Aucun produit</div>";
                       }?>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="row no-gutters justify-content-end mr-3">
                <div class="col-auto">
                  <table class="table table-sm table-borderless fs--1 text-right">
                    <tbody><tr>
                      <th class="text-900">Sous-Total:</th>
                      <td class="font-weight-semi-bold" id="sousTotal" value="{{ $total }}" > {{ formatPrice($total) }}</td>
                    </tr>
                    <tr>
                      <th class="text-900">Charges</th>
                      <td class="font-weight-semi-bold" >
                        <span id="chargeCol"> 00 </span> {{ getMyDevise() }} </td>
                    </tr>
                    <tr class="border-top border-2x font-weight-bold text-900">
                      <th>Total TTC </th>
                      <td class="valeurTTC"> {{ formatPrice($total) }} </td>
                    </tr>
                  </tbody></table>
                </div>
              </div>
            <div class="card-footer bg-light d-flex justify-content-end">
                <button class="btn btn-falcon-info btn-sm mr-2 fs-2" role="button">
                  {{-- <i class="fas fa-chart-pie mr-1 text-900 "></i> --}}
                  Nombre d'article : {{ formatQte($qteT) }}
                </button>
                <button class="btn btn-falcon-danger btn-sm mr-2 fs-2" role="button">
                  {{-- <i class="fas fa-chart-pie mr-1 text-900 "></i> --}}
                  Coût total : <span class="valeurTTC">{{ formatPrice($total) }}</span>
                </button>
                  <button class="btn btn-sm btn-primary fs-2" id="enregistreArrivage">Enregistrer</button>
            </div>
          </div>
          <div id="mytoken">
            <input type="hidden" name="id_succursale" id="idSuc" value="{{ $_SESSION['sucId'] }}">
            @csrf
          </div>


    <script src="{{ asset('assets/js/theme.js') }}"></script>


    <script type="text/javascript">

      $('#retourArrivage').click(function()
        {
          $('#main_content').load('mbo/approvi');
          // alert('cliquer');
        });


      $('#enregistreArrivage').click(function()
        {

              var chargeDesc = $('#chargeLibelle').val();
              var charge = $('#chargeVal').val();
              var date = $('#dateV').val();

            Swal.fire({
              title: 'Approvisionnement',
              text: "Voulez vous enregistrer l'approvisionnement ?",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              cancelButtonText: 'Annuler',
              confirmButtonText: 'oui , valider!'
            }).then((result) => {
                if (result.value) {
                  $.ajax({
                    url: 'mbo/saveAprovi',
                    method:'GET',
                    data:{charge:charge,date:date,chargeDesc:chargeDesc},
                    dataType:'json',
                    success:function(){
                      Swal.fire(
                       'Valider!',
                       'Stock mis à jours avec succès',
                       'success'
                      );
                        var idSuc= $('#idSuc').val();
                        var input = '#mytoken input[name=_token]';
                        var token = $(input).attr('value');
                    $('#main_content').load('/mbo/stockSuc',{ idSuc : idSuc,_token:token});

                    },
                    error:function(){
                      Swal.fire('Problème de connection internet');
                    }
                  });
                }
            })
        });


        //AU clic de supresion 
          $('.deleteBtn').click(function()
          {
            ajaxDeleteVente($(this).attr('id'));
          })

        //Au clic de calcul charge
        $('#btnAddCharge').click(function()
        {
            if ($('#chargeVal').val() != '' ) 
              {
                calculCharge();
              }
        })

    //Calcul charge
        function calculCharge()
        {
                  if ($('#chargeLibelle').val().trim() != '') 
                  {
                    if ($('#chargeVal').val() != '') 
                      {
                        $('#chargeVal').attr('class','form-control is-valid');
                        var chargeCol = $('#chargeCol');
                        var valeurTTC = $('.valeurTTC');
                         var chargeVal = parseInt($('#chargeVal').val());
                         var sousTotal = parseInt($('#sousTotal').attr('value'));
                         var ttc = chargeVal+sousTotal;
                         chargeCol.text(chargeVal);
                         valeurTTC.text(ttc);

                         formatPriceJs(ttc,valeurTTC);


                      }
                      else
                      {
                        $('#chargeVal').attr('class','form-control is-invalid');
                      }
                  }
                  else
                  {
                    toastr.error('Veuillez saisir le libelle de la charge');
                    $('#chargeVal').val('');

                  }
        }

    //Suprime arrivage
        $('#deleteArrivage').click(function()
        {

          ajaxDeleteArriv();
        })


        function ajaxDeleteVente(idProduit)
        {


                Swal.fire({
                  title: 'Suppresion vente',
                  text: "Voulez vous supprimer cet article de l'arrivage ?",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  cancelButtonText: 'Annuler',
                  confirmButtonText: 'oui , Supprimer!'
                }).then((result) => {
                    if (result.value) {
                      $.ajax({
                        url: 'mbo/delAproviPrd',
                        method:'GET',
                        data:{NumArt:idProduit},
                        dataType:'json',
                        success:function(){
                          Swal.fire(
                           'Supression!',
                           'Produits suipprimé avec succès',
                           'success'
                          );
                          $("#main_content").load("/mbo/listAproviPrd");
                        },
                        error:function(){
                          Swal.fire('La suppression de produits est impossible');
                        }
                      });
                    }
                })
        
        }

        function ajaxDeleteArriv()
        {


                Swal.fire({
                  title: 'Suppresion arrivage',
                  text: "Voulez vous supprimer cet arrivage ?",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#d33',
                  cancelButtonColor: '#3085d6',
                  cancelButtonText: 'Annuler',
                  confirmButtonText: 'oui , Supprimer!',
                   backdrop: `rgba(240,15,83,0.4)`
                }).then((result) => {
                    if (result.value) {
                      $.ajax({
                        url: 'mbo/delAprovi',
                        method:'GET',
                        data:{NumArt:1},
                        dataType:'json',
                        success:function(){
                          Swal.fire(
                           'Supression!',
                           'Arrivage suipprimé avec succès',
                           'success'
                          );
                          $("#main_content").load("mbo/approvi");
                        },
                        error:function(){
                          Swal.fire('Problème de connexion internet');
                        }
                      });
                    }
                })
        
        }




    </script>
