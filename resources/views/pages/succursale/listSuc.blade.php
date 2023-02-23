
<div class="card mb-3">
  <div class="bg-holder d-none d-lg-block bg-card" 
   style="background-image:url(../assets/img/illustrations/corner-4.png);">
  </div>
  <!--/.bg-holder-->

    <div class="card-body">
      <div class="row">
        <div class="col-lg-8">
          <h4 class="mb-0 text-primary"><i class="fas fa-store-alt"></i> Gestion des Succursales > Mes succursales</h4>
        </div>
      </div>
    </div>
</div>

          <div class="col-lg-12 col-sm-12 col-md-12 pl-lg-2 ">
            <div class="card mb-3">
              <div class="card-body">
                <div class="table-responsive fs--1">
                  <table class="table table-striped border-bottom">
                    <thead class="bg-200 text-900">
                      <tr>
   
                              {{-- <th scope="col">N°</th> --}}
                              <th scope="col">Libelle Succursale</th>
                              <th scope="col">Situé à </th>
                              <th scope="col">Gérant</th>
                              <th scope="col">Date Création</th>
                              <th scope="col">Stock (FCFA)</th>
                              <th class="white-space-nowrap" scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>

                        @if(!$succursales->isEmpty())
                          @foreach($succursales as $succursale)
                          {{-- {{ dd($succursale) }} --}}
                                  <tr class="fs-0">
                                    {{-- <td>{{ '0'.$loop->iteration }}</td> --}}
                                    <td>{{ $succursale->succursaleLibelle }}</td>
                                    <td>{{ $succursale->succursalLieu }}</td>
                                    <td>{{gerantSuc($succursale->user_id)['name'] }}</td>
                                    <td>{{ $succursale->datesucu }}</td>
                                    <td>
                                      <span class="badge badge rounded-capsule d-block badge-soft-secondary text-warning fs-0">
                                      {{formatPrice(getPrixPrdInStockSuc($succursale->id))}}
                                      </span>
                                    </td>
                                    <td class="pr-0 d-flex">

                                      <a href="#"  class="btnEdit mr-2" id="{{  $succursale->id }}" data-toggle="modal" data-target='#modalSuc'
                                        name ="{{ $succursale->succursaleLibelle }}"
                                        gerant ="{{ $succursale->user_id }}"
                                        telephone ="{{$succursale->succursalContact}}"
                                        date ="{{ $succursale->datesucu }}"
                                        localite ="{{ $succursale->succursalLieu }}"
                                        >
                                        <span class="far fa-edit fa-2x"></span>
                                      </a>

                                      <a href="#"  class="btnStock mr-2" id="{{  $succursale->id }}">

                                        <span class="far fa-eye fa-2x"></span>
                                      </a>
                                      <a href="#"  class="btnDel" id="{{ $succursale->id }}"  nameG="{{gerantSuc($succursale->user_id)['id']   }}">
                                        <span class="far fa-trash-alt fa-2x text-danger mr-2"></span>
                                      </a>

                                    </td>

                                  </tr>
                          @endforeach
                        @endif
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>




                {{-- TOKEN --}}
                                  <div id="mytoken">
                                     @csrf
                                  </div>
                {{-- TOKEN --}}


    <!-- ===============================================-->
          <!--    Modal-->
    <!-- ===============================================-->
          <div class="modal fade" id="modalSuc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Modification Suucursales</h5>
                  <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span class="font-weight-light" aria-hidden="true">&times;</span></button>
                </div>
                  <div class="border rounded position-relative bg-white p-3">
                    <form class="form-row" id="formSuccursale">
                      @csrf
                      <input type="hidden" name="idSuc" id="idSuc">
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
                        <label for="gerant">Administrateur Succursale</label>
                         @if(!allUser()->isEmpty())
                        <select class="form-control" id="gerant"  name="gerant">                        
                          @foreach(allUser() as $user)
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
                          <input class="form-control form-control-sm " id="telephone" name="telephone" required type="text" >
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="schedule-start-time">Date création </label>
                          <input class="form-control form-control-sm datetimepicker" id="date" required name="date" type="date" >
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

                <div class="modal-footer justify-content-around">
                  <button class="btn btn-secondary btn-sm btnClse" type="button" data-dismiss="modal">Fermer</button>
                  <button class="btn btn-primary btn-sm" id="updSucBtn" type="button">Enregistrer</button>
                </div>
              </div>
            </div>
          </div>

    <script src="{{ asset('assets/js/theme.js') }}"></script>


<script type="text/javascript">
  $(function()
  {
        function ajaxDeleteSuccursale(idSuc,idGerant)
        {
                Swal.fire({
                  title: 'Suppresion Succursale',
                  text: "Voulez vous supprimer cette succursale ?",
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
                        url:'mbo/delSuc',
                        method:'GET',
                        data:{idSuc:idSuc,idGerant:idGerant},
                        dataType:'json',
                        success:function(){
                          Swal.fire(
                           'Supression!',
                           'Succursale suipprimé avec succès',
                           'success'
                          );
                          $("#main_content").load("mbo/listSuc");
                        },
                        error:function(){
                          Swal.fire('Problème de connexion internet');
                        }
                      });
                    }
                })
        
        }


$('.btnDel').click(function()
{
  var idSuc= $(this).attr('id');
  var idGerant = $(this).attr('nameG');
  ajaxDeleteSuccursale(idSuc,idGerant);
})


$('.btnEdit').click(function()
{
  var idSuc= $(this).attr('id');
  $('#idSuc').val(idSuc);
$('#name').val($(this).attr('name'));
$('#gerant').val($(this).attr('gerant'));
$('#telephone').val($(this).attr('telephone'));
$('#date').val($(this).attr('date'));
$('#localite').val($(this).attr('localite'));

})

$('#updSucBtn').click(function()
{
          ajaxUpdtSuc();

})


    //Function ajax ajout succu
      function ajaxUpdtSuc()
      {
                  $.ajax({
                  method: "POST",
                  url: "mbo/UpdSuc",
                  data: $("#formSuccursale").serialize(),
                    dataType: "json",
                })

                .done(function(data) 
                  {

                        $('.btnClse').click();

                      Swal.fire(
                             'Modification !',
                             'Succursale modifié avec succès',
                             'success');
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

$('.btnStock').click(function()
{
  var idSuc= $(this).attr('id');
  var input = '#mytoken input[name=_token]';
  var token = $(input).attr('value');
  // alert(token);
  $('#main_content').load('mbo/stockSuc',{ idSuc : idSuc,_token:token});
})




// alert($('#mytoken').firstChild().attr('value'));
  })
</script>