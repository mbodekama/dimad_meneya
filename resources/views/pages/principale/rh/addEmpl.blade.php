
          <div class="card mb-3">
            <div class="card-body">
              <div class="row justify-content-between align-items-center">
                <div class="col-md">
                  <h4 class="mb-2 mb-md-0"><span class="fas fa-users"></span>  Gestion des Utilisateur</h4>
                </div>

                    <button class="btn btn-falcon-default btn-sm text-warning" type="button" id="btnList">
                      <span class="fas fa-eye" data-fa-transform="shrink-3 down-2"></span>
                      <span class="d-none d-sm-inline-block ml-1">Voir liste</span>
                    </button>

              </div>
            </div>
          </div>

            <div class="row no-gutters d-flex justify-content-center">
              <div class="col-lg-8 pr-lg-2">
                <div class="card mb-3">
                  <div class="card-header">
                    <h5 class="mb-0">Identité de l'utilisateur</h5>
                  </div>
                    @include('pages/principale/rh/formEmpl');

                </div>

              </div>
            </div>




    <script src="{{ asset('assets/js/theme.js') }}"></script>
