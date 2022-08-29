<div>
    @if(!$showTimesheet)
        <h4 class="card-title mb-4">Timesheet List
            @if($showList)<button type="button" class="btn btn-sm btn-primary  waves-effect waves-light  me-2 float-end" wire:click="toogleList"> <i class="bx bx-plus font-size-16 align-middle "></i> NEW</button>@endif
        </h4>

        <div class="card">
            <div class="card-body">

                @if($showList)
                    <ul class="nav nav-pills bg-light rounded" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#transactions-all-tab" role="tab">Pending</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#transactions-buy-tab" role="tab">approved</a>
                        </li>

                    </ul>
                    <div class="tab-content mt-4">
                        <div class="tab-pane active" id="transactions-all-tab" role="tabpanel">
                            <div class="table-responsive" data-simplebar style="max-height: 450px;">
                                <table class="table align-middle table-nowrap">
                                    <tbody>

                                    @foreach($timesheets->where('status','!=','approved') as $row)


                                        <tr>
                                            <td style="width: 50px;">
                                                <div class="font-size-22 text-primary">
                                                    <i class="bx bx-calendar"></i>
                                                </div>
                                            </td>

                                            <td>
                                                <div>
                                                    <h5 class="font-size-14 mb-1">{{$row->start_md}} <small class="text-muted">to</small> {{$row->end_md}}/{{$row->year}}</h5>
                                                    <p class="text-muted mb-0">Monday to Sunday </p>
                                                </div>
                                            </td>


                                            <td>
                                                <div class="text-end">

                                                    <h5 class="font-size-14 mb-0">{{$row->due_on_view}}</h5>
                                                    <p class="text-muted mb-0">Payment Date:</p>
                                                </div>
                                            </td>
                                            <td>

                                                <div class="col-lg-1 align-self-center">
                                                    <div class="text-lg-center mt-4 mt-lg-0">
                                                        <span class="badge text-uppercase {{$row->status}}  p-2">{{$row->status}}</span>
                                                    </div>
                                                </div>

                                            </td>

                                            <td>
                                                @if(\session()->get('url')!='profile')
                                                <button type="button" class="btn btn-sm btn-danger  waves-effect waves-light  me-2 float-end" wire:click.prevent="delete('{{$row->id}}')"> <i class="bx bx-trash font-size-16 align-middle "></i></button>
                                                @endif
                                                <button type="button" class="btn btn-sm btn-primary  waves-effect waves-light  me-2 float-end" wire:click.prevent="show('{{$row->id}}')"> <i class="bx bx-search font-size-16 align-middle "></i> View</button>
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
                                    @foreach($timesheets->where('status','approved') as $row)


                                        <tr>
                                            <td style="width: 50px;">
                                                <div class="font-size-22 text-primary">
                                                    <i class="bx bx-calendar"></i>
                                                </div>
                                            </td>

                                            <td>
                                                <div>
                                                    <h5 class="font-size-14 mb-1">{{$row->start_md}} <small class="text-muted">to</small> {{$row->end_md}}/{{$row->year}}</h5>
                                                    <p class="text-muted mb-0">Monday to Sunday </p>
                                                </div>
                                            </td>


                                            <td>
                                                <div class="text-end">

                                                    <h5 class="font-size-14 mb-0">{{$row->due_on_view}}</h5>
                                                    <p class="text-muted mb-0">Payment Date:</p>
                                                </div>
                                            </td>
                                            <td>

                                                <div class="col-lg-1 align-self-center">
                                                    <div class="text-lg-center mt-4 mt-lg-0">
                                                        <span class="badge text-uppercase {{$row->status}}  p-2">{{$row->status}}</span>

                                                    </div>
                                                </div>

                                            </td>

                                            <td>
                                                @if(\session()->get('url')!='profile')
                                                <button type="button" class="btn btn-sm btn-danger  waves-effect waves-light  me-2 float-end" wire:click.prevent="delete('{{$row->id}}')"> <i class="bx bx-trash font-size-16 align-middle "></i></button>
                                                @endif
                                                    <button type="button" class="btn btn-sm btn-primary  waves-effect waves-light  me-2 float-end" wire:click.prevent="show('{{$row->id}}')"> <i class="bx bx-search font-size-16 align-middle "></i> View</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>


                    </div>
                @else

                    <form action="" wire:submit.prevent="createWeek(Object.fromEntries(new FormData($event.target)))">
                        <h6>Select Date:</h6>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-12 mt-2">
                                    <div class="input-group" id="service_date" wire:ignore>
                                        <x-flatpickr   id="service_date" class="flatpickr_date" name="new_week" wire:model="new_week"   value="" />
                                        <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
                                    </div>
                                    @error('new_week')
                                    <div class="invalid-feedback show">
                                        Please type a valid date.
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-12 mt-2">

                                </div>
                                <div class="col-md-12 mt-2">
                                    <button type="button" class="btn btn-secondary btn-sm float-start m-1" wire:click="toggleFollowup"><i class="fas fa-chevron-left"></i> cancel</button>
                                    <button type="submit" class="btn btn-success btn-sm float-start m-1" > <i class="fas fa-save"></i> save</button>
                                </div>
                            </div>
                        </div>
                    </form>

                @endif
            </div>
        </div>
    @else

        <div class="col-lg-12">
            @livewire('employees::show.tabs.timesheet.show', ['user' => $user->id, 'timesheet' => $timesheet_id], key('employees_tab_timesheet_show'))
        </div>
    @endif
</div>
