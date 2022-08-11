<div>


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="btn-group">

                                {{--                                    Total Pending: ${{$listReceipts->where('status','pending')->sum('amount')}} /--}}
                                {{--                                    Total Approved: ${{$listReceipts->where('status','approved')->sum('amount')}}--}}

                            </div>
                        </div>
                        <div class="col-lg-4 float-end " >
                            {{--                                <input type="text" class="form-control" placeholder="Search..." wire:model="search">--}}
                        </div>
                    </div>
                    <div class="table-responsive mb-0" data-pattern="priority-columns">

                        <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100 listtable">
                            <thead>
                            <tr>

                                <th>Jobs</th>
                                <th>Rule</th>
                                <th>Amount</th>
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
                            @foreach($listComissions as $row)
                                <tr class="">
                                    <td style="width: 100px">
                                        <button type="button" class="btn btn-sm btn-info  waves-effect waves-light  me-2 float-end btn_show_jobs" data-id="{{$row->id}}"> <i class="bx bx-plus font-size-16 align-middle "></i> View</button>
                                        <button type="button" class="btn btn-sm btn-info  waves-effect waves-light  me-2 float-end btn_hide_jobs btn_hide_{{$row->id}}" > <i class="bx bx-minus font-size-16 align-middle "></i> Hide</button>
                                    </td>
                                    <td>
{{--                                        @switch($row->rule->type)--}}
{{--                                            @case('T')--}}
{{--                                            Technician %{{($row->rule->porcentagem*100)}}--}}
{{--                                                   <?php--}}
{{--                                                    $explode=explode(',',$row->rule->tech_ids);--}}
{{--                                                        $tech="";--}}
{{--                                                        foreach ($explode as $o){--}}
{{--                                                            $info=\Modules\User\Entities\User::find($o);--}}
{{--                                                            $tech="$tech / $info->name";--}}

{{--                                                        }--}}

{{--                                            echo $tech;--}}
{{--                                            ?>--}}
{{--                                            {{$row->rule->tech_ids}}--}}
{{--                                            @break--}}
{{--                                            @case('R')--}}
{{--                                            Marketing %{{($row->rule->porcentagem*100)}}- {{$row->rule->referral->full_name}}--}}
{{--                                            @break--}}
{{--                                            @case('J')--}}

{{--                                            <?php--}}

{{--                                                $job_type=\Modules\Assignments\Entities\AssignmentsJobTypes::find($row->rule->job_type);--}}

{{--//                                            echo $job_type->name;--}}
{{--                                            ?>--}}
{{--                                                {{$job_type->name}} - ${{$this->showMoney($row->rule->valor)}}--}}

{{--                                            @break--}}
{{--                                            @case('S')--}}
{{--                                            Roof Tarp- {{(int)$row->rule->sq_min}} up to {{(int)$row->rule->sq_max}} sqft - ${{$this->showMoney($row->rule->valor)}}--}}
{{--                                            @break--}}
{{--                                            @case('P')--}}
{{--                                            All Jobs %{{($row->rule->porcentagem*100)}}--}}
{{--                                            @break--}}
{{--                                        @endswitch--}}

                                            {{$row->rule->name}}

                                    </td>
                                    <td style="width: 150px">
                                        ${{$this->showMoney($row->total)}}

                                    </td>
                                </tr>

                                {{--                                        @dump($job)--}}
                                <tr class="list_jobs_item list_jobs_{{$row->id}}">

                                    <td colspan="3">
                                        <div class="table-responsive">
                                            <table class="table mb-0 font-size-11">

                                                <thead class="table-light">
                                                <tr>
                                                    <th>JOB</th>
                                                    <th>SCHEDULE</th>
                                                    <th>Paid Date</th>
                                                    <th>STATUS</th>
                                                    <th>Comission</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($row->jobs as $job)
                                                    {{--                                                        @dump($job->assignment->finance)--}}
                                                    <tr>
                                                        <th scope="row">{{$job->assignment->full_name}}</th>
                                                        <td>
                                                            <p class="mb-2">
                                                            @if($job->assignment->scheduling)
                                                            <i class="bx bx-calendar-event"></i>
                                                                {{$job->assignment->scheduling->schedule_date}} <i class="bx bx-time-five"></i> {{$job->assignment->scheduling->start_hour}} to {{$job->assignment->scheduling->end_hour}} <i class="bx bx-user"></i> {{$job->assignment->scheduling->tech->name}}
                                                            @else
                                                                Not Scheduled!
                                                            @endif
                                                            </p>
                                                        </td>
                                                        <td>{{ isset($job->assignment->finance->collection->payment_date_view) ? $job->assignment->finance->collection->payment_date_view : '-'}}</td>
                                                        <td><span class="badge text-uppercase  {{$job->status}}">{{$job->status}}</span></td>
                                                        <td>${{$this->showMoney($job->amount)}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>

                                </tr>


                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="float-end">

                        {{--                            {{$list->links()}}--}}

                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->


</div>
