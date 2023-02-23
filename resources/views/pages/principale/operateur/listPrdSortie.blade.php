<div class="card mb-3">
  <div class="bg-holder d-none d-lg-block bg-card" 
   style="background-image:url(../assets/img/illustrations/corner-4.png);">
  </div>
  <!--/.bg-holder-->
    {{-- {{dd($option_opteur)}} --}}
    <div class="card-body">
      <div class="row">
        <div class="col-lg-12">
          <h3 class="mb-0 text-primary">
           <a href="#" class="operateurs" id="{{$_SESSION["sortieIdOp"]}}">
            <i class="fas fa-user-tie"></i>
            Sortie de > {{ $_SESSION["sortieNameOp"] }}</a>
          </h3>
          <p class="mt-2"><b>Sortie >></b> Contenue de la commande <i class='fas fa-angle-double-left'></i> &nbsp;{{ count($_SESSION['sortieOp'])  }} articles <i class='fas fa-angle-double-right'></i> </p>

          <div class="col-md-auto">
            <h5 class="mb-3 mb-md-0">Facturé dans : @if (!empty($_SESSION['sortieOp'])) {{$_SESSION["sortieName"] }} &nbsp;   @endif
            </h5>
          </div><br>

        </div>
      </div>
    </div>

</div>

<div class="card mb-3">
  <div class="bg-holder d-none d-lg-block bg-card" 
   style="background-image:url(../assets/img/illustrations/corner-4.png);">
  </div>
  <!--/.bg-holder-->

    <div class="card-body">

        <div class="form-row">
          <div class="col-4">
          <div class="form-group">
            <label for="datepicker">Date de sortie</label>
             <input class="form-control datetimepicker flatpickr-input active" type="text"  data-options="{&quot;dateFormat&quot;:&quot;d/m/Y&quot;}" placeholder="d/m/Y" readonly="readonly" id="dateSortie">
          </div>
          </div>

          <div class="col-4">
          <div class="form-group">
            <label for="name">Charges(autres coûts associés...)</label>
            <input class="form-control" id="charges" type="number"  min="1">
          </div>
          </div>
          <div class="col-3">
          <div class="form-group">
            <label for="name">Description de la charges</label>
            <input class="form-control" id="descrptCHG" type="text" placeholder="Livraison...">
            <input class="form-control" id="tva" type="hidden"  min="1">
          </div>
          </div>

          <div class="col-1">
           <label for="name">Calculé</label>
           <a href="#subtotal">
           <button class="btn btn-sm btn-danger" id="appliquer" operat="6">       Appliquer
           </button>
           </a>
          </div>
          
        </div>
    </div>

</div>



          <div class="card">
            <div class="card-header">
              <div class="row justify-content-between">
                
                {{-- DATE DE LA SORTIE --}}
                



                <button class="btn btn-falcon-danger btn-sm" role="button"><i class="fas fa-money-check-alt mr-1 text-900"></i> Solde  : &nbsp; {{formatPrice( $option_opteur->montantrestant) }}</button>
                <div class="col-md-auto">
                  <button class="btn btn-sm btn-outline-secondary border-300 mr-2" id="retourSortie" > 
                    <input type="hidden" name="idV" value="{{ $_SESSION["sortieIdOp"] }}" id="OpId">
                    @csrf
                    <span class="fas fa-chevron-left mr-1"  data-fa-transform="shrink-4"></span>
                      Retour
                    </button>
                  <button class="btn btn-sm btn-danger" id="suprSortie" 
                  operat="{{ $_SESSION["sortieIdOp"] }}">Vider le panier</button>
                  <button class="btn btn-sm btn-info" id="refreshSortie">Actualiser</button>
                </div>
              </div>

            </div>

              <div class="card-body p-0">
                <div class="falcon-data-table">
                  <table class="table table-sm mb-0 table-striped table-dashboard fs--1 data-table border-bottom border-200" data-options='{"searching":false,"responsive":false,"pageLength":12,"info":false,"lengthChange":false,"sWrapper":"falcon-data-table-wrapper","dom":"<&#39;row mx-1&#39;<&#39;col-sm-12 col-md-6&#39;l><&#39;col-sm-12 col-md-6&#39;f>><&#39;table-responsive&#39;tr><&#39;row no-gutters px-1 py-3 align-items-center justify-content-center&#39;<&#39;col-auto&#39;p>>","language":{"paginate":{"next":"<span class=\"fas fa-chevron-right\"></span>","previous":"<span class=\"fas fa-chevron-left\"></span>"}}}'>
                    <thead class="bg-200 text-900">
                      <tr>
                        <th class="align-middle sort">Id</th>
                        <th class="align-middle sort">Produits</th>
                        <th class="align-middle sort">Qte</th>
                        <th class="align-middle sort">Prix/Unit</th>
                        <th class="align-middle no-sort">Prix Net</th>
                        <th class="no-sort pr-1 align-middle data-table-row-action">Action</th>

                      </tr>
                    </thead>
                   
                    <tbody id="customers">
                      <?php if (!empty($_SESSION['sortieOp'])){
                        $i=0;
                        $montant_commande = 0;
                          foreach ($_SESSION['sortieOp'] as $key => $value)
                           {$i +=1; ?>  
                      <tr>
                        <th class="align-middle sort">{{ $i }}</th>
                        <th class="align-middle sort">{{ $value['article']  }}</th>
                        <th class="align-middle sort">{{ $value['qte']  }}</th>
                        <th class="align-middle sort">{{ $value['prix']  }}</th>
                        <th class="align-middle no-sort">{{ $value['prix']* $value['qte'] }}</th>
                        <td class="align-middle text-center fs-0 deleteBtn" id="{{ $key }}" style="cursor: pointer;" ><input type="hidden" id="key" value="">
                          <span class="badge badge rounded-capsule badge-soft-danger"> &nbsp;<span class="mr-2 fas fa-trash ml-1" data-fa-transform="shrink-2"></span> &nbsp;</span>
                        </td>
                      </tr>

                       <?php 
                       $montant_commande += $value['prix']* $value['qte'];
                        } }else{
                         echo "<div class='alert alert-warning'>Aucun produit</div>";
                       }?>
                    </tbody>
                  </table>
                </div>
              </div>

              {{--  <button class="btn btn-falcon-danger btn-sm" role="button">
                <i class="fas fa-money-check-alt mr-1 text-900"></i> Montant Total  : &nbsp; @if(count($_SESSION['sortieOp']) != 0) 
                          {{formatPrice($montant_commande) }}
                        @else
                          {{formatPrice(00) }}

                        @endif
                </button> --}}
                <div class="row no-gutters justify-content-end">
                <div class="col-auto" id="subtotal">
                  <table class="table table-sm table-borderless fs--1 text-right">
                    <tr>
                      
                      <th class="text-900"><b>Sous-total:</b></th>
                      <td class="font-weight-semi-bold"> @if(count($_SESSION['sortieOp']) != 0) 
                          {{formatPrice($montant_commande) }}
                        @else
                          {{formatPrice(00) }}

                        @endif </td>
                      
                    </tr>

                    <tr>
                      <th class="text-900"><b>Charges</b>:</th>
                      <td class="font-weight-semi-bold">
                       <span class="chargesT">0</span> {{getMyDevise()}}
                      </td>
                    </tr>                    
                     <tr class="border-top">
                      <th class="text-900"><b class="text-danger">Total:</b></th>
                       <td class="font-weight-semi-bold text-danger">
                         <span class="totalttc">{{formatPrice($montant_commande) }}</span>
                        {{getMyDevise()}}</td>
                     </tr>
                    

                  </table>

                  <input type="hidden" id="montSortie" 
                   value="@if(count($_SESSION['sortieOp']) != 0) 
                          {{$montant_commande }}
                          @else
                           {{0}}
                          @endif">

                </div>
              </div>


            <div class="card-footer bg-light d-flex justify-content-end">
                  <button class="btn btn-sm btn-primary" 
                          id="btnSave"
                          idoperationOperateur="{{$idoperationOperateur}}"
                          operation="{{$operation}}"
                          operationcode="{{$operationcode}}"
                          operationcoment="{{$operationcoment}}"
                          idoperateur = {{$idoperateur}}
                          >
                    Enregistrer
                  </button>
                  
            </div>
          </div>

              {{-- Mes recuperations --}}

          <div id="mytoken">
            <input type="hidden" name="id_succursale" id="idSuc" value="{{ $_SESSION['sortieid'] }}">

                {{-- Montant de la commande du client --}}
            <input type="hidden" id="montant_commande" 
            value="@if(count($_SESSION['sortieOp']) != 0) 
                          {{formatPrice($montant_commande) }}
                        @else
                          {{formatPrice(00) }}

                        @endif">

                {{-- Montant du solde restant de l'operation du client --}}
            <input type="hidden" id="montant_restant" value="{{$option_opteur->montant_restant }}">
            @csrf
          </div>


    <script src="{{ asset('assets/js/theme.js') }}"></script>


    <script type="text/javascript">

      // Boutton de calcul du montant total
      $("#appliquer").click(function(){

        // Réception des données
         var montant = $("#montSortie").val().trim();
         var charges = $("#charges").val();
         var tva     = $("#tva").val();

         if (tva=="") {tva=parseInt(0);}
         if (charges=="") {charges=parseInt(0);}
         

        // Traitement des données
         var tvaVal = (parseInt(montant)*parseInt(tva))/100;
         var totalttc = tvaVal+parseInt(charges)+parseInt(montant);


        // Affichage des résultats
         $(".chargesT").text(charges);
         $(".taxeV").text(tva);
         $(".taxeMont").text(tvaVal);
         $(".totalttc").text(totalttc);
      });

      // Actualisation de la page
       $("#refreshSortie").click(function(){
         /*alert("Refresh Page");*/
          var token = $('input[name=_token]').val();
          var idoperationOperateur = $('#btnSave').attr('idoperationOperateur');
          var operation            = $('#btnSave').attr('operation');
          var operationcode        = $('#btnSave').attr('operationcode');
          var operationcoment      = $('#btnSave').attr('operationcoment');
          var idoperateur          = $('#btnSave').attr('idoperateur');
         $('#main_content').load('/listeSortiPrd',
                                { idOp:idoperateur,
                                  idOpt:idoperationOperateur,
                                  operation:operation,
                                  operationcode:operationcode,
                                  operationcoment:operationcoment,
                                  _token:token
                                });
       });

      $('#retourSortie').click(function()
        {
          var idOp = $('#OpId').val();
          var token = $('input[name=_token]').val();
          // alert(idOp);
          $('#main_content').load('/p_OpSortie',{idV:idOp,_token:token});
          // alert('cliquer');
        });

      // Retour sur la liste des opérations
      $(".operateurs").click(function(){
         var idV = $(this).attr("id");
         var token = $('input[name=_token]').val();
         $("#main_content").load("/p_OpTion",{idV:idV,_token:token});
         console.log(idV);
      });


      $('#btnSave').click(function()
        {
          var charges   = $("#charges").val();
          var chgDesc   = $("#descrptCHG").val();
          var tva       = $("#tva").val();
          var mnt_rst   = $('#montant_restant').val();
          var mnt_cmd   = $('#montant_commande').val();
          var dateSortie = $('#dateSortie').val();
          console.log("charges:"+charges+" tva:"+tva+" dateSortie:"+dateSortie);

          var idoperationOperateur = $('#btnSave').attr('idoperationOperateur');
          var operation            = $('#btnSave').attr('operation');
          var operationcode        = $('#btnSave').attr('operationcode');
          var operationcoment      = $('#btnSave').attr('operationcoment');
          var idoperateur          = $('#btnSave').attr('idoperateur');

          console.log(idoperateur+operationcoment+operationcode+operation+idoperationOperateur);

          if(dateSortie != "")
          {
           if (1) 
           {
            Swal.fire({
              title: 'Sortie',
              text: "Voulez vous enregistrer cette sortie de l'opérateur ?",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              cancelButtonText: 'Annuler',
              confirmButtonText: 'oui , valider!'
            }).then((result) => {
                if (result.value) {
                  $.ajax({
                     url:'saveSortie',
                     method:'get',
                     data:{charges:charges,tva:tva,chargeDesc:chgDesc,
                           dateSortie:dateSortie},
                     dataType:'json',
                     success:function(){
                        var token = $('input[name=_token]').val();
                        $("#main_content").load("/p_listeSortie",
                          {idOp : idoperateur, 
                           idOpt:idoperationOperateur, 
                           _token :token,
                           operation:operation,
                           operationcode:operationcode,
                           operationcoment:operationcoment
                          }
                        );
                     },
                     error:function(){alert('error')}
                  });
                }
            })
           }
          else
          {
            Swal.fire('Votre solde opération est inférieur au prix de la commande. Suprimé certains articles'); 
          }
          }
          else
          {
            Swal.fire('Veuillez saisir une date');
          }

        });



        $('.deleteBtn').click(function()
        {
          var idP = $(this).attr('id');
          console.log("idP:"+idP);
          ajaxDeleteVente($(this).attr('id'));
        })

        $('#suprSortie').click(function()
        {
          idV = $(this).attr('operat');
          console.log(idV);
          ajaxDeleteArriv();
        })


        function ajaxDeleteVente(idProduit)
        {


                Swal.fire({
                  title: 'Suppresion ',
                  text: "Voulez vous supprimer cet article de la commande ?",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  cancelButtonText: 'Annuler',
                  confirmButtonText: 'oui , Supprimer!'
                }).then((result) => {
                    if (result.value) {
                      $.ajax({
                        url:'/suprPrdSortie',
                        method:'GET',
                        data:{NumArt:idProduit},
                        dataType:'json',
                        success:function(){
                          Swal.fire(
                           'Supression!',
                           'Produits suipprimé avec succès',
                           'success'
                          );
                          $("#main_content").load("/listeSortiPrd");
                        },
                        error:function(){
                          Swal.fire('La suppression de produits est impossible');
                        }
                      });
                    }
                })
        
        }

        function ajaxDeleteArriv()
        {

                var token = $('input[name=_token]').val();
                Swal.fire({
                  title: 'Vider le panier',
                  text: "Voulez vous vider le panier cette sortie ?",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#d33',
                  cancelButtonColor: '#3085d6',
                  cancelButtonText: 'Annuler',
                  confirmButtonText: 'oui , Supprimer!',
                   backdrop: `rgba(240,15,83,0.4)`
                }).then((result) => {
                    if (result.value) {
                      $.ajax({
                        url:'/suprSortie',
                        method:'GET',
                        data:{NumArt:1},
                        dataType:'json',
                        success:function(){
                          Swal.fire(
                           'Supression!',
                           'Panier vidé avec succès',
                           'success'
                          );
                          //$("#main_content").load("/p_OpListe");
                          //var idV = $(this).attr('id');
                          
                          $("#main_content").load("/p_OpSortie",{idV:idV,_token:token});
                          //$('#main_content').load('/p_OpSortie',{idV:idOp,_token:token});
                        },
                        error:function(){
                          Swal.fire('Problème de connexion internet');
                        }
                      });
                    }
                })
        
        }




    </script>
