<div class="card mb-3">
  <div class="bg-holder d-none d-lg-block bg-card" 
   style="background-image:url(../assets/img/illustrations/corner-4.png);">
  </div>
  <!--/.bg-holder-->

    <div class="card-body">
      <div class="row">
        <div class="col-lg-8">
          <h3 class="mb-0 text-primary"> <i class="fas fa-grin-stars"></i> Propsects >Analyse</h3>
          <p class="mt-2">Statistiques des besoins de tes prospects</p>
        </div>
      </div>
    </div>
</div>
          <!-- -------------------------------------------->
          <!--    Tables, Files, and Lists-->
          <!-- -------------------------------------------->
          <div class="media mb-4 mt-6"><span class="fa-stack mr-2 ml-n1">
          	<i class="fas fa-circle fa-stack-2x text-300"></i>
          	<i class="fa-inverse fa-stack-2x text-primary fas fa-chart-line" 
          	 data-fa-transform="shrink-2"></i></span>
            <div class="media-body">
              <h5 class="mb-0 text-primary position-relative">
              	<span class="bg-200 pr-3">Trois produits les plus demandés</span>
              	<span class="border position-absolute absolute-vertical-center w-100 z-index--1 l-0"></span>
              </h5>
              {{-- <p class="mb-0">Lancer une campagne SMS promotionnel pour vendre</p><br> --}}
              <p class="font-weight-light overflow-hidden">Lancer une campagne SMS promotionnel pour vendre<br> <span class="typed-text font-weight-bold ml-1" data-typed-text='["Taux de lecture 95%","Délai ouverture de sms 4min","25fcfa le coût de chaque SMS","Augmente rapidement tes ventes"]'></span></p>
                  <div class="form-group">
                    <label for="timepicker2">Date de début - Date de fin</label>
                    <input class="form-control datetimepicker dateBes" 
                      id="timepicker2" type="text" data-options='{"mode":"range","dateFormat":"d/m/Y"}'>
                  </div>
                  <div>
                    <button class="btn btn-outline-info mr-1 mb-1 charts" type="button">
                       Lancer l'analyse
                    </button>
                  </div>
            </div>

          </div>

        <div class="statsBe">

        </div>





  <script src="{{ asset('assets/js/theme.js') }}"></script>
  <script type="text/javascript">

    // Analyse des besoins
      $(".charts").click(function(){
        var dateS = $('.dateBes').val();
        if (dateS!='') {
            $.ajax({
              url:'statBes',
              method:'get',
              data:{dateS:dateS},
              dataType:'html',
              success:function(data){
               $(".statsBe").html(data);
              },
              error:function(){
               Swal.fire('Aucun besoins demandé à cette date');
              }
            });
        }else{
          Swal.fire('Veuillez selectionner une date');
        }

      });

    // Relance SMS
    /* $(".ReSMS").click(function(){
       alert("bonjour");
     });
*/




  </script>