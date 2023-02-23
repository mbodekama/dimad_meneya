      {{-- Recuperation des roles --}}
      @php

        $roles = allRole();
      @endphp

                  <div class="card-body bg-light">
                      <form  id="addEmplForm" >
                          @csrf
                          {{-- si Ce input a 0 => creation sinon => update  --}}
                          <input type="hidden" name="idUser" id="idUser" value="0">
                          <div class="form-row">
                            <div class="col-6">
                              <div class="form-group">
                                <label for="name">Nom & prénoms
                                    <svg class="svg-inline--fa fa-times-circle fa-w-16 text-danger" data-fa-transform="shrink-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="times-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" style="transform-origin: 0.5em 0.5em;"><g transform="translate(256 256)"><g transform="translate(0, 0)  scale(0.9375, 0.9375)  rotate(0 0 0)"><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z" transform="translate(-256 -256)"></path></g></g>
                                    </svg>
                                </label>
                                <input class="form-control" id="name" name="name" type="text" placeholder="06 caratères min." required>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group">
                                <label for="mail">E-mail
                                  <svg class="svg-inline--fa fa-times-circle fa-w-16 text-danger" data-fa-transform="shrink-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="times-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" style="transform-origin: 0.5em 0.5em;"><g transform="translate(256 256)"><g transform="translate(0, 0)  scale(0.9375, 0.9375)  rotate(0 0 0)"><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z" transform="translate(-256 -256)"></path></g></g></svg>
                                </label>
                                <input class="form-control" id="email" name="email" type="email" required>
                              </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="gerant">Rôle (Accés) </label>
                                 @if(!$roles->isEmpty())
                                <select class="form-control" id="gerant"  name="gerant"> @foreach($roles as $role)
                                  <option value="{{ $role->id }}" >
                                    {{ $role->libelle }}
                                  </option>
                                  @endforeach
                                </select>
                                  @else
                                  <div class="alert alert-warning">
                                    <input class="form-control" id="gerant" name="gerant" type="text" readonly="" value="">
                                  </div>
                                  @endif
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group mb-0">
                                <label for="contact">Contact
                                    <svg class="svg-inline--fa fa-times-circle fa-w-16 text-danger" data-fa-transform="shrink-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="times-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" style="transform-origin: 0.5em 0.5em;"><g transform="translate(256 256)"><g transform="translate(0, 0)  scale(0.9375, 0.9375)  rotate(0 0 0)"><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z" transform="translate(-256 -256)"></path></g></g></svg>
                                </label>
                                <input class="form-control" id="contact" name="contact" type="text" required>
                              </div>
                            </div>
                            <div class="col-sm-6">
                            <div class="form-group">
                              <label for="wizard-email">Mot de passe 
                                <svg class="svg-inline--fa fa-times-circle fa-w-16 text-danger" data-fa-transform="shrink-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="times-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" style="transform-origin: 0.5em 0.5em;"><g transform="translate(256 256)"><g transform="translate(0, 0)  scale(0.9375, 0.9375)  rotate(0 0 0)"><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z" transform="translate(-256 -256)"></path></g></g></svg>
                              </label>
                              <input class="form-control" type="password" name="password"  required="required" id="password" placeholder="08 caratères min." value="" />
                            </div>
                            </div>
                            <div class="col-sm-6">
                            <div class="form-group">
                              <label for="wizard-email">Confirmation mot de passe
                                  <svg class="svg-inline--fa fa-times-circle fa-w-16 text-danger" data-fa-transform="shrink-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="times-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" style="transform-origin: 0.5em 0.5em;"><g transform="translate(256 256)"><g transform="translate(0, 0)  scale(0.9375, 0.9375)  rotate(0 0 0)"><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z" transform="translate(-256 -256)"></path></g></g>
                                  </svg>
                              </label>
                              <input class="form-control" type="password" name="passwordConf" required="required" id="passwordConf" value="" />
                            </div>
                            </div>

                          </div>
                          <div class="col-auto d-flex justify-content-center">
                          <button class="btn btn-primary btn-block" id="saveEmpl" >Enregistrer</button>
                        </div>
                      </form>
                </div>
 

  <script type="text/javascript">
    $(function()
    {
      //Voir liste des utilisateurs
        $('#btnList').click(function()
        {
           $('#main_content').load('mbo/listEmpl');
        })



      $('#saveEmpl').click(function(event)
      {
        event.preventDefault();
          if ($("#name").val() != "") 
            {

              $("#name").attr('class', 'form-control is-valid')
              if ($("#email").val() != "") 
                {
                  $("#email").attr('class', 'form-control is-valid');

                      if ($("#password").val() == $("#passwordConf").val()) 
                        { 

                          if ($("#gerant").val() != "1") 
                            {
                              $("#gerant").val("2");
                            }
                          if ($("#contact").val() == "") 
                            {
                              $("#contact").val("NON DEFINIS");
                            }                   
                          //appel fonction ajax d'enrgistrement
                          ajaxSaveEmpl();
                        }
                      else
                        {
                        $("#passwordConf").attr('class', 'form-control is-invalid');

                          toastr.error('Veuillez mettre des mot de passe identiques');
                        }                    
                   
                }
              else
              {
              $("#email").attr('class', 'form-control is-invalid');
              }

            }
          else
            {
              $("#name").attr('class', 'form-control is-invalid');
            }

      });

      function ajaxSaveEmpl()
      {
                  $.ajax({
                  method: "POST",
                  url: "mbo/ajaxSaveEmpl",
                  data: $("#addEmplForm").serialize(),
                    dataType: "json",
                })

        .done(function(data) 
                {
                $('.modalUserCls').click();
                Swal.fire(
                       "Employé!",
                       'Opération faite avec succès ',
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
                      var input = '#formProduit input[name=' + key1 + ']';
                      $(input).attr('placeholder',value1)
                    $(input).addClass('is-invalid');
                    })


                  }
              });
        });
      }


    });
  </script>