
          <div class="card">
            <div class="card-header">
              <div class="row align-items-center justify-content-between">
                <div class="col-4 col-sm-auto d-flex align-items-center pr-0">
                  <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Liste des Fournisseurs</h5>
                </div>
                <div id="mytoken">
                  @csrf
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
                  <div id="customer-table-actions">
                    <button class="btn btn-falcon-default btn-sm" type="button" id="btnAdd">
                      <span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span>
                      <span class="d-none d-sm-inline-block ml-1">Nouveau</span>
                    </button>
                  </div>
                </div>
                <!-- Pagination -->
                  @include('pages/dash/pagnMod')
                
              </div>
            </div>
            @if(!$fournisseurs->isEmpty())
            <div class="card-body p-0" id="loaderContent">
              <div class="falcon-data-table">
                <table class="mytable table table-sm mb-0 table-striped table-dashboard fs--1 data-table border-bottom border-200" data-options='{"searching":true,"responsive":false,"pageLength":20,"info":false,"lengthChange":false,"sWrapper":"falcon-data-table-wrapper","dom":"<&#39;row mx-1&#39;<&#39;col-sm-12 col-md-6&#39;l><&#39;col-sm-12 col-md-6&#39;f>><&#39;table-responsive&#39;tr><&#39;row no-gutters px-1 py-3 align-items-center justify-content-center&#39;<&#39;col-auto&#39;p>>","language":{"paginate":{"next":"<span class=\"fas fa-chevron-right\"></span>","previous":"<span class=\"fas fa-chevron-left\"></span>"}}}'>
                  <thead class="bg-200 text-900">
                    <tr>
                      <th class="align-middle no-sort pr-3">
                        <div class="custom-control custom-checkbox">
                          <input class="custom-control-input checkbox-bulk-select" id="checkbox-bulk-customers-select" type="checkbox" data-checkbox-body="#customers" data-checkbox-actions="#customers-actions" data-checkbox-replaced-element="#customer-table-actions" />
                          <label class="custom-control-label" for="checkbox-bulk-customers-select"></label>
                        </div>
                      </th>
                      <th class="align-middle sort">Nom/Sociéte</th>
                      <th class="align-middle sort">Responsable</th>
                      <th class="align-middle sort">Contact</th>
                      <th class="align-middle sort pl-5">Email</th>
                      <th class="align-middle sort pl-5">Total partenariat</th>
                      <th class="align-middle ">Actions</th>
                      {{-- <th class="align-middle no-sort"></th> --}}
                    </tr>
                  </thead>
                  <tbody id="customers">

                   @foreach($fournisseurs as $fournisseur)
                    <tr class="btn-reveal-trigger">
                      <td class="py-2 align-middle white-space-nowrap">
                        <div class="custom-control custom-checkbox">
                          <input class="custom-control-input checkbox-bulk-select-target" type="checkbox" id="customer-checkbox-0" />
                          <label class="custom-control-label" for="customer-checkbox-0"></label>
                        </div>
                      </td>
                      <td class="py-2 align-middle white-space-nowrap customer-name-column"><a href="../pages/customer-details.html">
                          <div class="media d-flex align-items-center">
                            <div class="media-body">
                              <h5 class="mb-0 fs--1">{{ $fournisseur->fournisseurNom }}</h5>
                            </div>
                          </div>
                        </a>
                      </td>
                      <td class="py-2 align-middle ">
                        {{ $fournisseur->fournisseurRespo}}
                      </td>
                      <td class="py-2 align-middle white-space-nowrap">
                       {{ $fournisseur->fournisseurContact}}
                      </td>
                      <td class="py-2 align-middle pl-5">
                        {{ $fournisseur->fournisseurMail}}
                      </td>
                      <td class="py-2 align-middle pl-5">
                        <?php echo number_format(getTransF($fournisseur->id),0,',','. ').' FCFA' ;?>
                      </td>
                            <td class="align-middle">
                                <button class="btn btn-falcon-default btn-sm btnShow" id="{{ $fournisseur->id }}" type="button">
                                  <span class=" text-primary text-900" data-fa-transform="shrink-3 down-2"> Consulter</span>
                                  
                      
                                </button>
                                <button class="btn btn-falcon-default btn-sm btnEdit" id="{{  $fournisseur->id }}" type="button">
                                  
                                  <span class="far fa-edit text-warning fa-2x" data-fa-transform="shrink-3 down-2"></span>
                                </button>

                                <button class="btn btn-falcon-default btn-sm btnDel" 
                                 id="{{ $fournisseur->id }}" type="button">
                                  
                                  <span class="far fa-trash-alt text-danger fa-2x" data-fa-transform="shrink-3 down-2"></span>
                      
                                </button>

                            </td>
                    </tr>
                    @endforeach
                   
                  </tbody>
                </table>

                <!-- Paginate -->
                <div class="row no-gutters px-1 py-3 align-items-center justify-content-center">
                   {{ $fournisseurs->links() }}
                   <input type="hidden" id='lastPrd' 
                   value="{{ $fournisseurs->last()->id }}"> 
                </div>

              </div>
            </div>
            @else
              <div class="alert alert-warning">Aucun fournisseur enregistré</div>
            @endif
          </div>
      

          <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->



{{--     <script src="{{ asset('assets/js/theme.js') }}"></script> --}}

    <script type="text/javascript">
      $(function()
      {
        // Faire disparaitre les paginate de Javascript
          $(".mytable").parent().next().hide();

          var input = '#mytoken input[name=_token]';
          var token = $(input).attr('value');
        
        $('.btnDel').click(function()
        {
          var idF= $(this).attr('id');
          delFour(idF);
        });

        $('.btnEdit').click(function()
        {
          loadingScreen();
          var idEmpl= $(this).attr('id');
          $("#main_content").load("/editF",{idF:idEmpl,_token:token });
        });

        $('#btnAdd').click(function()
        {
          loadingScreen();
          $("#main_content").load("/p_newF");

        });

        $('.btnShow').click(function()
        {
          loadingScreen();
          var idFour = $(this).attr('id');
          $("#main_content").load("/showFour",{idFour:idFour,_token: token});

        });


        function delFour(idF)
        {


                Swal.fire({
                  title: 'Suppression',
                  text: "Voulez-vous supprimer ce fournisseur",
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
                        url:'/delFour',
                        method:'GET',
                        data:{idF:idF},
                        dataType:'json',
                        success:function(){
                          Swal.fire(
                           'Supression!',
                           'Supression fait avec succès',
                           'success'
                          );
                          $("#main_content").load("/p_listF");
                        },
                        error:function(){
                          Swal.fire('Problème de connexion internet');
                        }
                      });
                    }
                })
        
        }


      })
    </script>