<div>
    <div>
        @if($showList)
            <div class="col-lg-12">
                <h4 class="card-title mb-4">List Paychecks
                </h4>
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

{{--                                            Total Pending: ${{$listReceipts->where('status','pending')->sum('amount')}} /--}}

                                        </div>
                                    </div>
                                    <div class="col-lg-4 float-end " >
                                        <input type="text" class="form-control" placeholder="Search..." wire:model="search">
                                    </div>
                                </div>
                                <div class="table-responsive mb-0" data-pattern="priority-columns">

                                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100 listtable">
                                        <thead>
                                        <tr>
                                            <th>Due On</th>
                                            <th>Balance</th>
                                            <th>Status</th>
                                            <th>Action</th>
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
                                                <td>
                                                    <p class="mb-0 font-size-12 ">{{$row->timesheet->due_on_view}}</p>
                                                </td>
                                                <td>
                                                    <p class="mb-0 font-size-12 ">{{$row->timesheet->finance->total}}</p>
                                                </td>
                                                <td>
                                                    <span class="badge text-uppercase  {{$row->status}}">{{$row->status}}</span>
                                                </td>
                                                <td>

                                                    @if(\session()->get('url')!='profile')
                                                    <button type="button" class="btn btn-sm btn-success  waves-effect waves-light  me-2 float-end" wire:click.prevent="paid('{{$row->id}}')"> <i class="bx bx-check font-size-16 align-middle "></i> Paid</button>
                                                    @endif
                                                    <button type="button" class="btn btn-sm btn-primary  waves-effect waves-light  me-2 float-end" wire:click.prevent="show('{{$row->id}}')"> <i class="bx bx-search font-size-16 align-middle "></i> View</button>

                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="float-start">
                                    Total Paychecks: {{$list->total()}}
                                </div>
                                <div class="float-end">

                                    {{$list->links()}}

                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->
            </div>
        @else

            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <button type="button" class="btn btn-sm btn-secondary  waves-effect waves-light  me-2 float-end" wire:click.prevent="backList"> <i class="fas fa-chevron-left font-size-16 align-middle "></i> Back</button>
                    </div>
                </div>

                @livewire('employees::show.tabs.paycheck.show', ['user' => $user->id, 'paycheck' => $paycheck_id], key('employees_tab_paycheck_show'))
            </div>
        @endif
    </div>
</div>
