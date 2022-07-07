<div>
    <div class="card-body">

        @if(!$show)
            <div class="row">
                <div class="col-lg-12">
                    <h5 class="card-title mt-4">Tarp Size</h5>

                    <form class="row gy-2 gx-3 align-items-center">
                        <div class="col-sm-auto">
                            <label class="visually-hidden" for="autoSizingInput" >width</label>
                            <div class="input-group">
                                <input type="number" min="0" class="form-control" id="autoSizingInputGroup" wire:model="width" placeholder="width">
                                <div class="input-group-text">ft</div>
                            </div>
                            @error('width')
                            <div class="invalid-feedback show">
                                Please input a number > 0.
                            </div>
                            @enderror
                        </div>
                        x
                        <div class="col-sm-auto">
                            <label class="visually-hidden" for="autoSizingInputGroup">Height</label>
                            <div class="input-group">
                                <input type="number" min="0" class="form-control" id="autoSizingInputGroup" wire:model="height" placeholder="height">
                                <div class="input-group-text">ft</div>
                            </div>
                            @error('height')
                            <div class="invalid-feedback show">
                                Please input a number > 0.
                            </div>
                            @enderror
                        </div>
                        -
                        <div class="col-sm-auto">
                            <label class="visually-hidden" for="autoSizingInputGroup">Quantity</label>
                            <div class="input-group">
                                <input type="number" min="0" class="form-control" id="autoSizingInputGroup" wire:model="qty" placeholder="Qty">
                                <div class="input-group-text">un</div>
                            </div>
                            @error('qty')
                            <div class="invalid-feedback show">
                                Please input a number > 0.
                            </div>
                            @enderror
                        </div>
                        <div class="col-sm-auto">
                            <label class="visually-hidden" for="autoSizingSelect">Preference</label>
                            <select class="form-select" id="autoSizingSelect" wire:model="stock_id">
                                <option selected>Inventory...</option>
                                @foreach($tarpStock as $tarp)
                                    <option value="{{$tarp->id}}">{{$tarp->name}}</option>
                                @endforeach
                            </select>
                            @error('stock_id')
                            <div class="invalid-feedback show">
                                Please select one option...
                            </div>
                            @enderror
                        </div>

                        <div class="col-sm-auto">
                            <button type="submit"  wire:click.prevent="addTarpSize" class="btn btn-primary w-md" >Add Tarp Size</button>
                        </div>
                    </form>
                </div>

                <!-- end col -->
                <div class="row mt-2">
                    <div class="col-lg-12">
                        <hr>
                        <?php $totalsqft=0;?>
                        @if($tsList->isNotEmpty())
                            @foreach($tsList as $ts)
                                <h5 class="text-end"> #{{$ts->width}} ft x {{$ts->height}} ft - {{$ts->qty}}un - {{$ts->sqft}} sqft ( Inventory: {{($ts->stock->name )}} ) <a href="#" wire:click.prevent="deleteTarpsize({{$ts->id}})" class="btn btn-danger btn-sm waves-effect waves-light" ><i class="bx bx-trash"></i></a></h5>
                                <?php $totalsqft=$totalsqft+$ts->sqft;?>
                            @endforeach
                            <h5 class="text-end"> Total Sqft Installed: {{$totalsqft}} sqft</h5>
                        @else
                            <div class="alert alert-danger" role="alert">
                                No Tarp size added!
                            </div>
                        @endif


                        <hr>
                    </div>
                </div>

                <div class="card-body">
                    <form action="" wire:submit.prevent="saveReport(Object.fromEntries(new FormData($event.target)))">
                        <div class="row">
                            <div class="col-xl-6 col-sm-6">
                                <div class="mt-0">
                                    <h5 class="font-size-14 mb-4">Tarp Situation</h5>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" name="tarp_situation" wire:model="tarp_situation"
                                               id="tarpsituation1" value="Y">
                                        <label class="form-check-label" for="tarpsituation1">
                                            New Tarp installation
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="tarp_situation" wire:model="tarp_situation"
                                               id="tarpsituation2" value="N">
                                        <label class="form-check-label" for="tarpsituation2">
                                            Same tarp used
                                        </label>
                                    </div>
                                    @error('tarp_situation')
                                    <div class="invalid-feedback show">
                                        Please select a valid option.
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div>
                            <hr>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="formrow-firstname-input" class="form-label">Sandbags</label>
                                    <input type="number" class="form-control" id="formrow-firstname-input" name="sandbags" wire:model="sandbags">
                                </div>
                                @error('sandbags')
                                <div class="invalid-feedback show">
                                    Please input a number > 0.
                                </div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="formrow-firstname-input" class="form-label">Roof Pitch</label>
                                    <select class="form-select" id="autoSizingSelect" name="pitch" wire:model="pitch"  placeholder="mm/dd/yyyy">
                                        <option selected>Select...</option>
                                        <option value="1/12">1/12</option>
                                        <option value="2/12">2/12</option>
                                        <option value="3/12">3/12</option>
                                        <option value="4/12">4/12</option>
                                        <option value="5/12">5/12</option>
                                        <option value="6/12">6/12</option>
                                        <option value="7/12">7/12</option>
                                        <option value="8/12">8/12</option>
                                        <option value="9/12">9/12</option>
                                        <option value="10/12">10/12</option>
                                        <option value="11/12">11/12</option>
                                        <option value="12/12">12/12</option>
                                        <option value="13/12">13/12</option>
                                        <option value="14/12">14/12</option>
                                        <option value="15/12">15/12</option>
                                        <option value="16/12">16/12</option>
                                        <option value="17/12">17/12</option>
                                        <option value="18/12">18/12</option>
                                        <option value="19/12">19/12</option>
                                        <option value="20/12">20/12</option>
                                        <option value="21/12">21/12</option>
                                        <option value="22/12">22/12</option>
                                        <option value="23/12">23/12</option>
                                        <option value="24/12">24/12</option>

                                    </select>
                                    @error('pitch')
                                    <div class="invalid-feedback show">
                                        Please select one option...
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="col-md-12 mt-2">
                                    <label>Service Date:</label>
                                    {{--                            <div class="input-group" id="datepicker1">--}}
                                    {{--                                <input type="text" id="service_date" class="form-control" placeholder="mm/dd/yyyy"  name="service_date" wire:model="service_date" data-date-format="mm/dd/yyyy" data-date-container='#datepicker1' data-provide="datepicker" autocomplete="off">--}}
                                    <div class="input-group" id="service_date" wire:ignore>
                                        <x-flatpickr   id="service_date" class="flatpickr_date" name="service_date" wire:model="service_date"   value="{{$service_date}}" />
                                        <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
                                    </div>


                                    {{--                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>--}}
                                    {{--                            </div>--}}
                                    @error('sandbags')
                                    <div class="invalid-feedback show">
                                        Please type a valid date.
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <hr>
                        </div>
                        <div class="row">
                            <div class="col-xl-3 col-sm-6">
                                <div class="mt-4">
                                    <h5 class="font-size-14 mb-4">Anchoring Support Network</h5>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" name="anchoring_support"  wire:model="anchoring_support"
                                               id="formRadios1" value="N" >
                                        <label class="form-check-label" for="formRadios1">
                                            No
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio"  name="anchoring_support"  wire:model="anchoring_support"
                                               id="formRadios2" value="Y" >
                                        <label class="form-check-label" for="formRadios2">
                                            Yes
                                        </label>
                                    </div>
                                    @error('height_accomodation')
                                    <div class="invalid-feedback show">
                                        Please select a valid option.
                                    </div>
                                    @enderror

                                </div>

                            </div>

                            <div class="col-xl-3 col-sm-6">
                                <div class="mt-4">

                                    <h5 class="font-size-14 mb-4">Tarp Alterations</h5>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" name="tarp_alterations"  wire:model="tarp_alterations"
                                               id="tarpalteration1" value="N" >
                                        <label class="form-check-label" for="tarpalteration1">
                                            No
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="tarp_alterations"  wire:model="tarp_alterations"
                                               id="tarpalteration2" value="Y">
                                        <label class="form-check-label" for="tarpalteration2">
                                            Yes
                                        </label>
                                    </div>
                                    @error('tarp_alterations')
                                    <div class="invalid-feedback show">
                                        Please select a valid option.
                                    </div>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-xl-3 col-sm-6">
                                <div class="mt-4">
                                    <h5 class="font-size-14 mb-4">Height Accommodation</h5>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" name="height_accomodation"  wire:model="height_accomodation"
                                               id="heightacomodation1" value="N" >
                                        <label class="form-check-label" for="heightacomodation1">
                                            No
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="height_accomodation"  wire:model="height_accomodation"
                                               id="heightacomodation2" value="Y" >
                                        <label class="form-check-label" for="heightacomodation2">
                                            Yes
                                        </label>
                                    </div>
                                    @error('height_accomodation')
                                    <div class="invalid-feedback show">
                                        Please select a valid option.
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">

                            <div class="col-xl-12 col-sm-12">
                                <label class="form-label">Job Report</label>
                                <div class="row" wire:ignore>
                                    @foreach($jobTypeOptions as $jt)
                                        <div class="col-auto float-start">
                                            <div class="form-check form-checkbox-outline form-check-primary mb-3">
                                                @if($reportsDB)
                                                    <input class="form-check-input" type="checkbox" id="checkReport{{$jt->id}}" wire:click="syncReport({{$jt->id}})" value="{{$jt->id}}"   {{($reportsDB->contains($jt->id)) ? 'checked=""' : ''}}">
                                                @else
                                                    <input class="form-check-input" type="checkbox" id="checkReport{{$jt->id}}" wire:click="syncReport({{$jt->id}})"  >
                                                @endif
                                                <label class="form-check-label" for="checkReport{{$jt->id}}">
                                                    {{$jt->name}}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @if(count($reportsDB) == 0)
                                    <div class="invalid-feedback show">
                                        Please select a report valid option.
                                    </div>
                                @endif
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-xl-6 col-sm-6">
                                <label class="form-label">Workers</label>
                                <div class="row" wire:ignore>
                                    @foreach($workers as $wk)
                                        <div class="col-auto float-start">
                                            <div class="form-check form-checkbox-outline form-check-primary mb-3">
                                                @if($workersDB)
                                                    <input class="form-check-input" type="checkbox" id="checkWorker{{$wk->user->id}}" wire:click="syncWorkers({{$wk->user->id}})" value="{{$wk->user->id}}"  {{ $workersDB->contains($wk->user->id) ? 'checked=""' : '' }}">
                                                @else
                                                    <input class="form-check-input" type="checkbox" id="checkWorker{{$wk->user->id}}" wire:click="syncWorkers({{$wk->user->id}})" value="{{$wk->user->id}}"  >
                                                @endif
                                                <label class="form-check-label" for="checkWorker{{$wk->user->id}}">
                                                    {{$wk->user->name}}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                @if(count($workersDB) == 0)
                                    <div class="invalid-feedback show">
                                        Please select a worker valid option.
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-sm-12">
                                <div class="mb-3">
                                    <label  class="form-label mt-2">Job Info:</label>
                                    <textarea id="textarea" class="form-control" rows="6" wire:model="job_info"  name="job_info"
                                              placeholder="Job info here limit of 225 chars."></textarea>
                                </div>
                            </div>

                            <div class="col-xl-12 col-sm-12">
                                <button {{ (count($workersDB) == 0 || count($reportsDB) == 0) ? 'disabled': '' }}  type="submit" class="btn  btn-primary w-md pull-right" >Save</button>
                            </div>
                        </div>


                    </form>
                </div>



            </div>
            {{--  // SHOWW VIEW --}}
        @else
            <div class="col-lg-12">


                <h5 class="card-title mt-4">Tarp Size <button type="button" class="btn btn-info btn-sm float-end" wire:click="$emit('editReport', {{$jobType_id}})"><i class="fas fa-edit"></i> Edit</button></p></h5>

            </div>
            <div class="row mt-2">
                <div class="col-lg-12">
                    <hr>
                    <?php $totalsqft=0;?>
                    @if($tsList->isNotEmpty())
                        @foreach($tsList as $ts)
                            <h5 class="text-end"> #{{$ts->width}} ft x {{$ts->height}} ft - {{$ts->qty}}un - {{$ts->sqft}} sqft ( Inventory: {{($ts->stock->name )}} ) </h5>
                            <?php $totalsqft=$totalsqft+$ts->sqft;?>
                        @endforeach
                        <h5 class="text-end"> Total Sqft Installed: {{$totalsqft}} sqft</h5>
                    @else
                        <div class="alert alert-danger" role="alert">
                            No Tarp size added!
                        </div>
                    @endif
                    <hr>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table  mb-0">
                            <tbody>
                            <tr>
                                <th scope="row">Tarp Situation :</th>
                                <td>{{ ($this->tarp_situation == 'Y') ? 'New Tarp installation' : 'Same tarp used'}}</td>
                                <td colspan="5">
                            </tr>
                            <tr>
                                <th scope="row">Service Date :</th>
                                <td>{{$jobReport->service_date_view}}</td>
                                <th scope="row" >Sandbags :</th>
                                <td colspan="1">{{$jobReport->sandbags}} un</td>
                                <th scope="row" >Roof Pitch :</th>
                                <td colspan="3">{{$jobReport->pitch}} </td>
                            </tr>
                            <tr>
                                <th scope="row">Anchoring Support Network :</th>
                                <td>{{($jobReport->anchoring_support  == 'Y') ? 'Yes' : 'No'}}</td>
                                <th scope="row">Tarp Alterations :</th>
                                <td>{{($jobReport->tarp_alterations  == 'Y') ? 'Yes' : 'No'}}</td>
                                <th scope="row">Height Accommodation :</th>
                                <td>{{($jobReport->height_accomodation  == 'Y') ? 'Yes' : 'No'}}</td>

                            </tr>
                            <tr>
                                <th scope="row">Job Report :</th>
                                <td colspan="5">
                                    <?php   $count=0;?>
                                    @foreach($reportSelected as $report)

                                        <?php   $count++;?>
                                        @if($count == 1)
                                            {{$report->name}}
                                        @else
                                            {{" , $report->name"}}
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Workers :</th>
                                <td colspan="5">
                                    <?php $count=0;?>
                                    @foreach($workersSelected as $work)
                                        <?php $count++;?>
                                        @if($count == 1)
                                            {{$work->name}}
                                        @else
                                            {{" , $work->name"}}
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Job Info :</th>
                                <td colspan="5">
                                    {{$jobReport->job_info}}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        @endif

        @push('js')
            <script>
                {{--$(function (){--}}
                {{--    $('.select2').select2();--}}
                {{--    $('.select_job_report').on('change', function (e){--}}
                {{--        let data = $(this).val();--}}
                {{--        @this.set('reportSelected', data);--}}
                {{--        console.log("select_job_report edit : "+data);--}}
                {{--    });--}}

                {{--    $('.selectWorker').on('change', function (e){--}}
                {{--        let data = $(this).val();--}}
                {{--        @this.set('workersSelected', data);--}}
                {{--        console.log("selectWorker edit : "+data);--}}
                {{--    });--}}

                {{--    $('#service_date').on('change.datetimepicker', function (e){--}}

                {{--        let data = $(this).val();--}}
                {{--        @this.set('service_date', data);--}}
                {{--    });--}}

                {{--});--}}

                {{--document.addEventListener('livewire:load', function (event) {--}}
                {{--    @this.on('select2Update', function () {--}}
                {{--        setTimeout(function(){--}}
                {{--            $('.select2').select2();--}}
                {{--            $('.select_job_report').on('change', function (e){--}}

                {{--                let data = $(this).val();--}}
                {{--                @this.set('reportSelected', data);--}}
                {{--                console.log("select_job_report select2update : "+data);--}}
                {{--            });--}}
                {{--            $('.selectWorker').on('change', function (e){--}}
                {{--                let data = $(this).val();--}}
                {{--                @this.set('workersSelected', data);--}}
                {{--                console.log("selectWorker edit : "+data);--}}
                {{--            });--}}
                {{--        },700);--}}

                {{--    });--}}
                {{--    @this.on('editReport', function () {--}}


                {{--        setTimeout(function(){--}}
                {{--            $('.select2').select2();--}}
                {{--            $('.select_job_report').on('change', function (e){--}}

                {{--                let data = $(this).val();--}}
                {{--                @this.set('reportSelected', data);--}}
                {{--                console.log("select_job_report select2update : "+data);--}}
                {{--            });--}}
                {{--            $('.selectWorker').on('change', function (e){--}}
                {{--                let data = $(this).val();--}}
                {{--                @this.set('workersSelected', data);--}}
                {{--                console.log("selectWorker edit : "+data);--}}
                {{--            });--}}
                {{--            $('#service_date').on('change.datetimepicker', function (e){--}}
                {{--                let data = $(this).val();--}}
                {{--                @this.set('service_date', data);--}}
                {{--            });--}}
                {{--        },700);--}}



                {{--    });--}}

                {{--});--}}

            </script>
        @endpush

    </div>
</div>


