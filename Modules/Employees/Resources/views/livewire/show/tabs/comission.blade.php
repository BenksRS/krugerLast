<div>

    <div class="row">
        <div class="col-lg-3 col-md-12">
            <h4 class="card-title mb-4">Balance Info</h4>
            @livewire('employees::show.tabs.comission.balance', ['user' => $user->id], key('employees_tab_comission_balance'))
        </div>
        <div class="col-lg-9 col-md-12">
            <h4 class="card-title mb-4">List Comissions
                <div class="float-end">
                    <div class="input-group input-group-sm">
                        <select class="form-select form-select-sm" wire:model="dueYearSelected" >
                            @foreach($dueYearList as $key => $data)
                                <option value="{{$key}}" >{{$data}}</option>
                            @endforeach
                        </select>
                        <label class="input-group-text">Year</label>
                    </div>
                </div>
                <div class="float-end">
                    <div class="input-group input-group-sm">
                        <select class="form-select form-select-sm" wire:model="dueMonthSelected" >
                            @foreach($dueMonthList as $key => $data)
                                <option value="{{$key}}" >{{$data}}</option>
                            @endforeach
                        </select>
                        <label class="input-group-text">Month</label>
                    </div>
                </div>

            </h4>
            @livewire('employees::show.tabs.comission.show', ['user' => $user->id], key('employees_tab_comission_show'))

        </div>
    </div>
</div>
