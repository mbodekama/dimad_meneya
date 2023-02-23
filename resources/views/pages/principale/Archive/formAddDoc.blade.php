
                  <div class="card-body bg-light">
                     
                      <form class="" method="POST" id='addDocForm' enctype="multipart/form-data">
                        @csrf
                          {{-- si Ce input a 0 => creation sinon => update  --}}
                          <input type="hidden" name="idUser" id="idUser" value="0">
                          <div class="form-row">
                            <div class="col-6">
                              <div class="form-group">
                                <label for="name">Emplacement (Dossier)</label>
                                <select class="form-control" id="dossier"  name="dossier"> 
                                  <option value="newdossier"  >
                                  </option>
                                  <option value="newdossier" >
                                    Nouveau Dossier
                                  </option>
                                 @if(!$dossiers->isEmpty())
                                 @foreach($dossiers as $dossier)
                                  <option value="{{ $dossier->id }}" >
                                    {{ $dossier->nomdossier }}
                                  </option>
                                  @endforeach
                                  @endif
                                </select>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group">
                                <label for="name">Titre Document</label>
                                <input class="form-control" id="name" name="titre" type="text" placeholder="06 caratères min." required>
                              </div>
                            </div>

                          <div class="col-6 custom-file mt-4">
                            <input class="custom-file-input" id="docFile" type="file" name="docFile">
                            <label class="custom-file-label" for="docFile">Votre fichier</label>
                          </div>

                            <div class="col-6">
                            <label for="datepicker">Date de création</label>
                            <input class="form-control datetimepicker" id="datepicker" type="text" data-options='{"dateFormat":"d/m/Y"}' value="{{ date('d/m/Y') }}" name="datepicker">
                          </div>
                            </div>
                            <div class="col-sm-12">
                                <label for="commentaire">Commentaire </label>
                                <textarea class="form-control" id="commentaire" name="commentaire" rows="3"></textarea>

                            </div>
                            </div>

                          </div>
                          <div class="col-auto d-flex justify-content-center">
                          <button class="btn btn-primary btn-block" id="saveDoc" >Enregistrer</button>
                        </div>
                      </form>
                </div>
 

  <script type="text/javascript">
    $(function()
    {
      //Voir liste des utilisateurs
        $('#btnList').click(function()
        {
           $('#main_content').load('mbo/listDoc');
        })



      //Verif input 
      $('#saveDoc').click(function(event)
      {
        event.preventDefault();

          if ($("#name").val() != "") 
            {

              $("#name").attr('class', 'form-control is-valid')
              if ($("#docFile").val() != "") 
                {
                  $("#docFile").attr('class', 'form-control is-valid');
                  //aPPEL DE FONCTION D4ENREGISTREMENT
                    ajaxSaveDoc();
                   
                   
                }
              else
              {
              $("#docFile").attr('class', 'form-control is-invalid');
              }

            }
          else
            {
              $("#name").attr('class', 'form-control is-invalid');
            }

      });

    //Au clic de nouveau doc
      $('#dossier').change(function()
      {
        if($('#dossier').val() == 'newdossier')
        {
          //Lancement process creation dossier;
          createDoc();

        }
      })


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
                  title: 'Des champs n\'ont pas été remplis',
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
            $("#addDoc").click();
          }

          // Fonction d'aout de fichir 
           function ajaxSaveDoc(form)
           {
            toastr.info('Fichier en chargement ...');
              // var myform = $('form#');
              var formData = new FormData(document.getElementById("addDocForm"));
             $.ajax({
               url:'/mbo/saveDoc',
               method:'POST',
               data:formData,
               dataType:'json',
               success:function(){

                Swal.fire({
                  icon: 'success',
                  title: 'Ajout fait avec succès',
                  showConfirmButton: true,
                  confirmButtonText: 'Retour',
                })
                 $("#addDoc").click();
                },
               cache : false,
               processData : false,
               contentType : false,
               error:function(){
                    toastr.error('Problème de connexion');
                }
             });
           }

    });
  </script>