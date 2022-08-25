<div>
    <div class="card">
        <div class="card-body">

                <ul class="nav nav-pills bg-light rounded" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link {{$tab == 'active' ? 'active' : ''}}" wire:click.prevent="setTab('active')"  data-bs-toggle="tab" href="#transactions-all-tab" role="tab">Time open </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{$tab == 'disable' ? 'active' : ''}}"  wire:click.prevent="setTab('disable')"data-bs-toggle="tab" href="#transactions-buy-tab" role="tab">Time set</a>
                    </li>

                </ul>
                <div class="tab-content mt-4">
                    <div class="tab-pane {{$tab == 'active' ? 'active' : ''}}" id="transactions-all-tab" role="tabpanel">
                        <div class="table-responsive" data-simplebar style="max-height: 450px;">
                            <table class="table align-middle table-nowrap">
                                <tbody>

                                @foreach($rules->where('status','active') as $row)


                                    <tr>
                                        <td style="width: 50px;">
                                            <i class="bx bx-check font-size-16 align-middle text-success "></i>
                                            <small class="text-muted">{{$row->id}}</small>
                                        </td>

                                        <td>
                                            <div>
                                                <h5 class="font-size-14 mb-1">{{$row->name}} <small class="text-muted"></small></h5>
                                                <p class=" mb-0"> from: <span class="text-muted">{{$row->start_date_view}}</span> to: <span class="text-muted">{{$row->end_date_view}}</span> </p>
                                            </div>
                                        </td>


                                        <td>
                                            <div class="text-end">
                                                <p class="text-muted mb-0">by {{$row->type_name}}</p>
                                            </div>
                                        </td>
                                        <td>

                                            <div class="col-lg-1 align-self-center">
                                                <div class="text-lg-center mt-4 mt-lg-0">
                                                    <span class="badge {{ $row->status}}  p-2">{{$row->status}}</span>
                                                </div>
                                            </div>

                                        </td>

                                        <td>
                                            <button type="button" class="btn btn-sm btn-danger  waves-effect waves-light  me-2 float-end" wire:click.prevent="disable('{{$row->id}}')"> <i class="bx bx-block font-size-16 align-middle "></i> Disable</button>
                                            <button type="button" class="btn btn-sm btn-primary  waves-effect waves-light  me-2 float-end" wire:click.prevent="show('{{$row->id}}')"> <i class="bx bx-file font-size-16 align-middle "></i> Edit</button>
                                        </td>
                                    </tr>
                                @endforeach



                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane {{$tab == 'disable' ? 'active' : ''}}" id="transactions-buy-tab" role="tabpanel">
                        <div class="table-responsive" data-simplebar style="max-height: 450px;">
                            <table class="table align-middle table-nowrap">
                                <tbody>
                                @foreach($rules->where('status','disable') as $row)


                                    <tr>
                                        <td style="width: 50px;">
                                            <i class="bx bx-block font-size-16 align-middle text-danger "></i>
                                            <small class="text-muted">{{$row->id}}</small>
                                        </td>

                                        <td>
                                            <div>
                                                <h5 class="font-size-14 mb-1">{{$row->name}} <small class="text-muted"></small></h5>
                                                <p class=" mb-0"> from: <span class="text-muted">{{$row->start_date_view}}</span> to: <span class="text-muted">{{$row->end_date_view}}</span> </p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-end">
                                                <p class="text-muted mb-0">by {{$row->type_name}}</p>
                                            </div>
                                        </td>
                                        <td>

                                            <div class="col-lg-1 align-self-center">
                                                <div class="text-lg-center mt-4 mt-lg-0">
                                                    <span class="badge {{ $row->status}}  p-2">{{$row->status}}</span>
                                                </div>
                                            </div>

                                        </td>

                                        <td>
                                            <button type="button" class="btn btn-sm btn-warning  waves-effect waves-light  me-2 float-end" wire:click.prevent="show('{{$row->id}}')"> <i class="bx bx-add-to-queue font-size-16 align-middle "></i> Clone</button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>


                </div>

        </div>
    </div>
</div>
