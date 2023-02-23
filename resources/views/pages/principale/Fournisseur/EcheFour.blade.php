<div class="card mb-3">
  <div class="bg-holder d-none d-lg-block bg-card" 
   style="background-image:url(../assets/img/illustrations/corner-4.png);">
  </div>
  <!--/.bg-holder-->

    <div class="card-body">
      <div class="row">
        <div class="col-lg-8">

          <h3 class="mb-0 text-primary">
           <a href="#" class="fournisseur">
            <i class="fas fa-user-tie"></i>
            Fournisseurs ></a>Nouvelle Achat
          </h3>
          <p class="mt-2"><b>Enregistrer un achat fait chez un fournisseur </b></p>
        </div>
      </div>
    </div>
</div>

<div class="card mb-3">
	<div class="card-body">
        <form id="Opera">
          @csrf
          <div class="form-group">
           <label for="basic-example" name="operateur">Fournisseur</label>
           <select class="selectpicker operat" name="idFour">
             <option></option>
             @foreach($fours as $four)
             <option value="{{ $four->id }}">{{ $four->fournisseurNom }} ( {{ $four->fournisseurRespo }})</option>
             @endforeach
           </select>
          </div>


         <div class="form-group">
           <label for="name">Montant de l'achat</label>
           <input class="form-control" id="montant" type="number" placeholder="" name="montant">
         </div>
         <div class="form-row">
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label for="dateAchat">Date d'achat</label>
                            <input class="form-control datetimepicker" id="dateAchat" name="dateAchat" type="text" data-options='{"dateFormat":"d/m/Y"}' value="{{ date('d/m/Y') }}">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label for="echeance">Date d'écheance du paiement</label>
                            <input class="form-control datetimepicker" id="echeance" name="echeance" type="text" data-options='{"dateFormat":"d/m/Y"}'>
                          </div>
                        </div>
                        </div>
         <button class="btn btn-falcon-default text-primary rounded-capsule mr-1 mb-1 AddEch"  type="submit">
         	Valider <i class="fas fa-plus"></i>
         </button>
        </form>
    </div>
</div>





  <script src="{{ asset('assets/js/theme.js') }}"></script>
  <script src="{{ asset ('assets/lib/select2/select2.min.js')}}"></script>
  <script type="text/javascript">

    // Ajouter un opérateur
    $("#Opera").on("submit",function(event){
        event.preventDefault();
        // Operation
         var opera = $("select.opera").children("option:selected").val();
        // operateur
        // Montant
         var montant = $("#montant").val();

       $.ajax({
         url:'EcheFour',
         method:'post',
         data:$('#Opera').serialize(),
         dataType:'json',
         success:function(datas){
            console.log(datas);
            Initform();
            var input = '#Opera input';
            $(input).attr('class','form-control');
            Swal.fire({
             position: 'top-end',
             icon:  'success',
             title: 'Attribution',
             text:  'Echéance crée  avec succès',
             showConfirmButton: true,
             timer: 5000
            });
            $('#main_content').load('/p_listF');  
         },
         error:function(datas){
            console.log(datas);
            $.each(datas.responseJSON,function(key,value){
               if (key == 'errors') {
            Swal.fire({
             position: 'top-end',
             icon:  'error',
             title: 'Echec',
             text:  "L'attribution a échouer veuillez reprendre !",
             showConfirmButton: true,
             timer: 4000
            });
               }
            });
         }
       });
    });

    // Retour sur les fournisseurs
    $(".fournisseur").click(function(){
      $("#main_content").load("/p_listF"); 
    });

    //Fonction d'initialisation
    function Initform() {
      $('.operat').val('');
      $('.opera').val('');
      $('#montant').val('');
    }
    
  </script>