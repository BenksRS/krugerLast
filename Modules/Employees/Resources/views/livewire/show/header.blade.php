<div>
    <div class="row">
        <div class="col-lg-12 col-md-12">

            <div class="card">
                <div class="card-body headerboardinfo">
                    @if($show)
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="d-flex">
                                    <div class="flex-grow-1 align-self-center">
                                        <div class="text-muted">
                                            <h5 class="mb-1 upc"> <small>System:</small> {{$user->name}}</h5>
                                            <h5 class="mb-1 upc"> <small>Full name:</small> {{$user_info->full_name}}</h5>
                                            <p class="mb-0"><small>Group: </small>{{$user->group->name}}   / <small>Phone: </small>{{$user_info->phone}} </p>
                                            <p class="mb-0"><small>D.O.B: </small>{{$user_info->dob_view}}   / <small>Start Date: </small>{{$user_info->start_date_view}} </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-1 align-self-center">
                                <div class="text-lg-center mt-4 mt-lg-0">
                                    <span class="badge {{$user->active == 'Y' ? "bg-active" : 'bg-danger' }}  p-2">{{$user->active == 'Y' ? "Active" : 'Disable' }}</span>
                                </div>
                            </div>
                            <div class="col-lg-5 d-none d-lg-block">
                                <div class="clearfix mt-4 mt-lg-0 ">

                                    @if($url != 'profile')
                                    <a href="#" type="button" class="btn btn-primary waves-effect waves-light me-2  float-end" wire:click.prevent="edit">
                                        <i class="fas fa-cogs font-size-16 align-middle"></i>
                                    </a>
                                    @endif

                                </div>
                            </div>
                        </div>
                    @else
                        <form class="needs-validation  was-validated" action="" wire:submit.prevent.lazy="update(Object.fromEntries(new FormData($event.target)))"  novalidate>
                            <div class="row">

                                <div class="col-lg-11">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3 ">
                                                        <label  class="form-label">System Name</label>
                                                        <input type="text" class="form-control "  name="name"
                                                               placeholder="Name" wire:model="name"  required>

                                                        <div class="valid-feedback">
                                                            Looks good!
                                                        </div>
                                                        @error('name')
                                                        <div class="invalid-feedback">
                                                            Please type a valid option.
                                                        </div>
                                                        @enderror
                                                    </div>

                                                    <div class="mb-3 ">
                                                        <label  class="form-label">Full Name</label>
                                                        <input type="text" class="form-control "  name="full_name"
                                                               placeholder="Name" wire:model="full_name"  required>

                                                        <div class="valid-feedback">
                                                            Looks good!
                                                        </div>
                                                        @error('full_name')
                                                        <div class="invalid-feedback">
                                                            Please type a valid option.
                                                        </div>
                                                        @enderror
                                                    </div>

                                                    <div class="mb-3 ">
                                                        <label  class="form-label">Phone</label>
                                                        <input type="text" class="form-control "  name="phone"
                                                               placeholder="Name" wire:model.debounce.500ms="phone"  required>

                                                        <div class="valid-feedback">
                                                            Looks good!
                                                        </div>
                                                        @error('phone')
                                                        <div class="invalid-feedback">
                                                            Please type a valid option.
                                                        </div>
                                                        @enderror
                                                    </div>


                                                </div>
                                            </div>


                                        </div>

                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-md-12">

                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label  class="form-label">Status</label>
                                                            <select class="form-select"  name="active" wire:model="active"  required>
                                                                <option selected disabled value="">Choose...</option>
                                                                <option {{ ($user->active == 'Y') ? "selected='selected'": "" }}  value="Y">ACTIVE</option>
                                                                <option {{ ($user->active == 'N') ? "selected='selected'": "" }} value="N">BLOCKED</option>
                                                            </select>

                                                            @error('active')
                                                            <div class="invalid-feedback">
                                                                Please select a valid option.
                                                            </div>
                                                            @enderror
                                                            <div class="valid-feedback">
                                                                Looks good!
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 ">
                                                            <label>Date of Birth</label>
                                                            <div class="input-group" id="dob" wire:ignore>
                                                                <x-flatpickr   id="dob" class="flatpickr_date" name="dob" wire:model="dob"   value="{{$dob}}" />
                                                                <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
                                                            </div>
                                                            @error('dob')
                                                            <div class="invalid-feedback show">
                                                                Please type a valid date.
                                                            </div>
                                                            @enderror
                                                        </div>
                                                        <div class="mb-3 ">
                                                            <label>Start Date</label>
                                                            <div class="input-group" id="start_date" wire:ignore>
                                                                <x-flatpickr   id="start_date" class="flatpickr_date" name="dob" wire:model="start_date"   value="{{$start_date}}" />
                                                                <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
                                                            </div>
                                                            @error('start_date')
                                                            <div class="invalid-feedback show">
                                                                Please type a valid date.
                                                            </div>
                                                            @enderror
                                                        </div>

                                                    </div>
                                                </div>
                                                <div>
                                                </div>

                                            </div>


                                        </div>
                                    </div>
                                </div>
                                <div  class="col-lg-1 ">


                                    <button class="btn btn-lg btn-success mt-4 "   type="submit"   >SAVE</button>
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
