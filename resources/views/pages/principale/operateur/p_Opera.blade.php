<div class="card mb-3">
  <div class="bg-holder d-none d-lg-block bg-card" 
   style="background-image:url(../assets/img/illustrations/corner-4.png);">
  </div>
  <!--/.bg-holder-->

    <div class="card-body">
      <div class="row">
        <div class="col-lg-8">

          <h3 class="mb-0 text-primary"> <i class="fas fa-user-tie"></i> Opérateur >Nouveau</h3>
          <p class="mt-2"><b>Créer un opérateur</b></p>
          <span>
            Un opérateur est une personne qui dépose une somme d'argent
            pour une ou plusieurs opérations données(Achat de matériels ...).Il faut suivre les sorties et la solvabilité des operations de ces opérateurs en question.
          </span>
        </div>
      </div>
    </div>
</div>

<div class="card mb-3">
	<div class="card-body">
        <form id="Opera">
          @csrf
         <div class="form-group">
           <label for="name">Nom</label>
           <input class="form-control" id="nom" type="text" placeholder="" name="nom">
         </div>

         <div class="form-group">
           <label for="name">Contact</label>
           <input class="form-control" id="contact" type="number" placeholder="" name="contact">
         </div>

         <div class="form-group">
           <label for="name">Lieu</label>
           <input class="form-control" id="lieu" type="text" placeholder="" 
            name="lieu">
         </div>

         <div class="form-group">
           <label for="name">Date</label>
           <input class="form-control datetimepicker" type="text"  id="date" 
           data-options='{"dateFormat":"d/m/Y"}'  name="date">
        </div>
         

         <button class="btn btn-falcon-default rounded-capsule mr-1 mb-1 AddOp"  type="submit">
         	Ajouter <i class="fas fa-user-plus"></i>
         </button>
        </form>
    </div>
</div>





  <script src="{{ asset('assets/js/theme.js') }}"></script>
  <script type="text/javascript">

    // Ajouter un opérateur
    $("#Opera").on("submit",function(event){
       event.preventDefault();
       var data = $(this).serialize();
       $.ajax({
         url:'p_AddOpera',
         method:'POST',
         data:data,
         dataType:'json',
         success:function(datas){
            console.log(datas);
            Initform();
            var input = '#Opera input';
            $(input).attr('class','form-control');
            Swal.fire({
             position: 'top-end',
             icon:  'success',
             title: 'Opérateur',
             text:  'Opérateur ajouter avec succès',
             showConfirmButton: true,
             timer: 5000
            }); 
            loadingScreen();
            $('#main_content').load("/p_OpListe"); 
         },
         error:function(datas){
            console.log(datas);
            $.each(datas.responseJSON,function(key,value){
               if (key == 'errors') {
                  $.each(value, function(key1, value1){
                    var input = '#Opera input[name='+key1+']';
                    $(input).addClass('is-invalid');
                    $(input).attr('placeholder',value1);
                  })
               }
            });
         }
       });
    });

    //Fonction d'initialisation
    function Initform() {
      $('#nom').val('');
      $('#contact').val('');
      $('#lieu').val('');
    }
    
  </script>