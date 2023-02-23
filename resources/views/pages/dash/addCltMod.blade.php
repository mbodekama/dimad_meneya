
      {{-- modal ajout de client --}}
              <div class="modal fade" id="modAddClt" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Nouveau Client</h5>
                      <button class="close cltModClose" type="button" data-dismiss="modal" aria-label="Close"><span class="font-weight-light" aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form  id="formAddClt" >
                          <input type="hidden" id="myIdEch" name="idEch" value="">
                          {{-- Input nécessaire pour le update  --}}
                          <input type="hidden" id="idClt" name="idClt" value="0" >
                          @csrf
                            
                                    <div class="form-row">
                                      <div class="col-7">
                                        <div class="form-group">
                                          <label for="name" class="text-danger">Nom & Prénoms</label>
                                          <input class="form-control" id="name" name="name" type="text" required>
                                        </div>
                                      </div>
                                      <div class="col-5">
                                        <div class="form-group">
                                          <label for="montant" class="text-danger">Contact</label>
                                          <input class="form-control " required id="contact" name="contact" type="number" >
                                        </div>
                                      </div>
                                      <div class="col-7">
                                        <div class="form-group">
                                          <label for="lieu">Lieu </label>
                                          <input class="form-control " id="lieu" name="lieu" type="text"  value="">
                                        </div>
                                      </div>
                                      <div class="col-5">
                                        <div class="form-group">
                                          <label for="date">Date </label>
                                          <input class="form-control datetimepicker" id="date" name="date" type="text" data-options='{"dateFormat":"d/m/Y"}' value="{{ date('d/m/Y') }}">
                                        </div>
                                      </div>

                                    </div>
                      </form>
                    </div>
                    <div class="modal-footer">
                      <button class="btn btn-secondary btn-sm cltModClose" type="button" data-dismiss="modal"  >Fermer</button>
                      <button class="btn btn-primary btn-sm addClt" type="button">Valider</button>
                    </div>
                  </div>
                </div>
              </div>
      {{-- modal ajout de client --}}


<script type="text/javascript">
  $(function()
  {
    $('.cltModClose').click(function()
    {
      $('#idClt').val("0");
      $("#formAddClt").trigger("reset");
    })
  })
</script>