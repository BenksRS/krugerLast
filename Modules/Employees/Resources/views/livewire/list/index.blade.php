<div>
    <div class="row">
        <div class="col-lg-8" ></div>
        <div class="col-lg-4 float-end " >
            <input type="text" class="form-control" placeholder="Search..." wire:model="searchEmployes">
        </div>
    </div>
    <div class="card">

        <div class="card-body">


            <ul class="nav nav-pills bg-light rounded" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#transactions-all-tab" role="tab">Active</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#transactions-buy-tab" role="tab">Disabled</a>
                </li>

            </ul>
            <div class="tab-content mt-4">
                <div class="tab-pane active" id="transactions-all-tab" role="tabpanel">
                    <div class="table-responsive" data-simplebar style="max-height: 450px;">
                        <table class="table align-middle table-nowrap">
                            <tbody>

                            @foreach($list_actives as $row)


                            <tr>
                                <td style="width: 50px;">
                                    <div class="font-size-22 text-primary">
                                        <i class="bx bx-user-circle"></i>
                                    </div>
                                </td>

                                <td>
                                    <div>
                                        <h5 class="font-size-14 mb-1"><a href="{{url($url_current.'/show/'.$row->id)}}">{{$row->name}}</a></h5>
{{--                                        @dump($row->info->phone)--}}
                                        @if(isset($row->info))
                                        <p class="text-muted mb-0">{{$row->info->phone}}</p>
                                            @endif
                                    </div>
                                </td>

                                <td>
                                    <div class="text-end">
                                        <h5 class="font-size-14 mb-0">{{$row->group->name}}</h5>
                                    </div>
                                </td>

                                <td>
                                    <div class="text-end">
                                        <h5 class="font-size-14 text-muted mb-0">OCALA</h5>
                                    </div>
                                </td>
                            </tr>
                            @endforeach



                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane" id="transactions-buy-tab" role="tabpanel">
                    <div class="table-responsive" data-simplebar style="max-height: 450px;">
                        <table class="table align-middle table-nowrap">
                            <tbody>
                            @foreach($list_off as $row)


                                <tr>
                                    <td style="width: 50px;">
                                        <div class="font-size-22 text-danger">
                                            <i class="bx bx-user-circle"></i>
                                        </div>
                                    </td>

                                    <td>
                                        <div>
                                            <h5 class="font-size-14 mb-1"><a href="{{url('employees/show/'.$row->id)}}">{{$row->name}}</a></h5>
                                            <p class="text-muted mb-0">Phone</p>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="text-end">
                                            <h5 class="font-size-14 mb-0">Technician</h5>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="text-end">
                                            <h5 class="font-size-14 text-muted mb-0">OCALA</h5>
                                        </div>
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
