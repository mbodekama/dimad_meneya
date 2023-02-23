

          <!-- -------------------------------------------->
          <!--    Tables, Files, and Lists-->
          <!-- -------------------------------------------->
          <div class="media mt-3"><span class="fa-stack mr-2 ml-n1"><i class="fas fa-circle fa-stack-2x text-300"></i><i class="fa-inverse fa-stack-1x text-primary fas fa-list" data-fa-transform="shrink-2"></i></span>
            <div class="media-body">
              <h5 class="mb-1 text-primary position-relative"><span class="bg-200 pr-3">Liste de tous vos produits</span>
                <span class="border position-absolute absolute-vertical-center w-100 z-index--1 l-0"></span></h5>
            </div>
          </div>

            <div class="card mb-3 no-print">
            <div class="card-body">
              <div class="row justify-content-between align-items-center">
                <div class="col-md">
                  <h5 class="mb-2 mb-md-0">Statistiques</h5>
                </div>
                <div class="col-auto">

                  <button class="btn btn-falcon-danger btn-sm mr-2 listCatg" role="button" data-toggle="modal" data-target="#histMod"> <i class="fas fa-chart-pie mr-1 text-900 " ></i>Mes Categories</button>
                  <button class="btn btn-falcon-primary btn-sm mr-2 byCatg" role="button"><i class="fas fa-sort-amount-down-alt" ></i> Trier par Catégorie</button>
                   <button class="btn btn-falcon-default btn-sm" id="addBtn" type="button" data-toggle="modal" data-target="#modalAddProd" data-backdrop="static" ><span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span><span class="d-none d-sm-inline-block ml-1">Ajouter</span></button>
                    <button class="btn btn-falcon-default btn-sm mx-2" id="btnActualiser" type="button"><span class="fas fa-sync-alt" data-fa-transform="shrink-3 down-2"></span><span class="d-none d-sm-inline-block ml-1">Actualiser</span></button>
                </div>
              </div>
            </div>
          </div>
            <div class="card mb-3 no-print d-none" id="mesCategorie">
            <div class="card-body">
              <div class="row justify-content-between align-items-center">
                <div class="col-md">
                  <h5 class="mb-2 mb-md-0">Categories</h5>
                </div>
                <div class="col-auto">
                  @foreach(getCatgo() as $catgo)
                <button class="btn btn-falcon-primary btn-sm mr-2 categorie" id="{{ $catgo->id }}" role="button"> 
                  <i class="fas fa-sort-amount-up-alt text-900"></i> &nbsp;{{ $catgo->libelle }}
                </button>
                  @endforeach
                   
                </div>
              </div>
            </div>
          </div>
          @if(!$produits->isEmpty())
          <div class="card mb-3">

            <div class="card-header">
              <div class="row align-items-center justify-content-between">
                <div class="col-4 col-sm-auto d-flex align-items-center pr-0">
                  <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">
              <p class="mb-0">Vous avez 
                <span class="badge badge-pill badge-soft-success fs-2"> {{ prdTotalP()->count() }} </span>  &nbsp;articles
              </p>                   
                  </h5>
                </div>
                @include('pages/dash/pagnMod')

              </div>
            </div>



            <div class="card-body p-0" id="loaderContent">
              @if(!$produits->isEmpty())
              <div class="falcon-data-table ">
                <table class="mytable table table-sm mb-0 table-striped table-dashboard fs--1 data-table border-bottom border-200" data-options='{"searching":true,"responsive":false,"pageLength":100,"info":false,"lengthChange":false,"sWrapper":"falcon-data-table-wrapper","dom":"<&#39;row mx-1&#39;<&#39;col-sm-12 col-md-6&#39;l><&#39;col-sm-12 col-md-6&#39;f>><&#39;table-responsive&#39;tr><&#39;row no-gutters px-1 py-3 align-items-center justify-content-center&#39;<&#39;col-auto&#39;p>>"}'>
                  <thead class="bg-200 text-900">
                    <tr>
                      <th class="align-middle no-sort pr-3">
                        <div class="custom-control custom-checkbox">
                          <input class="custom-control-input checkbox-bulk-select" id="checkbox-bulk-customers-select" type="checkbox" data-checkbox-body="#customers" data-checkbox-actions="#customers-actions" data-checkbox-replaced-element="#customer-table-actions" />
                          <label class="custom-control-label" for="checkbox-bulk-customers-select"></label>
                        </div>
                      </th>
                      <th class="align-middle sort">N°</th>
                      <th class="align-middle sort">Code produit</th>
                      <th class="align-middle sort">Libelle Produit</th>
                      <th class="align-middle sort">Prix Unitaire </th>
                      <th class="align-middle sort">Action</th>
                    </tr>
                  </thead>
                  <tbody id="customers">
                      @foreach($produits as $produit)
                        <tr>
                          <th class="align-middle no-sort pr-3">
                            <div class="custom-control custom-checkbox">
                              <input class="custom-control-input checkbox-bulk-select" id="checkbox-bulk-customers-select" type="checkbox" data-checkbox-body="#customers" data-checkbox-actions="#customers-actions" data-checkbox-replaced-element="#customer-table-actions" />
                              <label class="custom-control-label" for="checkbox-bulk-customers-select"></label>
                            </div>
                          </th>

                          <th class="align-middle sort">{{ $loop->iteration }}</th>
                          <th class="align-middle sort">{{ $produit->produitMat }}</th>
                          <th class="align-middle sort">{{ $produit->produitLibele }}</th>
                          <th class="align-middle sort">{{ $produit->produitPrix  }} fcfa</th>
                          <th class="align-middle sort">
                            <a href="#"  class="editProduit mr-2 text-danger" 
                            data-toggle="modal" data-target="#modalAddProd" 
                            id="{{ $produit->id }}" data-backdrop="static"      
                            produitMat = "{{ $produit->produitMat }}"
                            produitLibele = "{{ $produit->produitLibele }}"
                            produitPrix = "{{ $produit->produitPrix }}"
                            produitPrixFour = "{{ $produit->produitPrixFour }}"
                            unite_mesure = "{{ $produit->unite_mesure }}"
                            seuilAlert = "{{ $produit->seuilAlert }}"
                            categorie_id = "{{ $produit->categorie_id }}"
                            charge = "{{ $produit->autre_charge }}"
                            tva = "{{ $produit->tva }}"
                            >
                              <span class="far fa-edit fa-2x" ></span>
                            </a>
                          </th>
                        </tr>
                      @endforeach
                  </tbody>
                </table>
                  <div class="row no-gutters px-1 py-3 align-items-center               justify-content-center">
                    {{ $produits->links() }}
                    
                    <input type="hidden" id='lastPrd' value="{{ $produits->last()->id }}">

                   {{--  <input type="number" name="" min="1" id="gotTo"> --}}
                   
                   
              </div>

              </div>
                    @endif
              

            </div>



          @csrf
        @else
        <div class="alert alert-warning h4 text-center">Aucun produits enregistrer</div>
        @endif



            {{-- ***** MODULE AJOUT PRODUIT & CATGORIE**** --}}
              @include('pages/principale/approvision/addPrdMod')
            {{-- ***** MODULE AJOUT PRODUIT & CATGORIE**** --}}

<div class="modal fade" id="histMod" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Liste des categories</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span class="font-weight-light" aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body histBody">


      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary btn-sm" type="button" id="clsCatgo" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>



<script type="text/javascript">
  window.utils.$document.ready(function () {
  var select2 = $('.selectpicker');
  select2.length && select2.each(function (index, value) {
    var $this = $(value);
    var options = $.extend({}, $this.data('options'));
    $this.select2(options);
  });
});
</script>
<script type="text/javascript">
    $(function()
    {

      // Faire disparaitre les paginate de Javascript
          $(".mytable").parent().next().hide();
      
      //click sur btn de trie par categrie
        $('.byCatg').click(function()
        {
          $('#mesCategorie').attr('class','card mb-3 no-print');
        })

      //Choix d'une categorie pour trie
          $('.categorie').click(function()
          {
            //load vue de trie
            var idCat = $(this).attr('id');
            var token = $('input[name=_token]').val();
            $("#main_content").load("/mbo/prdByCatg",{idCat:idCat,_token:token});


           
          });      

      //Liste des categories
          $('.listCatg').click(function()
          {
            //Ajout spiner
            $('.histBody').html($('#spiner').html());

            //req ajax 
            ajaxListCatg();
          });


      //Ajax recup list des categories
         function ajaxListCatg()
         {
           $.ajax({
                    url: 'mbo/lCateg',
                    method:'GET',
                    data: {action:'lCateg'},
                    dataType:'html',
                    success:function(data){
                    $('.histBody').html(data);         
                    },
                    error:function()
                    {
                      Swal.fire('Problème de connection internet');
                        $('.histBody').html("<h3 class='text-danger'>Problème de connection Internet. Reéssayer !! <h3>");

                    }
                  });          

         }


      
      //Ajax suprime produits
        function delPrd(idProduit)
        {
                Swal.fire({
                  title: 'Produit',
                  text: "Voulez vous supprimer ce produits ?",
                  icon: 'error',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  cancelButtonText: 'Annuler',
                  confirmButtonText: 'oui , Supprimer!'
                }).then((result) => {
                    if (result.value) {
                      $.ajax({
                        url: 'mbo/delPrd',
                        method:'GET',
                        data:{idProduit:idProduit},
                        dataType:'json',
                        success:function(){
                          Swal.fire(
                           'Supression!',
                           'Produits suipprimé avec succès',
                           'success'
                          );
                          $("#main_content").load("mbo/allPrd");
                        },
                        error:function(){
                          Swal.fire('La suppression de produits est impossible');
                        }
                      });
                    }
                })
        
        };




        $('.editProduit').click(function()
          {

            
            var id        =$(this).attr('id');
            var produitMat = $(this).attr('produitMat');
            var produitLibele = $(this).attr('produitLibele');
            var produitPrix = $(this).attr('produitPrix');
            var produitPrixFour = $(this).attr('produitPrixFour');
            var unite_mesure = $(this).attr('unite_mesure');
            var seuilAlert = $(this).attr('seuilAlert');
            var categorie_id = $(this).attr('categorie_id');
            var charge = $(this).attr('charge');
            var tva = $(this).attr('tva');

            //Affectacion des valeurs
              $("#idPrd").val(id);
              $("#listCatg").val(categorie_id);
              $('#listCatg>option[value="'+categorie_id+'"]').attr('selected', true);
              $("#codePrd").val(produitMat);
              $("#libelleProd").val(produitLibele);
              $("#alertLevel").val(parseInt(seuilAlert));
              $("#unite").val(unite_mesure);
              $("#coutAchat").val(produitPrixFour);
              $("#prixPrd").val(produitPrix); 
              $("#tva").val(tva); 
              $("#charge").val(charge); 



          });

        $('.deleteProduit').click(function()
          {
            ajaxDeleteProduit($(this).attr('id'));


          });
     

      //Au clic du bouton Actualiser
        $('#btnActualiser').click(function()
          {
                $("#main_content").load("mbo/allPrd");

          });




    })
    </script>
