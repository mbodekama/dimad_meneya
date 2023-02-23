    <main class="main mt-4 recu_html" id="top">


      <div class="container" data-layout="container">

        <div class="content">
          <div class="card mb-3">


            <div class="card-body">


              <div class="row align-items-center text-center mb-3">
                <div class="col-sm-6 text-sm-left">
                  <img src="{{asset(getLogo())}}" 
                       alt="invoice" width="150">
                </div>
                <div class="col text-sm-right mt-3 mt-sm-0">
                  <h2 class="mb-3">Facture d'achat</h2>
                  <h5>{{getEntreprise()}}</h5>
                  <p class="fs--1 mb-0">
                    {{getLocal()}}<br>
                    {{getContact()}}<br>
                    {{getAlertMail()}}
                  </p>
                </div>
                <div class="col-12">
                  <hr>
                </div>
              </div>

            </div>
          </div>
          <div class="card mb-3">
            <div class="card-body" id="recu_content">

            </div>
          </div>
          <footer>
            <div class="card-footer bg-light">
              <p class="fs--1 mb-0"><strong>*Autres:</strong> 
                
                <?php 
                  if(isset($sortie)){

                   echo $sortie->chargesDesc;
                  }
                  else{
                    echo "aucun";
                  }
  
                ?>
              </p>
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




    