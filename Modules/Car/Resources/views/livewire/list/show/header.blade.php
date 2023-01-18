<div>
    <div class="row">
        <div class="col-lg-12 col-md-12">

            <div class="card">
                <div class="card-body headerboardinfo">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="d-flex">
                                <div class="flex-grow-1 align-self-center">

                                    @if($show)
                                        <button type="button" class="btn btn-primary btn-sm float-end" wire:click="$emit('showUpdateinfo')"><i class="fas fa-edit"></i> Edit</button></p>

                                    <div class="text-muted">
                                        <h5 class="mb-1 upc">{{$car->auto}}
                                        </h5>
                                        <p class="mb-0">({{$car->driver}})</p>
                                    </div>
                                    @else
                                        {{--                                        //EDIT --}}
                                          <form class="needs-validation  was-validated" action="" wire:submit.prevent="update(Object.fromEntries(new FormData($event.target)))"  novalidate>
                                            <div class="row">

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

                                                    <button class="btn btn-lg btn-success m-2"   type="submit"   >SAVE</button>
                                                </div>


                                            </div>
                                        </form>
                                        <!-- end row -->

                                    @endif


                                </div>
                            </div>
                        </div>

                </div>
            </div>
        </div>
    </div>
</div>
</div>
