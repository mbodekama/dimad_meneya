
@if(userHasSucc(Auth::id()))

<div class="card mb-3 no-print enteteSuc">
            <div class="card-header position-relative min-vh-25 mb-7">
              <div class="bg-holder rounded-soft rounded-bottom-0" style="background-image:url(../assets/img/generic/40.jpg);">
              </div>
              <!--/.bg-holder-->

              <div class="avatar avatar-5xl avatar-profile"><img class="rounded-circle img-thumbnail shadow-sm" src="../assets/img/team/2.jpg" width="200" alt="" /></div>
            </div>
            <div class="card-body" id="infoSucc">
              <div class="row">
                <div class="col-lg-8">
                  <h4 class="mb-1"> {{ $sucInfo->name }} 
                    <small class="fas fa-check-circle text-primary ml-1" data-toggle="tooltip" data-placement="right" title="Verified" data-fa-transform="shrink-4 down-2"></small>
                  </h4>
                  <h5 class="fs-0 font-weight-normal">
                    Gestionnaire de la succursale <span class="h4 text-primary">{{ $sucInfo->succursaleLibelle }}</span>
                  </h5>
                
                  <hr class="border-dashed my-4 d-lg-none" />
                </div>
                <div class="col pl-2 pl-lg-3">
                  <a class="media align-items-center mb-2" href="#">
                    <span class="fas fa-phone-square fs-4 mr-2 text-700"></span>
                    <div class="media-body">
                      <h6 class="mb-0">{{ $sucInfo->succursalContact }}</h6>
                    </div>
                  </a>
                  <a class="media align-items-center mb-2" href="#">
                    <span class="fas fa-map-marked-alt fs-4 mr-2 text-700"></span>
                    <div class="media-body">
                      <h6 class="mb-0">{{ $sucInfo->succursalLieu }}</h6>
                    </div>
                  </a>
                  <a class="media align-items-center mb-2" href="#">
                    <span class="fas fas fa-bullhorn fs-4 mr-2 text-700"></span>
                    <div class="media-body">
                      <h6 class="mb-0">Qte SMS : 200 </h6>
                    </div>
                  </a>
                </div>
              </div>
            </div>
</div>

          <div class="card mb-3 no-print">
            <div class="card-body">
              <div class="row justify-content-center align-items-center">
                <div class="col-md">
                  <a href='/appSuc' class="mb-0 text-primary h4"> <i class="fas fa-bars mr-3"></i>Menu</a>

                </div>
                <div class="col-2">
                    <button class="btn btn-falcon-primary btn-sm px-3" 
                   type="button" id="s_stock">
                   <a href='/appSuc' class="mb-0 text-primary h4"> Stock</a>
                  </button>  
                </div>
                <div class="col-2">
  
                    <button class="btn btn-falcon-primary btn-sm px-3 ml-2" 
                  type="button" id="s_vente">Mes Ventes</button>                
                </div>
                <div class="col-2">
                    <button class="btn btn-falcon-primary btn-sm px-3 ml-2" 
                  type="button" id="s_client">Mes Clients</button>     
                </div>
                <div class="col-2">
                    <button class="btn btn-falcon-primary btn-sm px-3 ml-2" 
                  type="button" id="s_credit">Gestion Crédit</button>
                </div>
                <div class="col-2">
                    <button class="btn btn-falcon-default active btn-sm px-3 ml-2" 
                  type="button" id="s_stats">Statistique</button>  
                </div>
       

              </div>
            </div>
          </div>

<div id="sucCont">
  {{-- verification si Stock non vide --}}
      @if( !$stockSuccursales->isEmpty())
          <div class="card mb-3">
            <div class="card-body">
              <div class="row justify-content-between align-items-center">
                <div class="col-md">
                  <h5 class="mb-2 mb-md-0">Mon stock</h5>
                </div>

                
                <div class="col-auto">
                  <button class="btn btn-falcon-danger btn-sm mr-2" role="button"> <i class="fas fa-chart-pie mr-1 text-900 "></i>Catégorie de produits : 
                    {{ formatQte($stockSuccursales->count('produits_id')) }} </button>
                  <button class="btn btn-falcon-danger btn-sm mr-2" role="button"> <i class="fas fa-sort-numeric-up mr-1 text-900 "></i>Qté :{{ formatQte($stockSuccursales->sum('stock_Qte')) }}  produits</button>
                  <button class="btn btn-falcon-danger btn-sm" role="button"><i class="fas fa-money-check-alt mr-1 text-900"></i> Montant : &nbsp; {{ formatPrice(getPrixPrdInStockSuc($stockSuccursales[0]->succursale_id)) }}</button>
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
                <table class="table table-sm mb-0 table-striped table-dashboard fs--1 data-table border-bottom border-200" data-options='{"searching":true,"responsive":false,"pageLength":12,"info":false,"lengthChange":false,"sWrapper":"falcon-data-table-wrapper","dom":"<&#39;row mx-1&#39;<&#39;col-sm-12 col-md-6&#39;l><&#39;col-sm-12 col-md-6&#39;f>><&#39;table-responsive&#39;tr><&#39;row no-gutters px-1 py-3 align-items-center justify-content-center&#39;<&#39;col-auto&#39;p>>","language":{"paginate":{"next":"<span class=\"fas fa-chevron-right\"></span>","previous":"<span class=\"fas fa-chevron-left\"></span>"}}}'>
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
                      <tr class="{{ produitManquant($stockProduit->stock_Qte) }}">
                        <td class="align-middle no-sort pr-3">
                          <div class="custom-control custom-checkbox">
                            <input class="custom-control-input checkbox-bulk-select" id="checkbox-bulk-customers-select" type="checkbox" data-checkbox-body="#customers" data-checkbox-actions="#customers-actions" data-checkbox-replaced-element="#customer-table-actions" />
                            <label class="custom-control-label" for="checkbox-bulk-customers-select"></label>
                          </div>
                        </td>
                          <td class="align-middle sort">
                            {{ $prd->produitMat }}
                          </td>
                          <td class="align-middle sort">
                            {{ $prd->produitLibele }}
                          </td>
                          <td class="align-middle sort">
                            {{ $stockProduit->stock_Qte }} 
                          </td>
                          <td class="align-middle sort">
                            {{$stockProduit->sucCoutAchat}}
                          </td>
                          <th class="align-middle sort">
                            {{ formatPrice($stockProduit->stock_Qte * $stockProduit->sucCoutAchat)}}
                          </th>
                      </tr>
                    @endforeach
                  </tbody>
                  @endif
                </table>
              </div>
            </div>
          </div>

      @else

<div class="alert alert-danger text-center h5">
  Aucun stock. Veuillez contactez votre administrateur pour un approvisionnement de stock.
</div>
      @endif         
</div>



<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script type="text/javascript">
$(function()
  {
     
  /*-----------------
   Gestions des menus
  -------------------*/

    // Stock
     $('#s_stock').click(function(){
      $('#sucCont').load('/s_stock');
      hideEntete();
     });

     
    // Ventes
     $("#s_vente").click(function(){
      $('#sucCont').load('/s_Vente');
      hideEntete();
     });


     //New Vente
     $("#Addvente").click(function(){
      $('#sucCont').load('/Addvente');
      hideEntete();

     });


    // Clients
     $("#s_client").click(function(){
      $('#sucCont').load('/mbo/s_Client');
      hideEntete();

     });

    // Crédits
     $("#s_credit").click(function(){
       $('#sucCont').load('/s_credits');
      hideEntete();

     });

    // Statis
     $("#s_stats").click(function(){
       $('#sucCont').load('/s_stats');
      hideEntete();

     });

function hideEntete()
{
  $('.enteteSuc').hide();
}

})
</script>

@else
 <div class="card">
            <div class="card-body overflow-hidden text-center pt-5">
              <div class="row justify-content-center">
                <div class="col-7 col-md-5"><img class="img-fluid" src="../assets/img/illustrations/modal-right.png" alt="" /></div>
              </div>
              <h3 class="mt-3 font-weight-normal fs-2 mt-md-4 fs-md-3">
                <b class="text-danger">Oupsss!!!!!!</b>, Ce gestionnaire n'est associé à aucune succursale.
              </h3>
              <p class="lead">Veuillez vous réferez a votre administrateur.               <br class="d-none d-md-block"/> 
                
                  <a class="ml-1 btn btn-outline-primary rounded-capsule mr-1 mb-1 approvi"  href="{{ route('logout') }}"
                         onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">
                          Déconnexion
                  </a>
                <br class="d-none d-md-block"/>
              </p>
              
            </div>
            <div class="card-footer d-flex justify-content-center bg-light text-center pt-4">
              <div class="col-10">
                <p class="mb-2 fs--1"><a href="/dashboard">Avec Meneya gérer vos succursales en toute simplicité.</a></p>
              </div>
            </div>
  </div>
@endif
