
          <div class="card mb-3">
            <div class="card-body">
              <div class="row justify-content-between align-items-center">
                <div class="col-md">
                  <h4 class="mb-2 mb-md-0"><span class="fas fa-briefcase"></span>  Gestion des Fournisseurs > Nouveau </h4>
                </div>

                    <button class="btn btn-falcon-default btn-sm text-warning" type="button" 
                     id="btnList">
                      <span class="fas fa-eye" data-fa-transform="shrink-3 down-2"></span>
                      <span class="d-none d-sm-inline-block ml-1">Voir liste</span>
                    </button>

              </div>
            </div>
          </div>
          <form  id="p_AddFour" >
            @csrf
            <div class="row no-gutters d-flex justify-content-center">
              <div class="col-lg-8 pr-lg-2">
                <div class="card mb-3">
                  <div class="card-header">
                    <h5 class="mb-0">Enregistrer votre fournisseurs</h5>
                  </div>
                  <div class="card-body bg-light">
                
                      <div class="form-row">
                        <div class="col-6">
                          <div class="form-group">
                            <label for="name">Nom / Société</label>
                            <input class="form-control" id="name" name="name" type="text" required>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label for="start-date">Responsable</label>
                            <input class="form-control " id="respo" name="respo" type="text" required >
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group mb-0">
                            <label for="contact">Contact</label>
                            <input class="form-control" id="contact" name="contact" type="number" required>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label for="localite">Email</label>
                            <input class="form-control " required id="email" name="email" type="email" >
                          </div>
                        </div>


                      </div>

                </div>


                </div>
                    <div class="col-auto d-flex justify-content-center">
                      <button class="btn btn-primary btn-block" id="saveFour" >Envoyer</button>
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
         $('#main_content').load('/p_listF');
      })

      $('#saveFour').click(function(event)
      {
        event.preventDefault();
          if ($("#name").val() != "") 
            {

              $("#name").attr('class', 'form-control is-valid')
              if ($("#contact").val() != "") 
                {
                  $("#contact").attr('class', 'form-control is-valid')
                  if ($("#respo").val() != "") 
                    {
                      $("#respo").attr('class', 'form-control is-valid');
                      
                      //appel fonction ajax d'enrgistrement
                      p_AddF();

                    }
                  else
                  {
                  $("#respo").attr('class', 'form-control is-invalid')

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

      function p_AddF()
      {
                  $.ajax({
                  method: "POST",
                  url: "/p_AddF",
                  data: $("#p_AddFour").serialize(),
                    dataType: "json",
                })

        .done(function(data) 
                {

                Swal.fire(
                       "Ajout Fournisseur!",
                       'Fournisseur ajouté avec succès ',
                       'success'
                      );
                    $('#main_content').load('/p_listF');

                 })
        .fail(function(data) 
        {
                    
          $.each(data.responseJSON, function (key, value) 
              {
                if (key == "errors") 
                  {
                    $.each(value, function(key1,value1)
                    {
                      var input = '#p_AddFour input[name=' + key1 + ']';
                      $(input).attr('placeholder',value1)
                    $(input).addClass('is-invalid');
                    })


                  }
              });
        });
      }


    });
  </script>