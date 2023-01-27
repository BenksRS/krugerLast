<div>
    <div class="card">
        <div class="card-body">

            <form class="needs-validation  " action="" wire:submit.prevent.lazy="saveLog(Object.fromEntries(new FormData($event.target)))"  novalidate>

                <div class="row">
                    <div class="col-md-6">
                        <div class="col-md-12 mt-2">
                            <label>Service Date:</label>
                            <div class="input-group" id="log_date" wire:ignore>
                                <x-flatpickr   id="log_date" class="flatpickr_date" name="log_date" wire:model="log_date"   value="{{$log_date}}" />
                                <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label  class="form-label mt-2">Miles:  </label>
                        <input type="text" class="form-control "  name="miles"
                               placeholder="Miles..." wire:model="miles" >

                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        @error('miles')
                        <div class="invalid-feedback">
                            Please type Miles.
                        </div>
                        @enderror

                    </div>
                </div>

<hr>
                <div class="row">
                    <div class="col-xl-12 col-sm-12">
                        <label class="form-label">CHANGES</label>
                        <div class="row" wire:ignore>
                            @foreach($carChanges as $option)
                                <div class="col-auto float-start">
                                    <div class="form-check form-checkbox-outline form-check-primary mb-3">
                                        @if($option)
                                            <input class="form-check-input" type="checkbox" id="checkWorker{{$option->id}}" wire:click="syncChanges({{$option->id}})" value="{{$option->id}}" {{ in_array($option->id, $syncChanges) ? 'checked=""' : '' }} >
                                        @else
                                            <input class="form-check-input" type="checkbox" id="checkWorker{{$option->id}}" wire:click="syncChanges({{$option->id}})" value="{{$option->id}}"  >
                                        @endif
                                        <label class="form-check-label" for="checkWorker{{$option->id}}">
                                            {{$option->name}}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <h5>CHECKLIST</h5>
                    <div class="col-xl-2 col-sm-6">
                        <div class="mt-4">
                            <h5 class="font-size-14 mb-4">Oil</h5>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="check_oil"  wire:model="check_oil"
                                       id="oil1" value="bad" >
                                <label class="form-check-label" for="oil1">
                                    Bad
                                </label>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio"  name="check_oil"  wire:model="check_oil"
                                       id="oil2" value="ok" >
                                <label class="form-check-label" for="oil2">
                                    ok
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio"  name="check_oil"  wire:model="check_oil"
                                       id="oil3" value="good" >
                                <label class="form-check-label" for="oil3">
                                    Good
                                </label>
                            </div>
                            @error('check_oil')
                            <div class="invalid-feedback show">
                                Please select a valid option.
                            </div>
                            @enderror

                        </div>

                    </div>
                    <div class="col-xl-2 col-sm-6">
                        <div class="mt-4">
                            <h5 class="font-size-14 mb-4">Oil Filter</h5>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="check_oil_filter"  wire:model="check_oil_filter"
                                       id="check_oil_filter1" value="bad" >
                                <label class="form-check-label" for="check_oil_filter1">
                                    Bad
                                </label>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio"  name="check_oil_filter"  wire:model="check_oil_filter"
                                       id="check_oil_filter2" value="ok" >
                                <label class="form-check-label" for="check_oil_filter2">
                                    ok
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio"  name="check_oil_filter"  wire:model="check_oil_filter"
                                       id="check_oil_filter3" value="good" >
                                <label class="form-check-label" for="check_oil_filter3">
                                    Good
                                </label>
                            </div>
                            @error('check_oil_filter')
                            <div class="invalid-feedback show">
                                Please select a valid option.
                            </div>
                            @enderror

                        </div>

                    </div>
                    <div class="col-xl-2 col-sm-6">
                        <div class="mt-4">
                            <h5 class="font-size-14 mb-4">Fuel Filter</h5>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="check_fuel_filter"  wire:model="check_fuel_filter"
                                       id="fuel1" value="bad" >
                                <label class="form-check-label" for="fuel1">
                                    Bad
                                </label>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio"  name="check_fuel_filter"  wire:model="check_fuel_filter"
                                       id="fuel2" value="ok" >
                                <label class="form-check-label" for="fuel2">
                                    ok
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio"  name="check_fuel_filter"  wire:model="check_fuel_filter"
                                       id="fuel3" value="good" >
                                <label class="form-check-label" for="fuel3">
                                    Good
                                </label>
                            </div>
                            @error('check_oil')
                            <div class="invalid-feedback show">
                                Please select a valid option.
                            </div>
                            @enderror

                        </div>

                    </div>
                    <div class="col-xl-2 col-sm-6">
                        <div class="mt-4">
                            <h5 class="font-size-14 mb-4">Air Filter</h5>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="check_air_filter"  wire:model="check_air_filter"
                                       id="air_filter1" value="bad" >
                                <label class="form-check-label" for="air_filter1">
                                    Bad
                                </label>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio"  name="check_air_filter"  wire:model="check_air_filter"
                                       id="air_filter2" value="ok" >
                                <label class="form-check-label" for="air_filter2">
                                    ok
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio"  name="check_air_filter"  wire:model="check_air_filter"
                                       id="air_filter3" value="good" >
                                <label class="form-check-label" for="air_filter3">
                                    Good
                                </label>
                            </div>
                            @error('check_air_filter')
                            <div class="invalid-feedback show">
                                Please select a valid option.
                            </div>
                            @enderror

                        </div>

                    </div>
                    <div class="col-xl-2 col-sm-6">
                        <div class="mt-4">
                            <h5 class="font-size-14 mb-4">Breaks</h5>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="check_break"  wire:model="check_break"
                                       id="break1" value="bad" >
                                <label class="form-check-label" for="break1">
                                    Bad
                                </label>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio"  name="check_break"  wire:model="check_break"
                                       id="break2" value="ok" >
                                <label class="form-check-label" for="break2">
                                    ok
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio"  name="check_break"  wire:model="check_break"
                                       id="break3" value="good" >
                                <label class="form-check-label" for="break3">
                                    Good
                                </label>
                            </div>
                            @error('check_oil')
                            <div class="invalid-feedback show">
                                Please select a valid option.
                            </div>
                            @enderror

                        </div>

                    </div>




                    <div class="col-xl-2 col-sm-6">
                        <div class="mt-4">
                            <h5 class="font-size-14 mb-4">Windshield</h5>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="check_windshield"  wire:model="check_windshield"
                                       id="windshield1" value="bad" >
                                <label class="form-check-label" for="windshield1">
                                    Bad
                                </label>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio"  name="check_windshield"  wire:model="check_windshield"
                                       id="windshield2" value="ok" >
                                <label class="form-check-label" for="windshield2">
                                    ok
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio"  name="check_windshield"  wire:model="check_windshield"
                                       id="windshield3" value="good" >
                                <label class="form-check-label" for="windshield3">
                                    Good
                                </label>
                            </div>
                            @error('check_oil')
                            <div class="invalid-feedback show">
                                Please select a valid option.
                            </div>
                            @enderror

                        </div>

                    </div>


                    <div class="col-xl-2 col-sm-6">
                        <div class="mt-4">
                            <h5 class="font-size-14 mb-4">Front Tire</h5>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="check_front_tires"  wire:model="check_front_tires"
                                       id="front_tire1" value="bad" >
                                <label class="form-check-label" for="front_tire1">
                                    Bad
                                </label>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio"  name="check_front_tires"  wire:model="check_front_tires"
                                       id="front_tire2" value="ok" >
                                <label class="form-check-label" for="front_tire2">
                                    ok
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio"  name="check_front_tires"  wire:model="check_front_tires"
                                       id="front_tire3" value="good" >
                                <label class="form-check-label" for="front_tire3">
                                    Good
                                </label>
                            </div>
                            @error('check_oil')
                            <div class="invalid-feedback show">
                                Please select a valid option.
                            </div>
                            @enderror

                        </div>

                    </div>


                    <div class="col-xl-2 col-sm-6">
                        <div class="mt-4">
                            <h5 class="font-size-14 mb-4">Rear Tire</h5>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="check_rear_tires"  wire:model="check_rear_tires"
                                       id="rear_tire1" value="bad" >
                                <label class="form-check-label" for="rear_tire1">
                                    Bad
                                </label>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio"  name="check_rear_tires"  wire:model="check_rear_tires"
                                       id="rear_tire2" value="ok" >
                                <label class="form-check-label" for="rear_tire2">
                                    ok
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio"  name="check_rear_tires"  wire:model="check_rear_tires"
                                       id="rear_tire3" value="good" >
                                <label class="form-check-label" for="rear_tire3">
                                    Good
                                </label>
                            </div>
                            @error('check_rear_tires')
                            <div class="invalid-feedback show">
                                Please select a valid option.
                            </div>
                            @enderror

                        </div>

                    </div>

                    <div class="col-xl-2 col-sm-6">
                        <div class="mt-4">
                            <h5 class="font-size-14 mb-4">Tire Pressure</h5>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="check_tire_pressure"  wire:model="check_tire_pressure"
                                       id="tire_pressure1" value="bad" >
                                <label class="form-check-label" for="tire_pressure1">
                                    Bad
                                </label>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio"  name="check_tire_pressure"  wire:model="check_tire_pressure"
                                       id="tire_pressure2" value="ok" >
                                <label class="form-check-label" for="tire_pressure2">
                                    ok
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio"  name="check_tire_pressure"  wire:model="check_tire_pressure"
                                       id="tire_pressure3" value="good" >
                                <label class="form-check-label" for="tire_pressure3">
                                    Good
                                </label>
                            </div>
                            @error('check_tire_pressure')
                            <div class="invalid-feedback show">
                                Please select a valid option.
                            </div>
                            @enderror

                        </div>

                    </div>




                </div>
<hr>
                <div>
                    <div class="d-flex">
                        <textarea class="form-control  me-2" wire:model="text"  rows="5" placeholder="Enter note here..."></textarea>
                    </div>
                    <br>
                </div>


                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div  class="col-lg-12">
                                <button class="btn btn-lg btn-success mt-2 float-end"   type="submit"  {{ (isset($check_oil) && isset($check_oil_filter) && isset($check_fuel_filter) && isset($check_air_filter) && isset($check_break) && isset($check_windshield) && isset($check_front_tires) && isset($check_rear_tires) && isset($check_tire_pressure)) ? '': 'disabled'}}   >SAVE</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


</div>
