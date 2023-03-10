
<div class="card mb-3">
  <!--/.bg-holder-->

    <div class="card-body">
                <div class="form-row justify-content-between no-print">

                  <div class="form-group col-4">
          
                    <label for='chargeLibelle'> Description  charge {{ count($_SESSION['achatP']) }} </label>
                    <input class="form-control " id="chargeLibelle" name="chargeLibelle" type="text" placeholder="livraison, transport..." maxlength="100">
                  </div>
                  <div class="form-group col-2">
                    <label for='chargeVal'> Montant ( en {{ getMyDevise() }}) </label>
                    <input class="form-control " id="chargeVal" name="chargeVal" type="number" value="">
                  </div>
                  <div class="form-group col-2">
                    <label for='dateV'> Date vente <span class="fas fa-times-circle text-danger" data-fa-transform="shrink-1"></span></label>

                    <input class="form-control datetimepicker" id="dateV" name="dateV" type="text" data-options='{"dateFormat":"d/m/Y"}'>
                  </div>                 
                  <div class="form-group col-1 ">
                    <label for='retour'> Retourner  </label>
                      <button class="btn btn-sm btn-secondary " id="retour">Retour</button>
                  </div> 
                  <div class="form-group col-2">
                    <label for='retour'> Vider panier </label>
                      <button class="btn btn-sm btn-danger " id="deleteAchat">Suprimer</button>
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
                      <?php if (!empty($_SESSION['achatP'])){
                        $i=0;
                        $total=0;
                          foreach ($_SESSION['achatP'] as $key => $value)
                           {$i +=1; ?>  
                      <tr>
                        <th class="align-middle sort">{{ $i }}</th>
                        <th class="align-middle sort">
                          {{ getPrd($value['article'])->produitLibele  }}
                        </th>
                        <th class="align-middle sort">{{ $value['qte']  }}</th>
                        <th class="align-middle sort">{{ $value['prix']  }}</th>
                        <th class="align-middle no-sort">{{ $value['prix']* $value['qte'] }}</th>
                        <td class="align-middle text-center fs-0 deleteBtn" id="{{ $key }}" style="cursor: pointer;" >
                          <input type="hidden" id="key" value="">
                          <span class="badge badge rounded-capsule badge-soft-danger"> &nbsp;<span class="mr-2 fas fa-trash ml-1" data-fa-transform="shrink-2"></span> &nbsp;</span>
                        </td>
                      </tr>
                       <?php
                       $total += $value['prix']* $value['qte']; 
                     } }else{
                         echo "<div class='alert alert-warning'>Aucun produit</div>";
                       }?>
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
                        <span id="chargeCol"> 00 </span> {{ getMyDevise() }} </td>
                    </tr>
                    <tr class="border-top border-2x font-weight-bold text-900">
                      <th>Total TTC </th>
                      <td class="valeurTTC"> {{ formatPrice($total) }} </td>
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
                 <span class="valeurTTC"> {{ formatPrice($total) }} </span>
                </button>
                  </div>

                  <div class="form-group col-4">
                    {{-- <label for="exampleFormControlSelect1">Type </label> --}}
                    <select class="form-control" id="type">
                      <option value="0" typeFacture ='Facture Proformat'>Facture Proformat</option>
                      <option value="1" typeFacture ="Facture d'achat">Vente</option>
                    </select>
                  </div>
                  <div class="form-group col-2">
                  <button class="btn btn-sm btn-primary fs-1" id="enregistreAchat">Enregistrer
                  </button>
                  </div> 
              {{-- </div> --}}


{{--                   <button class="btn btn-sm btn-primary fs-1" id="enregistreAchat">Enregistrer
                  </button>
                   <div class="form-group ">
                      <label for="idClient">Liste client</label>

                  </div> --}}
            </div>
          </div>


          <div id="mytoken">
            <input type="hidden" name="id_succursale" id="idSuc" value="{{ $_SESSION['clientId'] }}">
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
      //Retour au panier
        $('#retour').click(function()
          {

            $('#main_content').load('/mbo/venteP');
            // alert('cliquer');
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
              text: "Voulez vous enregistrer la vente ?",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              cancelButtonText: 'Annuler',
              confirmButtonText: 'oui , valider!'
            }).then((result) => {
                if (result.value) {
                  $.ajax({
                    url:'mbo/saveAchat',
                    method:'GET',
                    data:{charge:charge,dateV:date,chargeLibelle:chargeLibelle,type:type},
                    dataType:'text',
                    success:function(data){
                      //Impression de recu
                        printRecu(parseInt(data)); 
                          //mise en atente du mesage de succes pour
                          //pouvoir afficher le recu en chargement
                        setTimeout(msgSucces, 3000); 
                        
                       if ($('#type').val() =='0') 
                       {
                        //Retourner la vue des facture proformat
                        $("#main_content").load("mbo/lfactuProP");

                       }
                       else
                       {
                        //Retourner la vue des liste des ventes
                        $("#main_content").load("mbo/lventeP");

                       }
                    },
                    error:function(){
                      Swal.fire('Probl??me de connection internet');
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
            ajaxDelPrdAchat($(this).attr('id'));
          })
    
    //clic sur suppression achat 
        $('#deleteAchat').click(function()
        {

          delAchat();
        })


    //Supression du panier
        function delAchat()
        {
                Swal.fire({
                  title: 'Suppresion',
                  text: "Voulez vous supprimer la commande ?",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  cancelButtonText: 'Annuler',
                  confirmButtonText: 'oui , Supprimer!'
                }).then((result) => {
                    if (result.value) {
                      $.ajax({
                        url:'mbo/delAchat',
                        method:'GET',
                        data:{action:'tous supprimer'},
                        dataType:'json',
                        success:function(){
                          Swal.fire(
                           'Suppression!',
                           'Vente suipprim?? avec succ??s',
                           'success'
                          );
                          $("#main_content").load("mbo/venteP");
                        },
                        error:function(){
                          Swal.fire('Probl??me de connexion internet');
                        }
                      });
                    }
                })
        
        }

    //Function de supression dun  prd
        function ajaxDelPrdAchat(idPrd)
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
                        url:'mbo/delPrdAchat',
                        method:'GET',
                        data:{idPrd:idPrd},
                        dataType:'json',
                        success:function(){
                          Swal.fire(
                           'Supression!',
                           'Produit suipprim?? avec succ??s',
                           'success'
                          );
                          $("#main_content").load("mbo/lPrdAchat");
                        },
                        error:function(){
                          Swal.fire('Probl??me de connexion internet');
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
                       'Vente enregistrer avec succ??s.',
                       'success'
                      );
          }



    </script>
