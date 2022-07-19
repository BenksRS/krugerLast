<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-5 col-lg-2">
                            <div class="mb-3 mt-2">
                                <label class="form-label">From:</label>

                                <div class="input-group" id="start_time-input-group" wire:ignore >
                                    <x-flatpickr   id="date_from" name="date_from" show-time :time24hr="false" alt-format="m/d/Y h:i K"    />
                                    <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
                                </div>
                                @error('start_date')
                                <div class="invalid-feedback show">
                                    Please select a valid datetime.
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-5 col-lg-2">
                            <div class="mb-3 mt-2">

                                <label class="form-label">To:</label>
                                <div class="input-group" id="end_time-input-group" wire:ignore>
                                    <x-flatpickr   id="date_to" name="date_to" show-time :time24hr="false" alt-format="m/d/Y h:i K"    />
                                    <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
                                </div>
                                @error('end_date')
                                <div class="invalid-feedback show">
                                    Please select a valid datetime.
                                </div>
                                @enderror
                            </div>
                        </div>

                       <div class="col-md-6">

                           <div class="mt-0">
                               <h5 class="font-size-14 mb-3">Date Filter By:</h5>
                               <div class="form-check-inline">
                                   <input class="form-check-input" type="radio" name="tarp_situation" wire:model="filter_date"
                                          id="filter_date_c" value="created">
                                   <label class="form-check-label" for="filter_date_c">
                                       Jobs Created
                                   </label>
                               </div>
                               <div class="form-check-inline mt-1">
                                   <input class="form-check-input" type="radio" name="tarp_situation" wire:model="filter_date"
                                          id="filter_date_s" value="schedulled" checked>
                                   <label class="form-check-label" for="filter_date_s">
                                       Jobs Schedulled
                                   </label>
                               </div>
                               <div class="form-check-inline mt-1">
                                   <input class="form-check-input" type="radio" name="tarp_situation" wire:model="filter_date"
                                          id="filter_date_b" value="billed">
                                   <label class="form-check-label" for="filter_date_b">
                                      Jobs Billed
                                   </label>
                               </div>
                               <div class="form-check-inline mt-1">
                                   <input class="form-check-input" type="radio" name="tarp_situation" wire:model="filter_date"
                                          id="filter_date_p" value="paid">
                                   <label class="form-check-label" for="filter_date_p">
                                       Jobs Paid
                                   </label>
                               </div>
                               @error('tarp_situation')
                               <div class="invalid-feedback show">
                                   Please select a valid option.
                               </div>
                               @enderror
                           </div>
                       </div>
                            <div class="col-md-2 ">
                                <button class="btn btn-lg btn-info m-2 " wire:click="search"
                                                                                type="submit"><i class="bx bx-search"></i> Search  </button>
                            </div>

                    </div>




                </div>
            </div>
        </div>
    </div>

</div>
@push('js')
    <script>
        $(document).ready(function() {
            $('#date_from').on('change.datetimepicker', function (e){
                let data = $(this).val();
                @this.set('date_from', data);
            });
            $('#date_to').on('change.datetimepicker', function (e){
                let data = $(this).val();
                @this.set('date_to', data);
            });
        });
    </script>
@endpush
