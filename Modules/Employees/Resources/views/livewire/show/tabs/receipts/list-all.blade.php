<div>
    @if($showList)
        <div class="col-lg-12">
            <h4 class="card-title mb-4">List Receipts

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

                                        Total Pending: ${{$listReceipts->where('status','pending')->sum('amount')}} /
                                        Total Approved: ${{$listReceipts->where('status','approved')->sum('amount')}}

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

                                        <th>Created</th>
                                        <th>Imagem</th>
                                        <th>Amount</th>
                                        <th>Category</th>
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
                                                {{$row->created_view}} <small class="text-muted">by {{$row->user_created->name}}</small>
                                            </td>
                                            <td>

                                                <button type="button" class="btn  btn-sm btn-info waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".modal_image_{{$row->id}}"><i class="bx bx-zoom-in"></i>View</button>
                                                <div class="modal fade modal_image_{{$row->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <img src="{{$row->b64}}" class="img-fluid">
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div>
                                            </td>
                                            <td>
                                                <p class="mb-0 font-size-12 ">{{$row->amount_view}}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 font-size-12 ">{{$row->category}}</p>
                                            </td>
                                            <td>
                                                <span class="badge text-uppercase  {{$row->status}}">{{$row->status}}</span>
                                            </td>
                                            <td>

                                                @switch($row->status)
                                                    @case('pending')
                                                    @if(\session()->get('url')!='profile')
                                                    <button type="button" class="btn btn-sm btn-success  waves-effect waves-light  me-2 float-end" wire:click.prevent="approve('{{$row->id}}')"> <i class="bx bx-check font-size-16 align-middle "></i> Approve</button>
                                                    @endif
                                                    <button type="button" class="btn btn-sm btn-danger  waves-effect waves-light  me-2 float-end" wire:click.prevent="delete('{{$row->id}}')"> <i class="bx bx-trash font-size-16 align-middle "></i> Delete</button>
                                                    @break
                                                    @case('approved')
                                                    {{$row->approved_view}} <small class="text-muted">approved by {{$row->user_approved->name}}</small>
                                                    @break
                                                    @case('paid')
                                                    {{$row->approved_view}} <small class="text-muted">paid by {{$row->user_approved->name}}</small>
                                                    @break
                                                @endswitch

                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="float-start">
                                Total Receipts: {{$list->total()}}
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
            @livewire('employees::show.tabs.receipts.add', ['user' => $user->id], key('employees_tab_receipts_add'))
        </div>
    @endif
</div>
