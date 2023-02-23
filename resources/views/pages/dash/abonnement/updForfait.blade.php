          <div class="card mb-3 " id="entete">
            <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url(../assets/img/illustrations/corner-4.png);">
            </div>
            <!--/.bg-holder-->

            <div class="card-body">
              <div class="row">
                <div class="col-lg-8 d-flex justify-content-between">
                  <h4 class="mb-0 text-primary updForfait"><i class="fas fa-university"></i> 
                    Re-Abonnement <i class="fas fa-angle-right"></i> Choix de votre forfait </h4>
                </div>
              </div>
            </div>
          </div>

          <div class="card mb-3">
            <div class="card-body">
              <div class="row no-gutters">
                <div class="col-12 mb-3">
                  <div class="row justify-content-center justify-content-sm-between">
                    <div class="col-sm-auto text-center">
                      <h5 class="d-inline-block">Nos offres d'abonnement</h5>
                    </div>
                    <div class="col-sm-auto d-flex flex-center fs--1 mt-1 mt-sm-0">
                      {{-- <label class="mr-2 mb-0" for="customSwitch1">Monthly</label> --}}
                      <div>
                        <span class="badge badge-soft-danger badge-pill ml-1">Facturé uniquement par mois</span>
                        
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4 border-top border-bottom">
                  <div class="h-100">
                    <div class="text-center p-4">
                      <h3 class="font-weight-normal my-0 text-uppercase">{{ getForfait(1)->libele }}</h3>
                      <p class="mt-3">Pour une entreprise individuelle, gestion simple et éfficace</p>
                      <h2 class="font-weight-medium my-4"><sup class="font-weight-normal fs-2 mr-1"></sup>
                        @if(isEssaie())
                          {{ formatPrice(getForfait(1)->prixInscription) }}
                          <small class="fs--1 text-700"></small></h2>
                        @else
                          {{ formatPrice(getForfait(1)->Coutabonnement) }}
                          <small class="fs--1 text-700">/ mois</small></h2>
                        @endif
                        <a class="btn btn-outline-primary Suscribe" href="#" forfait="1">Souscrire</a>
                    </div>
                    <hr class="border-bottom-0 m-0">
                    <div class="text-left px-sm-4 py-4">
                      <h5 class="font-weight-medium fs-0">Accès aux fonctionnalités de :</h5>
                      <ul class="list-unstyled mt-3">
                        <li class="py-1"><span class="mr-2 fas fa-check text-success"></span> Suivie en temps réel</li>
                        <li class="py-1"><span class="mr-2 fas fa-check text-success"></span> Gestion du stock</li>
                        <li class="py-1"><span class="mr-2 fas fa-check text-success"></span> Gestion de la principale</li>
                        <li class="py-1"><span class="mr-2 fas fa-check text-success"></span>Gestion des fournisseurs</li>
                        <li class="py-1"><span class="mr-2 fas fa-check text-success"></span> Gestion des ventes</li>
                      </ul>
                      {{-- <a class="btn btn-link" href="#">More about Single</a> --}}
                    </div>
                  </div>
                </div>
                <div class="col-lg-4 border-top border-bottom">
                  <div class="h-100" style="background-color: rgba(115, 255, 236, 0.18)">
                    <div class="text-center p-4">
                      <h3 class="font-weight-normal my-0 text-uppercase">{{ getForfait(2)->libele }}</h3>
                      <p class="mt-3">Partagez vos taches de gestion et gérez vos filliales</p>
                      <h2 class="font-weight-medium my-4"> <sup class="font-weight-normal fs-2 mr-1"></sup>
                        @if(isEssaie())
                          {{ formatPrice(getForfait(2)->prixInscription) }}
                          <small class="fs--1 text-700"></small></h2>
                        @else
                          {{ formatPrice(getForfait(2)->Coutabonnement) }}
                          <small class="fs--1 text-700">/ mois</small></h2>
                        @endif
                        <a class="btn btn-primary Suscribe" href="#" forfait="2">Souscrire</a>
                    </div>
                    <hr class="border-bottom-0 m-0">
                    <div class="text-left px-3 px-sm-4 py-4">
                      <h5 class="font-weight-medium fs-0">Accès aux fonctionnalités de:</h5>
                       <ul class="list-unstyled mt-3">
                            <li class="py-1"><span class="mr-2 fas fa-check text-success"></span> Suivie en temps réel</li>
                            <li class="py-1"><span class="mr-2 fas fa-check text-success"></span> Gestion du stock</li>
                            <li class="py-1"><span class="mr-2 fas fa-check text-success"></span> Gestion de la principale</li>
                            <li class="py-1"><span class="mr-2 fas fa-check text-success"></span>Gestion des fournisseurs</li>
                            <li class="py-1"><span class="mr-2 fas fa-check text-success"></span> Gestion des ventes</li>
                            <li class="py-1"><span class="mr-2 fas fa-check text-success"></span><span class="badge badge-soft-warning badge-pill ml-1"><i class="fa fa-plus"></i></span> Gestion de vos filliales</li>
                            <li class="py-1"><span class="mr-2 fas fa-check text-success"></span><span class="badge badge-soft-warning badge-pill ml-1"><i class="fa fa-plus"></i></span>Gestion des utilisateurs</li>
                            <li class="py-1"><span class="mr-2 fas fa-check text-success"></span><span class="badge badge-soft-warning badge-pill ml-1"><i class="fa fa-plus"></i></span>Gestion des prospects</li>
                      </ul>
                      </div>
                  </div>
                </div>
                
                <div class="col-lg-4 border-top border-bottom">
                  <div class="h-100">
                    <div class="text-center p-4">
                      <h3 class="font-weight-normal my-0 text-uppercase">{{ getForfait(3)->libele }}</h3>
                      <p class="mt-3">Relation client & Campagne Marketting + volet E-commerce</p>
                      <h2 class="font-weight-medium my-4"> <sup class="font-weight-normal fs-2 mr-1"></sup>
                        @if(isEssaie())
                          {{ formatPrice(getForfait(3)->prixInscription) }}
                          <small class="fs--1 text-700"></small></h2>
                        @else
                          {{ formatPrice(getForfait(3)->Coutabonnement) }}
                          <small class="fs--1 text-700">/ mois</small></h2>
                        @endif
                        <a class="btn btn-outline-primary Suscribe" forfait='3'>Souscrire</a>
                    </div>
                    <hr class="border-bottom-0 m-0">
                    <div class="text-left px-sm-4 py-4">
                      <h5 class="font-weight-medium fs-0">Toutes les fonctionnalités:</h5>
                       <ul class="list-unstyled mt-3">
                            <li class="py-1"><span class="mr-2 fas fa-check text-success"></span> Suivie en temps réel</li>
                            <li class="py-1"><span class="mr-2 fas fa-check text-success"></span> Gestion du stock</li>
                            <li class="py-1"><span class="mr-2 fas fa-check text-success"></span> Gestion de la principale</li>
                            <li class="py-1"><span class="mr-2 fas fa-check text-success"></span>Gestion des fournisseurs</li>
                            <li class="py-1"><span class="mr-2 fas fa-check text-success"></span> Gestion des ventes</li>
                            <li class="py-1"><span class="mr-2 fas fa-check text-success"></span><span class="badge badge-soft-warning badge-pill ml-1"><i class="fa fa-plus"></i></span> Gestion de vos filliales</li>
                            <li class="py-1"><span class="mr-2 fas fa-check text-success"></span><span class="badge badge-soft-warning badge-pill ml-1"><i class="fa fa-plus"></i></span>Gestion des utilisateurs</li>
                            <li class="py-1">
                              <span class="mr-2 fas fa-check text-success"></span>
                              <span class="badge badge-soft-warning badge-pill ml-1"><i class="fa fa-plus"></i></span>
                              Gestion des prospects
                            </li>
                            <li class="py-1">
                              <span class="mr-2 fas fa-check text-success"></span>
                              <span class="badge badge-soft-success badge-pill ml-1"><i class="fa fa-plus"></i></span>
                              Gestion Opérateurs
                            </li>
                            <li class="py-1">
                              <span class="mr-2 fas fa-check text-success"></span>
                              <span class="badge badge-soft-success badge-pill ml-1"><i class="fa fa-plus"></i></span>
                              Campagnes SMS Riche
                            </li>
                            <li class="py-1">
                              <span class="mr-2 fas fa-check text-success"></span>
                              <span class="badge badge-soft-success badge-pill ml-1"><i class="fa fa-plus"></i></span>
                              Campagnes Mailling 
                            </li>
                            <li class="py-1">
                              <span class="mr-2 fas fa-check text-success"></span>
                              <span class="badge badge-soft-success badge-pill ml-1"><i class="fa fa-plus"></i></span>
                             Plateforme E-commerce
                            </li>

                      </ul>
                    </div>
                  </div>
                </div>
                <div class="col-12 text-center">
                  <h5 class="mt-5">Plus de fonctionnalités ?</h5>
                  <p class="fs-1">Contactez notre équipe support <a href="mailto:{{getSettingByName('supportMail')}}">{{getSettingByName("supportMail")}}</a> </p>
                </div>
              </div>
            </div>
          </div>

          <button id="cliqMe" style="display: none;">tester</button>

          <button id="bt_get_signature" style="display: none;"></button>

<script src="{{ asset('js/abonnement.js') }}"></script>
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

<script type="text/javascript">
  
  // Gestion de l'abonnement
   init();
</script>