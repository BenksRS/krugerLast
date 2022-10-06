<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="d-flex">
                                <div class="flex-grow-1 align-self-center">

                                    @if($show)
                                        <button type="button" class="btn btn-primary btn-sm float-end" wire:click="$emit('showUpdateinfo')"><i class="fas fa-edit"></i> Edit</button></p>
                                        <div class="text-muted">
                                            <p class="mb-0">
                                                <?php $count=0;?>
                                                @foreach($assignment->job_types as $job_types)
                                                    <?php $count++;?>
                                                    @if($count == 1)
                                                        {{$job_types->name}}
                                                    @else
                                                        {{" / $job_types->name"}}
                                                    @endif
                                                @endforeach

                                            </p>
                                            <h5 class="mb-1">{{$assignment->full_name}}
                                                <span class="badge {{strtolower($assignment->status->name)}}">{{$assignment->status->name}}</span>

                                                <button type="button" class="btn btn-info btn-sm waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".history_modal"><i class="bx bx-history" ></i></button>
                                            </h5>

                                            <!--  Modal Tags -->
                                            <div class="modal fade history_modal" tabindex="-1" role="dialog" aria-labelledby="myHistoryModalLabel" aria-hidden="true" >
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="myHistoryModalLabel">History</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <ul class="list-unstyled megamenu-list">
                                                                @if($historic)
                                                                    @foreach($historic->where('assignment_status_id', 2) as $h)

                                                                        <li style="border-bottom: 1px solid #c7c5c5;">
                                                                            <span class="badge {{strtolower($h->status->name)}}">{{$h->status->name}}</span> ({{$h->user->name}})- {{$h->created_date}} <br># <small>{{$h->description}}</small>
                                                                        </li>

                                                                    @endforeach
                                                                @else
                                                                    <li><h6 class="font-size-15 text-center not_found">No History at this job available..</h6></li>
                                                                @endif
                                                            </ul>
                                                        </div>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->

                                            <p class="mb-2">
                                            @if($assignment->scheduling)
                                                {{--                                            <p class="mb-2">10/21/2021 btw 11AM to 12PM - Tech: Bolo</p>--}}
                                                <p class="mb-2"><i class="bx bx-calendar-event"></i> {{$assignment->scheduling->schedule_date}} <i class="bx bx-time-five"></i> {{$assignment->scheduling->start_hour}} to {{$assignment->scheduling->end_hour}} <i class="bx bx-user"></i> {{$assignment->scheduling->tech->name}}</p>
                                            @else
                                                <p class="mb-2"> {{"Not Scheduled!"}}</p>
                                                @endif

                                                </p>

                                        </div>

                                    @else

                                        {{--                                        //EDIT --}}
                                        <form class="needs-validation  was-validated" action="" wire:submit.prevent="update(Object.fromEntries(new FormData($event.target)))"  novalidate>
                                            <div class="row">

                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3 ">
                                                                        <label  class="form-label">Fisrt Name</label>
                                                                        <input type="text" class="form-control "  name="first_name"
                                                                               placeholder="Fisrt Name" wire:model="first_name"  required>

                                                                        <div class="valid-feedback">
                                                                            Looks good!
                                                                        </div>
                                                                        @error('first_name')
                                                                        <div class="invalid-feedback">
                                                                            Please type a valid option.
                                                                        </div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label  class="form-label">Last Name</label>
                                                                        <input type="text" class="form-control" name="last_name"
                                                                               placeholder="Last Name" wire:model="last_name" required>
                                                                        @error('last_name')
                                                                        <div class="invalid-feedback">
                                                                            Please select a valid option.
                                                                        </div>
                                                                        @enderror
                                                                        <div class="valid-feedback">
                                                                            Looks good!
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div  class="col-md-10">
                                                    <h5 class="font-size-14 mb-4">Job TYPES</h5>


                                                    @livewire('assignments::show.jobtypes', ['assignment' => $assignment->id], key('assignment_header_jobtypes'))

                                                </div>

                                                <div  class="col-md-2">

                                                    <button class="btn btn-lg btn-success m-2"   type="submit"   >SAVE</button>
                                                </div>


                                            </div>
                                        </form>
                                        <!-- end row -->




                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-1 align-self-right">
                            <div class="text-lg-center mt-4 mt-lg-0">
                                <p class="mb-0 text-info ">  EVENT:  <button type="button" class="btn btn-info btn-sm waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".small_event_modal"><i class="fas fa-exchange-alt" ></i></button></p>
                                @if($assignment->event)
                                    <span class="badge bg-danger p-2 mt-2">{{$assignment->event->name}}  </span>
                                @endif


                            </div>
                        </div>
                        <div class="col-md-3 align-self-left">
                            <div class="text-lg-left mt-4 mt-lg-0">
                                <p class="mb-0 text-info ">TAGS:  <button type="button" class="btn btn-info btn-sm waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".small_tag_modal"><i class="fas fa-exchange-alt" ></i></button></p>
                                @foreach($this->selectedTags  as $tags)
                                    <span class="badge tagable float-start p-1 me-1 mt-1">{{$tags->name}}<a href="javascript:void(0);" wire:click="removeTag({{$tags->id}})"  alt="Remove Tag"> <i class="bx bx-x "></i></a></span>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="clearfix mt-4 mt-lg-0 ">
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="btn-group float-end">
                                            <button type="button" class="btn btn-sm btn-secondary dropdown-toggle " data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                                <i class="bx bx-dots-horizontal align-middle"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-lg-end">
                                                <li><button class="dropdown-item" wire:click="changeStatusScheduling(1)"  type="button">OPEN</button></li>
                                                <li><button class="dropdown-item" wire:click="setPreStatus(11)" type="button">OPEN RESCHEDULE</button></li>
                                                <li><button class="dropdown-item" wire:click="setPreStatus(12)" type="button">PENDING</button></li>
                                                
                                                @if(in_array($assignment->status->id,[1, 27, 28]))
                                                    <li><button class="dropdown-item" wire:click="changeStatus(31)" type="button">THIG</button></li>
                                                @endif
                                                <li><button class="dropdown-item" wire:click="changeStatus(32)" type="button">UNIV</button></li>
                                                
                                                @if($assignment->status->id == 4)
                                                    <li><button class="dropdown-item" wire:click="changeStatus(3)" type="button">IN PROGRESS</button></li>
                                                @endif
                                                
                                                <li><button class="dropdown-item" wire:click="changeStatus(28)" type="button">MESSAGE SENT</button></li>
                                                <li><button class="dropdown-item" wire:click="changeStatus(29)" type="button">REQUEST DOCUSIGN</button></li>
                                                <li><button class="dropdown-item" wire:click="changeStatus(14)"  type="button">DOCUSIGN SENT</button></li>
                                                <li><button class="dropdown-item" wire:click="changeStatus(17)"  type="button">READY TO INSTALL</button></li>
                                                @if($assignment->scheduling || in_array($assignment->status->id,[28, 17]))
                                                    <li><button class="dropdown-item" wire:click="changeStatusScheduling(27)"  type="button">LATE</button></li>
                                                @endif
                                                <li><button class="dropdown-item" wire:click="changeStatus(20)" type="button">UPLOADING PICS</button></li>
                                                <li><button class="dropdown-item" wire:click="changeStatus(4)"  @if(!isset($assignment->scheduling)) disabled @endif type="button">READY TO BILL @if(!isset($assignment->scheduling))  <i class="bx bx-time-five"></i> (MISSING SCHEDULED DATE) @endif   </button></li>
                                                <li><button class="dropdown-item" wire:click="setPreStatus(7)"  type="button">CLOSED</button></li>
                                                <li><button class="dropdown-item" wire:click="setPreStatus(26)" type="button">NO CHARGE</button></li>
                                                <li><button class="dropdown-item" wire:click="setPreStatus(8)"  type="button">NO JOB</button></li>
                                                <li><button class="dropdown-item" wire:click="changeStatus(30)"  type="button">LANDLINE</button></li>
                                            </ul>
                                        </div>

                                        <div class="float-end">
                                            @livewire('assignments::show.header-scheduling', ['assignment' => $assignment->id], key('assignment_header_scheduling'))
                                        </div>
                                    </div>


                                </div>

                            </div>

                        </div>
                        @switch( $this->preStatus)
                            @case(7)
                            <div class="col-md-6"></div>
                            <div class="col-md-6 ">
                                <hr>
                                <div>
                                    <h5 class="modal-title" id="change_status_modal_pending">Explain why do you want to Close this job? </h5>
                                    <div class="d-flex">
                                        <textarea class="form-control  me-2"  wire:model="changeStatustext"  rows="5" placeholder="Enter note here..."></textarea>
                                        <button type="button" {{(empty($this->changeStatustext)) ?'disabled' : '' }} class="btn btn-success waves-effect waves-light  float-end" wire:click="changeStatusNotes({{$this->preStatus}})"><i class="bx bx-save font-size-16 align-middle me-2"></i></button>
                                    </div>
                                    <br>
                                </div>
                            </div>
                            @break
                            @case(26)
                            <div class="col-md-6"></div>
                            <div class="col-md-6 ">
                                <hr>
                                <div>
                                    <h5 class="modal-title" id="change_status_modal_pending">Explain why do you change status to NO CHARGE at this job? </h5>
                                    <div class="d-flex">
                                        <textarea class="form-control  me-2"  wire:model="changeStatustext"  rows="5" placeholder="Enter note here..."></textarea>
                                        <button type="button" {{(empty($this->changeStatustext)) ?'disabled' : '' }} class="btn btn-success waves-effect waves-light  float-end" wire:click="changeStatusNotes({{$this->preStatus}})"><i class="bx bx-save font-size-16 align-middle me-2"></i></button>
                                    </div>
                                    <br>
                                </div>
                            </div>
                            @break
                            @case(8)
                            <div class="col-md-6"></div>
                            <div class="col-md-6 ">
                                <hr>
                                <div>
                                    <h5 class="modal-title" id="change_status_modal_pending">Explain why do you this job is a NO JOB? </h5>
                                    <div class="d-flex">
                                        <textarea class="form-control  me-2"  wire:model="changeStatustext"  rows="5" placeholder="Enter note here..."></textarea>
                                        <button type="button" {{(empty($this->changeStatustext)) ?'disabled' : '' }} class="btn btn-success waves-effect waves-light  float-end" wire:click="nojob({{$this->preStatus}})"><i class="bx bx-save font-size-16 align-middle me-2"></i></button>
                                    </div>
                                    <br>
                                </div>
                            </div>
                            @break
                            @case(11)
                            <div class="col-md-6"></div>
                            <div class="col-md-6 ">
                                <hr>
                                <div>
                                    <h5 class="modal-title" id="change_status_modal_pending">Explain why do you want to change this job to Open Reschedule? </h5>
                                    <div class="d-flex">
                                        <textarea class="form-control  me-2"  wire:model="changeStatustext"  rows="5" placeholder="Enter note here..."></textarea>
                                        <button type="button" {{(empty($this->changeStatustext)) ?'disabled' : '' }} class="btn btn-success waves-effect waves-light  float-end" wire:click="changeStatusNotes({{$this->preStatus}})"><i class="bx bx-save font-size-16 align-middle me-2"></i></button>
                                    </div>
                                    <br>
                                </div>
                            </div>
                            @break
                            @case(12)
                            <div class="col-md-6"></div>
                            <div class="col-md-6 ">
                                <hr>
                                <div>
                                    <h5 class="modal-title" id="change_status_modal_pending">Explain why do you want to change this job to Pending? </h5>
                                    <div class="d-flex">
                                        <textarea class="form-control  me-2"  wire:ignore.self wire:model="changeStatustext"  rows="5" placeholder="Enter note here..."></textarea>
                                        <button type="button" {{(empty($this->changeStatustext)) ?'disabled' : '' }} class="btn btn-success waves-effect waves-light  float-end" wire:click="changeStatusNotes({{$this->preStatus}})"><i class="bx bx-save font-size-16 align-middle me-2"></i></button>
                                    </div>
                                    <br>
                                </div>
                            </div>
                            @break
                        @endswitch

                    </div>
                    <!-- end row -->
                </div>
            </div>
        </div>
    </div>


    <!--  Modal Events -->
    <div class="modal fade small_event_modal" tabindex="-1" role="dialog" aria-labelledby="mySmallEventModalLabel" aria-hidden="true" >
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mySmallEventModalLabel">Select Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-unstyled megamenu-list">
                        @if($allEvents->isNotEmpty())
                            @foreach($allEvents as $event)
                                <li>
                                    <span class="badge tagable p-2 m-1">{{$event->name}}</span> <button type="button" class="btn btn-primary btn-sm waves-effect waves-light" data-bs-dismiss="modal" wire:click.prevent="addEvent({{$event->id}})">Select</button>
                                </li>
                            @endforeach
                        @else
                            <li><h6 class="font-size-15 text-center not_found">No Events Active..</h6></li>
                        @endif
                    </ul>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!--  Modal Tags -->
    <div class="modal fade small_tag_modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" >
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mySmallModalLabel">Add Tags</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-unstyled megamenu-list">
                        @if($allTags->isNotEmpty())
                            @foreach($allTags as $tags)
                                <li>
                                    <span class="badge tagable p-2 m-1">{{$tags->name}}</span> <button type="button" class="btn btn-primary btn-sm waves-effect waves-light" data-bs-dismiss="modal" wire:click.prevent="addTag({{$tags->id}})">ADD</button>
                                </li>
                            @endforeach
                        @else
                            <li><h6 class="font-size-15 text-center not_found">No Tags available..</h6></li>
                        @endif
                    </ul>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!--  Modal Change Status Notes -->
    <div class="modal fade change_status_modal_pending" tabindex="-1" role="dialog" aria-labelledby="change_status_modal_pending" aria-hidden="true" >
        <div class="modal-dialog modal-lg">
            <div class="modal-content" >
                <div class="modal-header">
                    <h5 class="modal-title" id="change_status_modal_pending">Explain why you change this job to PENDING? </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->







</div>
