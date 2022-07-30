
    <div class="row">
        <div class="col-lg-12">

            {{--kk--}}

            <div class="card">
                <div class="card-body headerboardinfo">

                    @if($show)

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="d-flex">
                                <div class="flex-grow-1 align-self-center">
                                    <div class="text-muted">
                                        <h5 class="mb-1 upc">{{"$referral->company_entity ($referral->company_fictitions) #$referral->id"}}
                                        </h5>
                                        <p class="mb-0">{{$referral->type->name}}</p>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-1 align-self-center">
                            <div class="text-lg-center mt-4 mt-lg-0">
                                <span class="badge {{$status_class}}  p-2">{{$referral->status}}</span>
                            </div>
                        </div>
                        <div class="col-lg-5 d-none d-lg-block">
                            <div class="clearfix mt-4 mt-lg-0 ">


                                <a href="#" type="button" class="btn btn-primary waves-effect waves-light me-2  float-end" wire:click.prevent="edit">
                                    <i class="fas fa-cogs font-size-16 align-middle"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->

                    @else

                    <form class="needs-validation  was-validated" action="" wire:submit.prevent.lazy="update(Object.fromEntries(new FormData($event.target)))"  novalidate>
                        <div class="row">

                            <div class="col-lg-11">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3 ">
                                                    <label  class="form-label">Entity Name</label>
                                                    <input type="text" class="form-control "  name="company_entity"
                                                           placeholder="Entity Name" wire:model="company_entity"  required>

                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                    @error('company_entity')
                                                    <div class="invalid-feedback">
                                                        Please type a valid option.
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label  class="form-label">Fictitions Name</label>
                                                    <input type="text" class="form-control" name="company_fictitions"
                                                           placeholder="Fictitions Name" wire:model="company_fictitions" required>
                                                    @error('company_fictitions')
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

                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label  class="form-label">Referal type</label>
                                                    <select class="form-select" name="referral_type_id"  wire:model="referral_type_id" required>
                                                        <option selected disabled value="">Choose...</option>


                                                        @foreach($types as $option)
                                                            <option {{ ($option->id == $referral->referral_type_id) ? "selected='selected'": "" }} value="{{$option->id}}">{{$option->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('referral_type_id')
                                                    <div class="invalid-feedback">
                                                        Please select a valid option.
                                                    </div>
                                                    @enderror
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label  class="form-label">Status</label>
                                                        <select class="form-select"  name="status" wire:model="status"  required>
                                                            <option selected disabled value="">Choose...</option>
                                                            <option {{ ($referral->status == 'ACTIVE') ? "selected='selected'": "" }}  value="ACTIVE">ACTIVE</option>
                                                            <option {{ ($referral->status == 'BLOCKED') ? "selected='selected'": "" }} value="BLOCKED">BLOCKED</option>
                                                            <option {{ ($referral->status == 'LEED') ? "selected='selected'": "" }} value="LEED">LEED</option>
                                                        </select>

                                                        @error('status')
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



