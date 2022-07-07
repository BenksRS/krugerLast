<div>

    <div class="row {{($showButtons) ? 'show' : 'hide' }}">
        <div class="col-lg-12 ">
        @if($showChangeTech)
                <button type="button" class="btn btn-primary  waves-effect waves-light  me-2 float-end" wire:click="$emit('showButtons','tech')"> <i class="bx bx-calendar-alt font-size-16 align-middle me-2"></i>C. Tech</button>
        @endif
        @if($showSched)
                <button type="button" class="btn btn-primary  waves-effect waves-light  me-2 float-end" wire:click="$emit('showButtons','full')"> <i class="bx bx-calendar-alt font-size-16 align-middle me-2"></i>Schedule</button>
        @endif
        @if($showChangeSched)
                <button type="button" class="btn btn-primary  waves-effect waves-light  me-2 float-end"  wire:click="$emit('showButtons','full')"> <i class="bx bx-calendar-alt font-size-16 align-middle me-2"></i>C. Scheduled</button>
        @endif
        </div>
    </div>

    <div class="row {{($showButtons) ? 'hide' : 'show' }}">
<!--        --><?php //dd($showButtons); ?>
        @if($showFormDate)
        <div class="col-lg-12">
            <label class="form-label">Schedule Date Time</label>
            <div class="input-group" id="start_time-input-group" wire:ignore>
                <x-flatpickr   id="schedule_start" class="flatpickr" name="schedule_start"    />
                <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
            </div>
            @error('schedule_start')
            <div class="invalid-feedback show">
                Please select a valid datetime.
            </div>
            @enderror
        </div>
        @endif
        <div class="col-lg-12">
            <div class="mb-3">
                <label for="techSelected" class="form-label">Tech</label>
                <select id="techSelected" class="form-select" name="techSelected" wire:model="techSelected">
                    <option selected>chose...</option>
                    @foreach($techs as $tech)
                        <option value="{{$tech->user->id}}">{{$tech->user->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-12">
            <button type="button" class="btn btn-success float-end m-2" wire:click="schedule" >Save changes</button>
            <button type="button" class="btn btn-secondary float-end m-2" wire:click="$emit('showButtons','back')">Cancel</button>

        </div>
    </div>



</div>
@push('js')
    <script>

        $('.select2').select2();
        var taskFlatpickrConfig = {
            enableTime: true,
            altInput: true,
            dateFormat: "Y-m-d H:i",
            altFormat: "m\/d\/Y h:i K",
            time_24hr: false
        };
        document.addEventListener("livewire:load", function (event) {
            @this.on('showButtons', function () {
                setTimeout(function() {
                    $('#schedule_start').flatpickr(taskFlatpickrConfig);
                    $('#schedule_start').on('change.datetimepicker', function (e){
                        let data = $(this).val();
                        @this.set('schedule_start', data);
                    });
                },700);
            });
        });
    </script>
@endpush
