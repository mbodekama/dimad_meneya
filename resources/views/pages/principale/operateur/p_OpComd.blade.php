<div class="card mb-3">
  <div class="bg-holder d-none d-lg-block bg-card" 
   style="background-image:url(../assets/img/illustrations/corner-4.png);">
  </div>
  <!--/.bg-holder-->

    <div class="card-body">
      <div class="row">
        <div class="col-lg-12">
          <h3 class="mb-0 text-primary"> <i class="fas fa-user-tie"></i> Opérateur >Opération</h3>
          <p class="mt-2"><b>Créer une opération</b></p>
          <span>Une opération, ce sont les différentes opérations que peut effectuer votre opérateur: la réalisation d'un chantier, achat de matériel etc.</span>
          <br>
          <button class="btn btn-falcon-danger mr-1 mb-1" id="refresh" 
           type="button">
             <span class="fab fa-battle-net fa-2x"  data-fa-transform="shrink-3">
             </span><a href="#">Actualiser</a>
          </button>
        </div>
        <br>
        
      </div>
    </div>
</div>

<div class="card mb-3">
  <div class="card-body">
        <form id="Opera">
          @csrf
         <div class="form-group">
           <label for="name">Libellé</label>
           <input class="form-control" id="nom" type="text" placeholder="" name="nom">
         </div>
         <div class="form-group">
           <label for="comment">Commentaire</label>
           <textarea class="form-control" id="comment"
            rows="3" name="comment"></textarea>
         </div>

         <button class="btn btn-falcon-default rounded-capsule mr-1 mb-1 AddOp"  type="submit">
          Ajouter <i class="fas fa-plus"></i>
         </button>
        </form>
    </div>
</div>


          @if(!$operat->isEmpty())
            <div class="card mb-3">
              <div class="card-header">
                <div class="row align-items-center justify-content-between">
                  <div class="col-4 col-sm-auto d-flex align-items-center pr-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Nos opérations
                    </h5>
                  </div>
                   <!-- Pagination -->
                   @include('pages/dash/pagnMod')
                </div>
              </div>
              <div class="card-body p-0"  id="loaderContent">
                <div class="falcon-data-table">
                  <table class="mytable table table-sm mb-0 table-striped table-dashboard fs--1 data-table border-bottom border-200" data-options='{"searching":false,"responsive":false,"info":false,"lengthChange":false,"sWrapper":"falcon-data-table-wrapper","dom":"<&#39;row mx-1&#39;<&#39;col-sm-12 col-md-6&#39;l><&#39;col-sm-12 col-md-6&#39;f>><&#39;table-responsive&#39;tr><&#39;row no-gutters px-1 py-3 align-items-center justify-content-center&#39;<&#39;col-auto&#39;p>>","language":{"paginate":{"next":"<span class=\"fas fa-chevron-right\"></span>","previous":"<span class=\"fas fa-chevron-left\"></span>"}}}'>
                    <thead class="bg-200 text-900">
                      <tr>
                        <th class="align-middle no-sort">
                          <div class="custom-control custom-checkbox">
                            <input class="custom-control-input checkbox-bulk-select" id="checkbox-bulk-purchases-select" type="checkbox" data-checkbox-body="#orders" data-checkbox-actions="#orders-actions" data-checkbox-replaced-element="#dashboard-actions">
                            <label class="custom-control-label" for="checkbox-bulk-purchases-select"></label>
                          </div>
                        </th>
                        <th class="align-middle sort">Code</th>
                        <th class="align-middle sort">Libellé</th>
                        <th class="align-middle sort">Commentaire</th> 
                        <th>Action</th>       
                      </tr>
                    </thead>
                    <tbody id="orders">
                     <?php foreach ($operat as $key => $value) {?>
                      <tr class="btn-reveal-trigger">
                        <td class="py-2 align-middle">
                          <div class="custom-control custom-checkbox">
                            <input class="custom-control-input checkbox-bulk-select-target" 
                            type="checkbox" id="checkbox-0" />
                            <label class="custom-control-label" for="checkbox-0"></label>
                          </div>
                        </td>
                        <td class="py-2 align-middle  fs-0 font-weight-medium">
                          {{ $value['operationCode'] }}
                        </td>
                        <td class="py-2 align-middle  fs-0 font-weight-medium">
                          {{ $value['OperationLibele'] }}
                        </td>
                        <td class="py-2 align-middle  fs-0 font-weight-medium">
                          {{ $value['Operationcomt'] }}
                        </td>
                        <td>
                          <a href="#" id="{{ $value['id'] }}" 
                            class="delete">
                            <i class="far fa-trash-alt fa-2x text-danger"></i>
                          </a>
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <a href="#" id="{{ $value['id'] }}" class="updOp">
                            <i class="far far fa-edit fa-2x text-primary"></i>
                          </a>
                        </td>
                      </tr>
                     <?php }?>
                    </tbody>
                  </table>

                  <!-- Paginate -->
                  <div class="row no-gutters px-1 py-3 align-items-center justify-content-center">
                     {{ $operat->links() }}
                     <input type="hidden" id='lastPrd' 
                     value="{{ $operat->last()->id }}"> 
                  </div>


                </div>
              </div>
            </div>
          @else
          <div class="alert alert-warning">Aucun arrivage enregistré</div>
          @endif


<!-- Modal-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Opération > Mise à jour</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span class="font-weight-light" aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="ContentL"></div>

      </div>
      <div class="modal-footer">
        {{-- <button class="btn btn-danger btn-sm updVald" type="button">Valider</button> --}}
        <button class="btn btn-danger btn-sm updVald" type="button" data-dismiss="modal">
          Valider
        </button>
        <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">
          Fermer
        </button>
        
      </div>
    </div>
  </div>
</div>




{{--   <script src="{{ asset('assets/js/theme.js') }}"></script> --}}
  <script type="text/javascript">

     $(function(){
        // Faire disparaitre les paginate de Javascript
         $(".mytable").parent().next().hide();
      });

    // Ajouter une opération
    $("#Opera").on("submit",function(event){
       event.preventDefault();
       var data = $(this).serialize();
       $.ajax({
         url:'p_AddOperation',
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
             title: 'Opération',
             text:  'Opération créer avec succès',
             showConfirmButton: true,
             timer: 5000
            });  
            $("#main_content").load("/p_OpComd");
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

    // Supprimer une opération
     $('.delete').click(function(){
          var idV = $(this).attr('id');
          Swal.fire({
            title: 'Opération',
            text: "Voulez-vous supprimer cette opération ?",
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Annuler',
            confirmButtonText: 'oui , supprimer!',
            backdrop: `rgba(240,15,83,0.4)`
          }).then((result) => {
              if (result.value) {
                $.ajax({
                  url:'/p_cmdDOp',
                  method:'GET',
                  data:{idV:idV},
                  dataType:'text',
                  success:function(){
                    Swal.fire(
                     'Supprimer!',
                     'Opération supprimer avec succès',
                     'error'
                    );
                    $("#main_content").load("/p_OpComd");
                  },
                  error:function(){
                    Swal.fire('Problème de connection internet');
                  }
                });
              }
          })
     });

    // Mise à jour d'une opération
        // Modifier phase 1
          $('.updOp').click(function(){
            var idOp = $(this).attr('id');
            $.ajax({
             url:'p_OperaUpd',
             method:'GET',
             data:{idOp:idOp},
             dataType:'html',
             success:function(data){
               $(".ContentL").html(data);
               $("#exampleModal").modal('show');
             },
             error:function(){
              Swal.fire('Problème de connection internet');
             }
           });
          });

        // Modifier phase 2
          $('.updVald').click(function(){
           var libele   = $("#libele").val();
           var comment  = $(".comment").val();
           var IdOp     = $("#IdOp").val();
           $.ajax({
             url:'/p_OperaUpd2',
             method:'GET',
             data:{libele:libele,comment:comment,IdOp:IdOp},
             dataType:'html',
             success:function(){
                Swal.fire('Modifier avec succès');
                $("#refresh").click();
              },
             error:function(){Swal.fire('Problème de connection internet');}
           });
         });

    // Refresh de la page
    $("#refresh").click(function(){
      loadingScreen();
      $('#main_content').load("/p_OpComd");
    });


    //Fonction d'initialisation
    function Initform() {
      $('#nom').val('');
      $('#contact').val('');
      $('#lieu').val('');
    }
    
  </script>