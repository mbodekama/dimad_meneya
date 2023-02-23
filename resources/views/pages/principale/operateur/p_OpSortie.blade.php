<div class="card mb-3">
  <div class="bg-holder d-none d-lg-block bg-card" 
   style="background-image:url(../assets/img/illustrations/corner-4.png);">
  </div>
  <!--/.bg-holder-->

    <div class="card-body">
      <div class="row">
        <div class="col-lg-8">

          <h3 class="mb-0 text-primary">
           <a href="#" class="operateurs" id="{{$operateur->id}}">
            <i class="fas fa-user-tie"></i>
            Sortie > Opérateur > {{ $operateur->operateurNom}}
           </a>
          </h3>
          <p class="mt-2"><b>Sortie >></b>Nouvelle sortie</p>
        </div>
      </div>
    </div>
</div>

<?php

  foreach ($operations as $key => $value) {
    $operationl        = $value->OperationLibele;
    $operationcode    = $value->operationCode;
    $operationcoment  = $value->Operationcomt;
    $operaOptID       = $value->operaOpt;
    $idoperateur      = $value->OperaID;
    $montantrestant   = $value->montantrestant;
    
  }
?>


<div class="container">
    <div class="row">
     <!-- Infos clients+Produits -->
     <div class="col-lg-6">
        <div class="card mb-3">
         <div class="card-body">
          <div class="fancy-tab">

            <div class="nav-bar nav-bar-center">
              <div class="nav-bar-item px-3 px-sm-4 active" id="navIdentificationClient"><span class="far fa-address-card"></span>
                <div class="mt-1">Sortie Operateur</div>
              </div>

            </div>

            <form class="tab-contents" id="formulaire">
              <!-- Infos clients -->
               
              <div class="tab-content active" id="identificationClient">
                <div class="form-validation" id="formClientIdentite">

                 <div class="form-group">
                  <label for="idOption">Opérations</label>
                    @if(empty($_SESSION["sortieName"]))
                      <select class="form-control" id="sortieName" name="sortieName" >
                         @foreach($operations as $operation)
                        <option value="{{ $operation->id }}" libelle="{{ $operation->id }}">{{ $operation->OperationLibele." (Matr: ".$operation->operaOpt."|".formatPrice($operation->montantrestant)."|".$operation->date." )" }}
                        </option>
                        @endforeach
                      </select>
                    @else
                      <input class="form-control" id="sortieName" type="text" value="{{ $_SESSION['sortieName'] }}" readonly>
                    @endif
                </div>
                 <button class="ml-1 btn btn-outline-primary rounded-capsule mr-1 mb-1 nav-bar-item px-3" id='validOp' type="button">
                  Suivant <i class="fas fa-angle-right"></i>
                 </button>
                </div>
              </div>

              <!-- Infos Produits -->
              <div class="tab-content" id="selectionProduit">
                <div id="#">
                  @csrf
                  {{-- recuperation des valeur arrivage  par id --}}
                  <input type="hidden" name="sortieNom" id="sortieNom" value="">
                  <input type="hidden" name="sortieLibelle" id="sortieid" value="">
                  <input type="hidden" name="sortieIdOp" value="{{ $operateur->id }}">
                  <input type="hidden" name="sortieNameOp" value="{{ $operateur->operateurNom }}">
                          
                <div class="form-group">
                  <label for="basic-example">Produit</label>
                     <select class="js-example-data-ajax"  id="article" name="article"> 
                    </select> 
                </div>
                <div class="form-row justify-content-around">
                 <div class="form-group col-6">
                   <label for="prix">Prix ( min: <span class="badge badge rounded-capsule badge-soft-secondary text-danger" id="formatPrixFour"> </span> )
                   </label>
                   <input class="form-control" id="prix" name="prix" type="number" placeholder="" autocomplete="off">
                 </div>
                <div class="form-group col-4">
                   <label for="quantite">Quantité</label>
                   <input class="form-control" id="quantite" name="quantite" type="number" placeholder="" min="1" max="">
                 </div>
                </div>

                <div class="d-flex justify-content-end">
                  
                 <button class="btn btn-outline-primary rounded-capsule" 
                 id="ajouterPanier" type="button">
                  Ajouter <i class="fas fa-plus"></i>
                 </button>
                </div>
                </div>
              </div>
            </form>

          </div>
         </div>
        </div>
     </div>
     
     <!-- Facture  -->
     <div class="col-lg-6">
      
<div class="card mb-3">
                <div class="card-header bg-light btn-reveal-trigger d-flex justify-content-between align-items-center">
                  <h5 class="mb-0">Sortie de  {{ $operateur->operateurNom }}</h5>
                  <span class="fas fa-shopping-cart"></span>

                </div>
                <div class="card-body d-flex justify-content-center">
                  <div class="row align-items-center mt-4">
                    <div class="col-auto">
                      <div class="avatar avatar-5xl status-online">
                        <a href="#" class="stretched-link">
                        <img class="rounded-circle" src="../assets/img/team/avatar.png" alt="">
                      </a>
                      </div>
                    </div>

                    <div class="avatar avatar-4xl">
                    <div class="avatar-name bg-primary rounded-circle "><span id="compteur_panier">@if(!empty($_SESSION['sortieOp'])) {{ count($_SESSION['sortieOp']) }} @else {{ "00" }} @endif</span></div>
                  </div>

                  </div>
                </div>
                      <button class ="btn btn-warning mr-1 mt-2" 
                              type ="button" 
                              id               = "listeSortiPrd"
                              operation        = "{{$operationl}}";
                              operationcode    = "{{$operationcode}}" 
                              operationcoment  = "{{$operationcoment}}"
                              operaOptID       = "{{$operaOptID}}"
                              idoperateur      = "{{$idoperateur}}">
                        <span class="fas fa-eye mr-2" 
                        data-fa-transform="shrink-2" ></span>
                        Consulter listes 
                      </button>
              
              </div>


     </div>

    </div>

</div>


<script src="{{ asset('assets/js/theme.js') }}"></script>


<script type="text/javascript">

$(function()
{

      $(".operateurs").click(function(){
         var idV = $(this).attr('id');
         var token = $('input[name=_token]').val();
         $("#main_content").load("/p_OpTion",{idV:idV,_token:token});
      });

        //Fonction permetant de valider avec la touche entré
            $('#quantite').keydown(function(event)
            {
              if(event.keyCode == 13)
                {
                  if ($.isNumeric($('#quantite').val())) 
                  {

                  verifInput();

                  }
                  else
                  {
                    toastr.error('Quantité invalide');
                  }
                }
            });


        // Passer a la quantite au clic de Entrer 
            $('#prix').keydown(function(event)
            {
              if(event.keyCode == 13)
                {
                  $('#quantite').focus();
                }
            });


        //Fonction de verification des entrées 
          function verifInput()
          {

            if($('#article').val() != null) 
            {
              if($("#quantite").val() != "")
                {
                  //selection de l'option de l'id de l'article choisit
                    var qte = parseInt($('#quantite').val());
                  //recup la qte en stock l'article choisit
                    var selectedPrdQte = $('#article option:selected').attr('qteInStck');

                    var prdPrixFour = $('#article option:selected').attr('prixFour');
                    var prixSaisi = parseInt($('#prix').val());


                    if(prixSaisi>=parseInt(prdPrixFour))
                    {
                    $('#prix').attr('class','form-control');
                    if (qte <= parseInt(selectedPrdQte)) 
                      {
                        toastr.options.positionClass = "toast-top-right";
                        ajaxSaveProduit();
                      }
                      else
                      {
                        toastr.options.positionClass = "toast-top-center";
                        var sms = "Produit insufisant dans votre stock! Qte dispo : "+selectedPrdQte;
                        toastr.error(sms);

                      }

                    }
                    else
                    {
                  $('#prix').attr('class','form-control is-invalid');
                  toastr.warning('Le prix de vente ne peut être en dessous du prix fournisseur');

                    }
                }
              else
                {
                  $('#quantite').attr('class','form-control is-invalid');
                }
            }
            else
            {
              toastr.warning('Produits Invalide');
            }
          }

        //Clic sur option select nouveau produit
          $('#article1').change(function()
          {
              
              if($('#article').val() == 'choix')
              {
                 toastr.warning('Veuillez choisir un article');
                $("#formatPrixFour").text('00');             


              }
              else
              {
                var prixPrd = $('#article option:selected').attr('prixPrd');
                var prixFourFormat = $('#article option:selected').attr('prixFourFormat');
                $("#prix").val(prixPrd);
                $("#formatPrixFour").text(prixFourFormat);             
              }
          })

        //Validation  de l'operation choisir
          $('#validOp').click(function()
          {

            if($("#idOption").val() != "choix")
              {
                        //Liste des produits
                          // ajaxRecupPrdP();
                        $('#sortieNom').attr('value',$("#sortieName").val());
                        // $('#arrivageid').attr('value',$("#arrivageName").attr('Cmd'));
                        var selecText = $('#sortieName option:selected').text();
                        $('#sortieid').attr('value', $.trim(selecText));

                          $('#idOption').attr('class','form-control is-valid');
                          $("#navIdentificationClient").removeClass('active');
                          $("#identificationClient").removeClass('active');
                          $("#navSelectionProduit").addClass('active');
                          $("#selectionProduit").addClass('active');
              }
            else
              {
                toastr.warning('Veuillez choisir une opération');
              }


          });

        //Clic sur le bouton ajouter au panier
            $('#ajouterPanier').click(function()
            {
              verifInput();

            });


      function ajaxSaveProduit()
          {
            //envoie de la commande dans une requete ajax 
            //enregistrement de la commande en session
            //notification du succes d'envoie
            //initialisation du formulaire

                $.ajax(
                  {
                       method: "POST",
                      url: "/savePrdSortie",
                      data: $('#formulaire').serialize(),
                        dataType: "json",
                  })

              .done(function(data) 
                      {
                        //Calcul quantite restante du prd 
                          var qte = parseInt($('#quantite').val());
                        //recup la qte en stock l'article choisit
                          var selectedPrdQte = $('#article option:selected').attr('qteInStck');
                          var qteRst = parseInt(selectedPrdQte)-qte;
                          $('#article option:selected').attr('qteInStck',qteRst);
                        toastr.success("Article ajouté avec succès  ");
                        var compteur_panier = $('#compteur_panier').text();
                        compteur_panier = parseInt(compteur_panier)+1;

                        if (compteur_panier < 10) 
                            {$('#compteur_panier').text('0'+compteur_panier);}
                        else{$('#compteur_panier').text(compteur_panier);}
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
                          toastr.error("Erreur , problème de connexion internet ");

                          })


                        }
                    });
              });
          }

      function articleformClassInit()
        {
          $('#formatPrixFour').text('00');
          $('#prix').val('').attr('class','form-control');
          $('#quantite').val('').attr('class','form-control');  
          $('#article').html('');  
        };


       /*---------------------------------------
       Ajax liste de produits ajouter au panier
      -----------------------------------------*/
          // Affiche liste
           $("#listeSortiPrd").click(function()
             {

                // Récupération des données
                var operation       = $(this).attr('operation');
                var operationcode   = $(this).attr('operation');
                var operationcoment = $(this).attr('operationcoment');
                var operaOptID      = $(this).attr('operaOptID');
                var idoperateur     = $(this).attr('idoperateur');
                var token = $('input[name=_token]').val();
                
                if (parseInt($('#compteur_panier').text()) >=1) 
                  {
                   $('#main_content').load('/listeSortiPrd',
                      {idOp : idoperateur, 
                       idOpt:operaOptID, 
                       _token :token,
                       operation:operation,
                       operationcode:operationcode,
                       operationcoment:operationcoment
                      });
                  }
                  else
                  {
                    Swal.fire(
                      'Oupss!',
                      'Commande  encore vide!',
                      'error'
                      );
                  }

             });


});

</script>

<script src="assets/lib/select2/select2.min.js"></script>
<script type="text/javascript">
$(".js-example-data-ajax").select2({
  ajax: {
    // url: "https://api.github.com/search/repositories",
    url: "mbo/ajaxRecupPrdP",
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
  minimumInputLength: 2,
  templateResult: formatRepo,
  templateSelection: formatState
});

function formatRepo (repo) {
  if (repo.loading) {
    return repo.text;
  }

  var $container = $(
                  '<div class="media"><a href="#!"><img class="img-fluid" src="'+repo.image+'" alt="" width="56" /></a><div class="media-body position-relative pl-3"><h6 class="fs-0 mb-0">'+repo.libelle+' ( Qte : '+repo.qteInStck+' )<small class="fas fa-check-circle text-primary ml-1" data-toggle="tooltip" data-placement="top" title="Verified" data-fa-transform="shrink-4 down-2"></small></h6><p class="mb-1">Coût : <b>'+repo.prixPrdFormat+'</b> <u></u></p></div></div>'
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
    $('#article option:selected').attr('prixFour', repo.prixFour);
    $('#article option:selected').attr('prixFourFormat', repo.prixFourFormat);
    $('#article option:selected').attr('prdId', repo.id);
    $('#article option:selected').attr('qteInStck', repo.qteInStck);
    $("#prix").val(repo.prixPrd);
    $("#formatPrixFour").text(repo.prixFourFormat);
  }

  return $state;
};
</script>