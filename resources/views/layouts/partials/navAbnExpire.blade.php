
          <div class="d-flex align-items-center">
            <div class="toggle-icon-wrapper">

              <button class="btn navbar-toggler-humburger-icon navbar-vertical-toggle" ><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>

            </div><a class="navbar-brand" href="{{ route('dashboard') }}">
              <div class="d-flex align-items-center py-3">
                <img class="mr-2" src="assets/img/illustrations/falcon.png" 
                  alt="" width="40" />
                  <span class="text-sans-serif" style="color:#cc0033;">
                   {{ env('APP_NAME') }}
                  </span>
              </div>
            </a>
          </div>
          <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
            <div class="navbar-vertical-content perfect-scrollbar scrollbar">
              <ul class="navbar-nav flex-column">
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('dashboard') }}">
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fab fa-trello"></span></span><span class="nav-link-text"> Tableau de bord</span>
                    </div>
                  </a>
                </li>

              </ul>

              <div class="navbar-vertical-divider">
                <hr class="navbar-vertical-hr my-2" />
              </div>


               {{-- MENU PRINCIPALES --}}

              @if(getRole() == "admin")

              <ul class="navbar-nav flex-column">
                {{-- ARRIVAGE --}}
                @if(hasStatAccesto(Auth::id(),1))
                <li class="nav-item">
                  <a class="nav-link dropdown-indicator" href="#arriv" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="arriv">
                    <div class="d-flex align-items-center">
                      <span class="nav-link-icon"><i class="fas fa-shipping-fast"></i></span>
                      <span class="nav-link-text">Arrivage</span>
                    </div>
                  </a>
                  <ul class="nav collapse" id="arriv" data-parent="#navbarVerticalCollapse">
                    <li class="nav-item  collapsed abnExpire">
                      <a class="nav-link" href="#top">Nouvelle commande</a>
                    </li>
                    <li class="nav-item  collapsed abnExpire">
                      <a class="nav-link" href="#top">Commande en attente</a>
                    </li>
                    <li class="nav-item  collapsed abnExpire">
                      <a class="nav-link" href="#top">Commande validée</a>
                    </li>

                    <li class="nav-item  collapsed" >
                      <a class="nav-link" href="{{ route('dashboard') }}">Statistique</a>
                    </li>

                  </ul>
                </li>
                @endif

                {{-- PRINCIPALES --}}
                @if(hasStatAccesto(Auth::id(),2))
                <li class="nav-item">
                  <a class="nav-link dropdown-indicator" href="#principal" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="principal">
                    <div class="d-flex align-items-center">
                      <span class="nav-link-icon"><i class="fas fas fa-home"></i></span>
                      <span class="nav-link-text">Principale</span>
                    </div>
                  </a>
                  <ul class="nav collapse" id="principal" data-parent="#navbarVerticalCollapse">
                    <li class="nav-item  collapsed  abnExpire">
                      <a class="nav-link" href="#top">Nos produits</a>
                    </li>
                    <li class="nav-item  collapsed abnExpire"><a class="nav-link" href="#top">Approvisionnement</a>
                    </li>
                    <li class="nav-item  collapsed abnExpire"><a class="nav-link" href="#top">Liste Approvi.</a>
                    </li>



                  </ul>
                </li>
                @endif

                {{-- SUCCURSALES --}}
                @if(hasStatAccesto(Auth::id(),3))
                <li class="nav-item">
                  <a class="nav-link dropdown-indicator" href="#Succursale" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="Succursale">
                    <div class="d-flex align-items-center">
                      <span class="nav-link-icon"><i class="fas fa-store-alt"></i></span>
                      <span class="nav-link-text">Succursale</span>
                    </div>
                  </a>
                  <ul class="nav collapse" id="Succursale" data-parent="#navbarVerticalCollapse">
                    <li class="nav-item  collapsed abnExpire" >
                      <a class="nav-link" href="#top">Créer Succursale</a>
                    </li>
                    <li class="nav-item  collapsed abnExpire" >
                      <a class="nav-link" href="#top">Liste Succursale</a>
                    </li>
                    <li class="nav-item abnExpire" >
                      <a class="nav-link" href="#main_content">Rapport agence </a>
                    </li>
                    <li class="nav-item abnExpire">
                      <a class="nav-link" href="#main_content">Versement </a>
                    </li>
                  </ul>
                </li>
                @endif

                {{-- VENTES --}}
                @if(hasStatAccesto(Auth::id(),4))
                <li class="nav-item">
                    <a class="nav-link dropdown-indicator" href="#e-commerce" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="e-commerce">
                      <div class="d-flex align-items-center"><span class="nav-link-icon"><i class="fas fa-money-bill-wave"></i></span><span class="nav-link-text">Gestion des Ventes</span>
                      </div>
                    </a>
                    <ul class="nav collapse" id="e-commerce" data-parent="#navbarVerticalCollapse">
                      <li class="nav-item  collapsed abnExpire">
                        <a class="nav-link" href="#top">Ventes</a>
                      </li>
                      <li class="nav-item  collapsed abnExpire">
                        <a class="nav-link" href="#top">Facture Proformat</a>
                      </li>
                      <li class="nav-item  collapsed abnExpire" ><a class="nav-link" href="#top">Mes ventes</a>
                      </li>
                      <li class="nav-item  collapsed abnExpire" ><a class="nav-link" href="#top">Mon stock</a>
                      </li>

                    </ul>
                </li>
                @endif


              </ul>
              <div class="navbar-vertical-divider">
                <hr class="navbar-vertical-hr my-2" />
              </div>

              <ul class="navbar-nav flex-column">

                {{-- UTILISATEURS --}}
                @if(hasStatAccesto(Auth::id(),5))
                <li class="nav-item">
                  <a class="nav-link dropdown-indicator" href="#utilities" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="utilities">
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-users"></span></span><span class="nav-link-text">Gestion Utilisateurs</span>
                    </div>
                  </a>
                  <ul class="nav collapse" id="utilities" data-parent="#navbarVerticalCollapse">

                    <li class="nav-item  collapsed abnExpire"><a class="nav-link" href="#top">Ajouter</a>
                    </li>
                    <li class="nav-item  collapsed abnExpire"><a class="nav-link" href="#top">Liste Utilisateur</a>
                    </li>
                  </ul>
                </li>
                @endif
              </ul>
              <div class="navbar-vertical-divider">
                <hr class="navbar-vertical-hr my-2" />
              </div>

              <ul class="navbar-nav flex-column">

                {{-- OPERATEURS --}}
                @if(hasStatAccesto(Auth::id(),6))
                <li class="nav-item">
                  <a class="nav-link dropdown-indicator" href="#operateur" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="operateur">
                    <div class="d-flex align-items-center"><span class="nav-link-icon">
                      <i class="fas fa-user-tie"></i></span><span class="nav-link-text">Opérateur</span>
                    </div>
                  </a>
                  <ul class="nav collapse" id="operateur" data-parent="#navbarVerticalCollapse">

                    <li class="nav-item collapsed abnExpire">
                      <a class="nav-link" href="#main_content">Nouveau </a>
                    </li>

                    <li class="nav-item collapsed abnExpire">
                      <a class="nav-link" href="#main_content">Liste </a>
                    </li>

                    <li class="nav-item collapsed abnExpire">
                      <a class="nav-link" href="#main_content">Type Opération</a>
                    </li>

                  </ul>
                </li>
                @endif

                {{-- FOURNISSEURS --}}
                @if(hasStatAccesto(Auth::id(),7))
                <li class="nav-item">
                  <a class="nav-link dropdown-indicator" href="#fournisseur" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="fournisseur">
                    <div class="d-flex align-items-center"><span class="nav-link-icon">
                      <i class="fas fa-briefcase"></i>
                    </span><span class="nav-link-text">Fournisseur</span>
                    </div>
                  </a>
                  <ul class="nav collapse" id="fournisseur" data-parent="#navbarVerticalCollapse">

                    <li class="nav-item collapsed" id="p_newF"
                      data-toggle="collapse" data-target="#navbarVerticalCollapse" 
                      aria-controls="navbarVerticalCollapse" aria-expanded="false" 
                      aria-label="Toggle Navigation">
                      <a class="nav-link" title="" href="#main_content">   
                        Nouveau
                      </a>
                    </li>
                    <li class="nav-item collapsed" id="p_listF"
                      data-toggle="collapse" data-target="#navbarVerticalCollapse" 
                      aria-controls="navbarVerticalCollapse" aria-expanded="false" 
                      aria-label="Toggle Navigation">
                      <a class="nav-link" title="" href="#main_content">   
                        Liste
                      </a>
                    </li>
                    <li class="nav-item collapsed" id="p_Eche"
                      data-toggle="collapse" 
                      data-target="#navbarVerticalCollapse" 
                      aria-controls="navbarVerticalCollapse" 
                      aria-expanded="false" 
                      aria-label="Toggle Navigation">
                      <a class="nav-link" href="#main_content"> Achat </a>
                    </li>
                  </ul>
                </li>
                @endif
              </ul>
              <div class="navbar-vertical-divider">
                <hr class="navbar-vertical-hr my-2" />
              </div>
              <ul class="navbar-nav flex-column">

                {{-- PROSPECT --}}
                @if(hasStatAccesto(Auth::id(),8))
                <li class="nav-item">
                    <a class="nav-link dropdown-indicator" href="#Prospects" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="Prospects">
                      <div class="d-flex align-items-center"><span class="nav-link-icon">
                        <i class="fas fa-grin-stars"></i> </span><span class="nav-link-text">Prospects</span>
                      </div>
                    </a>
                    <ul class="nav collapse" id="Prospects" data-parent="#navbarVerticalCollapse">

                      <li class="nav-item collapsed abnExpire">
                        <a class="nav-link"  href="#main_content">Nouveau</a>
                      </li>
                      <li class="nav-item collapsed abnExpire">
                        <a class="nav-link"  href="#main_content">Liste</a>
                      </li>
                      <li class="nav-item abnExpire">
                        <a class="nav-link" href="#main_content">Analyse</a>
                      </li>
                      <li class="nav-item abnExpire" 
                      ><a class="nav-link" href="#main_content">Besoins</a>
                      </li>
    

                    </ul>
                </li>
                @endif

                {{-- CAMPAGNE MARKETTING --}}
                @if(hasStatAccesto(Auth::id(),9))
                <li class="nav-item">
                    <a class="nav-link dropdown-indicator" 
                    href="#marketing" data-toggle="collapse" role="button" 
                    aria-expanded="false" aria-controls="fournisseur">
                      <div class="d-flex align-items-center"><span class="nav-link-icon">
                        <i class="fas fa-bullhorn"></i> </span><span class="nav-link-text">Campg. Marketing</span>
                      </div>
                    </a>
                    <ul class="nav collapse" id="marketing" data-parent="#navbarVerticalCollapse">

                      <li class="nav-item collapsed abnExpire">
                        <a class="nav-link"  href="#main_content">Nouveau</a>
                      </li>
                      <li class="nav-item abnExpire">
                        <a class="nav-link" href="#main_content">Historique</a>
                      </li>
                    </ul>
                </li>

                  {{-- SUIVIT DE COMMANDE --}}
                <li class="nav-item"><a class="nav-link dropdown-indicator" 
                  href="#commandes" data-toggle="collapse" role="button" 
                  aria-expanded="false" aria-controls="fournisseur">
                    <div class="d-flex align-items-center"><span class="nav-link-icon">
                      <i class="fas fa-cart-arrow-down"></i> </span><span class="nav-link-text">Mes commandes</span>
                    </div>
                  </a>
                  <ul class="nav collapse" id="commandes" data-parent="#navbarVerticalCollapse">

                    <li class="nav-item collapsed  abnExpire">
                      <a class="nav-link"  href="#main_content">Nouvelle</a>
                    </li>
                    <li class="nav-item collapsed abnExpire">
                      <a class="nav-link" href="#main_content">Livrées</a>
                    </li>
                  </ul>
                </li>
                @endif
              </ul>
            @else

              {{-- MENU SUCCURSAES --}}
              {{-- VERIF SI LE GESTIONNAIRE A UNE SUCC --}}
              @if(userHasSucc(Auth::id()))
                <ul class="navbar-nav flex-column">
                <li class="nav-item">
                  <a class="nav-link dropdown-indicator" href="#Succursale" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="Succursale">
                    <div class="d-flex align-items-center">
                      <span class="nav-link-icon"><i class="fas fa-store-alt"></i></span>
                      <span class="nav-link-text">Succursale</span>
                    </div>
                  </a>
                  <ul class="nav collapse" id="Succursale" data-parent="#navbarVerticalCollapse">
                    <li class="nav-item  collapsed ">
                      <a class="nav-link" href="#top">Ma succursale</a>
                    </li>
                  </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link dropdown-indicator" href="#Prospects" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="Prospects">
                      <div class="d-flex align-items-center"><span class="nav-link-icon">
                        <i class="fas fa-grin-stars"></i> </span><span class="nav-link-text">Prospects</span>
                      </div>
                    </a>
                    <ul class="nav collapse" id="Prospects" data-parent="#navbarVerticalCollapse">

                      <li class="nav-item collapsed"
                        data-toggle="collapse" data-target="#navbarVerticalCollapse" 
                        aria-controls="navbarVerticalCollapse" aria-expanded="false" 
                        aria-label="Toggle Navigation" id="p_prospNew">
                        <a class="nav-link"  href="#main_content">Nouveau</a>
                      </li>
                      <li class="nav-item collapsed"
                        data-toggle="collapse" data-target="#navbarVerticalCollapse" 
                        aria-controls="navbarVerticalCollapse" aria-expanded="false" 
                        aria-label="Toggle Navigation" id="p_prospL">
                        <a class="nav-link"  href="#main_content">Liste</a>
                      </li>

                      <li class="nav-item" 
                        data-toggle="collapse" data-target="#navbarVerticalCollapse" 
                        aria-controls="navbarVerticalCollapse" aria-expanded="false" 
                        aria-label="Toggle Navigation" id="p_prospbesoin" 
                      ><a class="nav-link" href="#main_content">Besoins</a>
                      </li>
    

                    </ul>
                </li>
               </ul>
              @endif
            @endif


               {{-- MENU SUCCURSALES --}}
          {{-- MENU VALABLE POUR PRINCIPLAES ET SUCCURSALES --}}


          {{-- MENU VALABLE POUR PRINCIPLAES ET SUCCURSALES --}}

            </div>
          </div>

