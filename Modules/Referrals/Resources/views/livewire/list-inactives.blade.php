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
                                <div class="btn-group">
                                    <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Marketing Rep <i class="mdi mdi-chevron-down"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-md">
                                        <ul class="list-group">
                                            @foreach($marketing as $mr)
                                                <li class="list-group-item">
                                                    <label>
                                                        <input type="checkbox" wire:model="selectedMarketing" value="{{$mr->id}}">
                                                        {{$mr->user->name}}</label>
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
                                @if(in_array('Id', $selectedColumns))
                                    <th>Id</th>
                                @endif
                                @if(in_array('Name', $selectedColumns))
                                    <th>Name</th>
                                @endif
                                @if(in_array('Marketing', $selectedColumns))
                                    <th>Type</th>
                                @endif
                                @if(in_array('Type', $selectedColumns))
                                    <th>JOB SENT</th>
                                @endif
                                @if(in_array('Type', $selectedColumns))
                                    <th>LAST JOB SENT</th>
                                @endif
                                @if(in_array('Type', $selectedColumns))
                                    <th>Days from Last Job</th>
                                @endif
                                @if(in_array('Type', $selectedColumns))
                                    <th>Marketing</th>
                                @endif
                                @if(in_array('status', $selectedColumns))
                                    <th>status</th>
                                @endif
                                @if(in_array('Address', $selectedColumns))
                                    <th>Address</th>
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
                            @foreach($list as $row)


                                <tr>
                                    @if(in_array('Id', $selectedColumns))
                                        <td><p>{{strtolower($row->id)}}</p></td>
                                        {{--                                        <td><span class="badge {{strtolower($row->status->name)}}">{{$row->status->name}}</span></td>--}}
                                    @endif
                                    @if(in_array('Name', $selectedColumns))
                                        <td><p>
                                                <a href="{{url('referrals/show/'.$row->id)}}"> {{strtolower($row->full_name)}}</a>
                                            </p></td>
                                    @endif
                                    @if(in_array('Type', $selectedColumns))
                                        <td><p>{{strtolower($row->type->name)}}</p></td>
                                    @endif
                                    @if(in_array('Type', $selectedColumns))
                                        <td><p>
                                                @if($row->jobs_sent == 'Y')

                                                    <span class="alert-success p-1" > Yes</span>
                                                @else
                                                    <span class="alert-danger"> No jobs sent!</span>
                                                @endif
                                            </p></td>
                                    @endif
                                    @if(in_array('Type', $selectedColumns))
                                        <td><p>
                                                @if($row->lastjob)
                                                    {{$row->lastjob->created_date}}
                                                @else
                                                    -
                                                @endif

                                            </p></td>
                                    @endif
                                    @if(in_array('Type', $selectedColumns))
                                        <td><p>
                                                @if($row->days_last_job > 0)
                                                {{$row->days_last_job}} Days
                                                @else
                                                    {{$row->days_last_job}}
                                                @endif
                                            </p></td>
                                    @endif
                                    @if(in_array('Marketing', $selectedColumns))
                                        <td><p>


                                                {{strtolower(isset($row->marketing->name) ? $row->marketing->name : '-' )}}</p></td>
                                    @endif
                                    @if(in_array('status', $selectedColumns))
                                        <td><span class="badge {{strtolower($row->status)}}">{{$row->status}}</span></td>
                                    @endif
                                    @if(in_array('Address', $selectedColumns))
                                        <td><p><a href="{{$row->address->link}}" target="{{$row->address->target}}" >{{$row->address->message}}</a></p></td>
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
