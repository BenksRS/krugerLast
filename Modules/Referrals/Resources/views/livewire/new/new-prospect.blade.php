<div>
    {{--kk--}}
    <form  class="needs-validation " autocomplete="off">
        <div class="row">
            <div class="col-lg-6">
                <h4 class="card-title mb-4">Prospect Info</h4>
                <div class="card">
                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="formrow-firstname-input" class="form-label">Entity Name</label>
                                    <input type="text" class="form-control" id="company_entity" wire:model="company_entity" placeholder="Enter entity name..." autocomplete="nope" >
                                    @error('company_entity')
                                    <div class="invalid-feedback show">
                                        Please enter a valid entity name.
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="formrow-firstname-input" class="form-label">Fictitions Name</label>
                                    <input type="text" class="form-control" id="company_fictitions" wire:model="company_fictitions" placeholder="Enter fictitions name..." autocomplete="nope">
                                    @error('company_fictitions')
                                    <div class="invalid-feedback show">
                                        Please enter a valid Fictitions name.
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
                                        Please enter a valid info in notes
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
                <h4 class="card-title mb-4">Prospect Settings</h4>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Referral Type</label>
                                    <select class="form-control select2  select2-multiple select_referral"
                                            name="referral_typeSelected" wire:model="referral_type_id" data-placeholder="Select ...">

                                        <option selected="selected" value="12">Prospect</option>
                                    </select>
                                </div>
                                @error('referral_typeSelected')
                                <div class="invalid-feedback show">
                                    Please select a report valid option.
                                </div>
                                @enderror
                            </div>


                            <div class="col-lg-12">
                                <div class="mb-3" >
                                    <label class="form-label">Status</label>
                                    <select class=" form-control select2-multiple select_carrier"
                                            name="carrierSelected" wire:model="status" data-placeholder="Select ...">

                                        <option selected="selected" value="LEED">LEED</option>
                                    </select>
                                </div>

                            </div>
                            <div class="row">
                                <div  class="col-lg-12 mt-5">
                                    <button class="btn btn-lg btn-success float-end" wire:click.prevent="addRef('open')"   type="submit"><i class="bx bx-save"></i> OPEN  </button>
                                </div>

                            </div>



                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->
                </div>

            </div>
        </div>



    </form>
</div>
