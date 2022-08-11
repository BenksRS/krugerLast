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
@push('js')
    <script>

        $('.list_jobs_item').hide();
        $('.btn_hide_jobs').hide();

        $('.btn_show_jobs').on('click', function (e){
            let data = $(this).data('id');
            let btn_hide = $(this).data('hide');

            $('.list_jobs_'+data).show();
            $('.btn_hide_'+data).show();
            $(this).hide();

        });
        $('.btn_hide_jobs').on('click', function (e){
            $('.list_jobs_item').hide();
            $('.btn_hide_jobs').hide();
            $('.btn_show_jobs').show();

        });


    </script>

@endpush