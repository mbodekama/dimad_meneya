
<div class="card mb-3">
            <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url(../assets/img/illustrations/corner-4.png);">
            </div>
            <!--/.bg-holder-->

            <div class="card-body">
              <div class="row">
                <div class="col-lg-8">
                  <h4 class="mb-0 text-primary"> <i class="far fa-folder-open"></i> 
                    <a href="#" class="folder"> Archives </a> >>
                      <a href="#" class="refresh" id="{{ $folder->id }}"> {{ $folder->nomdossier }}</a> >>> Liste fichier
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
                      <span class="fas fa-file-medical" data-fa-transform="shrink-3 down-2"></span>
                      <span class="d-none d-sm-inline-block ml-1">Nouveau</span>
                    </button>
                    <button class="btn btn-falcon-danger btn-sm" type="button" id="btnDelAll" idFolder="{{ $folder->id }}">
                      
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
                      <th class="align-middle no-sort">Fichier</th>
                      <th class="align-middle sort ">Date création</th>
                      <th class="align-middle sort ">Commentaire</th>
                      <th class="align-middle ">Actions</th>
                    </tr>
                  </thead>
                  <tbody id="customers">
                    @foreach($files as $file)
                    <tr class="btn-reveal-trigger">
                      <td class="py-2 align-middle white-space-nowrap">
                        <div class="custom-control custom-checkbox">
                          <input class="custom-control-input checkbox-bulk-select-target" type="checkbox" id="customer-checkbox-0" />
                          <label class="custom-control-label" for="customer-checkbox-0"></label>
                        </div>
                      </td>
                      <td class="py-2 align-middle white-space-nowrap customer-name-column">
                        <div class="media mb-3 hover-actions-trigger align-items-center">
                          <div class="file-thumbnail"><img class="img-fluid" src="assets/img/icons/docs.png" alt="">
                          </div>
                          <div class="media-body ml-3">
                            <h6 class="mb-1">
                              <a class="stretched-link text-900 font-weight-semi-bold" href="#!">
                                {{ $file->titre }}
                              </a>
                            </h6>
                            <div class="fs--1">
                              <span class="font-weight-medium text-600 ml-2">Auteur : </span>

                              <span class="font-weight-semi-bold">{{ gerantSuc($file->session)->name }}</span>
                            </div>
                          </div>
                        </div>
                      </td>
                      <td class="py-2 align-middle white-space-nowrap">
                        {{ $file->ref }}
                      </td>
                      <td class="py-2 align-middle white-space-nowrap"> 
                          {{ $file->commentaire }}                      
                      </td>
                      <td class="align-middle white-space-nowrap">
                                <button class="btn btn-falcon-default btn-sm btnVoir"
                                type="button" data-toggle="modal" data-target="#viewDoc" 
                                id="{{ $file->id }}" lien="{{ $file->joint}}"  type="button"
                                libele="{{ createLibele($file->titre,10).'.pdf' }}">
                                  <span class="far fa-eye  text-success fa-2x" data-fa-transform="shrink-3 down-2"></span>
                                </button>
                              <a class="btn btn-falcon-default btn-sm " 
                              id="{{ $file->id }}"  type="button" href="{{ $file->joint}}"
                               download="{{ createLibele($file->titre,10).'.pdf' }}">
                                  <span class="fas fa-cloud-download-alt text-primary fa-2x" data-fa-transform="shrink-3 down-2"></span>
                              </a>
                              <button class="btn btn-falcon-default btn-sm btnEdit" id="{{$file->id }}"     type="button" data-toggle="modal" data-target="#modalDoc"
                                name="{{ $file->titre }}"
                                auteur="{{ $file->session }}"
                                datepicker= "{{ $file->ref }}" 
                                commentaire= "{{ $file->commentaire }}" 
                                idDoc = {{ $file->id }}>
                                  <span class="far fa-edit fa-2x text-warning" data-fa-transform="shrink-3 down-2"></span>
                                  
                                </button>
                                <button class="btn btn-falcon-default btn-sm btnDel" id="{{ $file->id }}" idFolder="{{ $folder->id }}" type="button">
                                  <span class="far fa-trash-alt  text-danger fa-2x" data-fa-transform="shrink-3 down-2"></span>
                                </button>
                      </td>
                    </tr>

                    @endforeach
                  </tbody>
                </table>
                <div class="row no-gutters px-1 py-3 align-items-center justify-content-center">
                       {{ $files->links() }}
                   </div>
              </div>
            </div>
          </div>
    
    <ul>


          {{-- ACTIONNE LA VISUALISATION DE FICHIER  --}}

    <!-- ===============================================-->
          <!--    Modal MODIF USER -->
    <!-- ===============================================-->
          <div class="modal fade" id="viewDoc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Apreçue du fichier </h5>
                  <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span class="font-weight-light" aria-hidden="true">&times;</span></button>
                </div>
                <span id="link" class="text-center">
                  
                </span>
                <div class="modal-footer ">
                  
                  <button class="btn btn-secondary btn-sm updDocFormCls" type="button" data-dismiss="modal">Fermer</button>

                </div>
              </div>
            </div>
          </div>

{{-- POUR  LE PAGINATE  --}}
<input type="hidden" id="lastPrd" value="{{ $folder->id }}">


    <!-- ===============================================-->
          <!--    Modal MODIF USER -->
    <!-- ===============================================-->
          <div class="modal fade" id="modalDoc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Modification de fichier </h5>
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
                                <label for="name">Titre fichier</label>
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
                  <button class="btn btn-primary btn-sm updDoc" type="button">Mettre à jour</button>
                  <button class="btn btn-secondary btn-sm updDocFormCls" type="button" data-dismiss="modal">Fermer</button>

                </div>
              </div>
            </div>
          </div>


    <!-- ===============================================-->
          <!--    ANIMATION-->
    <!-- ===============================================-->

<div class="animation text-center invisible mt-5" id="animationDoc">

  <div>
  <span class="sr-only">Loading...</span>
  </div>
  <div class="spinner-grow text-secondary" role="status">
    <span class="sr-only">Loading...</span>
  </div>
  <div class="spinner-grow text-success" role="status">
    <span class="sr-only">Loading...</span>
  </div>
  <div class="spinner-grow text-info" role="status">
    <span class="sr-only">Loading...</span>
  </div>
  <div class="spinner-grow text-warning" role="status">
    <span class="sr-only">Loading...</span>
  </div>
  <div class="spinner-grow text-danger" role="status">
    <span class="sr-only">Loading...</span>
  </div>
  <div class="spinner-grow text-light" role="status">
    <span class="sr-only">Loading...</span>
  </div>
  <div class="spinner-grow text-dark" role="status">
    <span class="sr-only">Loading...</span>
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



        
        //Au clic de UpdAcess
          $('.updDoc').click(function()
          {
            ajaxUpdDoc();

          })

        //Rtour au dossier
          $('.folder').click(function()
          {
             $('#main_content').load('/mbo/listDoc');
          })
        //Actualiser la page 
          $('.refresh').click(function()
          {
            var idDoc = $(this).attr('id');
            $("#main_content").load("mbo/viewFolder?idDoc="+idDoc);
          });


        //Delete all DOC
          $('#btnDelAll').click(function()
          {
            var idFolder = $(this).attr('idFolder');
            var mytext = "La validation de cette action entrainera la supression de tous vos documents du dossier";
            ajaxDelAllDoc(0,mytext,idFolder);
          })

        //supression
          $('.btnDel').click(function()
          {
            var idFolder = $(this).attr('idFolder');
            var idEmpl= $(this).attr('id');
            var mytext = "Confirmer vous la supression de ce document ?";
            ajaxDelAllDoc(idEmpl,mytext,idFolder);
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
            $("#main_content").load("mbo/addDoc");  
          });



        //Telecharger une ressource
          $('.btnVoir').click(function()
          {

            $("#link").html($('#animationDoc').html());
            var lien = $(this).attr('lien');
            $("#link").attr("download", lien);
            var myIframe ='<div class="embed-responsive embed-responsive-16by9"  ><iframe class="embed-responsive-item" src="'+lien+'" allowfullscreen=""></iframe></div>';
            $("#link").html(myIframe);

            // lanceDownload()

          });
        

//Preload et lancement du telechargement
       function lanceDownload()
        {
         const ipAPI = '/storage/document/aMGpn9bVSltUWQKqJ0pMKLyPUFkJ7OWBrF0AORah.pdf';
         Swal.queue([{
          title: 'Téléchargement',
          confirmButtonText: 'Validez vous ce téléchargement ?',
          text:'En cours de télechargement',
          showLoaderOnConfirm: true,
          confirmButtonText: 'Oui, téléchargé',

          preConfirm: () => {
            return fetch(ipAPI)
              .then(response => response.text())
              .then(data => testMe(data))
              .catch(() => {
                Swal.insertQueueStep({
                  icon: 'error',
                  title: 'Erreur de connexion !!!'
                })
              })
          }
         }])

        };
      // Success de telechargement
        function testMe(data)
        {
          Swal.fire('Telechargement terminé');
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
                        url:'mbo/updFile',
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
                          //clique sur le lien de nav en entete
                          $(".refresh").click();
                          // $("#myNav").load("mbo/refreshNav");
                        },
                        error:function(){
                          Swal.fire('Problème de connexion internet');
                        }
                      });
                    }
                })
        
        }


      //Fonction Supression
        function ajaxDelAllDoc(idDoc,mytext,idFolder)
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
                        url:'mbo/delFile',
                        method:'GET',
                        data:{idDoc:idDoc,idFolder:idFolder},
                        dataType:'json',
                        success:function(){
                          
                          Swal.fire(
                           'Operation Effectuer avec succès!',
                           'Opération fait avec succès',
                           'success'
                          );

                          $('.refresh').click();
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