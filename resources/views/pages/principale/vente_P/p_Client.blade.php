<div class="card mb-3">
  <div class="bg-holder d-none d-lg-block bg-card" 
   style="background-image:url(../assets/img/illustrations/corner-4.png);">
  </div>
  <!--/.bg-holder-->

    <div class="card-body">
      <div class="row">
        <div class="col-lg-8">
          <h3 class="mb-0 text-primary"><i class="fas fa-users"></i> Mes clients</h3>
          <p class="mt-2">Gestion des clients des clients</p>
        </div>
        <div class="col-lg-12 d-flex justify-content-around">


                  @if(!$clts->isEmpty())
                  <button class="btn btn-falcon-danger btn-sm mr-2" role="button"> 
                    <i class="fas fa-chart-pie mr-1 text-900 "></i>
                     {{ formatQte(allCltSuc(userHasSucc(Auth::id())->id)->count()) }} Clients
                  </button>
                  <?php $best= getBestClt() ?>
                  <button class="btn btn-falcon-danger btn-sm mr-2 bestClt" 
                    nom="{{ $best['nom'] }}" contact="{{ $best['contact'] }}" montant="{{ formatPrice($best['montant']) }}" >
                    <i class="fas fa-eye mr-1 text-900 "></i>
                    Mon meilleur client
                  </button>
                  <button class="btn btn-falcon-danger btn-sm mr-2" role="button"> 
                    <i class="fas fa-money-check-alt mr-1 text-900 "></i>
                    Achat du meilleur: {{  formatPrice($best['montant']) }}
                  </button>
                  @endif
                  
      </div>
      </div>
    </div>
</div>


          @if(!$clts->isEmpty())
          <div class="card mb-3">
            <div class="card-header">
              <div class="row align-items-center justify-content-between">
                @include('pages/dash/pagnMod')
              </div>
            </div>
            <div class="card-body p-0" id="loaderContent">

              <div class="falcon-data-table">
                <table class="mytable table table-sm mb-0 table-striped table-dashboard fs--1 data-table border-bottom border-200" data-options='{"searching":true,"responsive":false,"pageLength":100,"info":false,"lengthChange":false,"sWrapper":"falcon-data-table-wrapper","dom":"<&#39;row mx-1&#39;<&#39;col-sm-12 col-md-6&#39;l><&#39;col-sm-12 col-md-6&#39;f>><&#39;table-responsive&#39;tr><&#39;row no-gutters px-1 py-3 align-items-center justify-content-center&#39;<&#39;col-auto&#39;p>>","language":{"paginate":{"next":"<span class=\"fas fa-chevron-right\"></span>","previous":"<span class=\"fas fa-chevron-left\"></span>"}}}'>
                  <thead class="bg-200 text-900">
                    <tr>
                      <th class="align-middle sort">N°</th>
                      <th class="align-middle sort">Nom</th>
                      <th class="align-middle sort">Contact</th>
                      <th class="align-middle sort">Lieu</th>
                      <th class="align-middle sort">Date</th>
                      <th class="align-middle text-center">Action</th>
                    </tr>
                  </thead>
                   <tbody id="customers">

                    @foreach($clts as $clt)
                    @php
                    $cltInfo = getClient($clt->id)
                    @endphp
                      <tr class="">
                        <td>
                           {{ $loop->iteration }}
                        </td>
                        <td>
                          {{ $clt->nom }}
                        </td>
                        <td>
                          {{ $clt->contact }}
                        </td>
                        <td>
                          {{ $clt->lieu ?? "Non définis" }}

                        </td>
                        <td>
                          {{ $clt->date }}
                        </td>
                       
                        <td class="text-center">
                          <button class="btn  mr-1 liste " type="button" data-toggle="modal" data-target="#lPrd" id="{{ $clt->id }}">
                          <span class='fas fa-list-alt fa-2x  text-primary ' ></span>
                          </button>
                         <button class="btn mr-1 editClt" type="button" 
                         data-toggle="modal" data-target="#modAddClt"
                         id="{{ $clt->id }}"
                         nom="{{ $cltInfo->nom }}"
                         contact="{{ $cltInfo->contact  }}"
                         lieu="{{ $cltInfo->lieu }}"
                         date="{{ $cltInfo->date }}"

                         >
                         <span class="far fa-edit text-warning text-center fa-2x " data-fa-transform="shrink-3"></span>
                         </button>
                        {{--  Bouton suprimer
                        <button class="btn mr-1 delete" type="button" id="{{ $clt->id }}">
                         <span class="fas fa-trash text-danger text-center fa-2x " data-fa-transform="shrink-3"></span>
                         </button> --}}
                        </td>

                      </tr>
                    @endforeach
                  </tbody>
                </table>

                  <div class="row no-gutters px-1 py-3 align-items-center justify-content-center">
                         {{ $clts->links() }}
                     </div>
              </div>
            </div>
          </div>
          @else
            <div class="alert alert-danger text-center h5">
                Aucune vente enregistrer. Veuillez cliquer sur le bouton nouveau pour effectuer enregistrer une vente.
              </div>
          @endif



{{-- MODAL AJOUT DE CLIENT  --}}
  @include('pages/dash/addCltMod')
{{-- MODAL AJOUT DE CLIENT  --}}

        {{-- MODAL DE LA LISTE DES PRODUITS DE LA VENTE --}}

            <div class="modal fade" id="lPrd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Résume des achats</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span class="font-weight-light" aria-hidden="true">&times;</span></button>
                  </div>
                  <div class="modal-body">
                    <div class="lPrdBody">
                      
                    </div>

                  </div>
                  <div class="modal-footer">
                    <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">
                      Fermer
                    </button>
                  </div>
                </div>
              </div>
            </div>



        {{-- FIN DE LA LISTE DES PRODUITS DE LA VENTE --}}


            {{-- SPINNER DU MODAL --}}

                  @csrf
                  <div class="d-none" id='spiner'>
                  <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                  </div>
                  <div class="spinner-border text-secondary" role="status">
                    <span class="sr-only">Loading...</span>
                  </div>
                  <div class="spinner-border text-success" role="status">
                    <span class="sr-only">Loading...</span>
                  </div>
                  <div class="spinner-border text-info" role="status">
                    <span class="sr-only">Loading...</span>
                  </div>
                  <div class="spinner-border text-warning" role="status">
                    <span class="sr-only">Loading...</span>
                  </div>
                  <div class="spinner-border text-danger" role="status">
                    <span class="sr-only">Loading...</span>
                  </div>
                  <div class="spinner-border text-light" role="status">
                    <span class="sr-only">Loading...</span>
                  </div>
                  <div class="spinner-border text-dark" role="status">
                    <span class="sr-only">Loading...</span>
                  </div>
                    
                  </div>

            {{-- fin  SPINNER DU MODAL --}}


  <script type="text/javascript">
$(function()
  {

    //Info meiller cient
    $('.bestClt').click(function()
    {
      var nom = $(this).attr('nom'); 
      var contact = $(this).attr('contact'); 
      var montant = $(this).attr('montant');
        Swal.fire({
          title: '<strong>Meilleur client</strong>',
          icon: 'info',
          html:
            'Nom du client : <b>'+nom+'</b><br> '+
            'Contact : <b>'+contact+'</b><br> ' +
            'Total Achats : <b>'+montant+'</b><br> ',
          confirmButtonText:
            '<i class="fa fa-thumbs-up"></i> Merci!',
          confirmButtonAriaLabel: 'Merci',
        })
    })

      // Faire disparaitre les paginate de Javascript
          $(".mytable").parent().next().hide();

      //Liste des acahts du clt
          $('.liste').click(function()
          {
            //Ajout spiner
            $('.lPrdBody').html($('#spiner').html());

            var idClt = $(this).attr('id');
            //req ajax 
            ajaxlistAchat(idClt);

          });


      //Action au clic sur Editer 
        $('.editClt').click(function()
        {
          //Le modal d'ajout de client s'affiche
          //recup des attribut du clt 
            var id=$(this).attr("id");
            var nom=$(this).attr("nom");
            var contact=$(this).attr("contact");
            var lieu=$(this).attr("lieu");
            var date=$(this).attr("date");
          //Affectation au champ input du modal
            $('#name').val(nom);
            $('#contact').val(contact);
            $('#lieu').val(lieu);
            $('#date').val(date);
          //Input necessaire pour savoir s'il sagit d1 update
            $('#idClt').val(id);


        })
      //Action au clic de suprimer
        $('.delete').click(function(){
          var idClt = $(this).attr('id');
          var action = 'Del';
          Swal.fire({
            title: 'Client',
            text: "Voulez-vous suprimer ce client ?  La suppression affectera vos statitiques de vente !",
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Annuler',
            confirmButtonText: 'oui , supprimer!',
            backdrop: `rgba(240,15,83,0.4)`
          }).then((result) => {
              if (result.value) {
                $.ajax({
                  url:'/delClt',
                  method:'GET',
                  data:{idClt:idClt},
                  dataType:'text',
                  success:function(){
                    Swal.fire(
                     'Supprimer!',
                     'Supression validé avec succès.',
                     'error'
                    );
                  $('#sucCont').load('/s_Client'); //Actualiser la page

                  },
                  error:function(){
                    Swal.fire('Problème de connection internet');
                  }
                });
              }
          })
        });


      //Fonction recup liste des achat du client
         function ajaxlistAchat(idClt)
         {
         $.ajax({
                  url:'/mbo/listAchatClt',
                  method:'GET',
                  data: {idClt:idClt},
                  dataType:'html',
                  success:function(data){
                  $('.lPrdBody').html(data);         
                  },
                  error:function()
                  {
                    Swal.fire('Problème de connection internet');
                      $('.lPrdBody').html("<h3 class='text-danger'>Problème de connection Internet. Reéssayer !! <h3>");

                  }
                });          

         }
  
      //Valiider form ajout client
            $('.addClt').click(function()
            {

              if( $('#name').val() != '')
              {
                if( $('#contact').val() != '')
                  {
                    if($('#idClt').val() !='0')
                    {
                      ajaxCltUpd();
                    }
                    else
                    {
                      ajaxCltAdd();
                    }
                  }
                else
                {
                  toastr.error('Veuilez remplir tous les champs');
                }
              
              }else
                {
                  toastr.error('Veuilez remplir tous les champs');
                }
            })

      //Ajax  Client Add
        function ajaxCltAdd()
          {
            //envoie de la commande dans une requete ajax 
  
                  $.ajax(
                  {
                      method: "POST",
                      url: "/mbo/AddClt",
                      data: $('#formAddClt').serialize(),
                      dataType: "json",
                  })

              .done(function(data) 
                      {

                        toastr.success("Client ajouté avec succès");
                        $("#formAddClt").trigger("reset");
                          $('#modAddClt').modal('hide');
                          $('#main_content').load('/mbo/s_Client'); //Actualiser la page


                       })
              .fail(function(data) 
                        {
                          toastr.error("Erreur d'ajout du client.");
                        });
          }


      //Ajax  Client Add
        function ajaxCltUpd()
          {
            //envoie de la commande dans une requete ajax 
  
                  $.ajax(
                  {
                      method: "POST",
                      url: "/mbo/UpdClt",
                      data: $('#formAddClt').serialize(),
                      dataType: "json",
                  })

              .done(function(data) 
                      {

                    Swal.fire(
                     'Modification!',
                     'Client modifié avec succès.',
                     'success'
                    );
                        $("#formAddClt").trigger("reset");
                          $('#modAddClt').modal('hide');
                          $('#main_content').load('/mbo/s_Client'); //Actualiser la page


                       })
              .fail(function(data) 
                        {
                          toastr.error("Erreur d'ajout du client.");
                        });
          }
      


  }) //Fin des scripts
</script>