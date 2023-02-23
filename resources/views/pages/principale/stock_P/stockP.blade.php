
<div class="card mb-3">
            <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url(../assets/img/illustrations/corner-4.png);">
            </div>
            <!--/.bg-holder-->

            <div class="card-body">
              <div class="row">
                <div class="col-lg-8">
                  <h4 class="mb-0 text-primary"> <i class="fas fa-database"></i>  Gestion de stock <i class="fas fa-angle-right"></i> Contenue Stock </h4>

                  <span class="fas fa-circle text-danger mr-3"></span>
                    <b> Le produits est fini en stock</b> <br>
                  <span class="fas fa-circle text-warning mr-3"></span>
                    <b> Le stock du produit est en baisse</b><br>
                  <span class="fas fa-circle mr-3"></span>
                    <b> Le stock du produit est suffisant</b>
                </div>
              </div>
            </div>
          </div>

    @if(!$stockProduits->isEmpty())
          <div class="card mb-3">
            <div class="card-body">
              <div class="row justify-content-between align-items-center">
                <div class="col-md">
                  <h5 class="mb-2 mb-md-0">Statistiques</h5>
                </div>
                <div class="col-auto">
                  <button class="btn btn-falcon-danger btn-sm mr-2" role="button"> <i class="fas fa-chart-pie mr-1 text-900 "></i>Type de produits : 
                    {{ $stockProduits->count('produits_id') }} </button>
                  <button class="btn btn-falcon-danger btn-sm mr-2" role="button"> <i class="fas fa-sort-numeric-up mr-1 text-900 "></i>Qté :{{ formatQte($stockProduits->sum('stock_Qte')) }}  produits</button>
                  <button class="btn btn-falcon-danger btn-sm" role="button"><i class="fas fa-money-check-alt mr-1 text-900"></i> Montant : &nbsp; {{ formatPrice(getPrixPrdInStockP()) }} </button>
                 
                </div>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-header d-flex justify-content-center">
              @include('pages/dash/pagnMod')
            </div>
            <div class="card-body p-0" id="loaderContent">

              <div class="falcon-data-table">
                <table class="mytable table table-sm mb-0 table-striped table-dashboard fs--1 data-table border-bottom border-200" data-options='{"searching":true,"responsive":false,"pageLength":100,"info":false,"lengthChange":false,"sWrapper":"falcon-data-table-wrapper","dom":"<&#39;row mx-1&#39;<&#39;col-sm-12 col-md-6&#39;l><&#39;col-sm-12 col-md-6&#39;f>><&#39;table-responsive&#39;tr><&#39;row no-gutters px-1 py-3 align-items-center justify-content-center&#39;<&#39;col-auto&#39;p>>","language":{"paginate":{"next":"<span class=\"fas fa-chevron-right\"></span>","previous":"<span class=\"fas fa-chevron-left\"></span>"}}}'>
                  <thead class="bg-200 text-900">
                    <tr>
              {{--  
                      <th class="align-middle no-sort pr-3">
                       <div class="custom-control custom-checkbox">
                          <input class="custom-control-input checkbox-bulk-select" id="checkbox-bulk-customers-select" type="checkbox" data-checkbox-body="#customers" data-checkbox-actions="#customers-actions" data-checkbox-replaced-element="#customer-table-actions" />
                          <label class="custom-control-label" for="checkbox-bulk-customers-select"></label>
                        </div> 
                      </th>--}}
                      <th class="align-middle sort">N°</th>
                      <th class="align-middle sort">Produit</th>
                      <th class="align-middle sort">Quantite</th>
                      <th class="align-middle sort">Prix Unitaire</th>
                      <th class="align-middle sort">Prix Net</th>
                    </tr>
                  </thead>
                   <tbody id="customers">
                    @foreach($stockProduits as $stockProduit)

                    {{-- lecture des informations des prduits --}}
                    @php
                      $infoPrd = recupInfoProduitPrincipal($stockProduit->produits_id);
                    @endphp
                    {{-- lecture des informations des prduits --}}
                      <tr class="{{ produitManquant($stockProduit->stock_Qte) }}">
{{--                         <td class="align-middle no-sort pr-3">
                          <div class="custom-control custom-checkbox">
                            <input class="custom-control-input checkbox-bulk-select" id="checkbox-bulk-customers-select" type="checkbox" data-checkbox-body="#customers" data-checkbox-actions="#customers-actions" data-checkbox-replaced-element="#customer-table-actions" />
                            <label class="custom-control-label" for="checkbox-bulk-customers-select"></label>
                          </div>
                        </td> --}}
                          <td class="align-middle sort">
                            {{ $loop->iteration }}
                          </td>
                          <td class="align-middle sort">
                            {{ $infoPrd->produitLibele }}
                          </td>
                          <td class="align-middle sort">
                            {{ $stockProduit->stock_Qte }} 
                          </td>
                          <td class="align-middle sort">
                            {{ $infoPrd->produitPrix}}
                          </td>
                          <th class="align-middle sort">
                            {{ $stockProduit->stock_Qte * $infoPrd->produitPrix}}  Fcfa
                          </th>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
                <div class="row no-gutters px-1 py-3 align-items-center justify-content-center">
                       {{ $stockProduits->links() }}
                   </div>
              </div>

           <div class="col-auto d-flex justify-content-center mb-3">
                  <button class="btn btn-falcon-danger btn-sm mr-2" role="button"> <i class="fas fa-chart-pie mr-1 text-900 "></i>Catégorie de produits : 
                    {{ $stockProduits->count('produits_id') }} </button>
                  <button class="btn btn-falcon-danger btn-sm mr-2" role="button"> <i class="fas fa-sort-numeric-up mr-1 text-900 "></i>Qté :{{ number_format($stockProduits->sum('stock_Qte'),0,',','. ') }}  produits</button>
                  <button class="btn btn-falcon-danger btn-sm" role="button"><i class="fas fa-money-check-alt mr-1 text-900"></i> Montant : &nbsp; {{number_format( getPrixPrdInStockP(),0,',',' .') }}  FCFA</button>
                  {{-- <button class="btn btn-falcon-primary btn-sm" role="button"></button> --}}
            </div>
            </div>
          </div>

    @else
      <div class="alert alert-warning text-center h5"> Vous n'avez pas de produits dans votre stock</div>
    @endif


<script type="text/javascript">
  $(function()
  {
    //Faire disparaitre le paginate coté front end
     $(".mytable").parent().next().hide();
  })
</script>