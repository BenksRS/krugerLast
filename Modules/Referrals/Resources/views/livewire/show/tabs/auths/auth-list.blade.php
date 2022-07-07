<div>
    <div class="row">
        <h4 class="card-title mb-4">Authorizations List </h4>

{{--                @if($carriersList)--}}
        <div class="accordion accordion-flush" id="accordionAuthorizathions" >
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-heading-{{$referral->id}}">
                    <button class="accordion-button fw-medium " type="button"  wire:ignore.self  data-bs-toggle="collapse" data-bs-target="#flush-collapse-{{$referral->id}}" aria-expanded="true" aria-controls="flush-collapse-{{$referral->id}}" wire:click="$emit('changeCarrier','{{$referral->id}}')">
                        {{$referral->full_name}} - Default for all carriers
                    </button>
                </h2>
                <div id="flush-collapse-{{$referral->id}}" wire:ignore.self class="accordion-collapse collapse show"  aria-labelledby="flush-heading-{{$referral->id}}" data-bs-parent="#accordionAuthorizathions">
                    <div class="accordion-body text-muted">
                        <?php
                        $authorizathions = \Illuminate\Support\Facades\DB::select("
    SELECT * from referral_authorization_pivots
join referral_authorizations on (referral_authorization_pivots.referral_authorizathion_id = referral_authorizations.id)
WHERE referral_id = $referral->id and carrier_id = $referral->id");
                        ?>
                            <div wire:loading class="row">
                                <div class="spinner-border text-primary m-auto col-lg-12" role="status">
                                </div>
                            </div>
                            <div class="row" wire:loading.remove>




                        @if(count($authorizathions) > 0)
                            @foreach($authorizathions as $auth)



                                <!-- start auth card -->
                                <div class="col-lg-6">

                                        <div class="card task-boxq" id="boxauth-{{$referral->id}}-{{$auth->id}}">
                                        <div class="card-body">

                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <img class="img-thumbnail" id="authlistimg-{{$referral->id}}-{{$auth->id}}" alt="200x200" width="100" src="{{$auth->b64}}">
                                                </div>

                                                <div class="col-lg-6">

                                                    <h5 class="font-size-15"><a href="javascript: void(0);" class="text-dark" id="task-name">{{$auth->name}}</a></h5>
                                                    <p class="text-muted mb-4">{{$auth->description}}</p>
                                                    <button type="button" class="btn btn-sm btn-outline-info waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".modal_auth-{{$referral->id}}-{{$auth->id}}">View</button>
                                                    <a target="_blank" href="{{ url("/referrals/authorizations/show/$auth->id") }}" class="btn btn-sm btn-primary waves-effect waves-light me-2"> <i class="bx bx-file font-size-16 align-middle "></i> EDIT</a>
                                                    <button type="button" class="btn btn-sm btn-danger waves-effect waves-light" wire:click.prevent="removeAuth({{$auth->id}})"><i class="bx bx-trash"></i></button>

                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="modal fade modal_auth-{{$referral->id}}-{{$auth->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                        @else
                            <div class="col-lg-12">
                            <div class="card task-boxq" id="noauth-{{$referral->id}}">
                                <div class="card-body">
                                    <h5 class="font-size-15 text-center not_found"> No authorizations setup for this carrier..</h5>
                                </div>
                            </div>
                            </div>


                        @endif

</div>
                    </div>
                </div>
            </div>

            @if($carriersList)
                @foreach($carriersList as $carrier)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-heading-{{$carrier->id}}">
                            <button class="accordion-button fw-medium collapsed"  wire:ignore.self type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse-{{$carrier->id}}" aria-expanded="false" aria-controls="flush-collapse-{{$carrier->id}}" wire:click="$emit('changeCarrier','{{$carrier->id}}')">
                                {{$carrier->full_name}}
                            </button>
                        </h2>
                        <div id="flush-collapse-{{$carrier->id}}"  wire:ignore.self class="accordion-collapse collapse" aria-labelledby="flush-heading-{{$carrier->id}}" data-bs-parent="#accordionAuthorizathions">
                            <div class="accordion-body text-muted">

<?php
                                $authorizathions=[];
    $authorizathions = \Illuminate\Support\Facades\DB::select("
SELECT * from referral_authorization_pivots
join referral_authorizations on (referral_authorization_pivots.referral_authorizathion_id = referral_authorizations.id)
WHERE referral_id = $referral->id and carrier_id = $carrier->id");
?>
    <div wire:loading class="row">
        <div class="spinner-border text-primary " role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <div class="row" wire:loading.remove>
                                @if(count($authorizathions) > 0)
                                    @foreach($authorizathions as $auth)

                                        <!-- start auth card -->
                                        <div class="col-lg-6">
                                            <div class="card task-boxq" id="boxauth-{{$carrier->id}}-{{$auth->id}}">
                                                <div class="card-body">

                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <img class="img-thumbnail" id="authlistimg-{{$carrier->id}}-{{$auth->id}}" alt="200x200" width="100" src="{{$auth->b64}}">
                                                        </div>

                                                        <div class="col-lg-6">

                                                            <h5 class="font-size-15"><a href="javascript: void(0);" class="text-dark" id="task-name">{{$auth->name}}</a></h5>
                                                            <p class="text-muted mb-4">{{$auth->description}}</p>
                                                            <button type="button" class="btn btn-sm btn-outline-info waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".modal_auth-{{$carrier->id}}-{{$auth->id}}">View</button>
                                                            <a target="_blank" href="{{ url("/referrals/authorizations/show/$auth->id") }}" class="btn btn-sm btn-primary waves-effect waves-light me-2"> <i class="bx bx-file font-size-16 align-middle "></i> EDIT</a>
                                                            <button type="button" class="btn btn-sm btn-danger waves-effect waves-light" wire:click.prevent="removeAuth({{$auth->id}})"><i class="bx bx-trash"></i></button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="modal fade modal_auth-{{$carrier->id}}-{{$auth->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                                @else
                                    <div class="card task-boxq" id="noauth-{{$carrier->id}}">
                                        <div class="card-body">
                                            <h5 class="font-size-15 text-center not_found"> No authorizations setup for this carrier..</h5>
                                        </div>
                                    </div>
                                @endif

    </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

        </div>








    </div>
</div>
