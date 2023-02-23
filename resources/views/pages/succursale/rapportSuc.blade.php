 @if(!$succ->isEmpty())

<div class="card mb-3">
  <div class="bg-holder d-none d-lg-block bg-card" 
   style="background-image:url(../assets/img/illustrations/corner-4.png);">
  </div>
  <!--/.bg-holder-->

    <div class="card-body">
      <div class="row">
        <div class="col-lg-8">
          <h3 class="mb-0 text-primary"> <i class="fas fa-grin-stars"></i> Rapport Agence >Analyse</h3>
          <p class="mt-2">Statistiques des ventes de vos succursales</p>
        </div>
      </div>
    </div>
</div>
          <!-- -------------------------------------------->
          <!--    Tables, Files, and Lists-->
          <!-- -------------------------------------------->
          <div class="media mb-2 mt-2"><span class="fa-stack mr-2 ml-n1">
            <i class="fas fa-circle fa-stack-2x text-300"></i>
            <i class="fa-inverse fa-stack-2x text-primary fas fa-chart-line" 
             data-fa-transform="shrink-2"></i></span>
            <div class="media-body">
              <h5 class="mb-0 text-primary position-relative">
                <span class="bg-200 pr-1">
                               <p class="font-weight-light overflow-hidden">
                <span class="typed-text font-weight-bold ml-1" data-typed-text='["1- Choisir un intervalle de date","2- Lancer une analyse de rapport","3- Obtenez le classement des meilleurs succursales","4- Génerer des demandes de versement", "<u>Meneya, le tout en un de la gestion</u>"]'></span></p> 
                </span>
                <span class="border position-absolute absolute-vertical-center w-100 z-index--1 l-0"></span>
              </h5>

              <form class="form-row" id="rapportSucForm">
                @csrf
                <div class="col-6">               
                  <div class="form-group">
                    <label for="timepicker2">Date de début - Date de fin</label>
                    <input class="form-control datetimepicker dateBes" 
                      id="timepicker2" type="text" name="dateInterval" 
                      data-options='{"mode":"range","dateFormat":"d/m/Y"}'>
                  </div>
                </div>
                <div class="col-4">
                  <label for="gerant">Succursales </label>
                   
                      <select class="form-control" id="succ"  name="succ"> 
                            <option value="0" >
                              Toutes les succursales
                            </option>                          
                          @foreach($succ as $suc)
                            <option value="{{ $suc->id }}" >
                              {{ $suc->succursaleLibelle }}
                            </option>
                          @endforeach
                      </select>

                </div>
                <div class="col-2">
                  <div class="form-group">
                    <label for="charts" > Lancer l'analyse</label>
                      <button class="btn btn-danger mr-1 mb-1 charts" type="button">
                         Analyser <i class="fas fa-chart-bar"></i>
                      </button>
                  </div>       
                </div>
              </form>

            </div>

          </div>

        <div class="statsBe">

        </div>
        <div id="rapport">
          
        </div>



<script src="{{ asset('assets/lib/typed.js/typed.js') }}"></script>

  <script src="{{ asset('assets/js/theme.js') }}"></script>

  <script type="text/javascript">

    // Analyse des besoins
      $(".charts").click(function(){
        var dateS = $('.dateBes').val();
        if (dateS!='') {
            $('.dateBes').attr('class','form-control datetimepicker dateBes flatpickr-input invalid');
            $.ajax({
              url:'mbo/rapAnlyz',
              method:'post',
              data:$('#rapportSucForm').serialize(),
              dataType:'html',
              success:function(data){

               $(".statsBe").html(data);

              },
              error:function(){
               Swal.fire('Erreur de connexion.');

              }
            });
        }else{
          toastr.error('Veuillez selectionner une date');
          $('.dateBes').attr('class','form-control datetimepicker dateBes flatpickr-input is-invalid');

        }

      });

  </script>

 


@else
 <div class="card">
            <div class="card-body overflow-hidden text-center pt-5">
              <div class="row justify-content-center">
                <div class="col-7 col-md-5"><img class="img-fluid" src="../assets/img/illustrations/modal-right.png" alt="" /></div>
              </div>
              <h3 class="mt-3 font-weight-normal fs-2 mt-md-4 fs-md-3">
                <b class="text-danger">Oupsss!!!!!!</b>, Vous n'avez aucune succursale.
              </h3>
              <p class="lead">Veuillez passer à la création de succursale.
               <br class="d-none d-md-block"/> 
                
                  <a class="ml-1 btn btn-outline-primary rounded-capsule mr-1 mb-1 newSuc"  href="#">
                          Nouvelle succursale
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

  <script type="text/javascript">
    $('.newSuc').click(function()
    {
      $('#main_content').load('/mbo/addSuc')
    })
  </script>
@endif