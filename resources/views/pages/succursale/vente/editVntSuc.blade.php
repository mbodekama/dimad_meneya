
<div class="card mb-3">

    <div class="card-body">
                <div class="form-row justify-content-between no-print">

                  <div class="form-group col-4">
                    <label for='chargeLibelle'> Description  charge</label>
                    <input class="form-control " id="chargeLibelle" name="chargeLibelle" type="text" placeholder="livraison, transport..." maxlength="100"
                    value="{{ $vente->description_charge }}">
                  </div>
                  <div class="form-group col-2">
                    <label for='chargeVal'> Montant ( en {{ getMyDevise() }}) </label>
                    <input class="form-control " id="chargeVal" name="chargeVal" type="number" value="{{$vente->charge  }}">
                  </div>
                  <div class="form-group col-2">
                    <label for='dateV'> Date vente <span class="fas fa-times-circle text-danger" data-fa-transform="shrink-1" ></span></label>

                    <input class="form-control datetimepicker" id="dateV" name="dateV" type="text" data-options='{"dateFormat":"d/m/Y"}' value="{{$vente->dateV }}">
                  </div>                 
                  <div class="form-group col-1 ">
                    <label for='retour'> Annuler </label>
                      <button class="btn btn-sm btn-secondary " id="retour" type="{{ $vente->typevente }}"
                      >Retour</button>
                  </div> 
                  <div class="form-group col-2">
                    <label for='deleteAchat'> Suprimer vente </label>
                      <button class="btn btn-sm btn-danger " id="deleteAchat" idV="{{ $vente->id }}">Suprimer</button>
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
                        <th class="align-middle sort">Prix/Unit</th>
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
                      <tr>
                        <th class="align-middle sort"></th>
                        <th class="align-middle sort">
                          {{ $prdL->produitLibele  }}
                        </th>
                        <th class="align-middle sort">{{ $prdL->qte  }}</th>
                        <th class="align-middle sort">{{ $prdL->prixvente  }}</th>
                        <th class="align-middle no-sort">{{ $prdL->prixvente* $prdL->qte }}</th>
                        <td class="align-middle text-center fs-0 deleteBtn" 
                          id="{{ $prdL->id }}"  idVnt ="{{ $vente->id }}" 
                          style="cursor: pointer;" >
                          <input type="hidden" id="key" value="">
                          <span class="badge badge rounded-capsule badge-soft-danger"> &nbsp;
                            <span class="mr-2 fas fa-trash ml-1" data-fa-transform="shrink-2"></span> &nbsp;</span>
                        </td>
                      </tr>

                        @php
                        $total += $prdL->prixvente* $prdL->qte; 
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
                        <span id="chargeCol"> {{ $vente->charge }} </span> {{ getMyDevise() }} </td>
                    </tr>
                    <tr class="border-top border-2x font-weight-bold text-900">
                      <th>Total TTC </th>
                      <td class="valeurTTC"> {{ formatPrice($total+($vente->charge)) }} </td>
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
                 <span class="valeurTTC"> {{ formatPrice($total+($vente->charge)) }} </span>
                </button>
                  </div>

                  <div class="form-group col-4">
                    {{-- <label for="exampleFormControlSelect1">Type </label> --}}
                    <select class="form-control" id="type">
                      <option value="0" typeFacture ='Facture Proformat'
                      @if($vente->typevente == 0) selected @endif>
                        Facture Proformat
                      </option>

                      <option value="1" typeFacture ="Facture d'achat"
                      @if($vente->typevente == 1) selected @endif>
                        Vente
                      </option>
                    </select>
                  </div>
                  <div class="form-group col-2">
                  <button class="btn btn-sm btn-primary fs-1" id="enregistreAchat"
                    idVnt='{{ $vente->id }}'
                  >Mettre a jour
                  </button>
                  </div> 

            </div>
          </div>


          <div id="mytoken">
            <input type="hidden" name="id_succursale" id="idSuc" value="{{ $vente->clients_id }}">
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
            $('#sucCont').load('s_Vente');
            
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
                    url:'updAchatSuc',
                    method:'GET',
                    data:{idVnt:idVnt,charge:charge,dateV:date,chargeLibelle:chargeLibelle,type:type},
                    dataType:'text',
                    success:function(data){
                      //Impression de recu
                        // printRecu(parseInt(data)); 
                          //mise en atente du mesage de succes pour
                          //pouvoir afficher le recu en chargement
                        setTimeout(msgSucces, 1000); 
                        
                        //Retourner la vue des facture proformat
                        $("#sucCont").load("s_Vente");

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
            var idPrd =$(this).attr('id');
            ajaxDelPrdAchat(idV,idPrd);
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
                  text: "Voulez vous supprimer cette vente ?",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  cancelButtonText: 'Annuler',
                  confirmButtonText: 'oui , Supprimer!'
                }).then((result) => {
                    if (result.value) {
                      $.ajax({
                        url:'delVntSuc',
                        method:'GET',
                        data:{idVente:idVnt},
                        dataType:'json',
                        success:function(){
                          Swal.fire(
                           'Suppression!',
                           'Vente suipprimé avec succès',
                           'success'
                          );
                           $("#sucCont").load("s_Vente");
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
                        url:'delPrdVntSuc',
                        method:'GET',
                        data:{idPrd:idPrd,idVnt:idV},
                        dataType:'json',
                        success:function(){
                          Swal.fire(
                           'Supression!',
                           'Produit suipprimé avec succès',
                           'success'
                          );
                          var token = $('input[name=_token]').val();
                          $("#sucCont").load("editVntSuc",{idV:idV, _token:token});
                        },
                        error:function(){
                          Swal.fire('Problème de connexion internet');
                        }
                      });
                    }
                })
        
        }


    //Impression du recu
        function printRecu(data)
        {
       
               var idVnt = data;              
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


          function msgSucces()
          {
                      Swal.fire(
                       'Valider!',
                       'Vente enregistrer avec succès.',
                       'success'
                      );
          }



    </script>
