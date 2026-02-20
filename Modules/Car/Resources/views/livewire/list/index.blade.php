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
                                    Sort BY<i class="mdi mdi-chevron-down"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-md">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <label> <input type="radio" wire:model="sortBy" value="tag_expires">TAG EXPIRES</label>
                                        </li>
                                        <li class="list-group-item">
                                            <label> <input type="radio" wire:model="sortBy" value="insurance_expires">INSURANCE EXPIRES</label>
                                        </li>
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
                                @if(in_array('Auto', $selectedColumns))
                                    <th>Auto</th>
                                @endif
                                @if(in_array('Auto', $selectedColumns))
                                    <th>Driver</th>
                                @endif
                                @if(in_array('Auto', $selectedColumns))
                                    <th>E-pass</th>
                                @endif
                                @if(in_array('Auto', $selectedColumns))
                                    <th>Plate</th>
                                @endif
                                @if(in_array('Auto', $selectedColumns))
                                    <th>Tag Expires</th>
                                @endif
                                @if(in_array('Auto', $selectedColumns))
                                    <th>Insurance Expires</th>
                                @endif
                                @if(in_array('Auto', $selectedColumns))
                                    <th>VIN</th>
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

                                    @if(in_array('Auto', $selectedColumns))
                                        <td><p><a href="{{url('cars/show/'.$row->id)}}">{{$row->auto}}</a></p></td>
                                    @endif
                                    @if(in_array('Auto', $selectedColumns))
                                        <td><p>{{$row->driver}}</p></td>
                                    @endif
                                    @if(in_array('Auto', $selectedColumns))
                                        <td><p>{{$row->epass}}</p></td>
                                    @endif
                                    @if(in_array('Auto', $selectedColumns))
                                        <td><p>{{$row->plate}}</p></td>
                                    @endif
                                    @if(in_array('Auto', $selectedColumns))
                                        <td><p>{{$row->tag_expires}}</p></td>
                                    @endif
                                    @if(in_array('Auto', $selectedColumns))
                                        <td><p>{{$row->insurance_expires}}</p></td>
                                    @endif
                                    @if(in_array('Auto', $selectedColumns))
                                        <td><p>{{$row->vin}}</p></td>
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