<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-5 col-lg-2">
                            <div class="mb-3 mt-2">
                                <label class="form-label">From:</label>
                                <div class="input-group" wire:ignore>
                                    <x-flatpickr id="general_date_from" name="date_from" show-time :time24hr="false" alt-format="m/d/Y h:i K"/>
                                    <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5 col-lg-2">
                            <div class="mb-3 mt-2">
                                <label class="form-label">To:</label>
                                <div class="input-group" wire:ignore>
                                    <x-flatpickr id="general_date_to" name="date_to" show-time :time24hr="false" alt-format="m/d/Y h:i K"/>
                                    <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="mt-0">
                                <h5 class="font-size-14 mb-3">Date Filter By:</h5>
                                <div class="form-check-inline">
                                    <input class="form-check-input" type="radio" wire:model="filter_date" id="gen_filter_c" value="created">
                                    <label class="form-check-label" for="gen_filter_c">Created</label>
                                </div>
                                <div class="form-check-inline">
                                    <input class="form-check-input" type="radio" wire:model="filter_date" id="gen_filter_s" value="schedulled">
                                    <label class="form-check-label" for="gen_filter_s">Scheduled</label>
                                </div>
                                <div class="form-check-inline">
                                    <input class="form-check-input" type="radio" wire:model="filter_date" id="gen_filter_b" value="billed">
                                    <label class="form-check-label" for="gen_filter_b">Billed</label>
                                </div>
                                <div class="form-check-inline">
                                    <input class="form-check-input" type="radio" wire:model="filter_date" id="gen_filter_p" value="paid">
                                    <label class="form-check-label" for="gen_filter_p">Paid</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-1">
                            <button class="btn btn-lg btn-info m-2" wire:click="$emit('search')" type="submit">
                                <i class="bx bx-search"></i> Search
                            </button>
                        </div>

                        <div class="col-md-6 col-lg-6">
                            <div class="mb-3" wire:ignore>
                                <label class="form-label">Workers</label>
                                <a href="#" wire:click.prevent="clear('workersSelected')" onClick="clearGenWorkers()" class="float-end">clear</a>
                                <select class="form-control select2-multiple select_gen_worker" multiple data-placeholder="Select ...">
                                    @foreach($workers as $wk)
                                        @if($wk->user)
                                            <option value="{{$wk->user->id}}">{{$wk->user->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-4">
                            <div class="mb-3" wire:ignore>
                                <label class="form-label">Job Type</label>
                                <a href="#" wire:click.prevent="clear('jtSelected')" onClick="clearGenJt()" class="float-end">clear</a>
                                <select class="form-control select2-multiple select_gen_jt" multiple data-placeholder="Select ...">
                                    @foreach($job_types as $jt)
                                        <option value="{{$jt->id}}">{{$jt->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div wire:loading class="row">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <div wire:loading.remove>
        @if($list !== null)
            @if(count($list))
                @livewire('reports::general.jobs', ['test' => $list, 'workersSelected' => $workersSelected], key('reports_general_jobs'))
            @else
                <div class="alert alert-warning">No jobs found for the selected filters.</div>
            @endif
        @endif
    </div>
</div>

@push('js')
    <script>
        $(document).ready(function () {
            $('#general_date_from').on('change.datetimepicker', function () {
                @this.set('date_from', $(this).val());
            });
            $('#general_date_to').on('change.datetimepicker', function () {
                @this.set('date_to', $(this).val());
            });
            $('.select_gen_worker').select2({placeholder: "chose..."}).on('change', function () {
                @this.set('workersSelected', $(this).val());
            });
            $('.select_gen_jt').select2({placeholder: "chose..."}).on('change', function () {
                @this.set('jtSelected', $(this).val());
            });
        });

        function clearGenWorkers() {
            $('.select_gen_worker').val(null).trigger('change');
        }

        function clearGenJt() {
            $('.select_gen_jt').val(null).trigger('change');
        }
    </script>
@endpush
