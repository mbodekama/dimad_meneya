@include('layouts.partials.header')

<div id="main_content">
        <div class="card">

            <div class="card-body overflow-hidden text-center pt-5" id="show">
              <div class="row justify-content-center">
                <div class="col-lg-8 col-md-5"><img class="img-fluid" 
                  src="{{$img}}" alt="" /></div>
              </div>
              <h3 class="mt-3 font-weight-normal fs-2 mt-md-4 fs-md-3">
               <b>{{$titre}}</b>
               <input type="hidden" value="{{$idprd}}" id="prdId">
               <input type="hidden" value="{{$prix}}" id="prix">
               <input type="hidden" value="{{$liv}}" id="livr">
              </h3>
                <h4 class="mt-3 font-weight-normal fs-2 mt-md-4 fs-md-3">
                 <span class="text-warning mr-2">{{$prix}} {{getMyDevise()}}
                 </span>

                 @if($prixold!=null)
                 <span class="mr-1 fs--1 text-500">
                  <strong><del class="mr-1">{{$prixold}} {{getMyDevise()}}</del>
                  </strong>{{-- <strong>-50%</strong> --}}
                 </span>
                 @endif
                </h4>
              <p class="lead">{{$descrpt}}</p>

              <div class="row justify-content-center mt-5 mb-4">
                <div class="col-md-7">
                  
                  <div>
                    <div class="form-row">

                      <div class="col mb-2 mb-sm-0">
                        <input class="form-control" type="number" 
                         placeholder="Quantité: 1" aria-label="Recipient's username" min="1" id="qte"/>
                      </div>
                      <div class="col-12 col-sm-auto">
                        <a href="#checkout">
                         <button class="btn btn-primary btn-block" 
                                type="button" id="buy">Acheter
                         </button>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="card-body overflow-hidden text-center pt-5" 
                id="checkout">
              <div class="card">
                <div class="card-header bg-light" id="step2">
                  <h5 class="mb-0">Addresse de Livraison</h5>
                </div>
                <div class="card-body">
                  <div class="form-row">
                    
                    <div class="col-12 pl-4">
                      <div class="row">
                        <div class="col-sm-8">

                          <div class="form-row align-items-center">
                            <div class="col">
                              <div class="form-group">
                                <input class="form-control" type="text" placeholder="Votre nom" id="nom">
                              </div>
                            </div>
                          </div>

                          <div class="form-row align-items-center">
                            <div class="col">
                              <div class="form-group">
                                <input class="form-control" type="text" placeholder="Votre numéro de téléphone" id="tel">
                              </div>
                            </div>
                          </div>

                          <div class="form-row align-items-center">
                            <div class="col">
                              <div class="form-group">
                                <input class="form-control" type="text" placeholder="Lieu de livraison" id="lieu">
                              </div>
                            </div>
                          </div>

                          
                        </div>
                        <div class="col-4 text-center pt-2 d-none d-sm-block">
                          <div class="rounded p-2 mt-3 bg-100">
                            <div class="text-uppercase fs--2 font-weight-bold">
                              {{-- Nous acceptons --}}
                            </div>
                            <img src="{{asset('assets/img/icons/OIP.jpg')}}" alt="" width="300">
                            <img src="../assets/img/icons/momo.png" alt="" width="120">

                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <hr class="border-dashed my-5">
                  <div class="row">
                    <div class="col-md-7 col-xl-12 col-xxl-7 px-md-3 mb-xxl-0">
                      <div class="media"><img class="mr-3" src="../assets/img/icons/shield.png" alt="" width="60">
                        <div class="media-body">
                          <h5 class="mb-2">Protection de l'acheteur</h5>
                          <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" id="protection-option-1" type="checkbox" checked>
                            <label class="custom-control-label" for="protection-option-1"> <strong>Remboursement complet </strong>Si vous ne <br class="d-none d-md-block d-lg-none">recevez pas votre commandes</label>
                          </div>
                          <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" id="protection-option-2" type="checkbox" checked>
                            <label class="custom-control-label" for="protection-option-2"> <strong>Remboursement complet ou partiel</strong> Si le produit ou service n'est pas comme décrit dans les détails</label>
                          </div>
                            <a class="fs--1 ml-3 pl-2" href="#!">
                              <b>{{ getSettingByName('Entreprise')}}</b>
                            </a>
                        </div>
                      </div>
                      <div class="vertical-line d-none d-md-block d-xl-none d-xxl-block"></div>
                    </div>
                    <div class="col-md-5 col-xl-12 col-xxl-5 pl-lg-4 pl-xl-2 pl-xxl-5 text-center text-md-left text-xl-center text-xxl-left">
                      <hr class="border-dashed d-block d-md-none d-xl-block d-xxl-none my-4">
                      <h5 class="mb-0">Résumé de commandes</h5>
                      <br>
                      <table class="table table-borderless fs--1 mb-0">
                    <tr class="border-bottom">
                      <th class="pl-0 pt-0">{{$titre}} <span class="text-danger">X</span> 
                        <span class="qtee text-danger"></span>
                        <div class="text-400 font-weight-normal fs--2">
                         {{$descrpt}}<br>
                         <b>Prix: {{$prix}} {{getMyDevise()}}</b>
                        </div>
                      </th>
                      <th class="pr-0 text-right pt-0">
                        <span class="TPr">
                        </span> 
                        {{getMyDevise()}}</th>
                      </tr>

                    <tr class="border-bottom">
                      <th class="pl-0">Livraison</th>
                       @if($liv!=null)
                       <th class="pr-0 text-right">{{$liv}} {{getMyDevise()}}
                       </th>
                       @else
                        <th class="pr-0 text-right text-danger">gratuite
                       </th>
                       @endif


                    </tr>
                    <tr>
                      <th class="pl-0 pb-0">Total</th>
                      <th class="pr-0 text-right pb-0"> <span id="total"></span> {{getMyDevise()}}</th>
                    </tr>
                  </table>
                      <div class="spinner-border sedPay" role="status">
                        <span class="sr-only">Loading...</span>
                        <span class='far fa-money-bill-alt'></span>
                      </div>
                      <button class="btn btn-danger mt-3 px-5" 
                          type="button" id="pay">Confirmer &amp; Payer
                      </button>
                      <button id="bt_get_signature" style="display: none;">
                      </button>
                    <a href="#show">
                      <button class="btn btn-info mt-3 px-5" 
                         id="back" type="submit">
                         Annuler
                      </button>
                    </a>
                     
                    </div>
                  </div>
                </div>
              </div>
            
            </div>

            <div class="card-footer d-flex justify-content-center bg-light text-center pt-4">
              <div class="col-10">

                <h4 class="font-weight-normal mb-3 fs-1 fs-md-2">
                  {{getSettingByName('Entreprise')}}
                </h4>
                <b>Qui sommes-nous ?</b>
                <p class="fs--1">
                  {{getSettingByName('about')}}  
                </p>
                <div class="form-row my-4">

                   <div class="col-xl-4">
                    <button class="btn btn-falcon-default btn-block mb-2 mb-xl-0" data-toggle="modal" data-target="#copyLinkModal">
                      
                      <span class="fas fa-share text-700"></span>
                      <span class="font-weight-medium ml-2">Partager</span>
                      
                    </button>
                    <div class="modal fade" id="copyLinkModal" tabindex="-1" role="dialog" aria-labelledby="copyLinkModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content overflow-hidden">
                          <div class="modal-header">
                            <h5 class="modal-title" id="copyLinkModalLabel">
                              Partager à vos contacts
                            </h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span class="font-weight-light" aria-hidden="true">&times;</span></button>
                          </div>
                          <div class="modal-body bg-light p-4">
                            <div class="sharethis-inline-share-buttons"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-xl-4">
                    <a href="http://wa.me/{{whatsAppShop()}}?text=*je suis interressé(e) par {{$titre}}. Veuillez me contactez.*
                    {{$shareL}}">
                     <button class="btn btn-falcon-default btn-block mb-2 mb-xl-0">
                      <span class="fab fa-whatsapp text-success" data-fa-transform="grow-2"></span>
                      <span class="font-weight-medium ml-2">
                      {{whatsAppShop()}}
                     </span></button>
                    </a>
                  </div>

                 
                  <div class="col-xl-4">
                    
                    <button class="btn btn-falcon-default btn-block mb-2 mb-xl-0">
                      <span class="fab fa-facebook-square text-facebook" data-fa-transform="grow-2"></span>
                      <span class="font-weight-medium ml-2">
                        <a href="{{facebookShop()}}">
                          Nous suivre...
                        </a>
                      </span>
                    </button>
                    
                  </div>

                </div>

              </div>
            </div>
          </div>
</div>


@include('layouts.partials.footer')
{{-- Script de gestion de la page --}}

<script charset="utf-8" src="https://www.cinetpay.com/cdn/seamless_sdk/latest/cinetpay.prod.min.js" type="text/javascript"></script>
<script src="{{ asset('js/payment.js') }}"></script>
<script type="text/javascript">
  
  $("#checkout").hide();
  $(".sedPay").hide();
  

  // Boutton acheter
  $("#buy").click(function(){
     $("#show").hide();
     $("#checkout").show();
     var prix = $("#prix").val();
     var qte  = $("#qte").val();
     var liv  = $("#livr").val();
     if (qte=="") {
       var qte = 1;
     }
     var total = (Number(prix)*Number(qte))+Number(liv);
     $("#total").text(total);
     $(".qtee").text(qte);
     $(".TPr").text(Number(prix)*Number(qte));
  });

  // Boutton Annuler
  $("#back").click(function(){
     $("#show").show();
     $("#checkout").hide();

     $("#nom").val("");
     $("#tel").val("");
     $("#lieu").val("");
     $("#qte").val("");
  });

   init();
</script>