<div>
    <div class="card-body">
        @if(!$show)
            <div class="row">
                <div class="card-body">
                    <form action="" wire:submit.prevent="saveReport(Object.fromEntries(new FormData($event.target)))">

                        <div class="row">
                            <div class="col-md-4">
                                    <label>Service Date:</label>
                                    {{--                            <div class="input-group" id="datepicker1">--}}
                                    {{--                                <input type="text" id="service_date" class="form-control" placeholder="mm/dd/yyyy"  name="service_date" wire:model="service_date" data-date-format="mm/dd/yyyy" data-date-container='#datepicker1' data-provide="datepicker" autocomplete="off">--}}
                                    <div class="input-group" id="service_date" wire:ignore>
                                        <x-flatpickr   id="service_date" class="flatpickr_date" name="service_date" wire:model="service_date"   value="{{$service_date}}" />
                                        <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
                                    </div>


                                    {{--                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>--}}
                                    {{--                            </div>--}}
                                    @error('service_date')
                                    <div class="invalid-feedback show">
                                        Please type a valid date.
                                    </div>
                                    @enderror
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-xl-12 col-sm-12">
                                <div class="mb-3">
                                    <label  class="form-label mt-2">Job Info:</label>
                                    <textarea id="textarea" class="form-control" rows="6" wire:model="job_info"  name="job_info"
                                              placeholder="Job info here limit of 225 chars."></textarea>
                                </div>
                            </div>

                            <div class="col-xl-12 col-sm-12">
                                <button type="submit" class="btn  btn-primary w-md pull-right" >Save</button>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
            {{--  // SHOWW VIEW --}}
        @else
            <div class="col-lg-12">
                <h5 class="card-title mt-4">Tree 3rd <button type="button" class="btn btn-info btn-sm float-end" wire:click="$emit('editReport', {{$jobType_id}})"><i class="fas fa-edit"></i> Edit</button></h5>

            </div>
            <div class="row mt-2">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <tbody>
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
                {{--        <script>--}}
                {{--            $(function (){--}}
                {{--                $('.select2').select2();--}}
                {{--                $('.select_job_report').on('change', function (e){--}}
                {{--                    let data = $(this).val();--}}
                {{--                    @this.set('reportSelected', data);--}}
                {{--                    console.log("select_job_report edit : "+data);--}}
                {{--                });--}}

                {{--                $('.selectWorker').on('change', function (e){--}}
                {{--                    let data = $(this).val();--}}
                {{--                    @this.set('workersSelected', data);--}}
                {{--                    console.log("selectWorker edit : "+data);--}}
                {{--                });--}}

                {{--                $('#service_date').on('change.datetimepicker', function (e){--}}

                {{--                    let data = $(this).val();--}}
                {{--                    @this.set('service_date', data);--}}
                {{--                });--}}

                {{--            });--}}

                {{--            document.addEventListener('livewire:load', function (event) {--}}
                {{--                @this.on('select2Update', function () {--}}
                {{--                    setTimeout(function(){--}}
                {{--                        $('.select2').select2();--}}
                {{--                        $('.select_job_report').on('change', function (e){--}}

                {{--                            let data = $(this).val();--}}
                {{--                            @this.set('reportSelected', data);--}}
                {{--                            console.log("select_job_report select2update : "+data);--}}
                {{--                        });--}}
                {{--                        $('.selectWorker').on('change', function (e){--}}
                {{--                            let data = $(this).val();--}}
                {{--                            @this.set('workersSelected', data);--}}
                {{--                            console.log("selectWorker edit : "+data);--}}
                {{--                        });--}}
                {{--                    },700);--}}

                {{--                });--}}
                {{--                @this.on('editReport', function () {--}}


                {{--                    setTimeout(function(){--}}
                {{--                        $('.select2').select2();--}}
                {{--                        $('.select_job_report').on('change', function (e){--}}

                {{--                            let data = $(this).val();--}}
                {{--                            @this.set('reportSelected', data);--}}
                {{--                            console.log("select_job_report select2update : "+data);--}}
                {{--                        });--}}
                {{--                        $('.selectWorker').on('change', function (e){--}}
                {{--                            let data = $(this).val();--}}
                {{--                            @this.set('workersSelected', data);--}}
                {{--                            console.log("selectWorker edit : "+data);--}}
                {{--                        });--}}
                {{--                        $('#service_date').on('change.datetimepicker', function (e){--}}
                {{--                            let data = $(this).val();--}}
                {{--                            @this.set('service_date', data);--}}
                {{--                        });--}}
                {{--                    },700);--}}



                {{--                });--}}

                {{--            });--}}

                </script>
            @endpush
    </div>
</div>
<script>

</script>
