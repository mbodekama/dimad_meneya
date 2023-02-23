<div class="card mb-3 no-print">
  <div class="bg-holder d-none d-lg-block bg-card" 
   style="background-image:url(../assets/img/illustrations/corner-4.png);">
  </div>
  <!--/.bg-holder-->

    <div class="card-body">
      <div class="row">
        <div class="col-lg-8">
          <h4 class="mb-0 text-primary"><i class="fas fa-money-bill-wave"></i> Gestion des factures > Mes Factures proformats</h4>
          <p class="mt-2">Liste des factures proformats editées </p>
        </div>
      </div>
    </div>


</div>
            <div class="card mb-3 no-print">
            <div class="card-body">
              <div class="row justify-content-between align-items-center">
                <div class="col-md">
                  {{-- <h5 class="mb-2 mb-md-0">Statistiques</h5> --}}
                </div>
                <div class="col-auto">
                  <button class="btn btn-falcon-primary btn-sm mr-2" id="newVente" role="button"> Nouvelle vente</button>
                  <button class="btn btn-falcon-danger btn-sm mr-2" id="delAll" role="button"> Tous suprimer</button>
                  <button class="btn btn-falcon-danger btn-sm mr-2" id="refresh" role="button"> Actualiser</button>
                  @csrf
                </div>
              </div>
            </div>
          </div>

        @if(!$ventes->isEmpty())
          <div class="card mb-3  no-print">
            <div class="card-header">
              <div class="row align-items-center justify-content-between">
                <div class="col-4 col-sm-auto d-flex align-items-center pr-0">
                  <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Liste de vos différentes factures <a href="" data-toggle="modal" data-target="#exampleModalRight"></a></h5>
                </div>
                       @include('pages/dash/pagnMod')
              </div>
            </div>
            <div class="card-body p-0" id="loaderContent">
              <div class="falcon-data-table">
                <table class="mytable table table-sm mb-0 table-striped table-dashboard fs--1 data-table border-bottom border-200" data-options='{"searching":true,"responsive":true,"pageLength":100,"info":false,"lengthChange":false,"sWrapper":"falcon-data-table-wrapper","dom":"<&#39;row mx-1&#39;<&#39;col-sm-12 col-md-6&#39;l><&#39;col-sm-12 col-md-6&#39;f>><&#39;table-responsive&#39;tr><&#39;row no-gutters px-1 py-3 align-items-center justify-content-center&#39;<&#39;col-auto&#39;p>>","language":{"paginate":{"next":"<span class=\"fas fa-chevron-right\"></span>","previous":"<span class=\"fas fa-chevron-left\"></span>"}}}'>
                  <thead class="bg-200 text-900">
                    <tr>
                      <th class="align-left sort">N° </th>
                      <th class="align-middle sort ">Date </th>
                      <th class="align-middle sort" >Client</th>
                      <th class="align-middle sort" >Qte article</th>
                      <th class="align-middle sort text-left">Montant Net</th>
                      <th class="align-middle sort text-center">
                        Action
                      </th>
                    </tr>
                  </thead>
                  <tbody id="orders">
                    @foreach($ventes as $vente)
                      <tr class="fs-0">
                          <th class="align-left sort">{{ $loop->iteration }}</th>
                          <th class="align-middle sort  ">{{ $vente->dateV }}</th>
                          <th class="align-middle sort" >
                            {{ getClient($vente->clients_id)->nom}}
                          </th>
                          <th class="align-middle sort" >
                            {{ $vente->qte }}
                          </th>
                          <th class="align-middle sort text-left">
                            <span class="badge badge rounded-capsule d-block badge-soft-secondary text-warning fs-1">
                            {{ formatPrice($vente->prix_vente_total + $vente->charge)}}
                            </span>
                           
                          </th>
                          <th class="align-middle sort text-center"  style="cursor: pointer;">
                          <span class='far fa-check-circle fa-2x  text-success validBtn' id="{{ $vente->id }}" 
                            name="{{ getClient($vente->clients_id)->id}}" ></span>                          
                          <span class='fas fa-eye fa-2x  text-primary consultBtn' id="{{ $vente->id }}" 
                            name="{{ getClient($vente->clients_id)->id}}" ></span>
                        
                          
                          <span class='far fa-file-pdf fa-2x  text-warning reçu ' id="{{ $vente->id }}" name="{{ getClient($vente->clients_id)->id}}" ></span>
                         
                          
                          <span class='far fa-edit fa-2x text-info editBtn ' id="{{ $vente->id }}" name="{{ getClient($vente->clients_id)->id}}"></span>
                        
                          
                          <span class='fas fa-trash fa-2x  text-danger deleteBtn ' id="{{ $vente->id }}" name="{{ getClient($vente->clients_id)->id}}" ></span>
                          


                          </th>
                      </tr>
                    @endforeach
                  </tbody>

                </table>
                <div class="row no-gutters px-1 py-3 align-items-center justify-content-center">
                       {{ $ventes->links() }}
                   </div>
              </div>
            </div>
          </div>

        @else
        <div class="alert alert-warning text-center h5">Aucunes Factures proformats</div>
        @endif


    <!-- ===============================================-->
    <!--    MODALS-->
    <!-- ===============================================-->

<!-- Button trigger modal-->

<!-- Modal-->
<div class="modal fade" id="exampleModalRight" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Détail > Vente</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span class="font-weight-light" aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body" id="modalBody">
      </div>
    </div>
  </div>
</div>


     <!-- ===============================================-->
    <!--    Fichier Facture pour operateur-->
    <!-- ===============================================-->

      @include('pages/dash/facture/vntP')

    <!-- ===============================================-->
    <!--    Fin Fichier Facture pour operateur -->
    <!-- ===============================================-->   

    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->

    <script type="text/javascript">
      $(function()
      {
        // Faire disparaitre les paginate de Javascript
          $(".mytable").parent().next().hide();
        //Nouvelle vente 
          $('#newVente').click(function()
          {
            $('#main_content').load('mbo/venteP');
          })


        //Consulter les detail
          $('.consultBtn').click(function()
            {
              ajaxDetailVntP($(this).attr('id'),$(this).attr('name'));

            });


        //Consulter les detail
          $('.editBtn').click(function()
            {
              var idV = $(this).attr('id');
              var idClt =$(this).attr('name');
              var token =$('input[name=_token]').val();
             $("#main_content").load("mbo/editVntP",{ idV :idV,idClt :idClt,_token:token});


            });

      //Fonction de consultation des details
        function ajaxDetailVntP(cmd_id,id_clt)
        {

                    $.ajax({
                    method: "GET",
                    url: "mbo/ajaxDetailVntP",
                    data: {NumVente:cmd_id,idClt:id_clt },
                      dataType: "html",
                  })

          .done(function(data) 
                  {

                    // toastr.success("Article ajouté avec succès  ");

                    $('#modalBody').html(data);
                    $('#exampleModalRight').modal('show');

                   })
          .fail(function(data) 
            {
                        
                toastr.error("Problème de connexion internet  ");
            });
        }

        $('.deleteBtn').click(function()
        {
          var idVente = $(this).attr('id');
          var idClt = $(this).attr('name');
          ajaxDeleteVente(idVente, idClt );
        })

        $('.validBtn').click(function()
        {
          var idVente = $(this).attr('id');
          var idClt = $(this).attr('name');
          ajaxValidVnt(idVente, idClt );
        })

        $('#delAll').click(function()
        {
          var type = 0 // Correspond au typevente des facture proformat
          ajaxDelAllVnt(type);
        })

        //Supression d'une vente
          function ajaxDeleteVente(idVente,idSuc)
          {


                  Swal.fire({
                    title: 'Suppresion vente',
                    text: "Voulez vous supprimer cette vente de la liste de vos vente ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Annuler',
                    confirmButtonText: 'oui , Supprimer!',
                    backdrop : 'rgba(240,15,83,0.4)'
                  }).then((result) => {
                      if (result.value) {
                        $.ajax({
                          url:'mbo/delVntP',
                          method:'GET',
                          data:{idVente:idVente},
                          dataType:'json',
                          success:function(){
                            Swal.fire(
                             'Supression!',
                             'Produits suipprimé avec succès',
                             'success'
                            );
                            $("#main_content").load("mbo/lfactuProP");
                          },
                          error:function(){
                            Swal.fire('La suppression de produits est impossible');
                          }
                        });
                      }
                  })
          
          }

        //Valider une facture proformat en vente

          function ajaxValidVnt(idVente)
          {


                  Swal.fire({
                    title: 'Validation de facture',
                    text: "La facture sera enregistré comme une vente et votre stock sera inputé. Veuille confirmé !",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Annuler',
                    confirmButtonText: 'oui , confirmé!',
                    backdrop : 'rgba(240,15,83,0.4)'
                  }).then((result) => {
                      if (result.value) {
                        $.ajax({
                          url:'mbo/validVnt',
                          method:'GET',
                          data:{idVnt:idVente},
                          dataType:'json',
                          success:function(){
                            Swal.fire(
                             'Vente!',
                             'La vente  a été enrgistré avec succès',
                             'success'
                            );
                            $("#main_content").load("mbo/lventeP");
                          },
                          error:function(){
                            Swal.fire("Problème de connexion");
                          }
                        });
                      }
                  })
          
          }
        //Supression toutes les vente
          function ajaxDelAllVnt(type)
          {


                  Swal.fire({
                    title: 'Suppresion des ventes',
                    text: "Voulez vous supprimer toutes les ventes ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    cancelButtonText: 'Annuler',
                    confirmButtonText: 'Tous supprimer!',
                    backdrop : 'rgba(240,15,83,0.4)'
                  }).then((result) => {
                      if (result.value) {
                        $.ajax({
                          url:'mbo/delAllVntP',
                          method:'GET',
                          data:{action:'alldelete',typevente:type},
                          dataType:'json',
                          success:function(){
                            Swal.fire(
                             'Supression!',
                             'Ventes suipprimés avec succès',
                             'success'
                            );
                            $("#main_content").load("mbo/lfactuProP");
                          },
                          error:function(){
                            Swal.fire('Problème de connexion');
                          }
                        });
                      }
                  })
          
          }


      //Actualiser
        $('#refresh').click(function()
        {
          $("#main_content").load("mbo/lfactuProP"); 
        })      
    //Impression du recu
        $('.reçu').click(function()
        {

          var idVnt = $(this).attr('id');
          printRecu(parseInt(idVnt)); 

        });

    //Impression du recu
        function printRecu(idVnt)
        {
       
               var idVnt = idVnt;              
          $.ajax({
                 url:'mbo/recuVntP',
                 method:'get',
                 data:{NumVente:idVnt},
                 dataType:'html',
                 success:function(data)
                 {
                   $('#recu_content').html('');
                   $('#recu_content').html(data);
                    print();
                 },
                 error:function()
                 {
                  toastr.error('Erreur ');
                 },

               });
                  }

      })
    </script>