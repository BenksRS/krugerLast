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

                                @if(in_array('Referral', $selectedColumns))
                                    <th>Referral</th>
                                @endif
                                @if(in_array('Referral', $selectedColumns))
                                    <th>Referral Type</th>
                                @endif
                                    @if(in_array('Referral', $selectedColumns))
                                        <th>Total jobs</th>
                                    @endif
                                    @if(in_array('Referral', $selectedColumns))
                                        <th>Total billed</th>
                                    @endif
                                    @if(in_array('Referral', $selectedColumns))
                                        <th>Total Paid</th>
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
                            @foreach($listALl as $row)

                                <tr>
                                    @if(in_array('Status', $selectedColumns))
                                        <td><p>{{$row->ref}}</p></td>

                                    @endif
                                    @if(in_array('Status', $selectedColumns))
                                        <td><p>{{$row->jobs[0]->referral->type->name}}</p></td>
                                    @endif
                                        @if(in_array('Status', $selectedColumns))
                                            <td><p>{{$row->total}}</p></td>
                                        @endif
                                        @if(in_array('Status', $selectedColumns))
                                            <td><p>${{$this->showMoney($row->jobs->sum('finance.invoices.total'))}}</p></td>
                                        @endif
                                        @if(in_array('Status', $selectedColumns))
                                            <td><p>${{$this->showMoney($row->jobs->sum('finance.payments.total'))}}</p></td>
                                        @endif

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
    </div> <!-- end row -->
</div>
