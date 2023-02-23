<div class="card mb-3">
            <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url(../assets/img/illustrations/corner-4.png);">
            </div>
            <!--/.bg-holder-->

            <div class="card-body">
              <div class="row">
                <div class="col-lg-8">
                  <h4 class="mb-0 text-primary"> <i class="far fa-sun"></i>  Configuration  Meneya
                  </h4>
                  <p>Premier pas !</p>
                </div>
              </div>
            </div>
          </div>

    <main class="main" id="top">
        <div class="container" data-layout="container">
        <div class="row justify-content-center pt-2">
          <div class="col-sm-10 col-lg-7 col-xxl-5">
            <div class="card theme-wizard mb-5" data-wizard data-controller="#wizard-controller" data-error-modal="#error-modal">
              <div class="card-header bg-light pt-1 pb-1">
                <ul class="nav justify-content-between nav-wizard">
                  
                  <li class="nav-item"><a class="nav-link active font-weight-semi-bold" href="#bootstrap-wizard-tab1" data-toggle="tab"><span class="nav-item-circle-parent"><span class="nav-item-circle"><span class="fas fa-lock"></span></span></span><span class="d-none d-md-block mt-1 fs--1">Compte</span></a></li>

                  <li class="nav-item"><a class="nav-link font-weight-semi-bold" href="#bootstrap-wizard-tab1-Entp" data-toggle="tab"><span class="nav-item-circle-parent"><span class="nav-item-circle"><span class="far fa-address-card"></span></span></span><span class="d-none d-md-block mt-1 fs--1">Entreprise</span></a></li>

                  <li class="nav-item"><a class="nav-link font-weight-semi-bold" href="#bootstrap-wizard-tab2" data-toggle="tab"><span class="nav-item-circle-parent"><span class="nav-item-circle"><span class="far fa-clipboard"></span></span></span><span class="d-none d-md-block mt-1 fs--1">Produits</span></a></li>

                  <li class="nav-item"><a class="nav-link font-weight-semi-bold" href="#bootstrap-wizard-tab3" data-toggle="tab"><span class="nav-item-circle-parent"><span class="nav-item-circle"><span class="far fa-bell"></span></span></span><span class="d-none d-md-block mt-1 fs--1">Seuil de stock</span></a></li>

                  <li class="nav-item"><a class="nav-link font-weight-semi-bold" href="#bootstrap-wizard-tab3-sms" data-toggle="tab"><span class="nav-item-circle-parent"><span class="nav-item-circle"><span class="far fa-comments"></span></span></span><span class="d-none d-md-block mt-1 fs--1">Sms</span></a></li>

                  <li class="nav-item" id="resume"><a class="nav-link font-weight-semi-bold" href="#bootstrap-wizard-tab4" data-toggle="tab"><span class="nav-item-circle-parent"><span class="nav-item-circle"><span class="far fa-sun"></span></span></span><span class="d-none d-md-block mt-1 fs--1">Resume</span></a></li>

                  <li class="nav-item"><a class="nav-link font-weight-semi-bold" href="#bootstrap-wizard-tab5" data-toggle="tab"><span class="nav-item-circle-parent">
                    <span class="nav-item-circle"><span class="fas fa-thumbs-up"></span></span></span><span class="d-none d-md-block mt-1 fs--1">Fin</span></a>
                  </li>

                </ul>
              </div>
              <div class="card-body py-4">
                <div class="tab-content">
                  
                  <!-- Compte -->
                  <div class="tab-pane active px-sm-3 px-md-5" id="bootstrap-wizard-tab1">
                    <form class="form-validation" data-options='{"rules":"terms":{"required":"Vous devez acceptez nos conditions "}}}' id='form-tab1'>
                      @csrf
                      <div class="form-group">
                        <label for="wizard-name">Role</label>
                        <input class="form-control" type="text" name="role" value="Administrateur" readonly="" />
                      </div>
                      <div class="form-group">
                        <label for="wizard-name">Username</label>
                        <input class="form-control" type="text" name="name"  id="wizardName" value="{{ Auth::user()->name }}" />
                      </div>
                      <div class="form-group">
                        <label for="myemail">Email*</label>
                        <input class="form-control" type="email" name="email" required="required" id="myemail" value="{{ Auth::user()->email }}" readonly="" />
                      </div>
                    </form>
                  </div>

                  <!-- Infos entreprise -->
                  <div class="tab-pane  px-sm-3 px-md-5" 
                  id="bootstrap-wizard-tab1-Entp">
                    <form class="" method="POST" id='form-Entp' enctype="multipart/form-data">
                      @csrf
                      <div class="form-group">
                        <label for="entreprise">Nom Entreprise</label>
                        <input class="form-control" type="text" 
                        name="entreprise" value="{{ getSettingByName('Entreprise') }}" readonly="" />
                      </div>

                          <div class="form-group custom-file mt-4">
                            <input class="custom-file-input" id="imageP" type="file" name="imageP">
                            <label class="custom-file-label" for="imageP">Votre fichier</label>
                          </div>
                      <div class="form-group">
                        <label for="sender">Sender(identifiant sms)</label>
                        <input class="form-control" type="text" 
                        name="sender" required="required" 
                        id="wizard-email" value="{{ getSettingByName('sender') }}" />
                      </div>

                      <div class="form-group">
                        <label for="facb">Lien Facebook</label>
                        <input class="form-control" type="text" 
                        name="facb"  id="wizard-name" 
                        value="{{ getSettingByName('facebook') }}" />
                      </div>

                      <div class="form-group">
                        <label for="whatsAp">WhatsApp</label>
                        <input class="form-control" type="text" 
                        name="whatsAp"  id="whatsAp" 
                        value="{{ getSettingByName('whatsApp') }}" />
                      </div>

                      <div class="form-group">
                        <label for="exampleFormControlTextarea1">
                         A propos (Qui sommes-nous ?)
                        </label>
                        <textarea class="form-control" id="descrp"
                         rows="3" 
                         name="descrp">{{ getSettingByName('about') }}</textarea>
                      </div>


                    </form>
                  </div>

                  <div class="tab-pane px-sm-3 px-md-5" id="bootstrap-wizard-tab2">
                    <form class="form-validation" id='form-tab2'> 
                      @csrf

                      <div class="form-row">
                        <div class="col-6">
                          <div class="form-group">
                            <label for="deviseName">Devise Utilisé</label>
                            <select class="custom-select" id="deviseName" name="deviseId">
                              <option value="1"> -- Choix -- </option>
                              @foreach(getAllDevises() as $devise)
                                <option value="{{ $devise->id }}" title='{{ $devise->symbole }}'>{{ $devise->libelle }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="col-6 mb-3">
                          <div class="form-group mb-0">
                            <label for="montant">Symbole                                       
                              <div class="badge badge-pill badge-soft-warning fs--2" >
                                <span class="fa fa-question-circle ml-2"></span>
                               
                              </div>
                            </label>
                            <input class="form-control" id="devise" placeholder="xxx" name="" maxlength="10" readonly  type="text"/ value="">
                          </div>
                        </div> 
                        <div class="col-md-6 col-sm-12 mb-3">
                          <div class="form-group mb-0">
                            <label for="montant">Dedouanement                                        
                              <div class="badge badge-pill badge-soft-warning fs--2" id="tDouane">
                               en %
                              </div>
                            </label>
                            <input class="form-control" id="montant" placeholder="123" name="txDouane" maxlength="10" required  type="text"/ value="{{ getTxDouane()}}">
                          </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                          <div class="form-group mb-0">
                            <label for="duree">Taxe Portuaire
                              <span class="badge badge-pill badge-soft-warning fs--2" > en %</span>
                            </label>
                            <input class="form-control" id="tPort" required  type="number" name="txPort" value="{{ getTxPort() }}" />
                          </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                          <div class="form-group mb-0">
                            <label for="duree">Marge de revente
                              <span class="badge badge-pill badge-soft-warning fs--2" > en %</span>
                            </label>
                            <input class="form-control" id="marge" required  type="number " name="txMarge" value="{{ getMgvente() }}" />
                          </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                          <div class="form-group mb-0">
                            <label for="duree">Frais Annexe
                              <span class="badge badge-pill badge-soft-warning fs--2" > en %</span>
                            </label>
                            <input class="form-control" id="tAnnexe" required  type="number" name="txAnexe" value="{{ getTxAnexe() }}" />
                          </div>
                        </div>
                      </div>   
                      <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" id="wizard-checkbox" type="checkbox" name="terms" required="required" checked="checked" />
                        <label class="custom-control-label" for="wizard-checkbox">
                          Ces valeurs seronts appliquées lors du calcul automatique du prix de tous vos produits
                        </label>
                      </div>       
                    </form>
                  </div>

                  <div class="tab-pane px-sm-3 px-md-5" 
                  id="bootstrap-wizard-tab3">
                    <form class="form-validation" id='form-tab3'>
                      @csrf

                      <div class="form-row">
                        <div class="col-md-6 col-sm-12">
                          <div class="form-group mb-0">
                            <label for="montant">Niveau d'alert                                        
                              <div class="badge badge-pill badge-soft-success fs--2" id="alertNiv">
                                <span class="fa fa-question-circle ml-2"></span>
                              </div>
                            </label>
                            <input class="form-control" name="niveauAlert" placeholder="123" name="seuilPrd" maxlength="10" required pattern="[0-9]{10}" type="number" value="{{ getSeuil() }}" />
                          </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                          <div class="form-group mb-0">
                            <label for="duree">Numéro à alerter <span class="fa fa-question-circle ml-2" data-toggle="tooltip" data-placement="top" placeholder="Durée du contrat"></span></label>
                            <input class="form-control" name="alertTel" required  type="number" value="{{ getAlertTel() }}" />
                          </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                          <div class="form-group mb-0">
                            <label for="duree">Mail à alerter <span class="fa fa-question-circle ml-2" data-toggle="tooltip" data-placement="top" placeholder="Durée du contrat"></span></label>
                            <input class="form-control" name="alertMail" required  type="mail" value="{{ getAlertMail() }}" />
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-group">
                            <label for="card-holder-country">Etat des alertes</label>
                            <select class="custom-select" id="card-holder-country" name="etatAlert">
                              <option value="1">Activé</option>
                              <option value="0">Desactivé</option>
                            </select>
                          </div>
                        </div>
                    {{--<div class="custom-control custom-checkbox">
                          <input class="custom-control-input" id="wizard-checkbox1" type="checkbox" name="mobileMoney"  />
                          <label class="custom-control-label text-warning" for="wizard-checkbox1">
                            Données soumises a nos conditions de confidentialités
                          </label>
                        </div> --}}
                      </div>
                    </form>
                  </div>

                  <div class="tab-pane px-sm-3 px-md-5" 
                  id="bootstrap-wizard-tab3-sms">
                    <h4 class="mb-0 text-center text-primary">
                    Configurer votre SMS promotionnel</h4><br>
                    <form class="form-validation" id='form-tab3-sms'>
                      @csrf

                      <div class="form-row">
                        <div class="col-md-6 col-sm-12">
                          <div class="form-group mb-0">
                            <label for="montant">Email </label>
                            <input class="form-control"
                            name="email_sms" required 
                            type="email" 
                            value="{{ getSettingByName('sms_mail') }}" />
                          </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                          <div class="form-group mb-0">
                            <label for="duree">clé secret</label>
                            <input class="form-control"
                             name="sms_key" required  
                             type="text" 
                             value="{{ getSettingByName('sms_secret') }}" />
                          </div>
                        </div>
                        
                        
                      </div>
                    </form>
                  </div>


                  <div class="tab-pane text-center px-sm-3 px-md-5" id="bootstrap-wizard-tab4">
                    <form class="form-validation" id='form-tab4'>
                      @csrf
                      <table class="table table-borderless fs--1 mb-0">
                        <tr class="border-bottom">
                          <th class="pl-0 pt-0 text-left">
                          Etat alert
                          </th>
                          <th class="pr-0 text-right pt-0">
                              <div class="badge badge-pill badge-soft-success fs--2">{{getAlertEtat()}}
                                <span class="fas fa-check ml-1" data-fa-transform="shrink-2"></span>
                              </div>
                          </th>
                        </tr>
                        <tr class="border-bottom">
                          <th class="pl-0 pt-0 text-left">
                          Mail Alerté
                          </th>
                          <th class="pr-0 text-right pt-0">
                              <div class="fs--2">
                                {{ getAlertMail() }}
                            
                              </div>
                          </th>
                        </tr>
                        <tr class="border-bottom">
                          <th class="pl-0 pt-0 text-left">
                          Numero Alerté
                          </th>
                          <th class="pr-0 text-right pt-0">
                              <div class=" fs--2">
                                {{ getAlertTel() }}
                            
                              </div>
                          </th>
                        </tr>
                        <tr class="border-bottom">
                          <th class="pl-0 pt-0 text-left">
                          Seuil d'alert
                          </th>
                          <th class="pr-0 text-right pt-0">
                              <div class=" fs--2">
                                {{ getSeuil().'articles' }}
                            
                              </div>
                          </th>
                        </tr>
                        <tr class="border-bottom">
                          <th class="pl-0 pt-0 text-left">
                          Taxe de dedouanement
                          </th>
                          <th class="pr-0 text-right pt-0">
                              <div class="badge badge-pill badge-soft-warning fs--2">
                                {{ getTxDouane() }} %
                            
                              </div>
                          </th>
                        </tr>
                        <tr class="border-bottom">
                          <th class="pl-0 pt-0 text-left">
                          Taxe de Portuaire
                          </th>
                          <th class="pr-0 text-right pt-0">
                              <div class="badge badge-pill badge-soft-warning fs--2">
                                {{ getTxPort() }} %
                            
                              </div>
                          </th>
                        </tr>
                        <tr class="border-bottom">
                          <th class="pl-0 pt-0 text-left">
                          Marge de Vente
                          </th>
                          <th class="pr-0 text-right pt-0">
                              <div class="badge badge-pill badge-soft-warning fs--2">
                                {{ getMgvente() }} %
                            
                              </div>
                          </th>
                        </tr>
                    </table>          
                    </form>
                  </div>
                  <div class="tab-pane text-center px-sm-3 px-md-5" id="bootstrap-wizard-tab5">
                    <div class="wizard-lottie-wrapper">
                      <div class="wizard-lottie mx-auto my-3" data-options='{"path":"../assets/img/animated-icons/celebration.json"}'></div>
                    </div>
                    <h4 class="mb-1">Felicitation</h4>
                    <p>Votre compte a été configurer avec succes</p><a class="btn btn-primary px-5 my-3" href="{{ route('dashboard') }}" >Tableau de bord</a>
                  </div>
                </div>
              </div>
              <div class="card-footer bg-light" id="wizard-controller">
                <div class="px-sm-3 px-md-5">
                  <ul class="pager wizard list-inline mb-0">
                    <li class="previous">
                      <button class="btn btn-link pl-0" type="button" style="display: none;"><span class="fas fa-chevron-left mr-2" data-fa-transform="shrink-3"></span>Retour</button>
                    </li>
                    <li class="next"><a class="btn btn-primary px-5 px-sm-6" href="#" id="next">Suivant<span class="fas fa-chevron-right ml-2" data-fa-transform="shrink-3"> </span></a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="modal fade" id="error-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 400px">
              <div class="modal-content position-relative p-5">
                <div class="media align-items-center">
                  <div class="lottie mr-3" data-options='{"path":"../assets/img/animated-icons/warning-light.json"}'></div>
                  <div class="media-body">
                    <button class="btn btn-link text-danger position-absolute t-0 r-0 mt-2 mr-2" data-dismiss="modal"><span class="fas fa-times"></span></button>
                    <p class="mb-0">Vous n'avez plus accès à cette zone</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>


    <script src="../assets/lib/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
    <script src="../assets/lib/lottie/lottie.min.js"></script>
    <script src="../assets/js/theme.js"></script>

    <script type="text/javascript">
      $(function()
      {

      //Changement de devises
        $('#deviseName').change(function()
        {
          $('#devise').val($('#deviseName option:selected').attr('title'));
        });
        $('#next').click(function()
        {
          var form = $('div .active').find('form');
          switch(form.attr('id'))
          {
              case 'form-tab1': 
                ajaxUpdUser(form);
              break;
              case 'form-tab2': 
                ajaxUpdTaxe(form);
              break;
              case 'form-tab3': 
                ajaxUpdAlert(form);
              break;
              case 'form-tab4': 
                  ajaxUpdSet();
              break;
              case 'form-tab3-sms':
               ajaxUpSms(form);
                ajaxUpdSet();
              break;
              case 'form-Entp':
               ajaxUpEntp(form);
              break; 
          } 
        })




    //MES FONCTION JS
          //Mis a jour de l'utilisateur
              function ajaxUpdUser(form) {
                $.ajax({
                  url:'/updUser',
                  method:'POST',
                  data:form.serialize(),
                  dataType:'json',
                  success:function(){
                    toastr.success('Mis à jour');
                    // $("#main_content").load("/p_Eche");
                  },

                  error:function(){
                    toastr.error('Probleme de connexion');
                  }
                });
              }

          //Mis a jour des taxes
              function ajaxUpdTaxe(form) {
                $.ajax({
                  url:'/updTaxe',
                  method:'POST',
                  data:form.serialize(),
                  dataType:'json',
                  success:function(){
                    toastr.success('Mis à jour');
                    // $("#main_content").load("/p_Eche");
                  },

                  error:function(){
                    toastr.error('Probleme de connexion');
                  }
                });
              }
          //Mis a jour des seuil d'alertes
              function ajaxUpdAlert(form) {
                $.ajax({
                  url:'/updAlert',
                  method:'POST',
                  data:form.serialize(),
                  dataType:'json',
                  success:function(){
                    toastr.success('Mis à jour');
                    // $("#main_content").load("/p_Eche");
                  },

                  error:function(){
                    toastr.error('Probleme de connexion');
                  }
                });
              }

          //Mis a du resume des parametres
              function ajaxUpdSet() {
                $.ajax({
                  url:'/lSetting',
                  method:'get',
                  data:{action:'updt'},
                  dataType:'html',
                  success:function(data){
                    $('#form-tab4').html(data);
                  },

                  error:function(){
                    toastr.error('Probleme de connexion');
                  }
                });
              }

          //Au clic de menu resume 
            $('#resume').click(function()
            {
              ajaxUpdSet();
            })

          // Mise à jour sms_key
           function ajaxUpSms(form)
           {
             $.ajax({
               url:'/updSms',
               method:'POST',
               data:form.serialize(),
               dataType:'json',
               success:function(){
                 toastr.success('Mis à jour');
                },
               error:function(){
                    toastr.error('Probleme de connexion');
                }
             });
           }





          // Mise à jour Entrprise
           function ajaxUpEntp(form)
           {
            toastr.info('Logo en chargement ...');
              // var myform = $('form#');
              var formData = new FormData(document.getElementById("form-Entp"));
             $.ajax({
               url:'/updEntp',
               method:'POST',
               data:formData,
               dataType:'json',
               success:function(){
                 toastr.success('Mis à jour');
                },
               cache : false,
               processData : false,
               contentType : false,
               error:function(){
                    toastr.error('Problème de connexion');
                }
             });
           }

           

      })
    </script>