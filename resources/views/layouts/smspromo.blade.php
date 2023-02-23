@include('layouts.partials.header')
<div id="main_content">
	    <div class="card">
            <div class="card-body overflow-hidden p-lg-6">
              <div class="row align-items-center justify-content-between">
                <div class="col-lg-6"><img class="img-fluid" src="../assets/img/illustrations/4.png" alt=""></div>
                <div class="col-lg-6 pl-lg-4 my-5 text-center text-lg-left">
                  <h3>J'augmente mes ventes !!</h3>

                  <div class="alert alert-success" role="alert">
                     <h4 class="alert-heading font-weight-semi-bold">
                     	Bien joué !!!
                     </h4>
                     <p>Résultat après traitement de votre campagne</p>
                     <hr>
                     <p class="mb-0">{{$info}}</p>
                  </div>

                  <a class="btn btn-falcon-primary" href="/dashboard">
                  	OK
                  </a><br><br>
                  <span>
                  	<b>*Note:</b> Contactez le support technique Meneya pour toutes difficultés rencontrées.<br>+225 07 88 83 30 60 / support@meneya.com <br> Tchater directement avec le service client .
                  </span>
                </div>
              </div>
            </div>
        </div>
</div>
@include('layouts.partials.footer')
