
              {{-- SPINNER DE VISUEL --}}
                    <div class="d-none" id='spiner'>
                    <div class="spinner-border text-primary" role="status">
                      <span class="sr-only">Loading...</span>
                    </div>
                    <div class="spinner-border text-secondary" role="status">
                      <span class="sr-only">Loading...</span>
                    </div>
                    <div class="spinner-border text-success" role="status">
                      <span class="sr-only">Loading...</span>
                    </div>
                    <div class="spinner-border text-info" role="status">
                      <span class="sr-only">Loading...</span>
                    </div>
                    <div class="spinner-border text-warning" role="status">
                      <span class="sr-only">Loading...</span>
                    </div>
                    <div class="spinner-border text-danger" role="status">
                      <span class="sr-only">Loading...</span>
                    </div>
                    <div class="spinner-border text-light" role="status">
                      <span class="sr-only">Loading...</span>
                    </div>
                    <div class="spinner-border text-dark" role="status">
                      <span class="sr-only">Loading...</span>
                    </div>
                      
                    </div>
              {{-- SPINNER DE VISUEL --}}

              {{-- MODAL VUE DES HISTORIQUE DE PAIEMENT --}}
                  <div class="modal fade" id="histMod" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Historique de paiement créance</h5>
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
              {{-- MODAL VUE DES HISTORIQUE DE PAIEMENT --}}

              {{-- MODAL DE PAIEMENT DE CREANCE--}}
                    <div class="modal fade" id="payerMod" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Reglement de créance</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span class="font-weight-light" aria-hidden="true">&times;</span></button>
                          </div>
                          <div class="modal-body">
                              <form  id="payeCrdForm" >
                                <input type="hidden" id="idCrd" name="idCrd" value="">
                                <input type="hidden" id="clientId" name="clientId" value="">
                                <input type="hidden" id="montantCrd" value="">
                                @csrf         
                                          <div class="form-row">
                                            <div class="col-sm-6">
                                              <div class="form-group">
                                                <label for="clientNom">Client </label>
                                                <input class="form-control " id="clientNom" type="text" value="" readonly="">
                                              </div>
                                            </div>
                                            <div class="col-sm-6">
                                              <div class="form-group">
                                                <label for="datepicker">Date </label>
                                                <input class="form-control datetimepicker" id="date" name="date" type="text" data-options='{"dateFormat":"d/m/Y"}' value="{{ date('d/m/Y') }}">
                                              </div>
                                            </div>
                                            <div class="col-sm-6">
                                            <div class="form-group">
                                              <label for="exampleFormControlSelect1">Type de paiement</label>
                                              <select class="form-control" id="exampleFormControlSelect1" name="typePaiement">
                                                <option value="Espèce">Espèce</option>
                                                <option value="Banque">Banque</option>
                                                <option value="Chèque">Chèque</option>

                                              </select>
                                            </div>
                                            </div>
                                            <div class="col-sm-6">
                                              <div class="form-group">
                                                <label for="montantCrd">Montant ( max : 
                                                  <span class="badge badge rounded-capsule badge-soft-secondary text-danger" id="montantCrdFormat"> </span> )</label>
                                                <input class="form-control " required id="mntPaye" name="mntPaye" type="number">
                                              </div>
                                            </div>




                                          </div>
                            </form>
                          </div>
                          <div class="modal-footer">
                            <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal" id="payFormClose" >Fermer</button>
                            <button class="btn btn-primary btn-sm validPay" type="button">Valider</button>
                          </div>
                        </div>
                      </div>
                    </div>
              {{-- MODAL DE PAIEMENT DE CREANCE--}}



<script type="text/javascript">
  $(function()
  {

      //Fonction permetant de valider avec la touche entré
          $('#mntPaye').keydown(function(event)
          {

            if(event.keyCode == 13)
              {
                $('.validPay').click();
              }
          });

      //Valider le paiement
            $('.validPay').click(function()
            {
              var mntPaye = parseInt($('#mntPaye').val());
              var mntCrd = parseInt($('#montantCrd').val());
                if( mntPaye != 0)
                  {
                    if(mntPaye <= mntCrd)
                    {
                    ajaxCrdPay();
                    }
                    else
                    {
                      toastr.error('Le montant  saisi n\'est pas valide');
                    }
                  }
                else
                {
                  toastr.error('Veuilez remplir tous les champs');
                }
              
            })

      //Ajax  Paieement credit
        function ajaxCrdPay()
          {
            //envoie de la commande dans une requete ajax 
  
                  $.ajax(
                  {
                      method: "POST",
                      url: "/s_payCrd",
                      data: $('#payeCrdForm').serialize(),
                      dataType: "json",
                  })

              .done(function(data) 
                      {

                        toastr.success("Créance soldé avec succès");
                        $("#payeCrdForm").trigger("reset");
                          $('#payFormClose').click();
                        $('#sucCont').load('/s_credits'); //Actualiser la page


                       })
              .fail(function(data) 
                        {
                          toastr.error("Erreur d'ajout du client.");
                        });
          }

      //Historique Paiement
        $('.btnHist').click(function()
        {
          //Ajout spiner
          $('.histBody').html($('#spiner').html());

          var idCrd = $(this).attr('id');
          //req ajax 
          ajaxHistCrd(idCrd);
        });

         function ajaxHistCrd(idCrd)
         {
           $.ajax({
                    url:'/histCrd',
                    method:'GET',
                    data: {idCrd:idCrd},
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



        //Supprimer
        $('.btnDel').click(function(){
          var idV = $(this).attr('id');
          var action = 'Del';
          Swal.fire({
            title: 'Echeance',
            text: "Voulez-vous suprimer ce crédit ?",
            icon: 'danger',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Annuler',
            confirmButtonText: 'oui , supprimer!',
            backdrop: `rgba(240,15,83,0.4)`
          }).then((result) => {
              if (result.value) {
                $.ajax({
                  url:'/delCrd',
                  method:'GET',
                  data:{idCrd:idV},
                  dataType:'text',
                  success:function(){
                    Swal.fire(
                     'Supprimer!',
                     'Supression validé avec succès',
                     'success'
                    );
                    $('#sucCont').load('/s_credits'); 
                  },
                  error:function(){
                    Swal.fire('Problème de connection internet');
                  }
                });
              }
          })
        });


  })
</script>