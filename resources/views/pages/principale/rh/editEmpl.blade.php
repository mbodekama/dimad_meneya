

          <div class="card mb-3">

            <div class="card-body">

              <div class="row justify-content-between align-items-center">

                <div class="col-md">

                  <h4 class="mb-2 mb-md-0"><span class="fas fa-users"></span>  Modification Utilisateur</h4>

                </div>

                <div class="d-flex justify-content-between">

                    <button class="btn btn-falcon-default btn-sm text-warning" type="button" id="addBtn">

                      <span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span>

                      <span class="d-none d-sm-inline-block ml-1">Nouveau</span>

                    </button>

                    <button class="btn btn-falcon-default btn-sm text-warning" type="button" id="btnList">

                      <span class="fas fa-eye" data-fa-transform="shrink-3 down-2"></span>

                      <span class="d-none d-sm-inline-block ml-1">Voir liste</span>

                    </button>

                </div>



              </div>

            </div>

          </div>

          <form  id="addEmplForm" >

            @csrf

            <input type="hidden" name="idEmploye" value="{{ $employe->id }}">

            <div class="row no-gutters d-flex justify-content-center">

              <div class="col-lg-8 pr-lg-2">

                <div class="card mb-3">

                  <div class="card-header">

                    <h5 class="mb-0">Identité de l'utilisateur</h5>

                  </div>

                  <div class="card-body bg-light">

                

                      <div class="form-row">

                        <div class="col-6">

                          <div class="form-group">

                            <label for="name">Nom & prénoms Utilisateur</label>

                            <input class="form-control" id="name" name="name" type="text" required value="{{ $employe->ressourcesHumNom}}">

                          </div>

                        </div>

                        <div class="col-sm-6">

                          <div class="form-group">

                            <label for="start-date">Fonction</label>

                            <input class="form-control " id="poste" name="poste" type="text" required value="{{ $employe->ressourcesHumMetier}}">

                          </div>

                        </div>

                        <div class="col-sm-6">

                          <div class="form-group mb-0">

                            <label for="contact">Contact</label>

                            <input class="form-control" id="contact" name="contact" type="text" required value="{{ $employe->ressourcesHContact}}">

                          </div>

                        </div>

                        <div class="col-sm-6">

                          <div class="form-group">

                            <label for="localite">Date enregistrement</label>

                            <input class="form-control " value="{{ $employe->ressourcesHumLieu}}" required id="dataEmbauche" name="dataEmbauche" type="date" type="text" >

                          </div>

                        </div>
                        @if(hasRole($employe->id))
                        <div class="col-sm-6">

                          <div class="form-group">

                            <label for="username">Email</label>

                            <input class="form-control" name="email" id="email" type="text" 
                            value="{{ hasRole($employe->id)->email }}">

                          </div>

                        </div>

                        <div class="col-sm-6">

                          <div class="form-group">

                            <label for="dataEmbauche">Mot de Passe</label>

                            <input class="form-control " id="password" name="password" type="text" 
                            value="{{ hasRole($employe->id)->password }}">

                          </div>

                        </div>
                        @endif



                      </div>

                    <div class="col-auto d-flex justify-content-center">

                      <button class="btn btn-primary btn-block" id="saveEmpl" >Envoyer</button>

                  </div>

                </div>

                </div>



              </div>

            </div>

        </form>

             <!-- ===============================================-->

    <!--    JavaScripts-->

    <!-- ===============================================-->







    <script src="{{ asset('assets/js/theme.js') }}"></script>

  



  <script type="text/javascript">

    $(function()

    {

      $('#btnList').click(function()

      {

         $('#main_content').load('mbo/listEmpl');

      });



      $('#addBtn').click(function()

      {

         $('#main_content').load('mbo/addEmpl');

      });



      addBtn



      $('#saveEmpl').click(function(event)

      {

        event.preventDefault();

          if ($("#name").val() != "") 

            {



              $("#name").attr('class', 'form-control is-valid')

              if ($("#contact").val() != "") 

                {

                  $("#contact").attr('class', 'form-control is-valid')

                  if ($("#poste").val() != "") 

                    {

                      $("#poste").attr('class', 'form-control is-valid');

                      

                      //appel fonction ajax d'enrgistrement

                        ajaxUpdateEmpl();



                    }

                  else

                  {

                  $("#poste").attr('class', 'form-control is-invalid')



                  }

                }

              else

              {

              $("#contact").attr('class', 'form-control is-invalid');

              }



            }

          else

            {

              $("#name").attr('class', 'form-control is-invalid');

            }



      });



      function ajaxUpdateEmpl()

      {

                  $.ajax({

                  method: "POST",

                  url: "mbo/UpdEmpl",

                  data: $("#addEmplForm").serialize(),

                    dataType: "json",

                })



        .done(function(data) 

                {



                Swal.fire(

                       "Modification d'utilisateur!",

                       'Employé modifié avec succès ',

                       'success'

                      );

                    $('#main_content').load('mbo/listEmpl');



                 })

        .fail(function(data) 

        {

                    

          $.each(data.responseJSON, function (key, value) 

              {

                if (key == "errors") 

                  {

                    $.each(value, function(key1,value1)

                    {

                      var input = '#addEmplForm input[name=' + key1 + ']';

                      $(input).attr('placeholder',value1)

                    $(input).addClass('is-invalid');

                    })





                  }

              });

        });

      }





    });

  </script>