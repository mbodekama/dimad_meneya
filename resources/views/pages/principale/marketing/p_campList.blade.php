<div class="card mb-3">
  <div class="bg-holder d-none d-lg-block bg-card"
   style="background-image:url(../assets/img/illustrations/corner-4.png);">
  </div>
  <!--/.bg-holder-->

    <div class="card-body">
      <div class="row">
        <div class="col-lg-8">
          <h3 class="mb-0 text-primary"> <i class="fas fa-grin-stars"></i> Campg. Marketing >Historique</h3>
          <p class="mt-2">Ciblez efficacement vos futurs clients par SMS</p>
        </div>
      </div>
    </div>
</div>

<div class="row">
   <div class="card mb-3">
            <div class="card-body">
              <div class="row">
                @foreach ($smsL as $sms)

                <div class="mb-4 col-md-6 col-lg-4">
                  <div class="border rounded h-100 d-flex flex-column justify-content-between pb-3">
                    <div class="overflow-hidden">
                      <div class="position-relative rounded-top overflow-hidden"><a class="d-block" href="#">
                        <img class="img-fluid rounded-top"
                         src="{{$sms->img}}" alt="" /></a>
                        <span class="badge badge-pill badge-success position-absolute r-0 t-0 mt-2 mr-2 z-index-2">Pub</span>
                      </div>
                      <div class="p-3">
                        <h5 class="fs-0"><a class="text-dark" href="#">
                         {{$sms->titre}}</a></h5>
                        <p class="fs--1 mb-3"><a class="text-500" href="#!">
                          {{$sms->descrpt}}</a></p>
                        <h5 class="fs-md-2 text-warning mb-0 d-flex align-items-center mb-3">{{$sms->prix}} {{getMyDevise()}}
                          @if($sms->prixold!=null)
                          <del class="ml-2 fs--1 text-500">{{$sms->prixold}} {{getMyDevise()}}</del>
                          @endif
                        </h5>
                        <p class="fs--1 mb-1">Livraison: <strong>
                          @if($sms->liv!=null)
                          {{$sms->liv}} {{getMyDevise()}}</strong>
                          @else
                           0 {{getMyDevise()}}</strong>
                          @endif
                        </p>

                        <p class="fs--1 mb-1">Messages: <strong>
                          {{$sms->msg}}</strong></p>

                      </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between px-3">
                      <div><b>Publié le {{$sms->datesms}}</b></div>

                      <div>

                        <a class="btn btn-sm btn-falcon-default mr-2 deleteSMS"
                        href="#!" data-toggle="tooltip" data-placement="top" title="Supprimer" id="{{$sms->id}}">
                        <span class="far fa-trash-alt text-danger"></span>
                        </a>

                      </div>

                      <div>
                         <a class="btn btn-sm btn-falcon-default mr-2"
                        href="{{$shareL.$sms->id}}" data-toggle="tooltip" data-placement="top" title="voir" target="_blank">
                        <span class="far fa-eye text-warning"></span>
                        </a>
                      </div>

                    </div>
                  </div>

                </div>
                @endforeach
              </div>
            </div>
            <div class="card-footer bg-light d-flex justify-content-center">
              Historique des campagnes publicitaires
            </div>
          </div>
</div>

<script src="{{ asset('assets/js/theme.js') }}"></script>
<script type="text/javascript">
  $('.deleteSMS').click(function(){
    var idS = $(this).attr('id');
    Swal.fire({
      title: 'SMS Marketing',
      text: "Voulez-vous supprimer cette campagne?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'oui, supprimer!'
    }).then((result) => {
      if (result.isConfirmed) {
        /*Swal.fire(
          'Deleted!',
          'Your file has been deleted.',
          'success'
        );*/
        $.ajax({
         url:"emptySMS",
         method:"get",
         data:{idsms:idS},
         dataType:'html',
         success:function(data){
           Swal.fire('Supprimer avec succès');
           $("#main_content").load("/CampgList");
         },
         error:function(){
           Swal.fire('erreur de connection');
         }
        });
      }
    })



  });

</script>
