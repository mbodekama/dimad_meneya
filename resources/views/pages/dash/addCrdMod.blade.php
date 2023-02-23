             {{-- modal ajout de CREDIT --}}

                    <button class="btn btn-falcon-default btn-sm newOpera" type="button" id="AddClt" data-toggle="modal" data-target="#modAddCrd">
                      <span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span>
                      <span class=" d-sm-inline-block ml-1" >
                        Nouveau crédit
                      </span>
                    </button>
                    
                      <div class="modal fade" id="modAddCrd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Ajout créance</h5>
                              <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span class="font-weight-light" aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <form  id="formAddCrd" >
                                  
                                  @csrf
                                              <div class="form-group">
                                                <select class="selectpicker"  id="nomCltCrd" name="client_id">
                                                  <option value="">--Client--</option>               
                                                  @if(!$Clt->isEmpty())
                                                    @foreach( $Clt as $clt)
                                                    <option class="text-900" value="{{ $clt->clientId}}" >
                                                      {{ $clt->nom}}
                                                    </option>
                                                    @endforeach
                                                  @endif  
                                                </select>
                                              
                                              <div class="col-12">
                                                <div class="form-group">
                                                  <label for="montant">Montant</label>
                                                  <input class="form-control " required id="montantCrd" name="montantCrd" type="number" placeholder="Montant (Fcfa)" >
                                                </div>
                                              </div>
                                              <div class="form-row">
                                                <div class="col-6">
                                                  <div class="form-group">
                                                    <label for="date">Date d'enregistrement</label>
                                                    <input class="form-control datetimepicker" id="dateCrd" name="dateCrd" type="text" data-options='{"dateFormat":"d/m/Y"}' value="{{ date('d/m/Y') }}">
                                                  </div>
                                                </div>
                                                <div class="col-6">
                                                  <div class="form-group">
                                                    <label class="text-danger" for="date">Date Echeance</label>
                                                    <input class="form-control datetimepicker" id="dateEch" name="dateEch" type="text" data-options='{"dateFormat":"d/m/Y"}' value="">
                                                  </div>
                                                </div>
                                              </div>
                                              </div>
                              </form>
                            </div>
                            <div class="modal-footer">
                              <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal" id="addCrdClose" >Fermer</button>
                              <button class="btn btn-primary btn-sm addCrd" type="button">Valider</button>
                            </div>
                          </div>
                        </div>
                      </div>
              {{-- modal ajout de client --}}