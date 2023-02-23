    <main class="main mt-4 recu_html" id="top">


      <div class="container" data-layout="container">

        <div class="content">
          <div class="card mb-3">
            <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url(../assets/img/illustrations/corner-4.png);opacity: 0.7;">
            </div>
            <!--/.bg-holder-->

            <div class="card-body">
              <div class="d-flex justify-content-between">
            
                <h5> {{ env('APP_LIBELLE') }}<br><span class="fas fa-map-marker-alt"></span> {{ env('APP_LOCATION') }} <span class="fas fa-phone-square-alt"></span> {{ env('APP_CONTACT') }} </h5>
                <img src="{{ asset('assets/img/team/logodimad.jpg') }}" alt="..." class="img-thumbnail">
              </div>


              <div  class="d-flex justify-content-between">
                <div>
                  <strong class="mr-2 SucName">Succursale: </strong>
                </div>
                <div>
                  <strong class="mr-2 gerant">Gérant:  </strong>
                </div>
                <div>
                  <strong class="mr-2">Date: </strong>
                  <div class="badge badge-pill badge-soft-secondary fs--2 dateVente">{{ date('d/m/Y') }}<span class="fas fa-check ml-1" data-fa-transform="shrink-2"></span></div>
                </div>
            </div>

            </div>
          </div>
          <div class="card mb-3">
            <div class="card-body" id="recu_content">

            </div>
          </div>
          <footer>
            <div class="row no-gutters justify-content-between fs--1 mt-4 mb-3">
              <div class="col-12 col-sm-auto text-center">
                <p class="mb-0 text-600">DIM AD Reçu <span class="d-none d-sm-inline-block">| </span><br class="d-sm-none" /> {{ date('Y') }} &copy; <a href="https://themewagon.com">Copyright</a></p>
              </div>
              <div class="col-12 col-sm-auto text-center">
                <p class="mb-0 text-600">v2.7.0</p>
              </div>
            </div>
          </footer>
        </div>
      </div>
    </main>



            <style type="text/css">

                  .recu_html
                  {
                    display: none;
                  }
                  @media print {

                      body {
                            width: auto!important;
                            margin: auto!important;
                            margin-top: 100px;
                            background-color: #fff;
                            
                          }
                          #top {

                            width: auto!important;
                            margin: auto!important;
                            margin-top: 100px;
                            background-color: #edf2f9;

                          }
                        .no-print
                        {
                            display: none;
                        }
                        .recu_html
                        {
                          display: block;
                        }
                    
                                }
            </style>