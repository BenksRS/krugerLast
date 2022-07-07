<h4 class="card-title mb-4">Authorizations List </h4>



@if($referral->authorizathions->isNotEmpty())
        <div class="row">
        @foreach($referral->authorizathions as $auth)
            <!-- start auth card -->
                <div class="col-lg-6">
                    <div class="card task-boxq" id="uptask-1">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-lg-4">
                                    <img class="img-thumbnail" id="uptask-1" alt="200x200" width="100" src="{{$auth->b64}}" data-holder-rendered="true">
                                </div>

                                <div class="col-lg-6">
                                    <h5 class="font-size-15"><a href="javascript: void(0);" class="text-dark" id="task-name">{{$auth->name}} dd {{$auth->id}}</a></h5>
                                    <p class="text-muted mb-4">{{$auth->description}}</p>
                                    <button type="button" class="btn btn-outline-info waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".modal_auth{{$auth->id}}">View</button>
                                    <button type="button" class="btn btn-info waves-effect waves-light">Edit</button>
                                    <a href="{{ route('referrals.ref_auth_sync') }}" type="button" class="btn btn-danger waves-effect waves-light ajax-action" data-id="{{$auth->id}}" data-referral_id="{{$referral->id}}"  data-method="POST" data-action="remove" data-target=".auth_list">Delete</a>




                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="modal fade modal_auth{{$auth->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="myLargeModalLabel">{{$auth->name}}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <img src="{{$auth->b64}}" class="img-fluid" alt="{{$auth->description}}">
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->


                </div>
                <!-- end auth card -->
            @endforeach
        </div>
@else



                    <div class="card task-boxq" id="uptask-1">
                        <div class="card-body">

                                    <h5 class="font-size-15 text-center not_found"> No authorizations setup for this referral..</h5>

                        </div>
                    </div>


@endif

