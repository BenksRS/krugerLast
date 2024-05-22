<div>
    <div class="col-lg-12">
        <h4 class="card-title mb-4">List Comissions

            <button type="button" class="btn btn-sm btn-primary  waves-effect waves-light  me-2 float-end" wire:click.prevent="update_commission"> <i class="fas fa-undo-alt font-size-16 align-middle "></i> Reload</button>
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

                                    <th>ID</th>
                                    <th>Description</th>
                                    <th>Employee</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                    <th>Comission Month</th>

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
                                @foreach($listCommissions as $row)
                                    <tr>
                                      <td>
                                          {{$row->id}}
                                          <button type="button" class="btn btn-sm btn-danger  waves-effect waves-light  me-2 float-end" wire:click.prevent="update_commission({{$row->id}})"> <i class="fas fa-undo-alt font-size-16 align-middle "></i> delete</button>
                                      </td>
                                      <td>
                                          {{$row->rule->name}}
                                      </td>
                                      <td>
                                          {{$row->user->name}}
                                      </td>
                                      <td>
                                          <span class="badge text-uppercase  {{$row->status}}">{{$row->status}}</span>
                                      </td>
                                        <td>
                                            ${{$this->showMoney($row->amount)}}
                                        </td>
                                      <td>
                                        @if($row->status != 'pending')
                                          {{$row->due_month}}/{{$row->due_year}}
                                          @else
                                            NOT PAID
                                          @endif
                                      </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div>
</div>
