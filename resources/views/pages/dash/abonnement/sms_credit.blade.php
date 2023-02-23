          <div class="card mb-3 " id="entete">
            <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url(../assets/img/illustrations/corner-4.png);">
            </div>
            <!--/.bg-holder-->

            <div class="card-body">
              <div class="row">
                <div class="col-lg-8 d-flex justify-content-between">
                  <h4 class="mb-0 text-primary"><i class="far fa-comment-dots"></i> 
                    Paramètre <i class="fas fa-angle-right"></i> Unité SMS</h4>
                  
                </div>
              </div>
            </div>
          </div>

              <main class="main" id="top">


      <div class="container" data-layout="container">
        <div class="row justify-content-center pt-6">
          <div class="col-sm-10 col-lg-7 col-xxl-5"><a class="d-flex flex-center mb-4" href="#"><img class="mr-2" src="../assets/img/illustrations/falcon.png" alt="" width="45" />
            <span class="text-sans-serif font-weight-extra-bold fs-4 d-inline-block CampgNew">SMS Marketing</span></a>
            <div class="card theme-wizard mb-5" data-wizard data-controller="#wizard-controller" data-error-modal="#error-modal">
              <div class="card-header bg-light pt-3 pb-2">
                Recharger vos unités SMS-PRO
              </div>
              <div class="card-body py-4">
                <div class="tab-content">
                  <div class="tab-pane active px-sm-3 px-md-5" id="bootstrap-wizard-tab1">

                    <div class="alert alert-warning" role="alert">
                     Solde SMS :{{soldeSMS(getSettingByName('sms_mail'),getSettingByName('sms_secret')) }} {{getMyDevise()}}<br>
                     <b>*Nb: 1 sms à 19 {{getMyDevise()}}</b>
                    </div>

                    <form class="form-validation" data-options='{"rules":{"confirmPassword":{"equalTo":"#wizard-password"}},"messages":{"confirmPassword":{"equalTo":"Passwords didn&#39;t match"},"terms":{"required":"You must accept terms and privacy policy"}}}'>
                      <div class="form-group">
                        <label for="wizard-name">Montant({{getMyDevise()}})</label>
                        <input class="form-control" type="number" 
                        name="montant"  id="montant" />
                      </div>
                      
                     
                      <div class="custom-control custom-checkbox">
                        <button class="Suscribe_sms btn btn-danger mr-1 mb-1 text-center" type="button">  Récharger vous
                        </button>

                        <button id="bt_get_signature" style="display: none;">
                        </button>
                        
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="card-footer bg-light" id="wizard-controller">
                <div class="px-sm-3 px-md-5">
                  <ul class="pager wizard list-inline mb-0">
                    
                    <li class="text-center">
                      <label class="text-center" >
                         Maximiser vos ventes en envoyant à vos clients et vos prospects des sms promotionnels
                        </label>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
         
        </div>
      </div>
    </main>

<script type="text/javascript">
  $(".CampgNew").click(function(){
    loadingScreen();
    $("#main_content").load("/CampgNew");
  });
</script>
<script src="{{ asset('js/abonnement_sms.js') }}"></script>
<script type="text/javascript">
  // Lancement du paiement
  init();
</script>