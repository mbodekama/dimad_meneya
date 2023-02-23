<div class="card mb-3">
            <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url(../assets/img/illustrations/corner-4.png);">
            </div>
            <!--/.bg-holder-->

            <div class="card-body">
              <div class="row">
                <div class="col-lg-8">
                  <h4 class="mb-0 text-primary"> <i class="fas fa-database"></i>  Gestion de stock <i class="fas fa-angle-right"></i> Nouvel approvisionnement </h4>
                </div>
              </div>
            </div>
          </div>
          <div style="display: flex; justify-content: space-around; ">
            <div class="card mb-2 col-lg-5 ">
              {{-- <div class="card-body bg-light overflow-hidden "> --}}

                  <ul class="nav nav-pills" id="pill-myTab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="pill-home-tab" data-toggle="tab" href="#pill-tab-home" role="tab" aria-controls="pill-tab-home" aria-selected="true"><span class="fab fa-shopify mr-2"></span> Création</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="pill-profile-tab" data-toggle="tab" href="#" role="tab" aria-controls="pill-tab-profile" aria-selected="false">
                        <i class="fas fa-briefcase mr-2"></i>
                          Produits
                      </a>
                    </li>
                  </ul>
                  <div class="tab-content border p-3 mt-3" id="pill-myTabContent">
                    <div class="tab-pane fade show active" id="pill-tab-home" role="tabpanel" aria-labelledby="home-tab">
                          <div class="col-12">
                            <div class="form-group">
                          <label for="sucId">Succursales</label>
                          @if(empty($_SESSION['sucId']))
                              <select class="form-control" id="sucId" name="sucId" >
                                @foreach($succursales as $succursale)
                                <option value="{{ $succursale->id }}" >
                                  {{ $succursale->succursaleLibelle }}
                                </option>
                                @endforeach
                              </select>
                              @else

                              <input class="form-control" id="sucId" type="text" value="{{ getSuccInfo($_SESSION['sucId'])->succursaleLibelle }}" readonly>

                          @endif
                            </div>
                          </div>
                          <div class="col-12" style="display: flex;justify-content: flex-end;">
                            <button class="btn btn-primary mr-1 mb-1" type="button" id="enregistreArrivage">
                                Suivant <i class="fas fa-angle-double-right"></i>
                            </button> 
                          </div>
                    </div>
                    <div class="tab-pane fade " id="pill-tab-profile" role="tabpanel" aria-labelledby="profile-tab">
                        <form id="formProduit">
                          {{-- recuperation des valeur arrivage  par id --}}
                          <input type="hidden" name="sucId" id="mySucId" >
                          
                        @csrf
                          <div class="form-group">
                            <label for="basic-example">Produit</label>
                            <select class="" id="inputVal" name="article">
                            </select>
                          </div> 
                 <div class="form-group col-12">
                   <label for="prix">Prix fournisseur ( vendu à : <span class="badge badge rounded-capsule badge-soft-secondary text-danger" id="formatPrixFour"> 00 </span> )
                   </label>
                   <input class="form-control" type="number" name="prix" id="prix" aria-label="Coût d'achat">
                 </div>

                               

                            <div class="form-row justify-content-center">
                             <div class="form-group col-5 ">
                               {{-- <label for="prixV">Quantité</label> --}}
                              <input class="form-control"  name="quantite" id="quantite" type="number" aria-label="Quantite" min="1" placeholder="Quantité">
                             </div>
                            <div class="form-group col-2">
                                <button class="btn btn-warning mr-1 mb-1" type="button" 
                                  id="addPrdAprovi">Ajouter 
                                </button>
                             </div>
                            </div>
              </form>
                                
   
                  </div>
                  </div>
              {{-- </div> --}}
            </div>
            <div class="card mb-2 col-lg-4 pt-2">


           
                  <div class="row justify-content-center align-items-center">
                    <div class="col-sm-auto">
                      <h5 class="mb-2 mb-sm-0 text-primary" id="titreArrivage"><u>Approvisionnement</u></h5>

                    </div>

                  </div>



<div class="row align-items-center mt-4">
  <div class="col-auto">
    <div class="avatar avatar-5xl status-away">
      <a href="#titreArrivage" class="stretched-link">
      <img class="rounded-circle" src="../assets/img/team/panier.jpg" alt="" />
    </a>
    </div>
  </div>

  <div class="avatar avatar-4xl">
  <div class="avatar-name bg-primary rounded-circle " style="cursor: pointer;">
    <span id="compteur_panier">
  @if(!empty($_SESSION['approvSuc'])) 
    {{ count($_SESSION['approvSuc']) }} 
    @else {{ "00" }} 
    @endif
    </span></div>
    </div>

</div>
<div class="d-flex justify-content-center">
    <button class="btn btn-warning mr-1 mt-2" type="button" id="listApprovPrd">
      <span class="fas fa-eye mr-2" data-fa-transform="shrink-2" ></span>
      Consulter listes
    </button>
</div>

            </div>


          </div>

    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->



    <script src="{{ asset('assets/js/theme.js') }}"></script>
    <script type="text/javascript">

        //Desactiver l'autocomplete 
          $('input').attr('autocomplete',"off");
          
        //Fonction permetant de valider avec la touche entré
            $('#quantite').keydown(function(event)
            {
              if(event.keyCode == 13 || event.keyCode == 9)
                {
                  if ($.isNumeric($('#quantite').val())) 
                  {
                    $('#addPrdAprovi').click();
                  }
                  else
                  {
                    toastr.error('Quantité invalide');
                  }
                }
            });

            


      function ajaxProduitSave()
      {
                  $.ajax({
                  method: "POST",
                  url: "mbo/addPrdAprovi",
                  data: $("#formProduit").serialize(),
                    dataType: "json",
                })

        .done(function(data) 
                {

                  toastr.success("Article ajouté avec succès  ");
                  var compteur_panier = parseInt($('#compteur_panier').text());
                 $('#compteur_panier').text(compteur_panier+1)
                   articleformClassInit();
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



      function articleformClassInit()
      {
        $('#inputVal').html('');
        $('#prix').val('').attr('class','form-control');
        $('#quantite').val('').attr('class','form-control');  
      };





      $(function()
      {
        $('#enregistreArrivage').click(function()
          {

            if($("#sucId").val() != "")
            {
              $('#mySucId').val($("#sucId").val());

              $('#sucId').removeClass('is-invalid').addClass('is-valid');
              $("#pill-home-tab").attr('class', 'nav-link');
              $("#pill-tab-home").attr('class', 'tab-pane fade');

              $("#pill-profile-tab").attr('class', 'nav-link active');
              $("#pill-tab-profile").attr('class', 'tab-pane fade show active');
            }
            else
              {
                $('#sucId').addClass('is-invalid');
              }


          });

        $('#addPrdAprovi').click(function()
         {
          if($('#inputVal').val() != null )
          {
            if ($('#prix').val() != "") 
            {
                $('#prix').attr('class', 'form-control is-valid');

                if ($('#quantite').val() != "") 
                {
                  $('#quantite').attr('class', 'form-control is-valid');

                  //selection de l'option de l'id de l'article choisit
                var selectedId = $('#inputVal option:selected').attr('idduPrd');
                var coutachat = $('#inputVal option:selected').attr('coutachat');
                $('#produitId').attr('value',selectedId);
                $('#coutachat').attr('value',coutachat);
                    ajaxProduitSave();
                 
                }
                else
                {
                  $('#quantite').addClass('is-invalid');
                }
            }
            else
              {
                $('#prix').addClass('is-invalid');

              }

          }
          else
          {
            toastr.error('Produits invalide');


          }

          })






 /*---------------------------------------
 Ajax liste de produits ajouter au panier
-----------------------------------------*/
    // Affiche liste
     $("#listApprovPrd").click(function()
       {
          if (parseInt($('#compteur_panier').text()) >=1) 
            {
             $('#main_content').load('/mbo/listAproviPrd');
            }
            else
            {
              Swal.fire(
                'Oupss!',
                'Votre arrivage est encore vide!',
                'error'
                );
            }

       });
      });
    </script>

<script src="assets/lib/select2/select2.min.js"></script>
<script type="text/javascript">
$("#inputVal").select2({
  ajax: {
    // url: "https://api.github.com/search/repositories",
    url: "mbo/ajaxPrdAll",
    dataType: 'json',
    delay: 250,
    data: function (params) {
      return {
        q: params.term, // search term
        page: params.page
      };
    },
    processResults: function (data, params) {
      // parse the results into the format expected by Select2
      // since we are using custom formatting functions we do not need to
      // alter the remote JSON data, except to indicate that infinite
      // scrolling can be used
      params.page = params.page || 1;

      return {
        results: data.items,
        pagination: {
          more: (params.page * 30) < data.total_count
        }
      };
    },
    cache: true
  },
  placeholder: 'Recherhe de produits',
  minimumInputLength: 1,
  templateResult: formatRepo,
  templateSelection: formatState
});

function formatRepo (repo) {
  if (repo.loading) {
    return repo.text;
  }

  var $container = $(
                  '<div class="media"><a href="#!"><img class="img-fluid" src="'+repo.image+'" alt="" width="56" /></a><div class="media-body position-relative pl-3"><h6 class="fs-0 mb-0">'+repo.libelle+' ( Code : '+repo.matricule+' )<small class="fas fa-check-circle text-primary ml-1" data-toggle="tooltip" data-placement="top" title="Verified" data-fa-transform="shrink-4 down-2"></small></h6><p class="mb-1">Prix de vente : <b>'+repo.prixPrdFormat+'</b> <u></u></p></div></div>'
  );

  return $container;
}

function formatState (repo) {
  // if (!repo.id) {
  //   return repo.text;
  // }
  var baseUrl = repo.image;
  var $state = $(
    '<span> <span></span></span>'
  );

  // Use .text() instead of HTML string concatenation to avoid script injection issues
  $state.find("span").text(repo.text);
  if (repo.id != 0) 
  {
    $('#article option:selected').attr('prixPrd', repo.prixPrd);
    $('#article option:selected').attr('coutachat', repo.prixFour);
    $('#article option:selected').attr('prixPrdFormat', repo.prixPrdFormat);
    $('#article option:selected').attr('idduPrd', repo.id);
    $('#article option:selected').attr('qteInStck', repo.qteInStck);


    $("#prix").val(repo.prixFour);
    $('#formatPrixFour').text(repo.prixPrdFormat);

  }

  return $state;
};
</script>
