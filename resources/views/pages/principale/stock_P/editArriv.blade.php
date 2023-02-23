
<div class="card mb-3">

    <div class="card-body">
                <div class="form-row justify-content-between no-print">

                  <div class="form-group col-4">
                    <label for='chargeLibelle'> Description  charge</label>
                    <input class="form-control " id="chargeLibelle" name="chargeLibelle" type="text" placeholder="livraison, transport..." maxlength="100"
                    value="{{ $arriv->description_charge }}">
                  </div>
                  <div class="form-group col-2">
                    <label for='chargeVal'> Montant ( en {{ getMyDevise() }}) </label>
                    <input class="form-control " id="chargeVal" name="chargeVal" type="number" value="{{$arriv->charge  }}">
                  </div>
                  <div class="form-group col-2">
                    <label for='dateV'> Date vente <span class="fas fa-times-circle text-danger" data-fa-transform="shrink-1" ></span></label>

                    <input class="form-control datetimepicker" id="dateV" name="dateV" type="text" data-options='{"dateFormat":"d/m/Y"}' value="{{$arriv->arrivageDate }}">
                  </div>                 
                  <div class="form-group col-1 ">
                    <label for='retour'> Annuler </label>
                      <button class="btn btn-sm btn-secondary " id="retour" type="{{ $arriv->statut }}"
                      >Retour</button>
                  </div> 
                  <div class="form-group col-2">
                    <label for='deleteAchat'> Suprimer vente </label>
                      <button class="btn btn-sm btn-danger " id="deleteAchat" idV="{{ $arriv->id }}">Suprimer</button>
                  </div> 
              </div>
    </div>
          <div class="card no-print">

              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-sm mb-0 table-striped table-dashboard fs--1  border-bottom border-200" data-options='{"searching":false,"responsive":true,"pageLength":50}'>
                    <thead class="bg-200 text-900">
                      <tr>
                        <th class="align-middle sort">Id</th>
                        <th class="align-middle sort">Produits</th>
                        <th class="align-middle sort">Qte</th>
                        <th class="align-middle sort">Coût achat/Unit</th>
                        <th class="align-middle no-sort">Prix Net</th>
                        <th class="no-sort pr-1 align-middle data-table-row-action">Action</th>

                      </tr>
                    </thead>
                    <tbody id="customers">
                      @if (!empty($prd))                     
                        @php
                           $total=0;
                         @endphp
                      @foreach ($prd as $prdL) 
                      <tr class="ligneVente">
                        <th class="align-middle sort">{{ $loop->iteration }}</th>
                        <th class="align-middle sort">
                          {{ $prdL->produitLibele  }}
                        </th>
                        <th class="align-middle sort fs-1" id="{{ "qtePrd".$prdL->arrivPrdLine }}">
                            {{ $prdL->qteproduits  }}</th>
                        <th class="align-middle sort fs-1" id="{{ "prixPrd".$prdL->arrivPrdLine }}">
                            {{ $prdL->coutachat }}</th>
                        <th class="align-middle no-sort fs-1" id="{{ "totalPrd".$prdL->arrivPrdLine }}">
                            {{ $prdL->coutachat* $prdL->qteproduits }}</th>
                        <td class="align-middle text-center d-flex " style="cursor: pointer;" >
                          <input type="hidden" id="key" value="">
                          
                            <div class="activeEdit" idPrd="{{ $prdL->id }}"  idVnt ="{{ $arriv->id }}"
                                  arrivPrdLine="{{ $prdL->arrivPrdLine }}"  >
                              <span class="mr-2 fas fa-2x fa-edit text-warning "  ></span>
                            </div>
                            <div class="validEdit" idPrd="{{ $prdL->id }}"  idVnt ="{{ $arriv->id }}"
                                  arrivPrdLine="{{ $prdL->arrivPrdLine }}" >
                            <span class="mr-2 far fa-check-square fa-2x text-primary  "  ></span>
                            </div>
                          <div class="deleteBtn" idPrd="{{ $prdL->id }}"  idVnt ="{{ $arriv->id }}">
                            <span class="mr-2  fas fa-2x fa-trash text-danger "  ></span>
                          </div>
                            
                        </td>
                      </tr>

                        @php
                        $total += $prdL->coutachat* $prdL->qteproduits; 
                        @endphp
                       @endforeach
                       @else
                         <div class='alert alert-warning'>Aucun produit</div>;
                       @endif


                    </tbody>
                  </table>
                </div>

              </div>
              <div class="row no-gutters justify-content-end mr-3">
                <div class="col-auto">
                  <table class="table table-sm table-borderless fs--1 text-right">
                    <tbody><tr>
                      <th class="text-900">Sous-Total:</th>
                      <td class="font-weight-semi-bold" id="sousTotal" value="{{ $total }}" > {{ formatPrice($total) }}</td>
                    </tr>
                    <tr>
                      <th class="text-900">Charges</th>
                      <td class="font-weight-semi-bold" >
                        <span id="chargeCol"> {{ $arriv->charge }} </span> {{ getMyDevise() }} </td>
                    </tr>
                    <tr class="border-top border-2x font-weight-bold text-900">
                      <th>Total TTC </th>
                      <td class="valeurTTC"> {{ formatPrice($total+($arriv->charge)) }} </td>
                    </tr>
                  </tbody></table>
                </div>
              </div>

            {{-- <div class="card-footer bg-light d-flex justify-content-between"> --}}

                <div class=" card-footer bg-light form-row justify-content-between">


               
                  <div class="form-group col-4 ">
                    {{-- <label for='retour'>  </label> --}}
                <button class="btn btn-falcon-danger btn-sm mr-2 fs-1" role="button">
                  Total: 
                 <span class="valeurTTC"> {{ formatPrice($total+($arriv->charge)) }} </span>
                </button>
                  </div>

                  <div class="form-group col-2">
                  <button class="btn btn-sm btn-primary fs-1" id="enregistreAchat"
                    idVnt='{{ $arriv->id }}'
                  >Mettre a jour
                  </button>
                  </div> 

                </div>
          </div>


          <div id="mytoken">
            <input type="hidden" name="id_succursale" id="idSuc" value="{{ $arriv->clients_id }}">
            @csrf
          </div>

     <!-- ===============================================-->
    <!--    Fichier Facture pour operateur-->
    <!-- ===============================================-->

      @include('pages/dash/facture/vntP')

    <!-- ===============================================-->
    <!--    Fin Fichier Facture pour operateur -->
    <!-- ===============================================--> 

    <script src="{{ asset('assets/js/theme.js') }}"></script>


    <script type="text/javascript">
      //Retour au liste des ventes / Facture proformat
        $('#retour').click(function()
          {
            var type = $(this).attr('type');
            if (type == 0) {$('#main_content').load('/mbo/arrivAttn');}
            else {$('#main_content').load('/mbo/arrivOk');}
            
          });

    // Appliquer Montant charge
        $('#chargeVal').keydown(function(event)
          {
              if(event.keyCode == 13 || event.keyCode == 9)
                {
                  calculCharge();
                    $('#dateV').focus();
                }
          });

    // Appliquer Montant charge
        $('#chargeVal').blur(function(event)
          {
            if ($('#chargeVal').val() != '' && $('#chargeVal').val().length >=2 ) 
              {
                calculCharge();
                $('#dateV').focus();

              }
          });



    //Calcul charge
        function calculCharge()
        {
                  if ($('#chargeLibelle').val().trim() != '') 
                  {
                    if ($('#chargeVal').val() != '') 
                      {
                        $('#chargeVal').attr('class','form-control is-valid');
                        var chargeCol = $('#chargeCol');
                        var valeurTTC = $('.valeurTTC');
                         var chargeVal = parseInt($('#chargeVal').val());
                         var sousTotal = parseInt($('#sousTotal').attr('value'));
                         var ttc = chargeVal+sousTotal;
                         chargeCol.text(chargeVal);
                         valeurTTC.text(ttc);

                         formatPriceJs(ttc,valeurTTC);


                      }
                      else
                      {
                        $('#chargeVal').attr('class','form-control is-invalid');
                      }
                  }
                  else
                  {
                    toastr.error('Veuillez saisir le libelle de la charge');
                    $('#chargeVal').val('');

                  }
        }

    //Enregistrement achat cliquer
      $('#enregistreAchat').click(function()
        {
        //Affectation au recu 
          var idVnt = $(this).attr('idVnt');
          $('#descritptionCharge').text($('#chargeLibelle').val());
          var typeFacture = $('#type option:selected').attr('typeFacture');
            $('#typeVente').text(typeFacture);
          var charge = $('#chargeVal').val();
          var chargeLibelle = $('#chargeLibelle').val();
          var type = $('#type').val();
          var date = $('#dateV').val();

          if($('#dateV').val() != "")
          {
            Swal.fire({
              title: 'Vente',
              text: "Voulez vous enregistrer les modifications apporté?",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              cancelButtonText: 'Annuler',
              confirmButtonText: 'oui , valider!'
            }).then((result) => {
                if (result.value) {
                  $.ajax({
                    url:'mbo/updArriv',
                    method:'GET',
                    data:{idVnt:idVnt,charge:charge,dateV:date,chargeLibelle:chargeLibelle,type:type},
                    dataType:'text',
                    success:function(data){
  
                        msgSucces();
                        
                        $("#main_content").load("mbo/arrivAttn");
                    },
                    error:function(){
                      Swal.fire('Problème de connection internet');
                    }
                  });
                }
            })
          }
          else
          {
            toastr.error('Veiullez saisir une date valide');
          }
        });
    
    //Clic sur suprimer un prd
          $('.deleteBtn').click(function()
          {
            
            var idV = $(this).attr('idVnt');
            var idPrd =$(this).attr('idPrd');
            ajaxDelPrdAchat(idV,idPrd);
          })

    //Clic sur editer un prd
          $('.activeEdit').click(function()
          {
            
            $(this).next().show();
            $(this).hide();
            
            let arrivPrdLine = $(this).attr('arrivPrdLine');
            let idV = $(this).attr('idVnt');
            let idPrd =$(this).attr('idPrd');

            // selection de la colonne quatite & prix
            let selecteur1 = "#qtePrd"+arrivPrdLine;
            let qtePrd = $(selecteur1);

            let selecteur2 = "#prixPrd"+arrivPrdLine;
            let prixPrd = $(selecteur2);

            //rendre editable les colonnes
            qtePrd.attr('contenteditable','true');
            prixPrd.attr('contenteditable','true');

      
          })

    //Clic sur valider edition un prd
          $('.validEdit').hide() //cacher par défaut

          $('.validEdit').click(function()
          {
            $(this).prev().show();
            $(this).hide();

            let arrivPrdLine = $(this).attr('arrivPrdLine');
            var idV = $(this).attr('idVnt');
            var idPrd =$(this).attr('idPrd');

            // selection de la colonne quatite & prix & total
            let selecteur1 = "#qtePrd"+arrivPrdLine;
            let qtePrd = $(selecteur1);

            let selecteur2 = "#prixPrd"+arrivPrdLine;
            let prixPrd = $(selecteur2);

            let selecteur3 = "#totalPrd"+arrivPrdLine;
            totalPrixPrd = $(selecteur3);

            //rendre editable les colonnes
            qtePrd.attr('contenteditable','false');
            prixPrd.attr('contenteditable','false');

                      $.ajax({
                        url:'mbo/updPrdArriv',
                        method:'GET',
                        data:{idPrd:idPrd,idVnt:idV,
                              newQte:parseInt(qtePrd.text()),
                              newPrix:parseInt(prixPrd.text())},
                        dataType:'json',
                        success:function(data){
                          toastr.success('Article mis à jour');
                          
                          //update prix net et total
                          totalPrixPrd.text(data.prdTotal);

                        },
                        error:function(data){
                          toastr.error('Echec de mise à jour');
                          
                        }
                      });
          })




    
    //clic sur suppression achat 
        $('#deleteAchat').click(function()
        {

          var idVnt = $(this).attr('idV');
          delAchat(idVnt);
        })

    //Supression du panier
        function delAchat(idVnt)
        {
                Swal.fire({
                  title: 'Suppresion',
                  text: "Voulez vous supprimer cet arrivage ?",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  cancelButtonText: 'Annuler',
                  confirmButtonText: 'oui , Supprimer!'
                }).then((result) => {
                    if (result.value) {
                      $.ajax({
                        url:'mbo/arrivDel',
                        method:'GET',
                        data:{idArr:idVnt},
                        dataType:'json',
                        success:function(){
                          Swal.fire(
                           'Suppression!',
                           'Arrivage suipprimé avec succès',
                           'success'
                          );
                          $("#main_content").load("mbo/arrivAttn");
                        },
                        error:function(){
                          Swal.fire('Problème de connexion internet');
                        }
                      });
                    }
                })
        
        }

    //Function de supression dun  prd
        function ajaxDelPrdAchat(idV,idPrd)
        {
          var input = '#mytoken input[name=_token]';
          var token = $(input).attr('value');
                Swal.fire({
                  title: 'Suppresion',
                  text: "Voulez vous supprimer ce produit de la commande ?",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  cancelButtonText: 'Annuler',
                  confirmButtonText: 'oui , Supprimer!'
                }).then((result) => {
                    if (result.value) {
                      $.ajax({
                        url:'mbo/delPrdArriv',
                        method:'GET',
                        data:{idPrd:idPrd,idVnt:idV},
                        dataType:'json',
                        success:function(){
                          toastr.success('Suprimé avec succès');
                          $("#main_content").load("mbo/editArriv",{idArr:idV, _token:token});
                        },
                        error:function(){
                          toastr.success('Problème de connexion');
                        }
                      });
                    }
                })
        
        }




    //Message de succes

          function msgSucces()
          {
                      Swal.fire(
                       'Valider!',
                       'Vente enregistrer avec succès.',
                       'success'
                      );
          }



    </script>
