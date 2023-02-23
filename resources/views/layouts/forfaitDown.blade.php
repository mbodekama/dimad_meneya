@include('layouts.partials.header')




    <!-- ===============================================-->
    <!--   DEBUT DU CONTAINER A RECHARGER -->
    <!-- ===============================================-->

			{{-- VUE INCLUS POUR PRINCIPALE --}}
			<div id="main_content">
                        <!-- ============================================-->
      <!-- <section> begin ============================-->
      <section class="py-0 overflow-hidden" id="banner">
        <div class="bg-holder overlay" style="background-image:url(../assets/img/generic/bg-1.jpg);background-position: center bottom;">
        </div>
        <!--/.bg-holder-->

        <div class="container">
          <div class="row justify-content-center align-items-center pt-3 pt-lg-3 pb-lg-9 pb-xl-0">
            <div class="col-md-11 col-lg-8 col-xl-4 pb-7 pb-xl-9 text-center text-xl-left">
              <h1 class="text-danger">Forfait Expirer</h1>
              <a class="btn btn-outline-danger mb-4 fs--1 border-2x rounded-pill" href="{{ route('logout') }}"
                         onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();"><span class="mr-2" role="img" aria-label="Gift">🎁</span>Re-abonnez vous</a>
              <h3 class="text-white font-weight-light">Contacter votre administrateur pour effectuer votre réabonnement</h3>

              <a class="btn btn-outline-light border-2x rounded-pill btn-lg mt-4 fs-0 py-2"  href="{{ route('logout') }}"
                         onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">Acceuil<span class="fas fa-play" data-fa-transform="shrink-6 down-1 right-5"></span></a>

                {{-- FORM DE DECONNEXION --}}
                      <form id="logout-form" action="{{ route('logout') }}" 
                        method="POST" style="display: none;">@csrf
                      </form>
            </div>
            <div class="col-xl-7 offset-xl-1 align-self-end"><a class="img-landing-banner" href="../index.html"><img class="img-fluid" src="../assets/img/generic/dashboard-alt.png" alt="" /></a></div>
          </div>
        </div>
        <!-- end of .container-->



      </section>
      <!-- <section> close ============================-->
      <!-- ============================================-->





    <!-- ===============================================-->
    <!--   FIN DU CONTAINER A RECHARGER -->
    <!-- ===============================================-->


@include('layouts.partials.footer')
    <script src="../assets/lib/typed.js/typed.js"></script>




