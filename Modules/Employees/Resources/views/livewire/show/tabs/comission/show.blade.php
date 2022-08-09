<div>
    <div class="col-lg-12">
        <h4 class="card-title mb-4">List Comissions

            <button type="button" class="btn btn-sm btn-primary  waves-effect waves-light  me-2 float-end" wire:click.prevent="edit"> <i class="bx bx-plus font-size-16 align-middle "></i> New</button>
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
                                @foreach($list as $row)
                                    <tr>

                                        <td>
                                          ({{$row->rule_id}}) Marketing %- {{$row->rule->referral->full_name}} -  ({{$row->due_month}} {{$row->due_year}})
                                        </td>
                                        <td>
                                            {{$row->total_debit}}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="float-start">
                            Total Comissions: {{$list->total()}}
                        </div>
                        <div class="float-end">

                            {{$list->links()}}

                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div>
</div>
