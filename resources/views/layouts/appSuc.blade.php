@include('layouts.partials.header')


@include('layouts.partials.navbar')

    <!-- ===============================================-->
    <!--   DEBUT DU CONTAINER A RECHARGER -->
    <!-- ===============================================-->

			{{-- VUE INCLUS POUR SUCCURSALE --}}
			<div id="main_content">
			         @include('pages.dash.indexSuc')
			</div>


    <!-- ===============================================-->
    <!--   FIN DU CONTAINER A RECHARGER -->
    <!-- ===============================================-->

@include('layouts.partials.footer')
