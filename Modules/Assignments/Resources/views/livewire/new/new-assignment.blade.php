<div>

    @if($ref && $ref->status == 'BLOCKED')

        <div  class="alert alert-danger" x-init="setTimeout(() => show = false, 3000)">
            <b>{{$ref->full_name}} </b> is <b>BLOCKED</b> on the system!!!! Don't proceed without permission!
        </div>
        <script>
            setTimeout(function() {
                $('.alert-success').fadeOut('fast');
            }, 2000);
        </script>
    @endif




     <form  class="needs-validation " autocomplete="off">
    <div class="row">
        <div class="col-lg-6">
            <h4 class="card-title mb-4">Homeowner Info</h4>
            <div class="card">
                <div class="card-body">

                        <div class="row">
    
                          <div class="col-md-12">
                                <div class="form-check form-check-left mb-3">
                                    <input class="form-check-input check_event" type="checkbox" id="event_id" wire:model="event_id" value="43">
                                    <label class="form-check-label" for="event_id">HURRICANE IDALIA</label>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                        <div class="mb-3">
                            <label for="formrow-firstname-input" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="first_name" wire:model="first_name" placeholder="Enter first name..." autocomplete="nope" >
                            @error('first_name')
                            <div class="invalid-feedback show">
                                Please enter a valid first name.
                            </div>
                            @enderror
                        </div>
                            </div>
                            <div class="col-md-6">
                        <div class="mb-3">
                            <label for="formrow-firstname-input" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="last_name" wire:model="last_name" placeholder="Enter last name..." autocomplete="nope">
                            @error('last_name')
                            <div class="invalid-feedback show">
                                Please enter a valid last name.
                            </div>
                            @enderror
                        </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="formrow-inputCity" class="form-label">Street</label>
                                    <input type="text" class="form-control" id="street" wire:model="street" placeholder="Enter street..." autocomplete="nope">
                                    @error('street')
                                    <div class="invalid-feedback show">
                                        Please enter a valid street.
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="formrow-inputCity" class="form-label">City</label>
                                    <input type="text" class="form-control" id="city" wire:model="city" placeholder="Enter city..." autocomplete="nope">
                                    @error('city')
                                    <div class="invalid-feedback show">
                                        Please enter a valid city.
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="mb-3">
                                    <label for="state" class="form-label">State</label>
                                    <select id="state" class="form-select" wire:model="state">
                                        <option selected>chose...</option>
                                        <option value="AL">AL</option>
                                        <option value="AK">AK</option>
                                        <option value="AZ">AZ</option>
                                        <option value="AR">AR</option>
                                        <option value="AS">AS</option>
                                        <option value="CA">CA</option>
                                        <option value="CO">CO</option>
                                        <option value="CT">CT</option>
                                        <option value="DE">DE</option>
                                        <option value="DC">DC</option>
                                        <option value="FL">FL</option>
                                        <option value="GA">GA</option>
                                        <option value="GU">GU</option>
                                        <option value="HI">HI</option>
                                        <option value="ID">ID</option>
                                        <option value="IL">IL</option>
                                        <option value="IN">IN</option>
                                        <option value="IA">IA</option>
                                        <option value="KS">KS</option>
                                        <option value="KY">KY</option>
                                        <option value="LA">LA</option>
                                        <option value="ME">ME</option>
                                        <option value="MD">MD</option>
                                        <option value="MA">MA</option>
                                        <option value="MI">MI</option>
                                        <option value="MN">MN</option>
                                        <option value="MS">MS</option>
                                        <option value="MO">MO</option>
                                        <option value="MT">MT</option>
                                        <option value="NE">NE</option>
                                        <option value="NV">NV</option>
                                        <option value="NH">NH</option>
                                        <option value="NJ">NJ</option>
                                        <option value="NM">NM</option>
                                        <option value="NY">NY</option>
                                        <option value="NC">NC</option>
                                        <option value="ND">ND</option>
                                        <option value="CM">CM</option>
                                        <option value="OH">OH</option>
                                        <option value="OK">OK</option>
                                        <option value="OR">OR</option>
                                        <option value="PA">PA</option>
                                        <option value="SC">SC</option>
                                        <option value="TN">TN</option>
                                        <option value="TX">TX</option>
                                        <option value="UT">UT</option>
                                        <option value="VT">VT</option>
                                        <option value="VA">VA</option>
                                        <option value="VI">VI</option>
                                        <option value="WA">WA</option>
                                        <option value="WV">WV</option>
                                        <option value="WI">WI</option>
                                        <option value="WY">WY</option>
                                    </select>
                                    @error('state')
                                    <div class="invalid-feedback show">
                                        Please select a valid state.
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-2">
                                <div class="mb-3">
                                    <label for="zipcode" class="form-label" >Zip</label>
                                    <input type="number" class="form-control" id="zipcode" wire:model="zipcode" placeholder="zipcode..." autocomplete="nope">
                                    @error('zipcode')
                                    <div class="invalid-feedback show">
                                        Please enter a valid zipcode.
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="formrow-inputZip" class="form-label">Phone</label>
                                    <input type="text" class="form-control" id="phone" wire:model.debounce.500ms="phone" placeholder="Enter phone..." autocomplete="nope">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="formrow-inputZip" class="form-label">Alternative Phone</label>
                                    <input type="text" class="form-control" id="phone_alternative" wire:model.debounce.500ms="phone_alternative" placeholder="Enter phone..." autocomplete="nope">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="formrow-email-input" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" wire:model="email" placeholder="Enter email..." autocomplete="nope">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="formrow-inputCity" class="form-label">Notes</label>
                                    <textarea class="form-control  me-2" id="notes"  wire:model="notes" rows="5" placeholder="Enter notes info here..."></textarea>
                                    @error('notes')
                                    <div class="invalid-feedback show">
                                        Please enter a valid info in notes.
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="formrow-inputCity" class="form-label">Tech Notes</label>
                                    <textarea class="form-control  me-2" id="notes_tech"  wire:model="notes_tech" rows="5" placeholder="Enter Tech notes info here..."></textarea>
                                    @error('notes_tech')
                                    <div class="invalid-feedback show">
                                        Please enter a valid info in notes.
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->

            <div class="col-lg-4">
                <h4 class="card-title mb-4">Insurance Info</h4>
                <div class="card">
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="mb-3 mt-2">
                                    <label class="form-label">Date</label>

                                    <div class="input-group" id="start_time-input-group" wire:ignore >
                                        <x-flatpickr   id="date_assignment" name="date_assignment" show-time :time24hr="false" alt-format="m/d/Y h:i K"    />
                                        <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
                                    </div>
                                    @error('start_date')
                                    <div class="invalid-feedback show">
                                        Please select a valid datetime.
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3 mt-2">

                                    <label class="form-label">Date of loss</label>
                                    <div class="input-group" id="end_time-input-group" wire:ignore>
                                        <x-flatpickr  class="flatpickr_date"  id="date_of_loss" name="date_of_loss" show-time :time24hr="false" alt-format="m/d/Y h:i K"    />
                                        <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
                                    </div>
                                    @error('end_date')
                                    <div class="invalid-feedback show">
                                        Please select a valid datetime.
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-12">
                            <div class="mb-3" wire:ignore>
                                    <label class="form-label">Referral</label>
                                    <select class="select2 form-control select2-multiple select_referral"
                                             name="reportSelected" data-placeholder="Select ...">
                                        <option selected>chose...</option>
                                        @foreach($allReferrals as $ref)

                                            @if($ref)
                                                <option  value="{{$ref->id}}">{{$ref->full_name}}</option>
                                            @else
                                                <option  value="{{$ref->id}}">{{$ref->full_name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                @error('reportSelected')
                                <div class="invalid-feedback show">
                                    Please select a report valid option.
                                </div>
                                @enderror
                        </div>

                        @if($showCarrierSelect)
                        <div class="col-lg-12">
                            <div class="mb-3" >
                                <label class="form-label">Carrier</label>
                                <select class=" form-control select2-multiple select_carrier"
                                        name="carrierSelected" data-placeholder="Select ...">
                                    <option selected>chose...</option>
                                    @foreach($carrierLists as $carr)

                                        @if($carr)
                                            <option  value="{{$carr->id}}">{{$carr->full_name}}</option>
                                        @else
                                            <option selected>chose...</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        @endif


{{--                        @if($showCarrierInfo)--}}
{{--                        <div class="col-lg-12">--}}
{{--                            <div class="mb-3">--}}
{{--                                <label for="carrier_info" class="form-label">Carrier Info</label>--}}
{{--                                <input type="text" class="form-control" id="carrier_info" wire:model="carrier_info" placeholder="Carrier info..." autocomplete="nope">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        @endif--}}
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="claim_info" class="form-label">Claim #</label>
                                <input type="text" class="form-control" id="claim_info" wire:model="claim_info" placeholder="claim number ..." autocomplete="nope">
                            </div>
                        </div>
{{--                        <div class="col-lg-12">--}}
{{--                            <div class="mb-3">--}}
{{--                                <label for="client_id" class="form-label">Costumer Job Number</label>--}}
{{--                                <input type="text" class="form-control" id="client_id" wire:model="client_id" placeholder="Costumer Job Number ..." autocomplete="nope">--}}

{{--                        </div>                            </div>--}}
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="adjuster_info" class="form-label">Adjuster Info</label>
                                <textarea class="form-control  me-2"  rows="5"  wire:model="adjuster_info" placeholder="Enter adjuster info here..."></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>


        <div class="col-lg-2">
            <h4 class="card-title mb-4">Job Type</h4>
            <div class="card">
                <div class="card-body">



                    <div class="col-lg-12">
                        @foreach($jobTypes as $js)

                                <div class="col-lg-12">
                                    <div class="form-check form-check-left mb-3">

                                            <input class="form-check-input check_types"  type="checkbox" data-type="{{$js->type}}" id="{{$js->name}}{{$js->id}}" wire:click="selectJobtype({{$js->id}})">
                                        <label class="form-check-label" for="{{$js->name}}{{$js->id}}">
                                            {{$js->name}}   </label>

                                    </div>
                                </div>

                        @endforeach

                    </div>
<div class="row">
    <hr>
    <div  class="col-lg-6 mt-5">
        <button class="btn btn-lg btn-primary m-2 " wire:click.prevent="addJob('next')"
         {{(count($this->jbSelected) > 0 && isset($this->referralSelected) &&  isset($this->carrierSelected)) ? ' ': ''}}

                type="submit"><i class="bx bx-save"></i> Next  </button>
    </div>
    <div  class="col-lg-6 mt-5">
        <button class="btn btn-lg btn-success m-2 " wire:click.prevent="addJob('open')"
                {{(count($this->jbSelected) > 0 && isset($this->referralSelected) &&  isset($this->carrierSelected)) ? ' ': ''}}
                type="submit"><i class="bx bx-save"></i> OPEN  </button>
    </div>

</div>


                    </div>

                    {{--                        @dump($jbSelected)--}}
                </div>
                <!-- end card body -->

            </div>
            <!-- end card -->
{{--            @dump(count($errors))--}}
        </div>



     </form>
</div>
@push('js')
    <script>
        $(document).ready(function() {
            $('.select2').select2();
            $('.select_referral').on('change', function (e){
                let data = $(this).val();
                @this.set('referralSelected', data);
            });

            $('#date_assignment').on('change.datetimepicker', function (e){
                let data = $(this).val();
                @this.set('date_create', data);
            });
            $('#date_of_loss').on('change.datetimepicker', function (e){
                let data = $(this).val();
                @this.set('date_dol', data);
            });
        });

        document.addEventListener("livewire:load", function (event) {
            @this.on('clearContent', function () {
                setTimeout(function() {
                    $('.select_referral').on('change', function (e){
                        let data = $(this).val();
                        @this.set('referralSelected', data);
                    });
                    $('#date_of_loss').val(null);
                    $('#date_assignment').val(null);
                },700);
            });
            @this.on('contentChange', function () {
                setTimeout(function() {
                    $('.select2').select2();
                    $('.select_referral').on('change', function (e){
                        let data = $(this).val();
                        @this.set('referralSelected', data);
                    });
                    $('.select_carrier').on('change', function (e){
                        let data = $(this).val();
                        @this.set('carrierSelected', data);
                    });

                },700);

            });
        });
    </script>
@endpush
