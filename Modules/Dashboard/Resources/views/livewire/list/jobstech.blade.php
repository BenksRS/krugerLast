<div>
    <style>
        nav svg{
            max-height: 20px;
        }
    </style>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">



                        </div>
                        <div class="col-lg-4 float-end " >

                            <div class="d-flex flex-wrap text-center text-sm-start align-items-center p-4">
                                <div class="d-sm-flex flex-wrap gap-2">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-primary btn-rounded" wire:click.prevent="changeDate('prev')">
                                            <i class="calendar-icon ic-arrow-line-left mdi mdi-chevron-left" data-action="move-prev"></i>
                                        </button>
                                        <button type="button" class="btn btn-primary btn-rounded" wire:click.prevent="changeDate('next')">
                                            <i class="calendar-icon ic-arrow-line-right mdi mdi-chevron-right" data-action="move-next"></i>
                                        </button>
                                    </div>
                                </div>
                                <h5 class="m-0 ms-3 fw-bold">{{$dateDisplay}}
                                    <span class="ms-1 text-secondary opacity-50 fw-normal">{{$weekDisplay}}</span>
                                </h5>
                            </div>
                        </div>

                    </div>


@foreach($techs as $tech)
                        <h4 class="m-0 mb-3 fw-bold">{{$tech->user->name}}</h4>



                    <div class="table-responsive mb-0" data-pattern="priority-columns">

                        <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100 listtable">
                            <thead>
                            <tr>

                                @if(in_array('Name', $selectedColumns))
                                    <th>JOB</th>
                                @endif

                                @if(in_array('Job Type', $selectedColumns))
                                    <th>JOB TYPE</th>
                                @endif
                                @if(in_array('Schedule', $selectedColumns))
                                    <th>SCHEDULLED</th>
                                @endif
                                @if(in_array('Status', $selectedColumns))
                                    <th>STATUS</th>
                                @endif
                                @if(in_array('Referral', $selectedColumns))
                                    <th>CITY</th>
                                @endif


                            </tr>

                            </thead>

                            <tbody >
                            <tr wire:loading>
                                <td colspan="100">
                                    <div style="margin-left: 48%">
                                        <div class="spinner-border text-primary col-lg-2 m-auto" >
                                        </div>
                                    </div>

                                </td>
                            </tr>
                            @foreach($list->where('tech',$tech->user->id) as $row)

                                @if(!$row->tags->contains(10))
                                    <tr>

                                        @if(in_array('Street', $selectedColumns))
                                            <td><a href="{{url('assignments/show/'.$row->id)}}">{{$row->last_name}}, {{$row->first_name}} #{{$row->id}}

                                                    @if($row->event)
                                                        <span class="badge alert-danger" >{{$row->event->name}}</span>
                                                    @endif
                                                    @if($row->tags)
                                                        @foreach($row->tags as $tag)
                                                            <span class="badge tagable float-start ">{{$tag->name}}</span>
                                                            {{--                                                <span class="badge alert-info">{{$tag->name}}</span>--}}
                                                        @endforeach
                                                    @endif
                                                </a>


                                            </td>
                                        @endif
                                        @if(in_array('Street', $selectedColumns))
                                                <td><p>
                                                        <?php $count=0;?>
                                                        @foreach($row->job_types as $job)
                                                            <?php $count++;?>
                                                            @if($count == 1)
                                                                {{$job->name}}
                                                            @else
                                                                {{" / $job->name"}}
                                                            @endif
                                                        @endforeach
                                                    </p></td>
                                        @endif
                                        @if(in_array('Street', $selectedColumns))
                                                <td><span class="font-size-14" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Scheduled Date">

                                            @if($row->scheduling)
                                                            <p class="mb-2"> <i class="bx bx-time-five"></i> {{$row->scheduling->start_hour}} to {{$row->scheduling->end_hour}}</p>
                                                        @else
                                                            <p class="mb-2"> {{"Not Scheduled!"}}</p>
                                                    @endif
                                                </td>
                                        @endif

                                            <td><span class="badge {{strtolower($row->status->name)}}">{{$row->status->name}}</span></td>

                                        @if(in_array('Street', $selectedColumns))
                                            <td><p>{{$row->city}}</p></td>
                                        @endif






                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>


                    @endforeach
                    <div class="float-start">
                        Total jobs: {{$list->count()}}
                    </div>
                    <div class="float-end">

                        {{--                        {{$list->links()}}--}}


                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
</div>
