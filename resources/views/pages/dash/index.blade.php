          <div class="card mb-3">
            <div class="card-body rounded-soft bg-gradient">
              <div class="row text-white align-items-center no-gutters">
                <div class="col">
                  <h6 class="text-white mb-0">Aujourd'hui<span class=" h5 text-danger "> {{ formatPrice(venteJourP()->sum('prix_vente_total')) }} </span></h6>
                  <p class="fs--1 font-weight-semi-bold">Hier <span class="opacity-50">{{
                  formatPrice(venteHierP()->sum('prix_vente_total')) }}</span></p>
                </div>
                <div class="col-auto d-none d-sm-block">
                  <select class="custom-select custom-select-sm mb-3" id="dashboard-chart-select">
                  <option value="thisMois" selected="selected" id="thisMois">
                    {{ date('M') }}
                  </option>
                  <option value="lastMois"  id="lastMois">
                    {{ date('M',strtotime('-1 month')) }}
                  </option>
                  </select>
                </div>
              </div>
          {{--     <canvas class="max-w-100 rounded" id="chart-line" width="1618" height="375" aria-label="Line chart" role="img"></canvas> --}}

              <canvas class="max-w-100 rounded" id="myChart" width="1618" height="375" aria-label="Line chart" role="img"></canvas>
            </div>
          </div>


          <div class="card bg-light mb-3 ">
            <div class="card-body p-3 d-flex justify-content-center">
                @if(getAbnmnt())
                 <p class="h5 text-info">
                Le renouvellement de votre abonnement est prévu pour le

                 <strong class="text-danger">  {{ formatMyDate(getAbnmnt()->dateFin)}} </strong>
                @else
                  <p class="h5 text-info"> 
                    <strong class="text-danger"> Votre abonnement {{ getLastAbnmnt()->libele }} a expirer le {{ formatMyDate(getLastAbnmnt()->dateFin) }} </strong> <a class="btn btn-danger ml-2 updForfait" href="#">Renouveler</a>
                
                @endif
              </p>
            </div>
          </div>

          <div class="card-deck">
            <div class="card mb-3 overflow-hidden" style="min-width: 12rem">
              <div class="bg-holder bg-card" style="background-image:url(assets/img/illustrations/corner-1.png);">
              </div>
              <!--/.bg-holder-->

              <div class="card-body position-relative">
                <h6>Ventes<span class="badge badge-soft-warning rounded-capsule ml-2"></span></h6>
                <div class="display-4 fs-4 mb-2 font-weight-normal text-sans-serif text-warning" >
                  <i class="far fa-money-bill-alt"></i> {{ formatPrice(venteTotalP()->sum('prix_vente_total')) }}
                </div>
              </div>
            </div>
            <div class="card mb-3 overflow-hidden" style="min-width: 12rem">
              <div class="bg-holder bg-card" style="background-image:url(assets/img/illustrations/corner-2.png);">
              </div>
              <!--/.bg-holder-->

              <div class="card-body position-relative">
                <h6>Clients<span class="badge badge-soft-info rounded-capsule ml-2">
                  <i class="far fa-address-card"></i>
                </span></h6>
                <div class="display-4 fs-4 mb-2 font-weight-normal text-sans-serif text-info" >
                  <i class="far fa-address-card"></i> {{ formatQte(getClientNbr()->count()) }}
                </div>
              </div>
            </div>
            <div class="card mb-3 overflow-hidden" style="min-width: 12rem">
              <div class="bg-holder bg-card" style="background-image:url(assets/img/illustrations/corner-3.png);">
              </div>
              <!--/.bg-holder-->

              <div class="card-body position-relative">
                <h6>Fournisseurs<span class="badge badge-soft-success rounded-capsule ml-2">{{ formatQte(getNbrFour()->count() )}}</span></h6>
                <div class="display-4 fs-4 mb-2 font-weight-normal text-sans-serif" >
                <i class="fas fa-shipping-fast"></i> {{ formatQte(getNbrFour()->count() )}} </div><a class="font-weight-semi-bold fs--1 text-nowrap" href="#!">Statistics<span class="fas fa-angle-right ml-1" data-fa-transform="down-1"></span></a>
              </div>
            </div>

          </div>
          @if(bestVente()->count() >0  )
            @php
            $end = bestVente()->count() > 5 ? 5 : bestVente()->count();
            @endphp
            <div class="card mb-3">
              <div class="card-header">
                <div class="row align-items-center justify-content-between">
                  <div class="col-6 col-sm-auto d-flex align-items-center pr-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">{{ formatQte($end )}} Meilleures Ventes</h5>
                  </div>
                 
                </div>
              </div>
              <div class="card-body px-0 pt-0">
                <div class="dashboard-data-table">
                  <table class="fs-0 bestVnt table table-sm table-dashboard fs--1 data-table border-bottom" data-options='{"responsive":true,"lengthChange":false,"searching":false,"pageLength":6}'>
                    <thead class="bg-200 text-900">
                      <tr>
                        <th class="no-sort pr-1 align-middle data-table-row-bulk-select">
                          <div class="custom-control custom-checkbox">
                            <input class="custom-control-input checkbox-bulk-select" id="checkbox-bulk-purchases-select" type="checkbox" data-checkbox-body="#purchases" data-checkbox-actions="#purchases-actions" data-checkbox-replaced-element="#dashboard-actions" />
                            <label class="custom-control-label" for="checkbox-bulk-purchases-select"></label>
                          </div>
                        </th>
                        <th class="sort pr-1 align-middle">Client</th>
                        <th class="sort pr-1 align-middle">Telephone</th>
                        <th class="sort pr-1 align-middle">N° Vente</th>
                        <th class="sort pr-1 align-middle text-right">Montant</th>
                        <th class="sort pr-1 align-middle text-right">Bénéfice</th>
                        <th class="no-sort pr-1 align-middle data-table-row-action"></th>
                      </tr>
                    </thead>
                    <tbody id="purchases">
                  @for($i=0; $i<$end; $i++)
                      <tr class="btn-reveal-trigger">
                        <td class="align-middle">
                          {{ formatQte($i+1) }}
                        </td>
                        <th class="align-middle">
                          <a href="#">{{ getClient(bestVente()[$i]->clients_id)->nom}}</a></th>
                        <td class="align-middle">
                          {{ getClient(bestVente()[$i]->clients_id)->contact}}
                        </td>
                        <td class="align-middle">{{ bestVente()[$i]->NumVente}}</td>

                        <td class="align-middle text-right">
                          <span class="badge badge rounded-capsule badge-soft-warning">
                          {{ formatPrice((bestVente()[$i]->prix_vente_total + bestVente()[$i]->charge)) }}
                          <span class="ml-1 fas fa-stream" data-fa-transform="shrink-2"></span></span>
                        </td>

                        <td class="align-middle text-right">
                          <span class="badge badge rounded-capsule badge-soft-success">
                          {{ formatPrice(bestVente()[$i]->mg_benef_brute) }}
                          <span class="ml-1 fas fa-check" data-fa-transform="shrink-2"></span></span></td>
                        <td class="align-middle">
                          <div class="custom-control custom-checkbox">
                            <input class="custom-control-input checkbox-bulk-select-target" type="checkbox" id="checkbox-0" />
                            <label class="custom-control-label" for="checkbox-0"></label>
                          </div>
                        </td>
                      </tr>
                  @endfor
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          @endif




