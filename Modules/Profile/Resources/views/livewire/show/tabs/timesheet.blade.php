<div>
    <div class="mb-4 d-flex justify-content-end">
        <button type="button" class="btn btn-success waves-effect waves-light" wire:click.prevent="saveDays">
            <i class="bx bx-save font-size-16 align-middle"></i> Save
        </button>
    </div>
    <div class="card">
        <div class="card-body">

            <p class="mb-3">
                <small class="text-muted"></small>
                {{ $week['start'] }}
                <small class="text-muted">to</small>
                {{ $week['end'] }}

                <span class="badge text-uppercase {{$timesheet->status}}  p-2">{{$timesheet->status}}</span>
            </p>



            <div class="row row-cols-1 row-cols-sm-2">
                @foreach($week['days'] as $name => $day)

                <div class="col">
                    <div class="card">
                        <div class="card-title">{{ $day['text'] }}</div>

                        <ul class="list-group">

                            <li class="list-group-item">
                                <input class="form-check-input" type="checkbox" wire:model="days.{{ $name }}.off" wire:click="disableAll('{{ $name }}')" {{ $isEdit == false ? 'disabled': '' }}>
                                <label class="form-check-label">Day Off</label>
                            </li>


                            @foreach($timesheetEvents as $key => $value)

                            <li class="list-group-item">
                                <input class="form-check-input" type="checkbox" wire:model="days.{{ $name }}.{{ $key }}" {{ $days[$name]['off'] == true || $isEdit == false ? 'disabled': '' }}>

                                <label class="form-check-label">{{ $value }}</label>
                            </li>

                            @endforeach

                        </ul>

                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>