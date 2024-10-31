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
                            <div class="btn-group">
                                <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Selected Rows <i class="mdi mdi-chevron-down"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-md">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <label>
                                                <input type="radio" wire:model="selectedRows" value="10">
                                                10</label>
                                        </li>
                                        <li class="list-group-item">
                                            <label>
                                                <input type="radio" wire:model="selectedRows" value="50">
                                                50</label>
                                        </li>
                                        <li class="list-group-item">
                                            <label>
                                                <input type="radio" wire:model="selectedRows" value="100">
                                                100</label>
                                        </li>

                                    </ul>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Selected Columns <i class="mdi mdi-chevron-down"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-md">
                                        <ul class="list-group">
                                            @foreach($columns as $column)
                                                <li class="list-group-item">
                                                    <label>
                                                        <input type="checkbox" wire:model="selectedColumns" value="{{$column}}">
                                                        {{$column}}</label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-4 float-end " >
                            <input type="text" class="form-control" placeholder="Search..." wire:model="searchAssignment">
                        </div>
                    </div>
                    <div class="table-responsive mb-0" data-pattern="priority-columns">
                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100 listtable">
                        <thead>
                        <tr>

                            @if(in_array('Name', $selectedColumns))

                                <th>Name</th>
                                <th>Billing by</th>
                            @endif
                            @if(in_array('Job Type', $selectedColumns))
                                <th>Job Type</th>
                            @endif
                            @if(in_array('Schedule', $selectedColumns))
                                <th>Schedule</th>
                            @endif
                            @if(in_array('Status', $selectedColumns))
                                <th>Status</th>
                            @endif
                            @if(in_array('Referral', $selectedColumns))
                                <th>Referral</th>
                            @endif
                            @if(in_array('Address', $selectedColumns))
                                <th>Address</th>
                            @endif
                            @if(in_array('Street', $selectedColumns))
                                <th>Street</th>
                            @endif
                            @if(in_array('City', $selectedColumns))
                                <th>City</th>
                            @endif
                            @if(in_array('State', $selectedColumns))
                                <th>State</th>
                            @endif
                            @if(in_array('Phone', $selectedColumns))
                                <th>Phone</th>
                            @endif
                               @if(in_array('Claim Number', $selectedColumns))
                                  <th width="120">C. Number</th>
                               @endif
                            {{--                            @if(in_array('Invoice', $selectedColumns))--}}
                            {{--                                <th>Invoice</th>--}}
                            {{--                            @endif--}}
                            @if(in_array('Created by', $selectedColumns))
                                <th>Created by</th>
                            @endif
                            @if(in_array('Created At', $selectedColumns))
                                <th>Created At</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($list as $row)


                            <tr>
                                @if(in_array('Name', $selectedColumns))
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
                                @if(in_array('Name', $selectedColumns))
                                        <td>
                                            @if(is_null($row->billed_created))
                                                -
                                            @else
                                                {{$row->billed_created->name}}
                                            @endif

                                        </td>
                                @endif
                                @if(in_array('Job Type', $selectedColumns))
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
                                @if(in_array('Schedule', $selectedColumns))
                                    <td><span class="font-size-14" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Scheduled Date">

                                            @if($row->scheduling)
                                                <p class="mb-2"><i class="bx bx-calendar-event"></i>{{$row->scheduling->schedule_date}} <i class="bx bx-time-five"></i> {{$row->scheduling->start_hour}} to {{$row->scheduling->end_hour}} <i class="bx bx-user"></i> {{$row->scheduling->tech->name}}</p>
                                            @else
                                                <p class="mb-2"> {{"Not Scheduled!"}}</p>
                                        @endif
                                    </td>
                                @endif
                                @if(in_array('Status', $selectedColumns))
                                        <td><span class="badge {{strtolower($row->status->name)}}">{{$row->status->name}}</span></td>
                                @endif
                                @if(in_array('Status', $selectedColumns))
                                    <td><p>{{strtolower($row->referral_carrier_full)}}</p>
                                        @if($row->referral->status == 'BLOCKED')
                                            <span class="badge alert-danger">{{$row->referral->status}}</span>
                                        @endif
                                    </td>
                                @endif
                                @if(in_array('Address', $selectedColumns))
                                    <td><p><a href="{{$row->address->link}}" target="{{$row->address->target}}" >{{$row->address->message}}</a></p></td>
                                @endif
                                @if(in_array('Street', $selectedColumns))
                                    <td><p>{{$row->street}}</p></td>
                                @endif
                                @if(in_array('City', $selectedColumns))
                                    <td><p>{{$row->city}}</p></td>
                                @endif
                                @if(in_array('State', $selectedColumns))
                                    <td><p>{{$row->state}}</p></td>
                                @endif
                                @if(in_array('Phone', $selectedColumns))
                                    <td>
                                        @foreach($row->phones as $phone)
                                            <a href="#"><small>{{$phone->phone}}</small> </a>
                                        @endforeach
                                    </td>
                                @endif
                                   @if(in_array('Claim Number', $selectedColumns))
                                      <td><p>{{$row->claim_number}}</p></td>
                                   @endif
                                {{--                                @if(in_array('Invoice', $selectedColumns))--}}
                                {{--                                    <td>--}}
                                {{--                                        @foreach($row->invoices as $invoice)--}}
                                {{--                                            <p>{{$invoice}}</p>--}}
                                {{--                                        @endforeach--}}
                                {{--                                    </td>--}}
                                {{--                                @endif--}}

                                @if(in_array('Created by', $selectedColumns))
                                    <td><p>{{$row->user_created->name}}</p></td>
                                @endif
                                @if(in_array('Created At', $selectedColumns))
                                    <td><p class="font-size-14" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Dol Date"><i class="bx bx-calendar me-1 text-muted"></i>{{$row->created_date}}</p></td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    </div>
                    <div class="float-start">
                        Total jobs: {{$list->total()}}
                    </div>
                    <div class="float-end">


                        {{$list->links()}}


                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
</div>
