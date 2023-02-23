          <div class="card mb-3 " id="entete">
            <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url(../assets/img/illustrations/corner-4.png);">
            </div>
            <!--/.bg-holder-->

            <div class="card-body">
              <div class="row">
                <div class="col-lg-8 d-flex justify-content-between">
                  <h4 class="mb-0 text-primary"><i class="fas fa-university"></i> 
                    Abonnement <i class="fas fa-angle-right"></i> Je gère mon abonnement </h4>
                  
                </div>
              </div>
            </div>
          </div>


          <div class="card mb-3">
            <div class="card-header">
              <div class="row align-items-center">
                <div class="col">
                  <h5 class="mb-0">Informations</h5>
                </div>
                <div class="col-auto">
                  <button class="btn btn-primary mr-1 mb-1 updForfait" type="button">
                    <span class="fas fa-sync-alt fs-0 mr-1"></span> Renouveler
                  </button>
                </div>

              </div>
            </div>
            <div class="card-body bg-light border-top">
              <div class="row">
                <div class="col-lg col-xxl-5">
                  <h6 class="font-weight-semi-bold ls mb-3 text-uppercase"> Information du compte</h6>
                  <div class="row">
                    <div class="col-5 col-sm-4">
                      <p class="font-weight-semi-bold mb-1">Domaine</p>
                    </div>
                    <div class="col">{{ 'http://'.getSettingByName('domaine') }}</div>
                  </div>
                  <div class="row">
                    <div class="col-5 col-sm-4">
                      <p class="font-weight-semi-bold mb-1">Proprietaire</p>
                    </div>
                    <div class="col text-uppercase">{{ Auth::user()->name }}</div>
                  </div>

                  <div class="row">
                    <div class="col-5 col-sm-4">
                      <p class="font-weight-semi-bold mb-1">Entreprise</p>
                    </div>
                    <div class="col"><a href="#">{{ getSettingByName('Entreprise')   }}</a></div>
                  </div>
                  <div class="row">
                    <div class="col-5 col-sm-4">
                      <p class="font-weight-semi-bold mb-1">Crée le</p>
                    </div>
                    <div class="col">{{ getSettingByName('dateMiseEnligne') }}</div>
                  </div>

                </div>
                <div class="col-lg col-xxl-5 mt-4 mt-lg-0 offset-xxl-1">
                  <h6 class="font-weight-semi-bold ls mb-3 text-uppercase">Mon Abonnement</h6>
                  <div class="row">
                    <div class="col-5 col-sm-4">
                      <p class="font-weight-semi-bold mb-1">Forfait</p>
                    </div>
                    <div class="col text-uppercase"><span class="badge badge-soft-success badge-pill text-danger fs-0">{{ (getAbnmnt()->libele) ?? getLastAbnmnt()->libele  }}</span></div>
                  </div>

                  <div class="row">
                    <div class="col-5 col-sm-4">
                      <p class="font-weight-semi-bold mb-1">Expire le</p>
                    </div>
                    <div class="col text-uppercase"><span class="badge badge-soft-warning badge-pill text-danger fs-0 ">{{ (getAbnmnt()->dateFin) ?? getLastAbnmnt()->dateFin   }}</span></div>
                  </div>

                  <div class="row">
                    <div class="col-5 col-sm-4">
                      <p class="font-weight-semi-bold mb-1">Contact</p>
                    </div>
                    <div class="col">
                      <p class="mb-1">{{ getSettingByName('contact')   }}</p>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-5 col-sm-4">
                      <p class="font-weight-semi-bold mb-1">Email</p>
                    </div>
                    <div class="col"><a href="#">{{ Auth::user()->email }}</a></div>
                  </div>

                </div>
              </div>
            </div>
            <div class="card-footer border-top text-right">
                <button class="btn btn-outline-warning mr-1 mb-1 updForfait" type="button">  
                 <span class="fas fa-sync-alt fs-0 mr-1"></span>Renouveler
                </button>
                <button class="btn btn-outline-danger mr-1 mb-1 updForfait" 
                type="button"> 
                  <span class="fas fa-dollar-sign fs-0 mr-1"></span>Changer de forfait
                </button>
            </div>
          </div>
          <div class="card">
            <div class="card-header">
              <h5 class="mb-0">Historiques des souscriptions</h5>
            </div>
            @php
              $allForfait = allAbnmnt();
            @endphp
            @foreach($allForfait as $forfait)
            <div class="card-body border-top p-0">
              <div class="row no-gutters align-items-center border-bottom py-2 px-3">
                <div class="col-md-auto pr-3"><span 
                  class="@if($forfait->statuPaiement == 1) 
                  badge badge-soft-success badge-pill 
                  @else badge badge-soft-danger badge-pill
                  @endif">
                  {{ "Offre ".$forfait->libele }}</span></div>
                <div class="col-md mt-1 mt-md-0"><code>
                  @if($forfait->statuPaiement == 1)
                   Cette souscription est en cours de validité
                  @else Cette souscription à expirer
                  @endif
                </code></div>
                <div class="col-md-auto">
                  <p class="mb-0"><span>Du <strong>{{ $forfait->dateDebut }}</strong> au  <strong>{{ $forfait->dateFin }}</strong> </span></p>
                </div>
              </div>

            </div>
            @endforeach
            <div class="card-footer bg-light p-0">
              {{-- <a class="btn btn-link btn-block" href="#!">View more logs<span class="fas fa-chevron-right fs--2 ml-1"></span></a> --}}
            </div>
          </div>



<script type="text/javascript">
  $(function()
  {
    //Renouvellement de l'abonnement 
     $('.updForfait').click(function()
     {
       loadingScreen();
       $('#main_content').load('updForfait'); 
     })
  })
</script>