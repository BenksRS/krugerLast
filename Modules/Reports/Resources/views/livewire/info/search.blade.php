<div> 
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-5 col-lg-2">
                            <div class="mb-3 mt-2">
                                <label class="form-label">From:</label>

                                <div class="input-group" id="start_time-input-group" wire:ignore >
                                    <x-flatpickr   id="date_from" name="date_from" show-time :time24hr="false" alt-format="m/d/Y h:i K"    />
                                    <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
                                </div>
                                @error('start_date')
                                <div class="invalid-feedback show">
                                    Please select a valid datetime.
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-5 col-lg-2">
                            <div class="mb-3 mt-2">

                                <label class="form-label">To:</label>
                                <div class="input-group" id="end_time-input-group" wire:ignore>
                                    <x-flatpickr   id="date_to" name="date_to" show-time :time24hr="false" alt-format="m/d/Y h:i K"    />
                                    <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
                                </div>
                                @error('end_date')
                                <div class="invalid-feedback show">
                                    Please select a valid datetime.
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">

                            <div class="mt-0">
                                <h5 class="font-size-14 mb-3">Date Filter By:</h5>
                                <div class="form-check-inline">
                                    <input class="form-check-input" type="radio" name="tarp_situation" wire:model="filter_date"
                                           id="filter_date_c" value="created">
                                    <label class="form-check-label" for="filter_date_c">
                                        Jobs Created
                                    </label>
                                </div>
                                <div class="form-check-inline mt-1">
                                    <input class="form-check-input" type="radio" name="tarp_situation" wire:model="filter_date"
                                           id="filter_date_s" value="schedulled" checked>
                                    <label class="form-check-label" for="filter_date_s">
                                        Jobs Scheduled
                                    </label>
                                </div>
                                <div class="form-check-inline mt-1">
                                    <input class="form-check-input" type="radio" name="tarp_situation" wire:model="filter_date"
                                           id="filter_date_b" value="billed">
                                    <label class="form-check-label" for="filter_date_b">
                                        Jobs Billed
                                    </label>
                                </div>
                                <div class="form-check-inline mt-1">
                                    <input class="form-check-input" type="radio" name="tarp_situation" wire:model="filter_date"
                                           id="filter_date_p" value="paid">
                                    <label class="form-check-label" for="filter_date_p">
                                        Jobs Paid
                                    </label>
                                </div>
                                @error('tarp_situation')
                                <div class="invalid-feedback show">
                                    Please select a valid option.
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-2">

                            <div class="mt-0">
                                <h5 class="font-size-14 mb-3">Show By:</h5>
                                <div class="form-check-inline">
                                    <input class="form-check-input" type="radio" name="filter_type" wire:model="filter_type"
                                           id="filter_type_jobs" value="jobs">
                                    <label class="form-check-label" for="filter_date_c">
                                        Jobs
                                    </label>
                                </div>
                                <div class="form-check-inline mt-1">
                                    <input class="form-check-input" type="radio" name="filter_type" wire:model="filter_type"
                                           id="filter_type_ref" value="referral" checked>
                                    <label class="form-check-label" for="filter_type_ref">
                                        Referral
                                    </label>
                                </div>
                                @error('filter_type')
                                <div class="invalid-feedback show">
                                    Please select a valid option.
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-2 ">
                            <button class="btn btn-lg btn-info m-2 " wire:click="$emit('search')"
                                    type="submit"><i class="bx bx-search"></i> Search  </button>
                        </div>

                        <div class="col-md-5 col-lg-5">
                            <div class="mb-3" wire:ignore>
                                <label class="form-label">Referral  </label>
                                <a href="#" wire:click.prevent="clear('referralSelected')"  onClick="clearReferral()" class="float-end">clear</a>
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
                        </div>
                        <div class="col-md-5 col-lg-5">
                            <div class="mb-3" wire:ignore>
                                <label class="form-label">Carrier</label>
                                <a href="#" wire:click="clear('carrierSelected')" onClick="clearCarrier()" class="float-end">clear</a>
                                <select class="select2 form-control select2-multiple select_carrier"
                                        name="reportSelected" data-placeholder="Select ...">
                                    <option selected>chose...</option>
                                    @foreach($allCarriers as $carrier)

                                        @if($carrier)
                                            <option  value="{{$carrier->id}}">{{$carrier->full_name}}</option>
                                        @else
                                            <option  value="{{$carrier->id}}">{{$carrier->full_name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-5 col-lg-2">
                            <div class="mb-3" >
                                <label class="form-label">State</label>
                                <a href="#" wire:click="clear('byState')"  class="float-end">clear</a>
                                <select class=" form-control select2-multiple "
                                        name="byState" wire:model="byState" data-placeholder="Select ...">
                                    <option selected>chose...</option>
{{--                                    @foreach($techs as $tech)--}}
	                                      <option  value="AL">AL</option>
	                                      <option  value="FL">FL</option>
                                        <option  value="LA">LA</option>
	                                      <option  value="MS">MS</option>
                                        <option  value="NC">NC</option>
                                        <option  value="SC">SC</option>
                                        <option  value="TX">TX</option>
                                        <option  value="GA">GA</option>
{{--                                    @endforeach--}}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-5 col-lg-2">
                            <div class="mb-3" >
                                <label class="form-label">Technician</label>
                                <a href="#" wire:click="clear('techSelected')"  class="float-end">clear</a>
                                <select class=" form-control select2-multiple "
                                        name="techSelected" wire:model="techSelected" data-placeholder="Select ...">
                                    <option selected>chose...</option>
                                    @foreach($techs as $tech)
                                            <option  value="{{$tech->id}}">{{$tech->user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @if($user->group_id == 1)
                        <div class="col-md-5 col-lg-2">
                            <div class="mb-3" >
                                <label class="form-label">Marketing</label>
                                <a href="#" wire:click="clear('marketingSelected')"  class="float-end">clear</a>
                                <select class=" form-control select2-multiple "
                                        name="marketingSelected" wire:model="marketingSelected" data-placeholder="Select ...">
                                    <option selected>chose...</option>
                                    @foreach($marketing as $mar)
                                        <option  value="{{$mar->id}}">{{$mar->user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endif
                        <div class="col-md-5 col-lg-2">
                            <div class="mb-3" >
                                <label class="form-label">Events</label>
                                <a href="#" wire:click="clear('eventSelected')"  class="float-end">clear</a>
                                <select class=" form-control select2-multiple "
                                        name="eventSelected" wire:model="eventSelected" data-placeholder="Select ...">
                                    <option selected>chose...</option>
                                    @foreach($events as $event)
                                        <option  value="{{$event->id}}">{{$event->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-5 col-lg-2">
                            <div class="mb-3" >
                                <label class="form-label">Referral Type</label>
                                <a href="#" wire:click="clear('reftypeSelected')"  class="float-end">clear</a>
                                <select class=" form-control select2-multiple "
                                        name="reftypeSelected" wire:model="reftypeSelected" data-placeholder="Select ...">
                                    <option selected>chose...</option>
                                    @foreach($ref_type as $rt)
                                        <option  value="{{$rt->id}}">{{$rt->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-5 col-lg-2">
                            <div class="mb-3" >
                                <label class="form-label">Job Type</label>
                                <a href="#" wire:click="clear('jtSelected')"  class="float-end">clear</a>
                                <select class=" form-control select2-multiple "
                                        name="jtSelected" wire:model="jtSelected" data-placeholder="Select ...">
                                    <option selected>chose...</option>
                                    @foreach($job_types as $jt)
                                        <option  value="{{$jt->id}}">{{$jt->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        @if($user->group_id == 1)
                        <div class="col-md-5 col-lg-2">
                            <div class="mb-3" >
                                <label class="form-label">Commissions</label>
                                <a href="#" wire:click="clear('commissionsSelected')"  class="float-end">clear</a>
                                <select class=" form-control select2-multiple "
                                        name="commissionsSelected" wire:model="commissionsSelected" data-placeholder="Select ...">
                                    <option selected>chose...</option>
                                    @foreach($commissions as $comm)
                                        <option  value="{{$comm->id}}">{{$comm->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endif

                    </div>


{{--@dump($this->filter_date)--}}
{{--@dump($this->date_to)--}}
{{--@dump($techSelected)--}}
{{--@dump($eventSelected)--}}

                </div>
            </div>
        </div>
    </div>




    <div wire:loading class="row">
        <div class="spinner-border text-primary " role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <div wire:loading.remove>
        @if($list)
            @livewire('reports::info.finance',['test' =>$list], key('reports_finance'))

            @switch($filter_type)
                @case('jobs')
                    @livewire('reports::info.jobs',['test' =>$list], key('reports_jobs'))
                @break
                @case('referral')
                    @livewire('reports::info.referrals',['test' =>$list], key('reports_referrals'))
                @break
            @endswitch
        @endif
    </div>
</div>

@push('js')
    <script>
        $(document).ready(function() {
            $('#date_from').on('change.datetimepicker', function (e){
                let data = $(this).val();
                @this.set('date_from', data);
            });
            $('#date_to').on('change.datetimepicker', function (e){
                let data = $(this).val();
                @this.set('date_to', data);
            });
            $('.select2').select2({
                placeholder: "chose..."
            });

            $('.select_referral').on('change', function (e){
                let data = $(this).val();
                @this.set('referralSelected', data);
            });
            $('.select_carrier').on('change', function (e){
                let data = $(this).val();
                @this.set('carrierSelected', data);
            });

        });
        function clearReferral(){
            $('.select_referral').empty().trigger('change');
        }
        function clearCarrier(){
            $('.select_carrier').empty().trigger('change');
        }
    </script>
@endpush