<div>
    <div class="card-body">

        @if(!$show)
            <div class="row">

                <div class="card-body">
                    <form action="" wire:submit.prevent="saveReport(Object.fromEntries(new FormData($event.target)))">
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
                            <div class="col-md-3">
                                <div class="mb-3 mt-4">
                                    <label for="formrow-firstname-input" class="form-label">Plywoods</label>
                                    <input type="number" class="form-control" id="formrow-firstname-input" name="sandbags" wire:model="plywoods">
                                </div>
                                @error('plywoods')
                                <div class="invalid-feedback show">
                                    Please input a number > 0.
                                </div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3 mt-4">
                                    <label for="formrow-firstname-input" class="form-label">2 in. x 4 in. x 8 ft.</label>
                                    <input type="number" class="form-control" id="formrow-firstname-input" name="s2x4x8" wire:model="s2x4x8">
                                </div>
                                @error('s2x4x8')
                                <div class="invalid-feedback show">
                                    Please input a number > 0.
                                </div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3 mt-4">
                                    <label for="formrow-firstname-input" class="form-label">2 in. x 4 in. x 12 ft.</label>
                                    <input type="number" class="form-control" id="formrow-firstname-input" name="s2x4x12" wire:model="s2x4x12">
                                </div>
                                @error('s2x4x12')
                                <div class="invalid-feedback show">
                                    Please input a number > 0.
                                </div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3 mt-4">
                                    <label for="formrow-firstname-input" class="form-label">2 in. x 4 in. x 16 ft.</label>
                                    <input type="number" class="form-control" id="formrow-firstname-input" name="s2x4x16" wire:model="s2x4x16">
                                </div>
                                @error('s2x4x16')
                                <div class="invalid-feedback show">
                                    Please input a number > 0.
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <hr>
                        </div>

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
                            <hr>
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
                                <button {{ (count($workersDB) == 0) ? 'disabled': '' }}  type="submit" class="btn  btn-primary w-md pull-right" >Save</button>
                            </div>
                        </div>


                    </form>
                </div>

            </div>
            {{--  // SHOWW VIEW --}}
        @else
            <h5 class="card-title mt-4">Info <button type="button" class="btn btn-info btn-sm float-end" wire:click="$emit('editReport', {{$jobType_id}})"><i class="fas fa-edit"></i> Edit</button></p></h5>

            <div class="row mt-2">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table  mb-0">
                            <tbody>

                            <tr>
                                <th scope="row">Service Date :</th>
                                <td>{{$jobReport->service_date_view}}</td>
                            </tr>
                            <tr>
                                <th scope="row" >Plywoods :</th>
                                <td colspan="5">{{$jobReport->plywoods}} un</td>
                            </tr>
                            <tr>
                                <th scope="row" >2 in. x 4 in. x 8 ft. :</th>
                                <td colspan="1">{{$jobReport->s2x4x8}} un</td>
                            </tr>
                            <tr>
                                <th scope="row" >2 in. x 4 in. x 12 ft. :</th>
                                <td colspan="1">{{$jobReport->s2x4x12}} un</td>
                            </tr>
                            <tr>
                                <th scope="row" >2 in. x 4 in. x 16 ft. :</th>
                                <td colspan="1">{{$jobReport->s2x4x16}} un</td>
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
{{--            <script>--}}
{{--                $(function (){--}}
{{--                    $('.select2').select2();--}}
{{--                    $('.select_job_report').on('change', function (e){--}}
{{--                        let data = $(this).val();--}}
{{--                        @this.set('reportSelected', data);--}}
{{--                        console.log("select_job_report edit : "+data);--}}
{{--                    });--}}

{{--                    $('.selectWorker').on('change', function (e){--}}
{{--                        let data = $(this).val();--}}
{{--                        @this.set('workersSelected', data);--}}
{{--                        console.log("selectWorker edit : "+data);--}}
{{--                    });--}}

{{--                    $('#service_date').on('change.datetimepicker', function (e){--}}

{{--                        let data = $(this).val();--}}
{{--                        @this.set('service_date', data);--}}
{{--                    });--}}

{{--                });--}}

{{--                document.addEventListener('livewire:load', function (event) {--}}
{{--                    @this.on('select2Update', function () {--}}
{{--                        setTimeout(function(){--}}
{{--                            $('.select2').select2();--}}
{{--                            $('.select_job_report').on('change', function (e){--}}

{{--                                let data = $(this).val();--}}
{{--                                @this.set('reportSelected', data);--}}
{{--                                console.log("select_job_report select2update : "+data);--}}
{{--                            });--}}
{{--                            $('.selectWorker').on('change', function (e){--}}
{{--                                let data = $(this).val();--}}
{{--                                @this.set('workersSelected', data);--}}
{{--                                console.log("selectWorker edit : "+data);--}}
{{--                            });--}}
{{--                        },700);--}}

{{--                    });--}}
{{--                    @this.on('editReport', function () {--}}


{{--                        setTimeout(function(){--}}
{{--                            $('.select2').select2();--}}
{{--                            $('.select_job_report').on('change', function (e){--}}

{{--                                let data = $(this).val();--}}
{{--                                @this.set('reportSelected', data);--}}
{{--                                console.log("select_job_report select2update : "+data);--}}
{{--                            });--}}
{{--                            $('.selectWorker').on('change', function (e){--}}
{{--                                let data = $(this).val();--}}
{{--                                @this.set('workersSelected', data);--}}
{{--                                console.log("selectWorker edit : "+data);--}}
{{--                            });--}}
{{--                            $('#service_date').on('change.datetimepicker', function (e){--}}
{{--                                let data = $(this).val();--}}
{{--                                @this.set('service_date', data);--}}
{{--                            });--}}
{{--                        },700);--}}



{{--                    });--}}

{{--                });--}}

{{--            </script>--}}
        @endpush

    </div>
</div>

