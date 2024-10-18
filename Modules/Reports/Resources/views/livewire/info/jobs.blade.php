<div>
    <style>
        nav svg{
            max-height: 20px;
        }
        .table th{
            vertical-align: middle;
        }
    </style>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="btn-group">

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
                        {{--                        <div class="col-lg-4 float-end " >--}}
                        {{--                            <input type="text" class="form-control" placeholder="Search..." wire:model="searchAssignment">--}}
                        {{--                        </div>--}}
                    </div>
                    <div class="table-responsive mb-0" data-pattern="priority-columns">
                        <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100 listtable">
                            <thead>
                            <tr>

                                @if(in_array('Name', $selectedColumns))
                                    <th>Name</th>
                                @endif
                                @if(in_array('Address', $selectedColumns))
                                  <th>Address</th>
                                @endif
                                @if(in_array('Job Type', $selectedColumns))
                                    <th width="120">Job Type</th>
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
                                    @if(in_array('Referral', $selectedColumns))
                                        <th>Marketing</th>
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
                                {{--                            @if(in_array('Invoice', $selectedColumns))--}}
                                {{--                                <th>Invoice</th>--}}
                                {{--                            @endif--}}
                                @if(in_array('Created by', $selectedColumns))
                                    <th width="120">Created by</th>
                                @endif
                                @if(in_array('Created At', $selectedColumns))
                                    <th width="120">Created At</th>
                                @endif
                                @if(in_array('invoice`s', $selectedColumns))
                                    <th>Invoice`s</th>
                                @endif
                                @if(in_array('Billied Date', $selectedColumns))
                                    <th>Billied Date</th>
                                @endif
                                @if(in_array('Total Invoice Amount', $selectedColumns))
                                    <th>Invoice Amount</th>
                                @endif
                                    @if(in_array('State', $selectedColumns))
                                        <th>Tree Amount</th>
                                    @endif
                                @if(in_array('Paid Date', $selectedColumns))
                                    <th>Paid Date</th>
                                @endif
                                @if(in_array('Paid Amount', $selectedColumns))
                                    <th>Paid Amount</th>
                                @endif
                                @if(in_array('Balance Amount', $selectedColumns))
                                    <th>Balance Amount</th>
                                @endif
                                @if(in_array('Claim Number', $selectedColumns))
                                    <th width="80">Claim<br> Number</th>
                                @endif
                                @if(in_array('Billed By', $selectedColumns))
                                  <th>Billed By</th>
                                @endif
{{--                                    @if(in_array('Claim Number', $selectedColumns))--}}
{{--                                        <th width="80">C. Job <br>Number</th>--}}
{{--                                    @endif--}}
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
                            @foreach($listALl as $row)


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
                                      @if(in_array('Address', $selectedColumns))
                                        <td><p><a href="{{$row->address->link}}" target="{{$row->address->target}}" >{{$row->address->message}}</a></p></td>
                                      @endif
                                    @if(in_array('Job Type', $selectedColumns))
                                        <td><p>
                                                @foreach($row->job_types as $job)
                                                    {{$job->name}}
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
                                        @if(in_array('Status', $selectedColumns))
                                            <td><p>
                                                    @if($row->referral->marketing_id)
                                                        {{strtolower($row->referral->marketing->name)}}
                                                        @endif
                                                </p></td>

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
                                                <a href="#"><small>{{$phone->phone}}</small></a>
                                            @endforeach
                                        </td>
                                    @endif

                                    @if(in_array('Created by', $selectedColumns))
                                        <td><p>{{$row->user_created->name}}</p></td>
                                    @endif
                                    @if(in_array('Created At', $selectedColumns))
                                        <td><p class="font-size-14" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Dol Date"><i class="bx bx-calendar me-1 text-muted"></i>{{$row->created_date}}</p></td>
                                    @endif
                                    @if(in_array('invoice`s', $selectedColumns))
                                        <td>
                                            @if($row->invoices)
                                                <p>
                                                    @foreach($row->invoices as $inv)
                                                        {{$inv->invoice_id}}
                                                    @endforeach
                                                </p>
                                            @endif
                                        </td>
                                    @endif
                                    @if(in_array('Billied Date', $selectedColumns))
                                        <td>
                                            @if(isset($row->finance->collection->billed_date_view))
                                                <p>{{$row->finance->collection->billed_date_view}}</p>
                                            @endif
                                        </td>
                                    @endif
                                    @if(in_array('Total Invoice Amount', $selectedColumns))
                                        <td>
                                            @if($row->finance->invoices)
                                                <p>${{$row->finance->invoices->total}}</p>
                                            @endif
                                        </td>
                                    @endif
                                        @if(in_array('State', $selectedColumns))
                                            <td>
                                                @if(isset($row->finance->invoices->tree_amount))
                                                    <p>${{$row->finance->invoices->tree_amount}}</p>
                                                @endif
                                            </td>
                                        @endif
                                    @if(in_array('Paid Date', $selectedColumns))

                                        <td>
                                            @if(isset($row->finance->collection->payment_date_view))
                                                <p>{{$row->finance->collection->payment_date_view}}</p>
                                            @endif
                                        </td>
                                    @endif
                                    @if(in_array('Paid Amount', $selectedColumns))
                                        <td>
                                            @if($row->finance->payments)
                                                <p>${{$row->finance->payments->total}}</p>
                                            @endif
                                        </td>
                                    @endif
                                    @if(in_array('Balance Amount', $selectedColumns))
                                        <td>
                                            @if($row->finance->balance)
                                                <p>${{$row->finance->balance->total}}</p>
                                            @endif
                                        </td>
                                    @endif
                                    @if(in_array('Claim Number', $selectedColumns))
                                        <td><p>{{$row->claim_number}}</p></td>
                                    @endif
                                      @if(in_array('Billed By', $selectedColumns))
                                        <td><p>{{$row->billed_created->name ?? ''}}</p></td>
                                      @endif

{{--                                        @if(in_array('Claim Number', $selectedColumns))--}}
{{--                                            <td><p>{{$row->client_id}}</p></td>--}}
{{--                                        @endif--}}
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="float-start">
                        {{--                        @if($list)--}}
                                                    Total jobs: {{$listALl->total()}}
                        {{--                        @endif--}}

                    </div>
                    <div class="float-end">
                        {{--                        @if($list)--}}
                                                                        {{$listALl->links()}}

                        {{--                        @endif--}}
                    </div>
                </div>
            </div>
        </div> <!-- end col -->

      @if(!empty($jobsBilled))
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Jobs Billed</h5>
                @foreach($jobsBilled as $user => $jobs)
                  <span><b>{{ $user }}</b>: {{ $jobs->count() }}</span><br>
                @endforeach
            </div>
          </div>
        </div>
      @endif
    </div> <!-- end row -->
</div>
