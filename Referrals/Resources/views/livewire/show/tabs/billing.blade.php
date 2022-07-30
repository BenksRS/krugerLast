<div>
    @if($showBilling)
        <button type="button" wire:click="edit" class="btn btn-sm btn-primary  waves-effect waves-light  me-2 float-end"> <i class="bx bx-file font-size-16 align-middle "></i> EDIT</button>
    @endif
        <h4 class="card-title mb-4">Billinf Info</h4>
    <div class="card">
        <div class="card-body">
            {{--kk--}}
            @if($showBilling)
                <div class="row">
                    <div class="col-lg-6">
                        <div class="table-responsive">

                            <table class="table table-nowrap mb-0">
                                <tbody>
                                <tr>
                                    <th scope="row">Days from billing :</th>
                                    <td class="font-size-11"> {{$days_from_billing}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Days from Schedulling :</th>
                                    <td>
                                        {{$days_from_scheduling}}
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Days from scheduling to Lien :</th>
                                    <td>
                                        {{$days_from_scheduling_lien}}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <h6>Billing Instructions</h6>
                        <p class="text-muted"><small>{{$description}} </small></p>
                    </div>
                </div>
            @else
            <div class="row">
                <div class="col-lg-6">
                    <div class="row">
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="formrow-firstname-input" class="form-label">Days from billing</label>
                            <input type="number" class="form-control" wire:model="days_from_billing" name="days_from_billing" value="{{$days_from_billing}}" >
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="formrow-firstname-input" class="form-label">Days from Schedulling</label>
                            <input type="number" class="form-control" wire:model="days_from_scheduling" name="days_from_scheduling" value="{{$days_from_scheduling}}" >
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="formrow-firstname-input" class="form-label">Days from scheduling to Lien</label>
                            <input type="number" class="form-control" wire:model="days_from_scheduling_lien" name="days_from_scheduling_lien" value="{{$days_from_scheduling_lien}}" >
                        </div>
                    </div>


                </div>
                </div>

                <div class="col-lg-5">
                    <label for="formrow-firstname-input" class="form-label">Billing Instructions</label>
                    <textarea class="form-control  me-2" wire:model="description"  rows="5" placeholder="Enter note here..."></textarea>

                </div>
                <div class="col-lg-auto">
                    <button type="button" {{(empty($this->description) || empty($this->days_from_billing) || empty($this->days_from_scheduling) || empty($this->days_from_scheduling_lien) ) ?'disabled' : '' }} class="btn btn-success waves-effect waves-light  float-end" wire:click.prevent="addNewNote"><i class="bx bx-save font-size-16 align-middle me-2"></i> SAVE</button>
                </div>
            </div>

        @endif
        </div>
    </div>
</div>
