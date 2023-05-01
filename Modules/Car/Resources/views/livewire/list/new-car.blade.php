<div>
    @if($show)
        <button type="button" class="btn btn-sm btn-primary  waves-effect waves-light  me-2 mb-2" wire:click.prevent="change"> <i class="bx bx-plus font-size-16 align-middle "></i> NEW</button>
    @else
        <div class="row">
            <form class="needs-validation  was-validated" action="" wire:submit.prevent="newAuto(Object.fromEntries(new FormData($event.target)))"  novalidate>
                <div class="row">
                    <div class="card">
                        <div class="card-body">

                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3 ">
                                                    <label  class="form-label">Car name</label>
                                                    <input type="text" class="form-control "  name="auto"
                                                           placeholder="Car name" wire:model="auto"  required>

                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                    @error('auto')
                                                    <div class="invalid-feedback">
                                                        Please type a valid option.
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label  class="form-label">Driver</label>
                                                    <input type="text" class="form-control" name="driver"
                                                           placeholder="Driver" wire:model="driver" required>
                                                    @error('driver')
                                                    <div class="invalid-feedback">
                                                        Please select a valid option.
                                                    </div>
                                                    @enderror
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div  class="col-md-10">


                            </div>

                            <div  class="col-md-2">
                                <button class="btn btn-lg btn-success"   type="submit">CONTINUE</button>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    @endif

</div>
