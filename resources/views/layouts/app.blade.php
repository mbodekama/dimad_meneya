@include('layouts.partials.header')


@include('layouts.partials.navbar')

    <!-- ===============================================-->
    <!--   DEBUT DU CONTAINER A RECHARGER -->
    <!-- ===============================================-->

			{{-- VUE INCLUS POUR PRINCIPALE --}}
			<div id="main_content">
			         @include('pages.dash.index')
			</div>



    <!-- ===============================================-->
    <!--   FIN DU CONTAINER A RECHARGER -->
    <!-- ===============================================-->

@include('layouts.partials.footer')
<script type="text/javascript">
  $(function()
  {

    //Bouton de renouvellement abonnement
    $('.updForfait').click(function()
    {
        loadingScreen();


        $('#main_content').load('updForfait'); 
    })

    //Supression paginate
    $(".bestVnt").parent().next().hide();
  })



</script>

{{-- CODE JS POUR L'ANIMATION DES GRAPHES DE LA PRINCIPAL --}}
@include('layouts/js/graphe_P')
