<div class="card mb-3">
  <div class="bg-holder d-none d-lg-block bg-card" 
   style="background-image:url(../assets/img/illustrations/corner-4.png);">
  </div>
  <!--/.bg-holder-->

    <div class="card-body">
      <div class="row">
        <div class="col-lg-8">
          <h3 class="mb-0 text-primary"> <i class="fas fa-grin-stars"></i> Propsects >Liste</h3>
          <p class="mt-2">Historique des vos prospects</p>
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
     <h5 class="mb-0 text-primary position-relative"><span class="bg-200 pr-3">Informations sur vos prospects</span><span class="border position-absolute absolute-vertical-center w-100 z-index--1 l-0"></span></h5>
     <p class="mb-0">Qui détient des données, a une mine d'or</p>
    </div>
</div>




       <div class="row">
        	<div class="col-lg-12 pl-lg-2 mb-3">
              <div class="row no-gutters h-100 align-items-stretch">
                <div class="col-lg-12 mb-3">
                  <div class="card h-100">
                    <div class="card-header bg-light">
                      <h5 class="mb-0">Historique</h5>
                     {{--  <a href="#"><span class="text-danger"><i class="fas fa-trash-alt">
                      </i> Tout supprimer</span></a><br> --}}

                      <a href="#" class="refresh"><span class="text-info">
                       <i class="fas fa-retweet"></i>
                      <b>Actualiser</b></span></a> |

                      <a href="#" class="newP"><span class="text-success">
                       <i class="fas fa-plus"></i>
                      <b>Nouveau</b></span></a> |

                      <a href="#" class="DelP"><span class="text-danger">
                       <i class="fas fa-trash mr-1"></i>
                      <b>Tout Supprimer</b></span></a> |

                      <a href="#" class="newP text-primary"><span class="">
                      <b>Total:</b></span> {{$nb}} prospects</a>

                    </div>

                    <div class="card-body">

                     <div class="row align-items-center justify-content-between">
                      <!-- Pagination -->
                       @include('pages/dash/pagnMod')
                     </div>
                    @if(!$prospL->isEmpty())
                     <div class="dashboard-data-table" 
                     id="loaderContent">
                     	<table class="mytable table table-sm table-dashboard data-table no-wrap mb-0 fs--1 w-100" data-options='{"searching":true,"responsive":false,"pageLength":20,"info":false,"lengthChange":false}'>
                        <thead class="bg-200">
                          <tr>
                            <th class="sort">N°</th>
                            <th class="sort">Nom</th>
                            <th class="sort">Tel</th>
                            <th class="sort">Email</th>
                            <th class="sort">Date</th>
                            <th class="sort">Actions</th>
                          </tr>
                        </thead>

                        <tbody class="bg-white">
                         @foreach ($prospL as $value)
                          <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$value->nom}}</td>
                            <td>{{$value->contact}}</td>
                            <td>{{$value->mail}}</td>
                            <td>{{$value->date}}</td>
                            <td>
                              <button class="btn btn-falcon-default btn-sm mr-1 mb-1 text-primary SMS" type="button" 
                              id="{{$value->id}}">
                               <span class="fas fa-sms mr-1" 
                               data-fa-transform="shrink-3"></span>SMS marketing
                              </button>

                              <button class="btn btn-falcon-default btn-sm mr-1 mb-1 text-success besoins" type="button"
                              nom="{{$value->nom}}"
                              id="{{$value->id}}">
                               <span class="fas fa-award mr-1" 
                               data-fa-transform="shrink-3"></span>Besoins
                              </button>

                              <button class="btn btn-falcon-default btn-sm mr-1 mb-1 text-info upd" type="button" 
                               id="{{$value->id}}">
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
                      </table>

                      <!-- Pagination -->
                      <div class="row no-gutters px-1 py-3 align-items-center justify-content-center">
                         {{ $prospL->links() }}
                        <input type="hidden" id='lastPrd' 
                        value="{{ $prospL->last()->id}}">
                      </div>

                     </div>
                     @else
                        <div class="alert alert-warning">Aucun prospect enregistré</div>
                     @endif
                    </div>
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
        <h5 class="modal-title" id="exampleModalLabel">Prospects > Mise à jour</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span class="font-weight-light" aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="ContentL">
          
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-danger btn-sm updVald" type="button">Valider</button>
        <input type="hidden" class="prosp">
        <button class="btn btn-secondary btn-sm ferm" type="button" data-dismiss="modal">
          Fermer
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Modal de besoins -->
<div class="modal modal-fixed-right fade" id="exampleModalRight" tabindex="-1" role="dialog" aria-labelledby="exampleModalRightLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-vertical" role="document">
    <div class="modal-content border-0 min-vh-100">
      
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalRightLabel">
          Prospect> <b><span class="text-warning nm"></span></b>
        </h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span class="font-weight-light" aria-hidden="true">&times;</span></button>
      </div>

      <div class="modal-body py-5 text-center">
        <span class="text-danger"><b>Nouvelle demande</b></span><br>
        
        <div class="form-group">
          <label for="BesAnc">Besoins existant</label>
            <select class="selectpicker besE" id="BesAnc">
                  <option value='no'>Aucun</option>
                @foreach($BesExs as $BesEx)
                  <option value="{{$BesEx->id}}">{{$BesEx->nom}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
          <label for="besoinsN">Besoins nouveaux</label>
          <input class="form-control" id="besoinsN" type="text" placeholder="">
        </div>
        <button class="btn btn-falcon-info mr-1 mb-1 addBs" type="button">
         Ajouter
        </button>
        <button class="btn btn-falcon-danger mr-1 mb-1 NOBs" type="button">
         Annuler
        </button><hr>
        <input type="hidden" class="prosptId">

        <div>
          <label class="text-danger"><b>Demande du prospect</b></label>
          <div id="BesP"></div>
         
        </div>

        

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

          <div class="form-group">
            <label for="basic-example">SENDER</label>
            <select class="selectpicker senderID" id="senderID">
              <option value="{{$sender}}">{{$sender}}</option>
            </select>
          </div>

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
        <div class="spinner-border lod" role="status"><span class="sr-only">Loading...</span></div>
        <button type="button" class="btn btn-primary sendSMS">
          Envoyez
          <i class="far fa-paper-plane"></i>
        </button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer
        </button>
      </div>
    </div>
  </div>
</div>




{{-- <script src="{{ asset('assets/js/theme.js') }}"></script> --}}
<script type="text/javascript">
 $(function(){
    $(".lod").hide();
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
      var id = $(this).attr("id");
      var nom = $(this).attr('nom');
      $('.prosptId').val(id);
      console.log(nom);
      $.ajax({
       url:'p_PrBes',
       method:'GET',
       data:{idp:id},
       dataType:'html',
       success:function(data){
         $('.nm').html(nom);
         $("#BesP").html(data);
         $("#exampleModalRight").modal("show");
       },
       error:function(){
         Swal.fire('Problème de connection internet');
       }
      });
    
    });
    
    /* Nouveau besoins*/
     $(".addBs").click(function(){
        var besN  = $("#besoinsN").val();
        var besAc = $("select.besE").children("option:selected").val();
        var Idpro = $(".prosptId").val();
        console.log('besN:'+besN);
        console.log('besAc:'+besAc);
        console.log('IdP:'+Idpro);
        if(besN=='' && besAc=='no'){
           Swal.fire('Veuillez attribuer un besoins');
        }
        else if(besN!='' && besAc!='no'){
          Swal.fire('Veuillez sélectionner un besoin existant ou remplir le champ pour un nouveau besoin');
        }else{
           $.ajax({
             url:'p_besoL',
             method:'get',
             data:{besN:besN,besAc:besAc,Idpro:Idpro},
             dataType:'html',
             success:function(data){
               $('#BesP').html(data);
             },
             error:function(){
               console.log('error');
             }
           });
        }
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

    $(".sendSMS").click(function(){
      $(".lod").show();
      var IPros  = $("#Idpros").val();
      var msg    = $("#smsP").val();
      var SendID = $("select.senderID").children("option:selected").val();
      console.log("IPros:"+IPros+" msg:"+msg+" SendID: "+SendID);
      if (msg!=""){
        $.ajax({
         url:"ProsSMS",
         method:"get",
         data:{IPros:IPros,msg:msg,SendID:SendID},
         dataType:'json',
         success:function(data){
         
           if (data.success==1) 
           {
             Swal.fire(
               'Message envoyé !',
               'Le prospect a bien reçu le sms',
               'success'
             );
             $(".lod").hide();
           }
           else
           {
          
              Swal.fire(
               'Message echoué !',
                data.error,
               'error'
              )
             $(".lod").hide();
           }
           $("#smsP").val('');
         },
         error:function(data)
         {
           console.log(data);
           Swal.fire('Envoie de SMS echoué');
           $(".lod").hide();
         }
        });
      }
      else
      {
        Swal.fire('Veuillez saisir le message');
        $(".lod").hide();
      }
    });

  // Modification phase 1
   $(".upd").click(function(){
     var id = $(this).attr("id");
     $.ajax({
      url:'p_PrUpd',
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
     $("#main_content").load("/p_prospL");
   });

  // Suppression
   $(".del").click(function(){
     var id = $(this).attr("id");
     console.log(id);
     Swal.fire({
      title: 'Prospects',
      text: "Voulez-vous supprimer ce prospect ?",
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
          url:'/p_DelP',
          method:'GET',
          data:{idP:id},
          dataType:'text',
          success:function(){
            $("#main_content").load("/p_prospL");
          },
          error:function(){
            Swal.fire('Problème de connection internet');
          }
        });
      }
     })
   });

  // Suppression globale
  $('.DelP').click(function(){
      var all = "tous";
      Swal.fire({
       title: 'Prospects',
       text: "Voulez-vous supprimer tous les prospects ?",
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
             url:'/p_DelPAll',
             method:'GET',
             data:{action:all},
             dataType:'text',
             success:function(){
               $("#main_content").load("/p_prospL");
             },
             error:function(){
               Swal.fire('Problème de connection internet');
             }
            });
         }
      })
  });

</script>
