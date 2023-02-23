<div class="card mb-3">
  <div class="bg-holder d-none d-lg-block bg-card" 
   style="background-image:url(../assets/img/illustrations/corner-4.png);">
  </div>
  <!--/.bg-holder-->

    <div class="card-body">
      <div class="row">
        <div class="col-lg-8">

          <h3 class="mb-0 text-primary">
           <a href="#" class="operateurs">
            <i class="fas fa-user-tie"></i>
            Opérateur ></a>Nouvelle opération
          </h3>
          <p class="mt-2"><b>Gérer vos opérateurs</b>, créer une opération</p>
        </div>
      </div>
    </div>
</div>

<div class="card mb-3">
  <div class="card-body">
        <form id="Opera">
          @csrf
          <div class="form-group">
           <label for="basic-example" name="operateur">Opérateurs</label>
           <select class="selectpicker operat">
             <option></option>
             @foreach($operateurs as $operateur)
             <option value="{{ $operateur->id }}">{{ $operateur->operateurNom }}</option>
             @endforeach
           </select>
          </div>

          <div class="form-group">
           <label for="basic-example">Opérations</label>
           <select class="selectpicker opera" name="operation">
             <option></option>
             @foreach($operations as $operation)
             <option value="{{ $operation->id }}">{{ $operation->OperationLibele }}</option>
             @endforeach
           </select>
          </div>

         <div class="form-row">
         <div class="form-group col-6">
           <label for="name">Montant</label>
           <input class="form-control" id="montant" type="number" placeholder="" name="montant">
         </div>
         <div class="form-group col-6">
          <label for="datepicker">Start Date</label>
          <input class="form-control datetimepicker" type="text"  id="dateOp" 
           data-options='{"dateFormat":"d/m/Y"}'>
        </div>
      </div>

         <button class="btn btn-falcon-default rounded-capsule mr-1 mb-1 AddOp"  type="submit">
          Ajouter <i class="fas fa-plus"></i>
         </button>
        </form>
    </div>
</div>





  <script src="{{ asset('assets/js/theme.js') }}"></script>
  <script src="{{ asset ('assets/lib/select2/select2.min.js')}}"></script>
  <script type="text/javascript">

    // Affecter une opération à un opérateur
    $("#Opera").on("submit",function(event){
        event.preventDefault();
        // Operation
         var opera = $("select.opera").children("option:selected").val();
        // operateur
         var operat = $("select.operat").children("option:selected").val();
        // Montant
         var montant = $("#montant").val();
         var date = $("#dateOp").val();
        $.ajax({
         url:'p_opeOpNew',
         method:'get',
         data:{opera:opera,operat:operat,montant:montant,date:date},
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
             text:  'Attribution faite avec succès',
             showConfirmButton: true,
             timer: 5000
            });
            loadingScreen();
            var idV = $(this).attr('id');
            var token = $('input[name=_token]').val();
            $("#main_content").load("/p_OpTion",{idV:operat,_token:token});
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
            $('#main_content').load('/p_opetNew');  
               }
            });
         }
       });
    });

    // Retour sur les opérateurs
    $(".operateurs").click(function(){
      $("#main_content").load("/p_OpListe"); 
    });

    //Fonction d'initialisation
    function Initform() {
      $('.operat').val('');
      $('.opera').val('');
      $('#montant').val('');
    }
    
  </script>