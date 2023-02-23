
<div class="card mb-3">
            <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url(../assets/img/illustrations/corner-4.png);">
            </div>
            <!--/.bg-holder-->

            <div class="card-body">
              <div class="row">
                <div class="col-lg-8">
                  <h4 class="mb-0 text-primary"> <i class="fas fa-users"></i>    Utlisateurs et Droits d'accès
                  </h4>
                </div>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header">
              <div class="row align-items-center justify-content-between">

                <div id="mytoken">
                  @csrf
                </div>
                @include('pages/dash/pagnMod')
                <div class="col-8 col-sm-auto text-right pl-2">
                  <div id="customer-table-actions">
                    <button class="btn btn-falcon-default btn-sm" type="button" id="btnAdd">
                      <span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span>
                      <span class="d-none d-sm-inline-block ml-1">Nouveau</span>
                    </button>
                    <button class="btn btn-falcon-danger btn-sm" type="button" id="btnAdd">
                      
                      <span class=" d-sm-inline-block ml-1 btnAllAccess">Demettre les accès</span>
                      <i class="fas fa-lock-open text-danger"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body p-0" id="loaderContent">
              <div class="falcon-data-table">
                <table class="mytable table table-sm mb-0 table-striped table-dashboard fs--1 data-table border-bottom border-200" data-options='{"searching":true,"responsive":false,"pageLength":100,"info":false,"lengthChange":false,"sWrapper":"falcon-data-table-wrapper","dom":"<&#39;row mx-1&#39;<&#39;col-sm-12 col-md-6&#39;l><&#39;col-sm-12 col-md-6&#39;f>><&#39;table-responsive&#39;tr><&#39;row no-gutters px-1 py-3 align-items-center justify-content-center&#39;<&#39;col-auto&#39;p>>","language":{"paginate":{"next":"<span class=\"fas fa-chevron-right\"></span>","previous":"<span class=\"fas fa-chevron-left\"></span>"}}}'>
                  <thead class="bg-200 text-900">
                    <tr>
                      <th class="align-middle no-sort pr-3">
                        <div class="custom-control custom-checkbox">
                          <input class="custom-control-input checkbox-bulk-select" id="checkbox-bulk-customers-select" type="checkbox" data-checkbox-body="#customers" data-checkbox-actions="#customers-actions" data-checkbox-replaced-element="#customer-table-actions" />
                          <label class="custom-control-label" for="checkbox-bulk-customers-select"></label>
                        </div>
                      </th>
                      <th class="align-middle sort">Nom</th>
                      <th class="align-middle sort">Email</th>
                      <th class="align-middle sort">Contact</th>
                      <th class="align-middle sort ">Rôle</th>
                      <th class="align-middle sort ">Autorisation</th>
                      <th class="align-middle ">Actions</th>
                      {{-- <th class="align-middle no-sort"></th> --}}
                    </tr>
                  </thead>
                  <tbody id="customers">
                    @foreach($users as $user)
                    <tr class="btn-reveal-trigger">
                      <td class="py-2 align-middle white-space-nowrap">
                        <div class="custom-control custom-checkbox">
                          <input class="custom-control-input checkbox-bulk-select-target" type="checkbox" id="customer-checkbox-0" />
                          <label class="custom-control-label" for="customer-checkbox-0"></label>
                        </div>
                      </td>
                      <td class="py-2 align-middle white-space-nowrap customer-name-column"><a href="../pages/customer-details.html">
                          <div class="media d-flex align-items-center">
                            <div class="media-body">
                              <h5 class="mb-0 fs--1">{{ $user->name }}</h5>
                            </div>
                          </div>
                        </a>
                      </td>
                      <td class="py-2 align-middle white-space-nowrap ">
                        {{ $user->email}}
                      </td>
                      <td class="py-2 align-middle white-space-nowrap">
                       {{ $user->contact}}
                      </td>
                      <td class="py-2 align-middle white-space-nowrap">
                        {{ getUserRole($user->id)->libelle }}
                      </td>
                      <td class="py-2 align-middle white-space-nowrap"> 
                          <button 
                          type="button" id="{{  $user->id }}"
                          @if(getUserRole($user->id)->roleId ==1 )
                          class="btn btn-primary mr-1 mb-1 btnAcces" 
                            data-toggle="modal" data-target="#modalAccess"
                            data-backdrop="static" data-keyboard="false"
                          @else
                          class="btn btn-info mr-1 mb-1 btnAcessOff" 
                          @endif
                            acces1 = "{{ hasStatAccesto($user->id,1) }}"
                            acces2 = "{{ hasStatAccesto($user->id,2) }}"
                            acces3 = "{{ hasStatAccesto($user->id,3) }}"
                            acces4 = "{{ hasStatAccesto($user->id,4) }}"
                            acces5 = "{{ hasStatAccesto($user->id,5) }}"
                            acces6 = "{{ hasStatAccesto($user->id,6) }}"
                            acces7 = "{{ hasStatAccesto($user->id,7) }}"
                            acces8 = "{{ hasStatAccesto($user->id,8) }}"
                            acces9 = "{{ hasStatAccesto($user->id,9) }}"
                            idUser = "{{  $user->id }}"

                            > Accès
                             <i class="fas fa-user-lock text-danger"></i>
                          </button>                      
                      </td>
                      <td class="align-middle white-space-nowrap">
                              <button class="btn btn-falcon-default btn-sm btnEdit" id="{{  $user->id }}" type="button" data-toggle="modal" data-target="#modalUser"
                                name="{{ $user->name }}"
                                email="{{ $user->email }}"
                                gerant= "{{ getUserRole($user->id)->roleId }}"
                                contact="{{ $user->contact }}"
                                password= "{{ $user->localite }}" 
                                >
                                  <span class="far fa-edit fa-2x text-warning" data-fa-transform="shrink-3 down-2"></span>
                                  
                                </button>
                                <button class="btn btn-falcon-default btn-sm btnDel" id="{{ $user->id }}" isAdminSuc="{{ isAdminSuc($user->id) }}" type="button">
                                  <span class="far fa-trash-alt  text-danger fa-2x" data-fa-transform="shrink-3 down-2"></span>
                                </button>
                                

                      </td>
                    </tr>

                    @endforeach
                  </tbody>
                </table>
                <div class="row no-gutters px-1 py-3 align-items-center justify-content-center">
                       {{ $users->links() }}
                   </div>
              </div>
            </div>
          </div>
    


    <!-- ===============================================-->
          <!--    Modal MODIF USER -->
    <!-- ===============================================-->
          <div class="modal fade" id="modalUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Modification Utilisateur</h5>
                  <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span class="font-weight-light" aria-hidden="true">&times;</span></button>
                </div>

                    @include('pages/principale/rh/formEmpl')

                <div class="modal-footer ">
                  <button class="btn btn-secondary btn-sm modalUserCls" type="button" data-dismiss="modal">Fermer</button>

                </div>
              </div>
            </div>
          </div>


    <!-- ===============================================-->
          <!--    Modal AUTORISATION-->
    <!-- ===============================================-->
          <div class="modal fade" id="modalAccess" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Accès de l'utilisateur</h5>
                  <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span class="font-weight-light" aria-hidden="true">&times;</span></button>
                </div>
                <form class="card-body" id="formAcces">
                  @csrf
                  <input type="hidden" name="user_id" id="user_id">
                  <table class="table  fs--1 mb-0">
                    <tbody>
                      @foreach($access as $acces)
                        <tr class="border-bottom">
                          <th class="pl-0">{{ $acces->libelle }}
                            <div class="text-400 font-weight-normal fs--2">
                              {{ $acces->description }}
                            </div>
                          </th>
                          <th class="pr-0 text-right">
                            <div class="custom-control custom-switch">
                            <input class="custom-control-input" 
                            id="{{ 'accessSwitch'.$acces->id }}" 
                            type="checkbox" 
                             name="{{ 'accessSwitch'.$acces->id }}">
                            <label class="custom-control-label" for="{{ 'accessSwitch'.$acces->id }}">Activé</label>
                          </div>
                          </th>
                        </tr>
                      @endforeach
                  </tbody>
                  </table>
                </form>

                <div class="modal-footer ">
                  <button class="btn btn-secondary btn-sm modalAccessCls" type="button" data-dismiss="modal">Fermer</button>
                  <button class="btn btn-primary btn-sm" id="updAcces" type="button">Sauvergardé</button>
                </div>
              </div>
            </div>
          </div>




          <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->



    <script type="text/javascript">
      $(function()
      {

        // Faire disparaitre les paginate de Javascript
          $(".mytable").parent().next().hide();

        //Acces gerant succu
        $('.btnAcessOff').click(function()
        {
                Swal.fire({
                  title: 'Gérant Succursale!',
                  text: 'Cet utilisateur n\'à que les droits d\'accès de succursales',
                  icon: 'info',
                  confirmButtonColor: '#3085d6',
                  confirmButtonText: 'Ok,compris',
                   backdrop: `rgba(237, 242, 249, 0.6)`
                })
        })
        //Acces des ADMINISTRATEURS 
          $('.btnAcces').click(function()
          {
            $('#user_id').val($(this).attr('idUser')); //Affectation idUser
            //Recup valeur 
              var acces1 = $(this).attr('acces1');
              var acces2 = $(this).attr('acces2');
              var acces3 = $(this).attr('acces3');
              var acces4 = $(this).attr('acces4');
              var acces5 = $(this).attr('acces5');
              var acces6 = $(this).attr('acces6');
              var acces7 = $(this).attr('acces7');
              var acces8 = $(this).attr('acces8');
              var acces9 = $(this).attr('acces9');

            //Rends les switchBtn (acces) actif ou pas
              checkOrNo(acces1,$('#accessSwitch1'));
              checkOrNo(acces2,$('#accessSwitch2'));
              checkOrNo(acces3,$('#accessSwitch3'));
              checkOrNo(acces4,$('#accessSwitch4'));
              checkOrNo(acces5,$('#accessSwitch5'));
              checkOrNo(acces6,$('#accessSwitch6'));
              checkOrNo(acces7,$('#accessSwitch7'));
              checkOrNo(acces8,$('#accessSwitch8'));
              checkOrNo(acces9,$('#accessSwitch9'));

          }) 

        //Verif stat and check or uncheck
          function checkOrNo(acces,switchBtn)
          {
            if(acces == "1")
            {
              switchBtn.prop('checked',true);
            }
            else
            {
              switchBtn.prop('checked',false);
            }
          }
        
        //Au clic de UpdAcess
          $('#updAcces').click(function()
          {
            ajaxUpdAcces();

          })
        //Demettre tous les accès 
        $('.btnAllAccess').click(function()
        {
          ajaxDelAllAcces();
        })

        //supression
          $('.btnDel').click(function()
          {
            var isAdminSuc= $(this).attr('isAdminSuc');
            var idEmpl= $(this).attr('id');
            if(isAdminSuc == "1")
            {
              toastr.error("Cet utilisateur est un gerant de succursale ou Super Admin. Veuillez le démettre avant de le suprimé");
            }
            else
            {
              ajaxDelEmpl(idEmpl);
            }
          });

        //Edition 
          $('.btnEdit').click(function()
          {
            //Affectation user id au input hidden
              var idEmpl= $(this).attr('id');
              $('#idUser').val(idEmpl);
              $('#name').val( $(this).attr('name'));
              $('#email').val( $(this).attr('email'));
              $('#gerant').val( $(this).attr('gerant'));
              $('#contact').val( $(this).attr('contact'));
              $('#password').val( $(this).attr('password'));
              $('#passwordConf').val( $(this).attr('password'));

          });

        //Add User
          $('#btnAdd').click(function()
          {
              $("#main_content").load("mbo/addEmpl");

          });

      //Supression Empl
        function ajaxDelEmpl(idEmpl)
        {


                Swal.fire({
                  title: 'Suppression',
                  text: "Cette action est irréversible ! Cliquez oui pour continuer.",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#d33',
                  cancelButtonColor: '#3085d6',
                  cancelButtonText: 'Annuler',
                  confirmButtonText: 'oui , Supprimer!',
                   backdrop: `rgba(240,15,83,0.4)`
                }).then((result) => {
                    if (result.value) {
                      $.ajax({
                        url:'mbo/ajaxDelEmpl',
                        method:'GET',
                        data:{idEmpl:idEmpl},
                        dataType:'json',
                        success:function(){
                          Swal.fire(
                           'Supression!',
                           'Supression fait avec succès',
                           'success'
                          );
                          $("#main_content").load("mbo/listEmpl");
                        },
                        error:function(){
                          Swal.fire('Problème de connexion internet');
                        }
                      });
                    }
                })
        
        }

      //Mis a jour des access
        function ajaxUpdAcces(idEmpl)
        {
                Swal.fire({
                  title: 'Modification',
                  text: "Voulez vous valider les modifications",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#d33',
                  cancelButtonColor: '#3085d6',
                  cancelButtonText: 'Annuler',
                  confirmButtonText: 'oui , Valider!',
                   backdrop: `rgba(240,15,83,0.4)`
                }).then((result) => {
                    if (result.value) {
                      $.ajax({
                        url:'mbo/updAcces',
                        method:'POST',
                        data:$('#formAcces').serialize(),
                        dataType:'json',
                        success:function(){
                          $('.modalAccessCls').click();
                          Swal.fire(
                           'Enregistrement!',
                           'Opération fait avec succès',
                           'success'
                          );

                          $("#main_content").load("mbo/listEmpl");
                          // $("#myNav").load("mbo/refreshNav");
                        },
                        error:function(){
                          Swal.fire('Problème de connexion internet');
                        }
                      });
                    }
                })
        
        }


      //Supression de tous des access
        function ajaxDelAllAcces()
        {
                Swal.fire({
                  title: 'URGENT !!!',
                  text: "La validation de cette action vas démettre tous les droits d'accès de tous vos utilisateurs sauf le super Administrateur",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#d33',
                  cancelButtonColor: '#3085d6',
                  cancelButtonText: 'Annuler',
                  confirmButtonText: 'oui , Valider!',
                   backdrop: `rgba(240,15,83,0.4)`
                }).then((result) => {
                    if (result.value) {
                      $.ajax({
                        url:'mbo/delAllAcces',
                        method:'GET',
                        data:{action:'delAllAcces'},
                        dataType:'json',
                        success:function(){
                          
                          Swal.fire(
                           'Operation Effectuer avec succès!',
                           'Opération fait avec succès',
                           'success'
                          );

                          location.replace("/home");
                          // $("#myNav").load("mbo/refreshNav");
                        },
                        error:function(){
                          Swal.fire('Problème de connexion internet');
                        }
                      });
                    }
                })
        
        }

      })
    </script>