<div>
{{--//--}}

    @if(Auth::user()->id == 2)

    <form  class="needs-validation" novalidate action=""  wire:submit.prevent="addRule(Object.fromEntries(new FormData($event.target)))">
    <div class="row">
        <div class="col-lg-4 col-md-12">


            <h4 class="card-title mb-4">Rule Info</h4>

            <div class="card">
                <div class="card-body">
                    <div class="mb-3" >
                        <label class="form-label">Rule Type</label>
                        <select class=" form-control select2-multiple" wire:model="ruleType"
                                name="type" data-placeholder="Select ...">
                            <option >choose...</option>
{{--                            <option value="T">Technician</option>--}}
                            <option value="A">Technician NO TREE</option>
                            <option value="N">Technician TREE REMOVAL</option>
                            <option value="R">Marketing Referral Full</option>
                            <option value="X">Marketing Referral Full by State</option>
                            <option value="C">Marketing Carrier From Referral</option>
                            <option value="Z">Marketing Carrier From Referral by State</option>
                            <option value="J">Job Type</option>
                            <option value="S">Roof Tarp</option>
                            <option value="P">All Jobs</option>
                        </select>
                    </div>

                    @switch($ruleType)
                        @case('T')
                        <div class="mb-3" >
                            <label class="form-label">Technician</label>
                            <select class=" form-control select2-multiple" wire:model="techSelected"
                                    name="techs_id" data-placeholder="Select ...">
                                <option >choose...</option>
                                @foreach($techs as $row)
                                    <option value="{{$row->id}}">{{$row->user->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @break
                        @case('R')
                        <div>
                            <div class="mb-3" wire:ignore>
                                <label class="form-label">Referral</label>
                                <select class="select2 form-control select2-multiple select_referral"
                                        name="referral_id" data-placeholder="Select ...">
                                    <option selected>chose...</option>
                                    @foreach($allReferrals as $ref)

                                        @if($ref->id == $referralSelected)
                                            <option  selected value="{{$ref->id}}">{{$ref->full_name}}</option>
                                        @else
                                            <option  value="{{$ref->id}}">{{$ref->full_name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @error('reportSelected')
                        <div class="invalid-feedback show">
                            Please select a report valid option.
                        </div>
                </div>
                @enderror
                @break
                @case('C')
                <div>
                    <div class="mb-3" wire:ignore>
                        <label class="form-label">Referral</label>
                        <select class="select2 form-control select2-multiple select_referral"
                                name="referral_id" data-placeholder="Select ...">
                            <option selected>chose...</option>
                            @foreach($allReferrals as $ref)

                                @if($ref->id == $referralSelected)
                                    <option  selected value="{{$ref->id}}">{{$ref->full_name}}</option>
                                @else
                                    <option  value="{{$ref->id}}">{{$ref->full_name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="mb-3" >
                        <label class="form-label">Carrier</label>
                        <select class=" form-control select2-multiple select_carrier"
                                name="carrier_id" data-placeholder="Select ...">
                            <option selected>chose...</option>
                            @foreach($allReferrals->sortBy('company_entity') as $carr)
                                @if($carr)
                                    <option  value="{{$carr->id}}">{{$carr->full_name}}</option>
                                @else
                                    <option selected>chose...</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                </div>




                @error('reportSelected')
                <div class="invalid-feedback show">
                    Please select a report valid option.
                </div>
            </div>
            @enderror
            @break

            @case('Z')
            <div>
                <div class="mb-3" wire:ignore>
                    <label class="form-label">Referral</label>
                    <select class="select2 form-control select2-multiple select_referral"
                            name="referral_id" data-placeholder="Select ...">
                        <option selected>chose...</option>
                        @foreach($allReferrals as $ref)

                            @if($ref->id == $referralSelected)
                                <option  selected value="{{$ref->id}}">{{$ref->full_name}}</option>
                            @else
                                <option  value="{{$ref->id}}">{{$ref->full_name}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="mb-3" >
                    <label class="form-label">Carrier</label>
                    <select class=" form-control select2-multiple select_carrier"
                            name="carrier_id" data-placeholder="Select ...">
                        <option selected>chose...</option>
                        @foreach($allReferrals->sortBy('company_entity') as $carr)
                            @if($carr)
                                <option  value="{{$carr->id}}">{{$carr->full_name}}</option>
                            @else
                                <option selected>chose...</option>
                            @endif
                        @endforeach
                    </select>
                </div>

            </div>
            <div class="col-lg-12">
                <div class="mb-3" >
                    <label class="form-label">State</label>
                    <select class=" form-control select2-multiple select_state"
                            name="byState" wire:model="byState" data-placeholder="Select ...">
                        <option selected>chose...</option>
                        {{--                                    @foreach($techs as $tech)--}}
                        <option  value="AL">AL</option>
                        <option  value="FL">FL</option>
                        <option  value="LA">LA</option>
                        <option  value="GA">GA</option>
                        <option  value="MS">MS</option>
                        <option  value="NC">NC</option>
                        <option  value="SC">SC</option>
                        <option  value="TX">TX</option>
                        <option  value="MO">MO</option>
                        {{--                                    @endforeach--}}
                    </select>
                </div>
            </div>




            @error('reportSelected')
            <div class="invalid-feedback show">
                Please select a report valid option.
            </div>
        </div>
        @enderror
        @break
        @case('X')
        <div>
            <div class="mb-3" wire:ignore>
                <label class="form-label">Referral</label>
                <select class="select2 form-control select2-multiple select_referral"
                        name="referral_id" data-placeholder="Select ...">
                    <option selected>chose...</option>
                    @foreach($allReferrals as $ref)

                        @if($ref->id == $referralSelected)
                            <option  selected value="{{$ref->id}}">{{$ref->full_name}}</option>
                        @else
                            <option  value="{{$ref->id}}">{{$ref->full_name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="mb-3" >
                <label class="form-label">State</label>
                <select class=" form-control select2-multiple select_state"
                        name="byState" wire:model="byState" data-placeholder="Select ...">
                    <option selected>chose...</option>
                    {{--                                    @foreach($techs as $tech)--}}
                    <option  value="AL">AL</option>
                    <option  value="FL">FL</option>
                    <option  value="LA">LA</option>
                    <option  value="MS">MS</option>
                    <option  value="GA">GA</option>
                    <option  value="NC">NC</option>
                    <option  value="SC">SC</option>
                    <option  value="TX">TX</option>
                    <option  value="MO">MO</option>
                    {{--                                    @endforeach--}}
                </select>
            </div>
        </div>




        @error('reportSelected')
        <div class="invalid-feedback show">
            Please select a report valid option.
        </div>
    </div>
        @enderror
        @break
                @case('J')
                <div class="mb-3" >
                    <label class="form-label">Job Type</label>
                    <select class=" form-control select2-multiple" wire:model="jobTypesSelected"
                            name="job_type" data-placeholder="Select ...">
                        <option >choose...</option>
                        @foreach($jobTypes as $jt)
                            <option value="{{$jt->id}}">{{$jt->name}}</option>
                        @endforeach
                    </select>
                </div>
                @break
                @case('S')
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="formrow-firstname-input" class="form-label">Sq Min</label>
                            <input type="number" class="form-control" id="sq_min" name="sq_min" wire:model="sq_min" placeholder="0.00" autocomplete="nope" >
                            @error('sq_min')
                            <div class="invalid-feedback show">
                                Please enter a valid Sq Min
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="formrow-firstname-input" class="form-label">Sq Max</label>
                            <input type="number" class="form-control" id="sq_max" name="sq_max" wire:model="sq_max" placeholder="0.00" autocomplete="nope" >
                            @error('sq_min')
                            <div class="invalid-feedback show">
                                Please enter a valid Sq Max
                            </div>
                            @enderror
                        </div>
                    </div>

                </div>
                @break
                @case('P')
                @break
                @endswitch

            </div>


        </div>


    </div>
    <div class="col-lg-4 col-md-12">
        <h4 class="card-title mb-4">Time Frame</h4>

        <div class="card">
            <div class="card-body">
                <div class="row">

                    <div class="col-md-6">
                        <div class="mb-3 mt-2">
                            <label class="form-label">Date Start</label>

                            <div class="input-group" id="start_time-input-group" wire:ignore >
                                <x-flatpickr  class="flatpickr_date"  id="date_start" name="date_start" show-time :time24hr="false" alt-format="m/d/Y h:i K"    />
                                <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
                            </div>
                            @error('date_start')
                            <div class="invalid-feedback show">
                                Please select a valid datetime.
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3 mt-2">

                            <label class="form-label">Date End</label>
                            <div class="input-group" id="end_time-input-group" wire:ignore>
                                <x-flatpickr  class="flatpickr_date"  id="date_end" name="date_end" show-time :time24hr="false" alt-format="m/d/Y h:i K"    />
                                <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
                            </div>
                            @error('date_end')
                            <div class="invalid-feedback show">
                                Please select a valid datetime.
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="col-lg-4 col-md-12">
        <h4 class="card-title mb-4">Amount info</h4>

        <div class="card">
            <div class="card-body">
                <div class="row">

                    @switch($ruleType)
                        @case('T')
                        @case('A')
                        @case('N')
                        <div class="col-md-6">
                            <label  class="form-label">Percentage</label>
                            <input type="text" class="form-control"  name="percentage"
                                   placeholder="Max 0.05 = 5%" wire:model.debounce.1000ms="percentage"  required>

                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            @error('percentage')
                            <div class="invalid-feedback">
                                Please type a valid option.
                            </div>
                            @enderror
                        </div>
                        <button class="btn btn-lg btn-success m-2 "
                                {{isset($this->percentage) ? ' ': 'disabled'}}

                                type="submit" ><i class="bx bx-save"></i> Save  </button>
                        @break
                        @case('R')
                        @case('Z')
                        @case('X')
                        @case('C')
                        <div class="col-md-6">
                            <label  class="form-label">Amount</label>
                            <input type="text" class="form-control"  name="valor"
                                   placeholder="$0.00" wire:model.debounce.1000ms="valor"  required>

                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            @error('valor')
                            <div class="invalid-feedback">
                                Please type a valid option.
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label  class="form-label">Percentage</label>
                            <input type="text" class="form-control"  name="percentage"
                                   placeholder="Max 0.05 = 5%" wire:model.debounce.1000ms="percentage"  required>

                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            @error('percentage')
                            <div class="invalid-feedback">
                                Please type a valid option.
                            </div>
                            @enderror
                        </div>
                        <button class="btn btn-lg btn-success m-2 "
                                {{(isset($this->percentage) && isset($this->valor)) ? ' ': 'disabled'}}

                                type="submit"><i class="bx bx-save"></i> Save  </button>
                        @break
                        @case('J')
                        <div class="col-md-6">
                            <label  class="form-label">Amount</label>
                            <input type="text" class="form-control"  name="valor"
                                   placeholder="$0.00" wire:model.debounce.1000ms="valor"  required>

                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            @error('valor')
                            <div class="invalid-feedback">
                                Please type a valid option.
                            </div>
                            @enderror
                        </div>
                        <button class="btn btn-lg btn-success m-2 "
                                {{(isset($this->valor)) ? ' ': 'disabled'}}

                                type="submit"><i class="bx bx-save"></i> Save  </button>
                        @break
                        @case('S')
                        <div class="col-md-6">
                            <label  class="form-label">Amount</label>
                            <input type="text" class="form-control"  name="valor"
                                   placeholder="$0.00" wire:model.debounce.1000ms="valor"  required>

                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            @error('valor')
                            <div class="invalid-feedback">
                                Please type a valid option.
                            </div>
                            @enderror
                        </div>
                        <button class="btn btn-lg btn-success m-2 "
                                {{(isset($this->valor)) ? ' ': 'disabled'}}

                                type="submit"><i class="bx bx-save"></i> Save  </button>
                        @break
                        @case('P')
                            <div class="col-md-6">
                                <label  class="form-label">Percentage</label>
                                <input type="text" class="form-control"  name="percentage"
                                       placeholder="Max 0.05 = 5%   " wire:model.debounce.1000ms="percentage"  required>

                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                @error('percentage')
                                <div class="invalid-feedback">
                                    Please type a valid option.
                                </div>
                                @enderror
                            </div>

                        <button class="btn btn-lg btn-success m-2 "
                                {{isset($this->percentage) ? ' ': 'disabled'}}

                                type="submit"><i class="bx bx-save"></i> Save  </button>
                        @break
                    @endswitch




                </div>
            </div>
        </div>


    </div>
    </form>
@else
    <h3 style="color: red;"> You Don`t Have Access !!!</h3>
@endif


</div>




</div>
@push('js')
    <script>
        var taskFlatpickrConfigDate = {
            enableTime: false,
            altInput: true,
            dateFormat: "Y-m-d",
            altFormat: "m\/d\/Y",
        };
        var taskFlatpickrConfigDateTime = {
            enableTime: true,
            altInput: true,
            dateFormat: "Y-m-d H:i",
            altFormat: "m\/d\/Y h:i K",
            time_24hr: false
        };

        function componentsLoadPage(){
            console.log('START components employeesdsdssdds');
            $('.select2').select2();
            $('.dropzone').dropzone();
            $('.flatpickr_date').flatpickr(taskFlatpickrConfigDate);
            $('.flatpickr_datetime').flatpickr(taskFlatpickrConfigDateTime);


            $('.list_jobs_item').hide();
            $('.btn_hide_jobs').hide();

            $('.btn_show_jobs').on('click', function (e){
                let data = $(this).data('id');
                let btn_hide = $(this).data('hide');
                $('.list_jobs_item').hide();
                $('.btn_hide_jobs').hide();
                $('.btn_show_jobs').show();

                $('.list_jobs_'+data).show();
                $('.btn_hide_'+data).show();


                $(this).hide();

            });
            $('.btn_hide_jobs').on('click', function (e){
                $('.list_jobs_item').hide();
                $('.btn_hide_jobs').hide();
                $('.btn_show_jobs').show();

            });


            console.log('END components employeesdsds')

        }
        document.addEventListener("DOMContentLoaded", () => {
            Livewire.hook('message.processed', (message, component) => {componentsLoadPage()})
        });
    </script>

@endpush