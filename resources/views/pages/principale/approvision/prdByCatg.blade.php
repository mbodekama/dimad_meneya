

          <!-- -------------------------------------------->
          <!--    Tables, Files, and Lists-->
          <!-- -------------------------------------------->
          <div class="media mt-3"><span class="fa-stack mr-2 ml-n1"><i class="fas fa-circle fa-stack-2x text-300"></i><i class="fa-inverse fa-stack-1x text-primary fas fa-list" data-fa-transform="shrink-2"></i></span>
            <div class="media-body">
              <h5 class="mb-1 text-primary position-relative"><span class="bg-200 pr-3">Produit de la categorie 
                <span class="badge badge-pill badge-soft-warning fs-2">{{ getOneCatgo($idCat)->libelle }}</span>
                </span>
                <span class="border position-absolute absolute-vertical-center w-100 z-index--1 l-0"></span></h5>
            </div>
          </div>
            <div class="card mb-3 no-print">
            <div class="card-body">
              <div class="row justify-content-between align-items-center">
                <div class="col-auto">
                  @foreach(getCatgo() as $catgo)
                <button class="btn btn-falcon-primary btn-sm mr-2 categorie" id="{{ $catgo->id }}" role="button"> 
                  <i class="fas fa-sort-amount-up-alt text-900"></i> &nbsp;{{ $catgo->libelle }}
                </button>
                  @endforeach
                    <button class="btn btn-falcon-default btn-sm mx-2" id="btnActualiser" type="button"><span class="fas fa-list-ul" data-fa-transform="shrink-3 down-2"></span><span class=" d-sm-inline-block ml-1">Tous les produits</span></button>
                </div>
              </div>
            </div>
          </div>


          <div class="card mb-3">
            <div class="card-header">
              <div class="row align-items-center justify-content-between">
                <div class="col-4 col-sm-auto d-flex align-items-center pr-0">
                  <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">
              <p class="mb-0">Vous avez 
                <span class="badge badge-pill badge-soft-success fs-2"> {{ getCatgoEle($idCat)->count() }} </span>  &nbsp;articles
              </p>

                    
                  </h5>
                </div>


                <div class="col-8 col-sm-auto text-right pl-2">
                  <div class="d-none" id="customers-actions">
                    <div class="input-group input-group-sm">
                      <select class="custom-select cus" aria-label="Bulk actions">
                        <option selected="">Bulk actions</option>
                        <option value="Delete">Delete</option>
                        <option value="Archive">Archive</option>
                      </select>
                      <button class="btn btn-falcon-default btn-sm ml-2" type="button">Apply</button>
                    </div>
                  </div>

                </div>
              </div>
            </div>
            <div class="card-body p-0">
              @if(!$produits->isEmpty())
              <div class="falcon-data-table mytable">
                <table class="table table-sm mb-0 table-striped table-dashboard fs--1 data-table border-bottom border-200" data-options='{"searching":true,"responsive":false,"pageLength":50,"info":false,"lengthChange":false,"sWrapper":"falcon-data-table-wrapper","dom":"<&#39;row mx-1&#39;<&#39;col-sm-12 col-md-6&#39;l><&#39;col-sm-12 col-md-6&#39;f>><&#39;table-responsive&#39;tr><&#39;row no-gutters px-1 py-3 align-items-center justify-content-center&#39;<&#39;col-auto&#39;p>>"}'>
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
                            id="{{ $produit->id }}"       
                            produitMat = "{{ $produit->id }}"
                            produitLibele = "{{ $produit->produitLibele }}"
                            produitPrix = "{{ $produit->produitPrix }}"
                            produitPrixFour = "{{ $produit->produitPrixFour }}"
                            unite_mesure = "{{ $produit->unite_mesure }}"
                            seuilAlert = "{{ $produit->seuilAlert }}"
                            categorie_id = "{{ $produit->categorie_id }}"
                            >
                              <span class="far fa-edit fa-2x" ></span>
                            </a>
                           {{--  <a href="#"   class="deleteProduit"  id={{ $produit->id }} >
                              <span class="far fa-trash-alt text-danger mr-2"></span>
                            </a> --}}
                          </th>
                        </tr>
                      @endforeach
                  </tbody>
                </table>
                  <div class="row no-gutters px-1 py-3 align-items-center justify-content-center">
              </div>
              </div>
                    @endif
              

            </div>

            {{-- ***** MODULE AJOUT PRODUIT & CATGORIE**** --}}
              @include('pages/principale/approvision/addPrdMod')
            {{-- ***** MODULE AJOUT PRODUIT & CATGORIE**** --}}

@csrf
<div class="d-none" id='spiner'>
<div class="spinner-border text-primary" role="status">
  <span class="sr-only">Loading...</span>
</div>
<div class="spinner-border text-info" role="status">
  <span class="sr-only">Loading...</span>
</div>
  
</div>

<!-- Button trigger modal-->
{{-- <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#exampleModal">Launch demo modal</button> --}}
<!-- Modal-->
<!-- Button trigger modal-->
<!-- Modal-->
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
        <button class="btn btn-secondary btn-sm" type="button" id="histModClose" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>



 <script src="{{ asset('assets/js/theme.js') }}"></script>


<script src="{{ asset('assets/lib/jquery-validation/jquery.validate.min.js') }}"></script>


<script type="text/javascript">
    $(function()
    {


      
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

      // Code pour enlever le paginate de JS
          $('.mytable .table-responsive').next().hide();

      //Action des bouton paginate de Laravel
        $('.page-item > .page-link').click(function()
        {
            event.preventDefault();
            var valeur = parseInt($(this).text());
            if(valeur>= 1)
            {
              var page = $('#lastPrd').val();
            $('#main_content').load('mbo/allPrd?page='+valeur+'&idPage='+page);
      
            }
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
        function ajaxDeleteProduit(idProduit)
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
            //Affectacion des valeurs
              $("#idPrd").val(id);
              $("#listCatg").val(categorie_id);
              $("#codePrd").val(produitMat);
              $("#libelleProd").val(produitLibele);
              $("#alertLevel").val(parseInt(seuilAlert));
              $("#unite").val(unite_mesure);
              $("#coutAchat").val(produitPrixFour);
              $("#prixPrd").val(produitPrix); 


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





