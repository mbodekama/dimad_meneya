<div class="card mb-3">
  <div class="bg-holder d-none d-lg-block bg-card" 
   style="background-image:url(../assets/img/illustrations/corner-4.png);">
  </div>
  <!--/.bg-holder-->

    <div class="card-body">
      <div class="row">
        <div class="col-lg-8">
          <h3 class="mb-0 text-primary"> <i class="fas fa-cart-plus"></i> Commandes >Nouvelle</h3>
          <p class="mt-2">Mes Nouvelles commandes</p>
        </div>
      </div>
    </div>
</div>

<div class="media mb-4 mt-6">
	<span class="fa-stack mr-2 ml-n1">
		<i class="fas fa-circle fa-stack-2x text-300"></i>
		<i class="fa-inverse fa-stack-1x text-primary far fa-address-card" 
		 data-fa-transform="shrink-2"></i>
	</span>
    <div class="media-body">
     <h5 class="mb-0 text-primary position-relative"><span class="bg-200 pr-3">Gérer et suivre les commandes de vos clients</span><span class="border position-absolute absolute-vertical-center w-100 z-index--1 l-0"></span></h5>
     <p class="mb-0">Vos clients peuvent payer directement par Mobile Money, carte bancaire</p>
    </div>
</div>




       <div class="row">
        	<div class="col-lg-12 pl-lg-2 mb-3">
              <div class="row no-gutters h-100 align-items-stretch">
                <div class="col-lg-12 mb-3">
                  <div class="card h-100">
                    <div class="card-header bg-light">
                      <h5 class="mb-0"></h5>
                     {{--  <a href="#"><span class="text-danger"><i class="fas fa-trash-alt">
                      </i> Tout supprimer</span></a><br> --}}

                      <a href="#" class="refresh"><span class="text-info">
                       <i class="fas fa-retweet"></i>
                      <b>Actualiser</b></span></a> |

                      <a href="#" class="DelP"><span class="text-danger">
                       <i class="fas fa-trash mr-1"></i>
                      <b>Tout Supprimer</b></span></a> |

                      <a href="#" class="newP text-primary"><span class="">
                      <b>Total:</b></span> {{$nbt}} commandes</a>
                      <div class="row align-items-center justify-content-between">
                     <!-- Pagination -->
                     @include('pages/dash/pagnMod')
                   </div>
                    </div>

                   

                   @if(!$comd->isEmpty())
                    <div class="card-body" id="loaderContent">
                     <div class="dashboard-data-table">
                     	<table class="mytable table table-sm table-dashboard data-table no-wrap mb-0 fs--1 w-100" data-options='{"searching":true,"responsive":false,"pageLength":20,"info":false,"lengthChange":false}'>
                        <thead class="bg-200">
                          <tr>
                          	<th class="sort">Date</th>
                          	<th class="sort">Code</th>
                            <th class="sort">Nom</th>
                            <th class="sort">Lieu</th>
                            <th class="sort">Tel</th>
                            <th class="sort">Produit</th>
                            <th class="sort">Statut</th>
                            <th class="sort">Actions</th>
                          </tr>
                        </thead>

                        <tbody class="bg-white">
                         @foreach ($comd as $value)
                          <tr>
                            <td>{{$value->dateCmd}}</td>
                            <td>{{$value->code}}</td>
                            <td>{{$value->nom}}</td>
                            <td>{{$value->lieu}}</td>
                            <td>{{$value->tel}}</td>
                            <td>{{$value->titre}}</td>
                            <td>
                             @if($value->statut !=0)	
                            	<span class="badge badge-pill badge-success">soldé</span>
                             @else
                               <span class="badge badge-pill badge-danger">non soldé</span>
                             @endif
                            </td>
                            <td>
                              
                              <button class="btn btn-falcon-default btn-sm mr-1 mb-1 text-success besoins" type="button"
                              id="{{$value->InterID}}" sms="{{$value->SMSID}}">
                               <span class="far fa-eye mr-1" 
                               data-fa-transform="shrink-3">
                               </span>Détails
                              </button>

                              <button class="btn btn-falcon-default btn-sm mr-1 mb-1 text-info upd" type="button" 
                               id="{{$value->InterID}}" sms="{{$value->SMSID}}">
                               <span class="far fa-calendar-check mr-1" 
                               data-fa-transform="shrink-3"></span>Livrer
                              </button>

                              <button class="btn btn-falcon-default btn-sm mr-1 mb-1 text-danger del" type="button" 
                              id="{{$value->InterID}}" sms="{{$value->SMSID}}">
                               <span class="fas fa-trash mr-1" 
                               data-fa-transform="shrink-3"></span>Supprimer
                              </button>
                            </td>
                          </tr>
                         @endforeach
                    	  </tbody>
                      </table>

                      <!-- Paginate -->
                      <div class="row no-gutters px-1 py-3 align-items-center justify-content-center">
                        {{ $comd->links() }}
                        <input type="hidden" id='lastPrd' 
                         value="{{ $comd->last()->id }}"> 
                      </div>  

                     </div>
                    </div>
                   @else
                     <div class="alert alert-warning">Aucune nouvelle commande enregistrée
                     </div>
                   @endif
                  </div>
                </div>
              </div>
            </div>
        </div>



<!-- Modal pour Besoins -->
<div class="modal fade" id="BesoinModal" tabindex="-1" role="dialog" 
 aria-labelledby="BesoinModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="BesoinModal">Commande > Détails</h5>
        <button class="close" type="button" data-dismiss="modal" 
         aria-label="Close"><span class="font-weight-light" aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="BesP">
        	
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary btn-sm ferm" type="button" 
          data-dismiss="modal">
          Fermer
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Modal SMS Marketing -->
<div class="modal fade" id="SMSModal" tabindex="-1" 
     aria-labelledby="SMSModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="SMSModalLabel">Prospects > SMS Markeing</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <span class="text-success"><i class="fas fa-bullhorn"></i> Attirer des nouveaux clients</span><br>
          
          <input type="hidden" name="Idpros" id="Idpros">

          {{-- <div class="form-group">
            <label for="basic-example">SENDER</label>
            <select class="selectpicker senderID" id="senderID">
              <option value="{{$sender}}">{{$sender}}</option>
            </select>
          </div> --}}

          <div class="form-group">
            <label for="smsP">Messages</label>
              <textarea class="form-control msgP" id="smsP" 
               rows="3"  onkeyup="count_up(this);"></textarea>
              <p class="text-danger mb-1" style="font-size:15px;">
              Caractères: <span id="compteur">0</span> | SMS: <span id="NbSMS">0</span></p>
              <p class="" style="font-size:12px;">NB: 1 SMS fait 160 caractères</p>
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary sendSMS">Envoyez
          <i class="far fa-paper-plane"></i>
        </button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer
        </button>
      </div>
    </div>
  </div>
</div>




{{--  <script src="{{ asset('assets/js/theme.js') }}"></script> --}}
<script type="text/javascript">
  $(function(){
    // Faire disparaitre les paginate de Javascript
     $(".mytable").parent().next().hide();
  });

  // Fonction de comptage
   function count_up(obj){
     document.getElementById('compteur').innerHTML = obj.value.length;
      var sms = $("#compteur").text();
      var nbS = parseInt(sms)/160;
      $("#NbSMS").text(parseInt(nbS));
   }


  
  // Initialisation du formulaire
   function InitForm(){
    $('#senderID').val("");
    $("#smsP").val("");
   }
  
  // Nombre de caractères
     function KeyPress()
     {
        total = document.getElementById("smsP").value.length+1;
        document.getElementById("compteur").innerHTML = total; 
     }

  // Besoins propsects

    /* Liste des besoins */
     $(".besoins").click(function(){
      var idInters = $(this).attr("id");
      var SMSID    = $(this).attr("sms"); 
      $.ajax({
       url:'comdShow',
       method:'GET',
       data:{idInters:idInters,SMSID:SMSID},
       dataType:'text',
       success:function(data){
         $(".BesP").html(data);
         $("#BesoinModal").modal("show");
       },
       error:function(){
         Swal.fire('Problème de connection internet');
       }
     });
    
     });
    
   
    /* Initialiser */
     $(".NOBs").click(function(){
       $("#besoinsN").val("");
     });

  // Nouveau prospect
   $(".newP").click(function(){
     $("#main_content").load("/p_prospNew");
   });

  // SMS Marketing
    $(".SMS").click(function(){
      $("#SMSModal").modal("show");
      var ID = $(this).attr("id");
      $("#Idpros").val(ID);
    });


  // Modification phase 1
   $(".upd").click(function(){
     var idInters = $(this).attr("id");
     var SMSID    = $(this).attr("sms"); 
     Swal.fire({
      title: 'Commandes',
      text: "Voulez-vous livrer cette commande ?",
      icon: 'error',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Annuler',
      confirmButtonText: 'oui , livrer!',
      backdrop: `rgba(240,15,83,0.4)`
     }).then((result) => {
      if (result.value) {
        $.ajax({
          url:'/ComdLiv',
          method:'GET',
          data:{idInters:idInters,SMSID:SMSID},
          dataType:'text',
          success:function(data){
            $("#main_content").load("/CommdNew");
            Swal.fire(data);
          },
          error:function(data){
            Swal.fire(data);
          }
        });
      }
     })
   });
 
    // Modification phase 2
     $('.updVald').click(function(){
     var id        = $("#IdOp").val();
     var nom       = $("#nom").val();
     var phone     = $("#phone").val();
     var email     = $("#email").val();
     $.ajax({
       url:'prosUp',
       method:'GET',
       data:{nom:nom,phone:phone,email:email,IdP:id},
       dataType:'html',
       success:function(datas){
         Swal.fire('Modifié avec succès');
         $(".ferm").click();
         $(".refresh").click();
       },
       error:function(){
        console.log("error");
       }
      });
     });

  // Refresh
   $(".refresh").click(function(){
     $("#main_content").load("/CommdNew");
   });

  // Suppression
   $(".del").click(function(){
     var idInters = $(this).attr("id");
     var SMSID    = $(this).attr("sms"); 
     console.log("inters:"+idInters+"SMSID:"+SMSID);
     Swal.fire({
      title: 'Commandes',
      text: "Voulez-vous supprimer cette commande ?",
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
          url:'/ComdDel',
          method:'GET',
          data:{idInters:idInters,SMSID:SMSID},
          dataType:'text',
          success:function(data){
            $("#main_content").load("/CommdNew");
            Swal.fire(data);
          },
          error:function(data){
            Swal.fire(data);
          }
        });
      }
     })
   });

  // Suppression globale
  $('.DelP').click(function(){
      var all = "new";
      Swal.fire({
       title: 'Commandes',
       text: "Voulez-vous supprimer toutes les commandes?",
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
             url:'/p_DelCdAll',
             method:'GET',
             data:{action:all},
             dataType:'text',
             success:function(data){
               $("#main_content").load("/CommdNew");
               Swal.fire(data);
             },
             error:function(data){
               Swal.fire(data);
             }
            });
         }
      })
  });

</script>
