<div>
    <h4 class="card-title mb-4">Timesheet
        @if($timesheetEdit)
            Edit
            <span class="badge {{$timesheet->status == 'new' ? "bg-info" : 'bg-warning' }}  p-2">{{$timesheet->status}}</span>
            <button type="button" class="btn btn-sm btn-success  waves-effect waves-light  me-2 float-end" wire:click.prevent="saveDays"> <i class="bx bx-save font-size-16 align-middle "></i> Save</button>
        @else
            View
            @if($timesheet->status != 'approved')
                <span class="badge bg-warning  p-2">{{$timesheet->status}} </span>
                <button type="button" class="btn btn-sm btn-primary  waves-effect waves-light  me-2 float-end" wire:click.prevent="toogleEdit"> <i class="bx bx-plus font-size-16 align-middle "></i> Edit</button>
                <button type="button" class="btn btn-sm btn-success  waves-effect waves-light  me-2 float-end" wire:click.prevent="approve"> <i class="bx bx-check font-size-16 align-middle "></i> Approve</button>
            @else
                <span class="badge bg-success  p-2">{{$timesheet->status}}</span> <small class="text-muted">by {{$timesheet->user_approved->name}} ({{$timesheet->approved_view}})</small>
                <button type="button" class="btn btn-sm btn-primary  waves-effect waves-light  me-2 float-end" wire:click.prevent="toogleEdit"> <i class="bx bx-plus font-size-16 align-middle "></i> Edit</button>
            @endif
        @endif
        <button type="button" class="btn btn-sm btn-secondary waves-effect waves-light  me-2 float-end" wire:click.prevent="$emit('backList')"> <i class="fas fa-chevron-left font-size-16 align-middle "></i> Back</button>
    </h4>

    <div class="card">
        <div class="card-body">


            <div class="table-responsive">
                <table class="table table-striped mb-0">

                    <thead>
                    <tr>
                        <th scope="row" colspan="7">
                            <p class="mb-0"> <small class="text-muted">Monday</small> {{$timesheet->start_md}}/{{$timesheet->year}} <small class="text-muted">to Sunday</small> {{$timesheet->end_md}}/{{$timesheet->year}}</p>
                        </th>
                    </tr>
                    <tr>
                        <th >DATE</th>
                        <th>MORNING</th>
                        <th>AFTERNOON</th>
                        <th>SLEEP OUT</th>
                        <th>ON CALL</th>
                        <th>HURRICANE</th>
                        <th>DAY OFF</th>
                    </tr>
                    </thead>
                    <tbody>

                    @if($timesheetDays)
                        @foreach($timesheetDays as $day)
                            <?php
                            $off=${$day->day_week}['off'];
                            $morning=${$day->day_week}['morning'];
                            $afternoon=${$day->day_week}['afternoon'];
                            $out=${$day->day_week}['out'];
                            $oncall=${$day->day_week}['oncall'];
                            $hurricane=${$day->day_week}['hurricane'];
                            //
                            ?>
                            <tr>
                                <th scope="row">
                                    <p class="text-muted" style="text-align: right;">{{$day->date_timesheet}}</p>
                                </th>
                                <td>
                                    <div class="form-check ms-4">
                                        <input class="form-check-input" type="checkbox" id="{{$day->day_week}}_morning" wire:model="{{$day->day_week}}.morning" {{$timesheetEdit && $off == false ? '': 'disabled'}}>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check ms-4">
                                        <input class="form-check-input" type="checkbox" id="{{$day->day_week}}_morning" wire:model="{{$day->day_week}}.afternoon"  {{$timesheetEdit && $off == false ? '': 'disabled'}}>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check ms-4">
                                        <input class="form-check-input" type="checkbox" id="{{$day->day_week}}_morning" wire:model="{{$day->day_week}}.out"  {{$timesheetEdit && $off == false ? '': 'disabled'}}>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check ms-4">
                                        <input class="form-check-input" type="checkbox" id="{{$day->day_week}}_morning" wire:model="{{$day->day_week}}.oncall"  {{$timesheetEdit && $off == false ? '': 'disabled'}}>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check ms-4">
                                        <input class="form-check-input" type="checkbox" id="{{$day->day_week}}_morning" wire:model="{{$day->day_week}}.hurricane"  {{$timesheetEdit && $off == false ? '': 'disabled'}}>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check ms-4">
                                        <input class="form-check-input" type="checkbox" id="{{$day->day_week}}_morning" wire:model="{{$day->day_week}}.off" {{$timesheetEdit && $morning == false && $afternoon == false && $out == false && $oncall == false && $hurricane == false ? '': 'disabled'}}>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    @endif





                    </tbody>
                </table>
            </div>


        </div>
    </div>

</div>
