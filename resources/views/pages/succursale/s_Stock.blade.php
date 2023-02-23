
<?php
  // Vérification de l'existence d'opérations-opérateurs
   $nb = count($stockSuccursales);
   if ($nb==0) {?>
             <div class="card">
            <div class="card-body overflow-hidden text-center pt-5">
              <div class="row justify-content-center">
                <div class="col-7 col-md-5"><img class="img-fluid" src="../assets/img/illustrations/modal-right.png" alt="" /></div>
              </div>
              <h3 class="mt-3 font-weight-normal fs-2 mt-md-4 fs-md-3">
                <b class="text-danger">Ouf!!!!!!</b>, Cette Sucuursale ne dispose pas de stock.
              </h3>
              <p class="lead">Veuillez lui approvisionner du stock
                <br class="d-none d-md-block"/>
                <button class="ml-1 btn btn-outline-primary rounded-capsule mr-1 mb-1 approvi" 
                 type="button">  Approvisionné
                </button><br class="d-none d-md-block"/>
                <button class="ml-1 btn btn-outline-primary retour">
                  <span class="text-danger"><i class="fas fa-angle-left"></i> Retour</span>
                </button>
              </p>
              
            </div>
            <div class="card-footer d-flex justify-content-center bg-light text-center pt-4">
              <div class="col-10">
                <p class="mb-2 fs--1"><a href="/dashboard">Avec Meneya gérer vos succursales en toute simplicité.</a></p>
              </div>
            </div>
          </div>

<?php     
   }else{
?>
          <div class="card mb-3">
            <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url(../assets/img/illustrations/corner-4.png);">
            </div>
            <!--/.bg-holder-->

            <div class="card-body">
              <div class="row">
                <div class="col-lg-8">
                  <h4 class="mb-0 text-primary"> <i class="fas fa-database"></i>  Gestion de stock <i class="fas fa-angle-right"></i> {{ $succursaleInfo->succursaleLibelle }}</h4><p><b>Gérant :</b><span class="text-danger"> {{gerantSuc($succursaleInfo->user_id)['name'] }}</span>
                </div>
              </div>
            </div>
          </div>
          <div class="card mb-3">
            <div class="card-body">
              <div class="row justify-content-between align-items-center">
                <div class="col-md">
                  <h5 class="mb-2 mb-md-0">Statistiques</h5>
                </div>

                
                <div class="col-auto">
                  <button class="btn btn-falcon-danger btn-sm mr-2" role="button"> <i class="fas fa-chart-pie mr-1 text-900 "></i>Catégorie de produits : 
                    {{ $stockSuccursales->count('produits_id') }} </button>
                  <button class="btn btn-falcon-danger btn-sm mr-2" role="button"> <i class="fas fa-sort-numeric-up mr-1 text-900 "></i>Qté :{{formatQte($stockSuccursales->sum('stock_Qte'))}}  produits</button>
                  <button class="btn btn-falcon-danger btn-sm" role="button">
                    <i class="fas fa-money-check-alt mr-1 text-900"></i>Montant : &nbsp; 
                    {{formatPrice(getPrixPrdInStockSuc($stockSuccursales[0]->succursale_id))}}  </button>
                  {{-- <button class="btn btn-falcon-primary btn-sm" role="button"></button> --}}
                </div>
              </div>
            </div>
          </div>

          <div class="card mb-3">
            <div class="card-header">

              <div class="row align-items-center justify-content-between">

              </div>
            </div>
            <div class="card-body p-0">

              <div class="falcon-data-table">
                <table class="table table-sm mb-0 table-striped table-dashboard fs--1 data-table border-bottom border-200" data-options='{"searching":true,"responsive":false,"pageLength":50,"info":false,"lengthChange":false,"sWrapper":"falcon-data-table-wrapper","dom":"<&#39;row mx-1&#39;<&#39;col-sm-12 col-md-6&#39;l><&#39;col-sm-12 col-md-6&#39;f>><&#39;table-responsive&#39;tr><&#39;row no-gutters px-1 py-3 align-items-center justify-content-center&#39;<&#39;col-auto&#39;p>>","language":{"paginate":{"next":"<span class=\"fas fa-chevron-right\"></span>","previous":"<span class=\"fas fa-chevron-left\"></span>"}}}'>
                  <thead class="bg-200 text-900">
                    <tr>
                      <th class="align-middle no-sort pr-3">
                        <div class="custom-control custom-checkbox">
                          <input class="custom-control-input checkbox-bulk-select" id="checkbox-bulk-customers-select" type="checkbox" data-checkbox-body="#customers" data-checkbox-actions="#customers-actions" data-checkbox-replaced-element="#customer-table-actions" />
                          <label class="custom-control-label" for="checkbox-bulk-customers-select"></label>
                        </div>
                      </th>
                      <th class="align-middle sort">Code</th>
                      <th class="align-middle sort">Produit</th>
                      <th class="align-middle sort">Quantite</th>
                      <th class="align-middle sort">Prix Unitaire</th>
                      <th class="align-middle sort">Prix Net</th>
                    </tr>
                  </thead>
                    @if(!$stockSuccursales->isEmpty())
                   <tbody id="customers">
                    @foreach($stockSuccursales as $stockProduit)
                      @php
                        $prd = getPrd($stockProduit->produits_id)
                      @endphp
                      <tr 
                      @if($stockProduit->stock_Qte > getSeuilPrd($stockProduit->produits_id))
                        class="h6"
                      @else
                      class="bg-white text-warning h6"
                      @endif
                      >
                        <td class="align-middle no-sort pr-3">
                          <div class="custom-control custom-checkbox">
                            <input class="custom-control-input checkbox-bulk-select" id="checkbox-bulk-customers-select" type="checkbox" data-checkbox-body="#customers" data-checkbox-actions="#customers-actions" data-checkbox-replaced-element="#customer-table-actions" />
                            <label class="custom-control-label" for="checkbox-bulk-customers-select"></label>
                          </div>
                        </td>
               
                          <td class="align-middle sort">
                           {{ $prd->produitMat  }}
                          </td>
                          <td class="align-middle sort">
                            {{ $prd->produitLibele }}
                          </td>
                          <td class="align-middle sort">
                            {{ formatQte($stockProduit->stock_Qte) }} 
                          </td>
                          <td class="align-middle sort">
                            {{formatPrice( $stockProduit->sucCoutAchat)}}
                          </td>
                          <th class="align-middle sort">
                            {{ formatPrice($stockProduit->sucCoutAchat * $stockProduit->stock_Qte )
                            }}
                          </th>
                      </tr>
                    @endforeach
                  </tbody>
                  @endif
                </table>
              </div>
            </div>
          </div>
          <div class="col-auto d-flex justify-content-center">
                  <button class="btn btn-falcon-danger btn-sm mr-2" role="button"> <i class="fas fa-chart-pie mr-1 text-900 "></i>Catégorie de produits : 
                    {{ $stockSuccursales->count('produits_id') }} </button>
                  <button class="btn btn-falcon-danger btn-sm mr-2" role="button"> <i class="fas fa-sort-numeric-up mr-1 text-900 "></i>Qté :{{ number_format($stockSuccursales->sum('stock_Qte'),0,',','. ') }}  produits</button>
                  <button class="btn btn-falcon-danger btn-sm" role="button"><i class="fas fa-money-check-alt mr-1 text-900"></i> Montant : &nbsp; {{number_format( getPrixPrdInStockSuc($stockSuccursales[0]->succursale_id),0,',',' .') }}  FCFA</button>
          </div>

<?php

}

?>

    <script src="{{ asset('assets/js/theme.js') }}"></script>
          <script type="text/javascript">
            // Nouvelle opération
             $('.approvi').click(function(){
               $("#main_content").load("mbo/approvi");
             });

            // Retour opérateur
             $('.retour').click(function(){
               $("#main_content").load("mbo/listSuc");
             });

          </script>
    