<div class="card mb-3">
  <div class="bg-holder d-none d-lg-block bg-card" 
   style="background-image:url(../assets/img/illustrations/corner-4.png);">
  </div>
  <!--/.bg-holder-->

    <div class="card-body">
      <div class="row">
        <div class="col-lg-8">

          <h3 class="mb-0 text-primary"> <i class="fas fa-money-check-alt"></i> Versement >Liste</h3>
          <p class="mt-2"><b>Gérer vos versement</b>, Suivie des versements de vos succursales</p>
        </div>
      </div>
    </div>
</div>
      @if(!$versL->isEmpty())
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
                      <th class="align-middle sort">N°.Vers</th>
                      <th class="align-middle sort pr-7">Période</th>
                      <th class="align-middle sort" >Surccursale</th>
                      <th class="align-middle sort ">Montant(en FCFA)</th>
                      <th class="align-middle sort ">Statut</th>
                      <th class="no-sort">Action</th>
                    </tr>
                  </thead>
                  <tbody id="orders">

                   @foreach ($versL as $vers)
                    <tr class="btn-reveal-trigger">
                      <td class="py-2 align-middle white-space-nowrap"><a href="#">
                        {{ $vers->versMat }}
                      </td>
                      <td class="py-2 align-middle">
                        {{ $vers->dateDebut.' à '.$vers->dateFin }}
                      </td>
                      <td class="py-2 align-middle">
                         {{ readSurc($vers->succursale_id)->succursaleLibelle }}
                      </td>
                      
                      <td class="py-2 align-middle text-center fs-1 text-warning">
                        @if(!getHistVers($vers->id)->isEmpty())
                          @php
                            $mntPayeDeja = getHistVers($vers->id)->sum('montantPaye');
                          @endphp
                          @if($vers->versMnt - $mntPayeDeja == 0)
                            <del>{{formatPrice($vers->versMnt) }}</del>
                          @else
                            {{formatPrice($vers->versMnt - $mntPayeDeja) }}<br>
                            <del class="text-danger fs-0">
                              {{formatPrice($vers->versMnt)}}
                            </del>
                          @endif
                        @else
                          @php
                            $mntPayeDeja =0;
                          @endphp
                          {{formatPrice($vers->versMnt)}}
                        @endif
                      </td>
                      @if($vers->versStatu)
                          <td class="py-2 align-middle text-center ">
                            <span class="badge badge rounded-capsule d-block badge-soft-success">
                            Soldé
                            <span class="ml-1 fas fa-check" data-fa-transform="shrink-2"></span>
                            </span>
                            </td>
                      @else
                          <td class="py-2 align-middle text-center ">
                            <span class="badge badge rounded-capsule d-block badge-soft-danger">Non soldé</span>
                          </td>
                      @endif


                      <td class="py-2 align-middle">
                        @if($vers->versStatu)
                        <button class="btn btn-info mr-1 mb-1 histPay" 
                        type="button" data-toggle="modal" data-target="#histVers"
                        idVers ="{{ $vers->id}}"
                        nameSucHist ="{{ readSurc($vers->succursale_id)->succursaleLibelle }}">
                              Historique  
                        </button>
                        <span class="delVers" idVers ="{{ $vers->id}}" style="cursor: pointer;" >
                          <i class="far fa-trash-alt fa-2x mr-2 text-danger "></i>
                        </span>
                        @else
                        <button class="btn btn-warning mr-1 mb-1 payBtn" type="button" data-toggle="modal" data-target="#payVers"
                        nameSuc="{{ readSurc($vers->succursale_id)->succursaleLibelle }}" 
                        periode="{{ $vers->dateDebut.' à '.$vers->dateFin }}"
                        montantFormat= "{{ formatPrice($vers->versMnt - $mntPayeDeja) }}"
                        montant= "{{ $vers->versMnt}}"
                        montRst ="{{$vers->versMnt - $mntPayeDeja}}"
                        idVers ="{{ $vers->id}}">
                              Payer  
                        </button>
                        <button class="btn btn-info mr-1 mb-1 histPay" 
                        type="button" data-toggle="modal" data-target="#histVers"
                        idVers ="{{ $vers->id}}"
                        nameSucHist ="{{ readSurc($vers->succursale_id)->succursaleLibelle }}">
                              Historique  
                        </button>
                        <span class="delVers" idVers ="{{ $vers->id}}" style="cursor: pointer;" >
                          <i class="far fa-trash-alt fa-2x mr-2 text-danger "></i>
                        </span>
                        <span class="alertSuc" idVers ="{{ $vers->id}}" style="cursor: pointer;" >
                          <i class="fas fa-bell fa-2x  text-primary "></i>
                        </span>
                        @endif
                      </td>
                    </tr> 
                  @endforeach                 
                  </tbody>
                </table>
                <div class="row no-gutters px-1 py-3 align-items-center  justify-content-center">
                                  {{ $versL->links() }}
                   </div>
              </div>
            </div>
          </div>
      @else
      <div class="alert alert-warning h3 text-center">Aucun versement à afficher</div>
      @endif




      {{-- MES MODALS --}}

      <!-- Modal Historique-->
      <div class="modal fade" id="histVers" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Historique de paiement > 
                <span class="text-danger" id="nameSucHist"></span>
              </h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span class="font-weight-light" aria-hidden="true">&times;</span></button>
            </div>
            <form class="modal-body" id="histVersForm">


            </form>
            <div class="modal-footer">
              <button class="btn btn-secondary btn-sm closeBtn" type="button" data-dismiss="modal">Fermer</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal Payement-->
    <div class="modal fade" id="payVers" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
              Paiement de Versement > 
              <span class="text-danger" id="nameSuc"></span>
               </h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span class="font-weight-light" aria-hidden="true">&times;</span></button>
          </div>
          <form class="modal-body" id="payVersForm">
                  <div class="form-group">
                     <label for="infoVers">Période => Montant Restant</label>
                     <input class="form-control" id="infoVers" type="text" 
                     readonly="">
                  </div>
                  <div class="form-row">
                    <div class="col-6">
                     <div class="form-group">
                     <label for="agent" class="text-danger">Agent (Nom du caissier)
                      <span class="fas fa-times-circle " data-fa-transform="shrink-1"></span>
                     </label>
                     <input class="form-control" id="agent" name="agent" value="{{ Auth::user()->name }}"  type="text" readonly="">
                    </div>                 
                    </div>
                    <div class="col-6">
                      <div class="form-group">
                        <label for="agent">Type paiement</label>
                        <select class="form-control" id="moyen"  name="moyen">
                              <option value="Mobile money" >Mobile money</option> 
                              <option value="Chèques" >Chèques</option>
                              <option value="Espèce" >Espèce</option>
                              <option value="Virement Bancaire" >Virement Bancaire</option>
                        </select>
                      </div>                 
                    </div>
                    <div class="col-6">
                      <div class="form-group ">
                       <label for="montant " class="text-danger">
                          Montant 
                          <span class="fas fa-times-circle text-danger" data-fa-transform="shrink-1"></span>
                       </label>
                       <input class="form-control" id="montant" type="number" name='montant' value="" min='1' max="">
                      </div>
                    </div> 
                    <div class="col-6">
                      <div class="form-group">
                              <label for="datePayVers">Date (date de paiement) </label>
                              <input class="form-control form-control-sm datetimepicker flatpickr-input" id="datePayVers" required="" name="datePayVers" type="text" placeholder="d/m/Y" value="{{ date('d/m/Y') }}" >
                            </div>
                    </div> 
                        {{-- input hidden  important --}}
                        @csrf
                        <input type="hidden" name="idVers" id="idVers">
                  </div>


          </form>
          <div class="modal-footer">
            <button class="btn btn-secondary btn-sm payModCls" type="button" data-dismiss="modal">Fermer</button>
            <button class="btn btn-primary btn-sm" type="button" id="validPayVers">Valider</button>
          </div>
        </div>
      </div>
    </div>



      {{-- MES MODALS --}}
     <script type="text/javascript">
   
        // Faire disparaitre les paginate de Javascript
          $(".mytable").parent().next().hide();   


        //Valider 
         $('.valider').click(function(){
            var idV     = $(this).attr('id');
            var action = 'OkVers';
            Swal.fire({
             title: 'Versement',
             text: "Voulez vous solder le versement ?",
             icon: 'warning',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             cancelButtonText: 'Annuler',
             confirmButtonText: 'oui , solder!'
            }).then((result) => {
              if (result.value) {
                $.ajax({
                  url:'/p_versOk',
                  method:'GET',
                  data:{idV:idV,action:action},
                  dataType:'text',
                  success:function(){
                    $("#main_content").load("/p_LVer");
                    Swal.fire(
                     'Solder!',
                     'Versement solder avec succès',
                     'success'
                    );
                  },
                  error:function(){
                    Swal.fire('Problème de connection internet');
                  }
                });
              }
          })
         });

        //Supprimer un versement
        $('.delVers').click(function(){     
          var idVers = $(this).attr('idVers');
          Swal.fire({
            title: 'Versement',
            text: "Voulez-vous supprimer ce versement ?",
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
                  url:'/mbo/delVers',
                  method:'GET',
                  data:{idVers:idVers},
                  dataType:'text',
                  success:function(){
                    Swal.fire(
                     'Supprimer!',
                     'Versement supprimer avec succès',
                     'error'
                    );
                    $("#main_content").load("mbo/p_LVer");
                  },
                  error:function(){
                    Swal.fire('Problème de connection internet');
                  }
                });
              }
          })
        });


        //Send alert to succursal
          $('.alertSuc').click(function(){
           var idVers = $(this).attr('idVers');
          Swal.fire({
            title: 'Envoie d\'alerte',
            text: "Confirmez l'envoie de la notification (notification Meneya, mail,SMS) à la succursale",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Annuler',
            confirmButtonText: 'oui , Envoyer!',
            backdrop: `rgba(240,15,83,0.4)`
          }).then((result) => {
              if (result.value) {
                $.ajax({
                  url:'/mbo/alertVers',
                  method:'GET',
                  data:{idVers:idVers},
                  dataType:'text',
                  success:function(){

                    Swal.fire(
                     'Alertes!',
                     'Les différentes notifications ont été envoyés avec succès',
                     'success'
                    );
                    // toastr.error('Notifications momentanemnt desactivé');
                    // $("#main_content").load("/p_LVer");
                  },
                  error:function(){
                    Swal.fire('Problème de connection internet');
                  }
                });
              }
          })
            }); 


        //Clique bouton payer
          $('.payBtn').click(function()
          {
            //reuperation de valeur
              var nameSuc = $(this).attr('nameSuc');
              var periode = $(this).attr('periode');
              var montantFormat = $(this).attr('montantFormat');
              var montant = $(this).attr('montant');
              var montRst = $(this).attr('montRst');
              var idVers  =$(this).attr('idVers');

            //Ajout dans le modal
              $('#nameSuc').text(nameSuc);
              $('#infoVers').val("Du "+periode+" => "+montantFormat);
              $('#idVers').val(idVers);
              $('#montant').attr('max',montRst);

          })


        //Voir l'historique des paiements 
          $('.histPay').click(function()
          {
            //Recup de valeur
              var idVers = $(this).attr('idVers');
              var nameSucHist = $(this).attr('nameSucHist');

            //Insertion modal 
              $('#nameSucHist').text(nameSucHist);
                $.ajax({
                    url:'mbo/histPayVers',
                    method:'GET',
                    data:{idVers:idVers},
                    dataType:'html',
                    success:function(data){
                    
                     $('#histVersForm').html(data);
                    },
                    error:function(){
                      Swal.fire('Problème de connection internet');
                    }
                  });     

          })

        //Cliquer sur btn Valider le versement 
          $('#validPayVers').click(function()
          {

            if(parseInt($('#montant').val()) !=0 && parseInt($('#montant').val())<= parseInt($('#montant').attr('max') ))
            {
              ajaxPayVers();
            }
            else
            {
              toastr.error('Veiullez saisir un montant valide');
              $('#montant').attr('class','form-control is-invalid');
            }

          })
        // Fonction enregistrement du paiement
          function ajaxPayVers()
          {
                $.ajax({
                  url:'mbo/payVers',
                  method:'POST',
                  data:$('#payVersForm').serialize(),
                  dataType:'text',
                  success:function(){
                    $('.payModCls').click();
                    Swal.fire(
                     'Paiement!',
                     'Votre paiement a été enregistré avec sucès',
                     'success'
                    );
                    // toastr.error("Verifier le controller pour notifier la succursale");
                    $("#main_content").load("mbo/p_LVer");
                  },
                  error:function(){
                    Swal.fire('Problème de connection internet');
                  }
                });     
          }
     </script>