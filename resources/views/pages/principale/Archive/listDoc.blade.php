
<div class="card mb-3">
            <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url(../assets/img/illustrations/corner-4.png);">
            </div>
            <!--/.bg-holder-->

            <div class="card-body">
              <div class="row">
                <div class="col-lg-8">
                  <h4 class="mb-0 text-primary"> <i class="far fa-folder-open"></i> Archives >  Dossiers et fichiers 
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
                      <span class="fas fa-folder-plus" data-fa-transform="shrink-3 down-2"></span>
                      <span class="d-none d-sm-inline-block ml-1">Nouveau</span>
                    </button>
                    <button class="btn btn-falcon-danger btn-sm" type="button" id="btnDelAll">
                      
                      <span class=" d-sm-inline-block ml-1 ">Tous suprimer</span>
                      <i class="fas fa-trash-restore text-danger"></i>
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
                      <th class="align-middle sort">Dossier</th>
                      <th class="align-middle sort">Contenue</th>
                      <th class="align-middle sort">Crée par</th>
                      <th class="align-middle sort ">Date création</th>
                      <th class="align-middle sort ">Commentaire</th>
                      <th class="align-middle ">Actions</th>
                      {{-- <th class="align-middle no-sort"></th> --}}
                    </tr>
                  </thead>
                  <tbody id="customers">
                    @foreach($dossiers as $dossier)
                    <tr class="btn-reveal-trigger">
                      <td class="py-2 align-middle white-space-nowrap">
                        <h4 class="mb-0 text-primary"> <i class="fas fa-folder"></i></h4>

                      </td>
                      <td class="py-2 align-middle white-space-nowrap customer-name-column"><a href="#">
                          <div class="media d-flex align-items-center">
                            <div class="media-body">
                              <h5 class="mb-0 fs--1">{{ $dossier->nomdossier }}</h5>
                            </div>
                          </div>
                        </a>
                      </td>
                      <td class="py-2 align-middle white-space-nowrap ">
                        {{ formatQte($dossier->nbrefichier)}}
                      </td>
                      <td class="py-2 align-middle white-space-nowrap">
                       {{  gerantSuc($dossier->session)->name}}
                      </td>
                      <td class="py-2 align-middle white-space-nowrap">
                        {{ $dossier->dateCreation }}
                      </td>
                      <td class="py-2 align-middle white-space-nowrap"> 
                          {{ $dossier->ref }}                      
                      </td>
                      <td class="align-middle white-space-nowrap">
                                <button class="btn btn-falcon-default btn-sm btnVoir" id="{{ $dossier->id }}"  type="button">
                                  <span class="far fa-eye  text-primary fa-2x" data-fa-transform="shrink-3 down-2"></span>
                                </button>
                              <button class="btn btn-falcon-default btn-sm btnEdit" id="{{$dossier->id }}" type="button" data-toggle="modal" data-target="#modalDoc"
                                name="{{ $dossier->nomdossier }}"
                                contact="{{ $dossier->session }}"
                                datepicker= "{{ $dossier->dateCreation }}" 
                                commentaire= "{{ $dossier->ref }}" 
                                idDoc = {{ $dossier->id }}
                                >
                                  <span class="far fa-edit fa-2x text-warning" data-fa-transform="shrink-3 down-2"></span>
                                  
                                </button>
                                <button class="btn btn-falcon-default btn-sm btnDel" id="{{ $dossier->id }}" isAdminSuc="{{ $dossier->id }}" type="button">
                                  <span class="far fa-trash-alt  text-danger fa-2x" data-fa-transform="shrink-3 down-2"></span>
                                </button>
                                

                      </td>
                    </tr>

                    @endforeach
                  </tbody>
                </table>
                <div class="row no-gutters px-1 py-3 align-items-center justify-content-center">
                       {{ $dossiers->links() }}
                   </div>
              </div>
            </div>
          </div>
    


    <!-- ===============================================-->
          <!--    Modal MODIF USER -->
    <!-- ===============================================-->
          <div class="modal fade" id="modalDoc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Modification Dossier </h5>
                  <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span class="font-weight-light" aria-hidden="true">&times;</span></button>
                </div>
                  <div class="card-body bg-light">
                     
                      <form class="" method="POST" id='updDocForm' enctype="multipart/form-data">
                        @csrf
                          {{-- si Ce input a 0 => creation sinon => update  --}}
                          <input type="hidden" name="idDoc" id="idDoc" value="0">
                          <div class="form-row">
                            <div class="col-6">
                              <div class="form-group">
                                <label for="name">Titre Dossier</label>
                                <input class="form-control" id="name" name="titre" type="text" placeholder="06 caratères min." required>
                              </div>
                            </div>

                            <div class="col-6">
                            <label for="datepicker">Date de création</label>
                            <input class="form-control datetimepicker" id="datepicker" type="text" data-options='{"dateFormat":"d/m/Y"}' value="{{ date('d/m/Y') }}" name="datepicker">
                          </div>
                            <div class="col-sm-12">
                                <label for="commentaire">Commentaire </label>
                                <textarea class="form-control" id="commentaire" name="commentaire" rows="3"></textarea>

                            </div>
                            </div>
                      </form>
                </div>
                <div class="modal-footer ">
                  <button class="btn btn-primary btn-sm updDoc" type="button">Enregistrer</button>
                  <button class="btn btn-secondary btn-sm updDocFormCls" type="button" data-dismiss="modal">Fermer</button>

                </div>
              </div>
            </div>
          </div>


    <!-- ===============================================-->
          <!--    Modal AUTORISATION-->
    <!-- ===============================================-->





          <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->



    <script type="text/javascript">
      $(function()
      {

        // Faire disparaitre les paginate de Javascript
          $(".mytable").parent().next().hide();



        
        //Au clic de UpdAcess
          $('.updDoc').click(function()
          {
            ajaxUpdDoc();

          })
        //Delete all DOC
        $('#btnDelAll').click(function()
        {
          var mytext = "La validation de cette action entrainera la supression de tous vos archives";
          ajaxDelAllDoc(0,mytext);
        })

        //supression
          $('.btnDel').click(function()
          {
            var idEmpl= $(this).attr('id');
            var mytext = "Confirmer vous la supression de ce dossier ?";
            ajaxDelAllDoc(idEmpl,mytext);
          });

        //Edition 
          $('.btnEdit').click(function()
          {
            //Affectation user id au input hidden
              var idEmpl= $(this).attr('id');
              $('#idUser').val(idEmpl);
              $('#name').val( $(this).attr('name'));
              $('#datepicker').val( $(this).attr('datepicker'));
              $('#commentaire').val( $(this).attr('commentaire'));
              $('#idDoc').val( $(this).attr('idDoc'));


          });

        //Add User
          $('#btnAdd').click(function()
          {
              createDoc();
          });

        //Consulter  contenue d'un dosier 
          $('.btnVoir').click(function()
          {
            var idDoc = $(this).attr('id');
            $("#main_content").load("mbo/viewFolder?idDoc="+idDoc);
          });
          
        //Processs creation de Dossier
          function createDoc()
            {
              Swal.mixin({
              input: 'text',
              confirmButtonText: 'Suivant &rarr;',
              cancelButtonText: 'Annuler',
              showCancelButton: true,
              progressSteps: ['1', '2']
              }).queue([
                {
                title: 'Nouveau dossier',
                text: 'Ajout de dossier d\'archive'
                },
                'Commentaire',
              ]).then((result) => {
                if (result.value) {
                  var answers = result.value
                  if(answers[0] != '')
                  {
                      const ipAPI = '/mbo/saveFolder?titre='+answers[0]+'&com='+answers[1];

                      Swal.queue([{
                        title: 'Création du dossier',
                        confirmButtonText: 'Oui, Crée',
                        text:'Voulez vous validez l\'ajout ?',
                        showLoaderOnConfirm: true,
                        preConfirm: () => {
                          return fetch(ipAPI)
                          .then(response => response.json())
                          .then(data => createDocOk())
                          .catch(() => {
                            Swal.insertQueueStep({
                              icon: 'error',
                              title: 'Erreur de connexion !!!'
                            })
                          })
                      }
                    }])
                }
                else
                {
                    Swal.fire({
                      icon: 'error',
                      title: 'Des champs n\'ont pas été correctement remplis',
                      showConfirmButton: true,
                      confirmButtonText: 'Retour',
                    })
                }
              }
            })

            }

    //Success created doc
          function createDocOk()
          {
            toastr.success('Création de dossier fait avec succès');
            $("#listDoc").click();
          }

      //Mis a jour des access
        function ajaxUpdDoc()
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
                        url:'mbo/updDoc',
                        method:'POST',
                        data:$('#updDocForm').serialize(),
                        dataType:'json',
                        success:function(){
                          $('.updDocFormCls').click();
                          Swal.fire(
                           'Modification!',
                           'Fait avec succès',
                           'success'
                          );

                          $("#main_content").load("mbo/listDoc");
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
        function ajaxDelAllDoc(idDoc,mytext)
        {
                Swal.fire({
                  title: 'URGENT !!!',
                  text: mytext,
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
                        url:'mbo/delDoc',
                        method:'GET',
                        data:{idDoc:idDoc},
                        dataType:'json',
                        success:function(){
                          
                          Swal.fire(
                           'Operation Effectuer avec succès!',
                           'Opération fait avec succès',
                           'success'
                          );

                          $('#main_content').load('/mbo/listDoc');
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