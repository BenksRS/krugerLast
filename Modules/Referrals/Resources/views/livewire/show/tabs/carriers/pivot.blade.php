<div>
    <h4 class="card-title  mb-4">Carriers List</h4>

    @if($carriersList->isNotEmpty())
        @foreach($carriersList as $carrier)
            <div class="card" id="boxcarrier{{$carrier->id}}">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <h5>{{$carrier->company_entity}}({{$carrier->company_fictitions}}) {{$carrier->id}}</h5>
                        </div>
                        <div class="col-lg-7">
                            @if($editCarrier == $carrier->id)
                                <div class="row">
                                    <div class="col-lg-auto">
                                        <h5 class="font-size-14 mb-4">AUTHORIZATION NEEDED ?</h5>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" name="auth_needed"  wire:model="auth_needed"
                                                   id="formRadiosAN{{$carrier->id}}" value="No" >
                                            <label class="form-check-label" for="formRadiosAN{{$carrier->id}}">
                                                No
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio"  name="auth_needed"  wire:model="auth_needed"
                                                   id="formRadiosAY{{$carrier->id}}" value="Yes" >
                                            <label class="form-check-label" for="formRadiosAY{{$carrier->id}}">
                                                Yes
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-auto">
                                        <h5 class="font-size-14 mb-4">USE DEFAULT AUTHORIZATIONS ?</h5>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" name="default_auth"  wire:model="default_auth"
                                                   id="formRadiosDN{{$carrier->id}}" value="No" >
                                            <label class="form-check-label" for="formRadiosDN{{$carrier->id}}">
                                                No
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio"  name="default_auth"  wire:model="default_auth"
                                                   id="formRadiosDY{{$carrier->id}}" value="Yes" >
                                            <label class="form-check-label" for="formRadiosDY{{$carrier->id}}">
                                                Yes
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-auto">
                                        <button type="button" class="btn btn-success btn-sm waves-effect waves-light float-end" wire:click="saveconfig({{$carrier->id}})" wire:loading.attr="disabled"><i class="fas fa-save"></i> Save</button>
                                    </div>
                                </div>
                            @else
                                @php
                                    $carrierConfig=\Modules\Referrals\Entities\ReferralCarriersPivot::where('referral_vendor_id', $referral->id)->where('referral_carrier_id', $carrier->id)->first();
                                @endphp
                                <p>
                                    AUTHORIZATION NEEDED: <b>{{$carrierConfig->auth}}</b> /
                                    USE DEFAULT AUTHORIZATIONS: <b> {{$carrierConfig->default}}</b></b>
                                    <button type="button" class="btn btn-primary btn-sm waves-effect waves-light" wire:click="editcarrier({{$carrier->id}})" wire:loading.attr="disabled"><i class="fas fa-exchange-alt"> </i>  Edit</button>
                                </p>

                            @endif
                        </div>
                        <div class="col-lg-auto">
                            @if($carrier->referral_type_id != 13)
                                <button type="button" class="btn btn-danger btn-sm waves-effect waves-light float-end" wire:click="removeCarrier({{$carrier->id}})" wire:loading.attr="disabled"><i class="fas fa-unlink"></i> </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="card">
            <div class="card-body">
                <h5 class="text-center">No carrier Selected ...</h5>
            </div>
        </div>

    @endif



</div>
