
<div class="card mb-3">
  <div class="bg-holder d-none d-lg-block bg-card" 
   style="background-image:url(../assets/img/illustrations/corner-4.png);">
  </div>
  <!--/.bg-holder-->

    <div class="card-body">
      <div class="row">
        <div class="col-lg-8">
          <h4 class="mb-0 text-primary"><i class="fas fa-store-alt"></i> Gestion des Succursales > Nouvelle succursale</h4>
        </div>
      </div>
    </div>
</div>

          <div class="row no-gutters d-flex justify-content-center">

            <div class="col-lg-9 pl-lg-2">
              <div class="card mb-3">

                <div class="card-body bg-light">
                  <div class="border rounded position-relative bg-white p-3">
                    <form class="form-row" id="formSuccursale">
                      @csrf
                      <div class="position-absolute r-0 t-0 mt-2 mr-3 z-index-1">
                        <button class="btn btn-link btn-sm p-0" type="button"><span class="fas fa-times-circle text-danger" data-fa-transform="shrink-1"></span></button>
                      </div>
                      <div class="col-12">
                        <div class="form-group">
                          <label for="name">Titre Succursalle</label>
                          <input class="form-control form-control-sm" id="name" name="name" type="text" required placeholder="Titre">
                        </div>
                      </div>
                      <div class="col-sm-6">
                      <div class="form-group">
                        <label for="exampleFormControlSelect1">Administrateur Succursale</label>
                         @if(!$users->isEmpty())
                        <select class="form-control" id="exampleFormControlSelect1"  name="gerant">                        
                          @foreach($users as $user)
                          <option value="{{ $user->id }}" >
                            {{ $user->name }}
                          </option>
                          @endforeach
                        </select>
                          @else
                          <div class="alert alert-warning">
                            <p>
                              Aucun employé enregistré ! 
                            </p>
                          </div>
                          @endif
                      </div>
                      </div>

                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="localite">Téléphone</label>
                          <input class="form-control form-control-sm " id="localite" name="telephone" required type="text" >
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="schedule-start-time">Date création </label>
                          <input class="form-control form-control-sm datetimepicker" id="schedule-start-time" required name="date" type="date" >
                        </div>
                      </div>

                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="localite">Localité</label>
                          <input class="form-control form-control-sm " id="localite" name="localite" required type="text" >
                        </div>
                      </div>
                    </form>
                  </div>
                  <div style="display: flex;justify-content: flex-end;">
                  <button class="btn btn-primary mr-1 mb-1 mt-2" id="enregistrer" type="button">Enregistrer
                  <span class="far fa-save fs--2 mr-1" data-fa-transform="up-1"> </span>

                  </button>
                  </div>

                </div>
              </div>

            </div>

          </div>


    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->



    <script src="{{ asset('assets/js/theme.js') }}"></script>
    <script type="text/javascript">
      $(function()
      {

      function ajaxSuccursaleSave()
      {
                  $.ajax({
                  method: "POST",
                  url: "mbo/saveSuc",
                  data: $("#formSuccursale").serialize(),
                    dataType: "json",
                })

                .done(function(data) 
                  {

                      Swal.fire(
                             'Ajout !',
                             'Succursale ajouté avec succès',
                             'success'
                            );
                      $("#main_content").load("mbo/listSuc");

                   })
                .fail(function(data) 
                  {
                              
                    $.each(data.responseJSON, function (key, value) 
                        {
                          if (key == "errors") 
                            {
                              $.each(value, function(key1,value1)
                              {
                                var input = '#formSuccursale input[name=' + key1 + ']';
                                $(input).attr('placeholder',value1)
                              $(input).addClass('is-invalid');
                              })


                            }
                        });
                  });
      }



        $('#enregistrer').click(function()
        {
          // alert("ok");
          ajaxSuccursaleSave();
        })
      })
    </script>