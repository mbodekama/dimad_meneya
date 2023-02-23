<div class="card mb-3">
  <div class="bg-holder d-none d-lg-block bg-card" 
   style="background-image:url(../assets/img/illustrations/corner-4.png);">
  </div>
  <!--/.bg-holder-->

    <div class="card-body">
      <div class="row">
        <div class="col-lg-8">
          <h3 class="mb-0 text-primary"> <i class="fas fa-grin-stars"></i> Propsects >Besoins</h3>
          <p class="mt-2">Historique des besoin de vos prospects</p>
        </div>
      </div>
    </div>
</div>

<div class="media mb-4 mt-6">
	<span class="fa-stack mr-2 ml-n1">
		<i class="fas fa-circle fa-stack-2x text-300"></i>
		<i class="fa-inverse fa-stack-1x text-primary fas fa-gifts" 
		 data-fa-transform="shrink-2"></i>
	</span>
    <div class="media-body">
     <h5 class="mb-0 text-primary position-relative"><span class="bg-200 pr-3">Besoins des prospects</span><span class="border position-absolute absolute-vertical-center w-100 z-index--1 l-0"></span></h5>
     <p class="mb-0">Un prospect est une personne qui cherche un produit spécifique. Il est prêt à l'acheter</p>
    </div>
</div>
        <div class="row">
        	<div class="col-lg-12 pl-lg-2 mb-3">
              <div class="row no-gutters h-100 align-items-stretch">
                <div class="col-lg-12 mb-3">
                  <div class="card h-100">
                    <div class="card-header bg-light">
                      <h5 class="mb-0">Produits</h5>
                    </div>
                    <div class="card-body">
                      <form class="form-validation">
                        <div class="form-group">
                          <label for="wizard-datepicker">Nom</label>
                          <input class="form-control" type="text" id="besoinsN" />
                        </div>
                      </form>
                      <div class="d-flex justify-content-end">
                        <button class="btn btn-primary" id="addBs">Enregistrer ></button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>

        <div class="row">
        	<div class="col-lg-12 pl-lg-2 mb-3">
              <div class="row no-gutters h-100 align-items-stretch">
                <div class="col-lg-12 mb-3">
                  <div class="card h-100">
                    <div class="card-header bg-light">
                      <h5 class="mb-0">Produits demandés</h5>
                      <a href="#" class="supBes"><span class="text-danger">
                        <i class="fas fa-trash-alt"></i> Tout supprimer</span>
                      </a>|
                      <a href="#" class="refresh"><span class="text-info">
                       <i class="fas fa-retweet"></i>
                      <b>Actualiser</b></span>
                      </a> 

                      <div class="row align-items-center justify-content-between">
                       <!-- Pagination -->
                       @include('pages/dash/pagnMod')
                     </div>
                    </div>

                     
                    @if(!$BespL->isEmpty())
                     <div class="card-body">
                      <table class="table table-sm table-dashboard data-table no-wrap mb-0 fs--1 w-100" data-options='{"searching":true,"responsive":false,"pageLength":20,"info":false,"lengthChange":false,"}'>
                        <thead class="bg-200">
                          <tr>
                            <th class="sort">N°</th>
                            <th class="sort">Nom</th>
                            <th class="sort">Action</th>
                          </tr>
                        </thead>
                        <tbody class="bg-white">
                         @foreach ($BespL as $value)
                          <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$value->nom}}</td>
                            <td>

                              <button class="btn btn-falcon-default btn-sm mr-1 mb-1 text-info upd" type="button" id="{{$value->id}}">
                               <span class="far fa-edit mr-1" 
                                data-fa-transform="shrink-3"></span>Modifier
                              </button>

                              <button class="btn btn-falcon-default btn-sm mr-1 mb-1 text-danger del" type="button" 
                              id="{{$value->id}}">
                               <span class="fas fa-trash mr-1" 
                               data-fa-transform="shrink-3"></span>Supprimer
                              </button>

                            </td>
                          </tr>
                         @endforeach
                        </tbody>
 					           </div>
                    @else
                    <div class="alert alert-warning">Aucun besoins enregistré
                    </div>
                    @endif
                  </div>
                </div>
              </div>
            </div>
        </div>


<!-- Modal Pour Modification -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Besoins > Mise à jour</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span class="font-weight-light" aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="ContentL">
          
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-danger btn-sm updVald" type="button">Valider</button>
        <button class="btn btn-secondary btn-sm ferm" type="button" data-dismiss="modal">
          Fermer
        </button>
      </div>
    </div>
  </div>
</div>

{{-- <script src="{{ asset('assets/js/theme.js') }}"></script> --}}
<script type="text/javascript">
    // Suppression
    $(".del").click(function(){
     var id = $(this).attr("id");
     console.log(id);
     Swal.fire({
      title: 'Besoins prospects',
      text: "Voulez-vous supprimer ce produits ?",
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
          url:'/p_DelPB',
          method:'GET',
          data:{idP:id},
          dataType:'text',
          success:function(){
            $("#main_content").load("/p_prospbesoin");
          },
          error:function(){
            Swal.fire('Problème de connection internet');
          }
        });
      }
     })
    });

    // Suppression totale
    $(".supBes").click(function(){
       var Allbes = 'all';
       Swal.fire({
         title: 'Besoins prospects',
         text: "Voulez-vous supprimer ce produits ?",
         icon: 'error',
         showCancelButton: true,
         confirmButtonColor: '#3085d6',
         cancelButtonColor: '#d33',
         cancelButtonText: 'Annuler',
         confirmButtonText: 'oui , supprimer!',
         backdrop: `rgba(240,15,83,0.4)`
       }).then((result)=>{
         if (result.value) {
            $.ajax({
             url:'/p_DelBesAll',
             method:'GET',
             data:{action:Allbes},
             dataType:'text',
             success:function(){
               $("#main_content").load("/p_prospbesoin");
             },
             error:function(){
               Swal.fire('Problème de connection internet');
             }
            });
         }
       })
    });

    // Modification
    $(".upd").click(function(){
     var id = $(this).attr("id");
     $.ajax({
      url:'p_PrUpdB',
      method:'GET',
      data:{idp:id},
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

    // Modification phase 2
     $('.updVald').click(function(){
       var nom = $("#nom").val();
       var IdP = $("#IdOp").val();
       $.ajax({
         url:'prosBUp',
         method:'GET',
         data:{nom:nom,IdP:IdP},
         dataType:'html',
         success:function(){
           Swal.fire('Modifié avec succès');
           $(".ferm").click();
           $(".refresh").click();
          },
         error:function(){
           console.log("error");
         }
      });
     });

    // Nouveau besoins
     $("#addBs").click(function(){
        var besN  = $("#besoinsN").val();
        console.log('besN:'+besN);
        if(besN!=''){
           $.ajax({
             url:'p_besAdd',
             method:'get',
             data:{besN:besN},
             dataType:'html',
             success:function(){
               Swal.fire('Besoins enregistré avec succès');
               $(".refresh").click();
             },
             error:function(){
               console.log('error');
             }
           });
        }else{
          Swal.fire('Veuillez saisir le besoin');
        }

     });
    
    // Refresh
     $(".refresh").click(function(){
       $("#main_content").load("/p_prospbesoin");
     });
</script>          