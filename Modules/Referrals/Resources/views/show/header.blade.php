@if($toaster == true)
    @toastr_render
    @endif
@if( $control == 'EDIT')

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body headerboardinfo">
                    <form class="needs-validation" id="referral_header"  enctype="multipart/form-data"   href="{{ route('referrals.bloco_update') }}"  data-id="{{$referral->id}}" data-action="UPDATE"  data-view="referrals::show.header"  data-target=".bloco_header" novalidate>
                    <div class="row">

                        <div class="col-lg-11">
                                <div class="row">
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label  class="form-label">Entity Name</label>
                                                <input type="text" class="form-control"  name="company_entity"
                                                       placeholder="Entity Name" value="{{$referral->company_entity}}" required>

                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label  class="form-label">Fictitions Name</label>
                                                <input type="text" class="form-control" name="company_fictitions"
                                                       placeholder="Fictitions Name" value="{{$referral->company_fictitions}}" required>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label  class="form-label">Referal type</label>
                                                <select class="form-select"  required>
                                                    <option selected disabled value="">Choose...</option>


                                                    @foreach($types as $option)
                                                        <option value="{{$option->id}}">{{$option->name}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    <div class="invalid-feedback">
                                                        Please select a valid option.
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label  class="form-label">Status</label>
                                                    <select class="form-select"  required>
                                                        <option selected disabled value="">Choose...</option>
                                                        <option>...</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Please select a valid option.
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


                                <button class="btn btn-lg btn-success mt-4 " type="submit"   >SAVE</button>
                        </div>


                    </div>
                    </form>
                    <!-- end row -->
                </div>
            </div>
        </div>
    </div>

@else

<div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body headerboardinfo">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="d-flex">
                                <div class="flex-grow-1 align-self-center">
                                    <div class="text-muted">
                                        <h5 class="mb-1 upc">{{"$referral->company_entity ($referral->company_fictitions) #$referral->id"}} NAO EDIT
                                        </h5>
                                        <p class="mb-0">{{$referral->type->name}}</p>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-1 align-self-center">
                            <div class="text-lg-center mt-4 mt-lg-0">
                                <span class="badge bg-success p-2">active</span>
                            </div>
                        </div>
                        <div class="col-lg-5 d-none d-lg-block">
                            <div class="clearfix mt-4 mt-lg-0 ">


                                <a href="{{ route('referrals.bloco_update') }}" type="button" class="btn btn-primary waves-effect waves-light me-2  float-end ajax-action" data-id="{{$referral->id}}" data-action="EDIT"  data-view="referrals::show.header"  data-method="POST"  data-target=".bloco_header">
                                    <i class="fas fa-cogs font-size-16 align-middle"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                </div>
            </div>
        </div>
    </div>
@endif
