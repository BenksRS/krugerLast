<div>

    <form  class="needs-validation" novalidate action=""  wire:submit.prevent="saveRate(Object.fromEntries(new FormData($event.target)))">
    <div class="row">
        <div class="col-lg-4 col-md-12">
            <h4 class="card-title mb-4">Rate Type</h4>

            <div class="card">
                <div class="card-body">
                    <div class="mb-3" >
                        <label class="form-label">Rate Type</label>
                        <select class=" form-control select2-multiple" wire:model="type"
                                name="type" data-placeholder="Select ...">
                            <option >choose...</option>
                            <option value="D">Day</option>
                            <option value="H">Hour</option>
                            <option value="S">Salary</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-8 col-md-12">
            <h4 class="card-title mb-4">Rates amount</h4>

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <label  class="form-label">Regular Day</label>
                            <input type="text" class="form-control"  name="regular_day"
                                   placeholder="$0.00" wire:model.debounce.1000ms="regular_day"  required>

                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            @error('regular_day')
                            <div class="invalid-feedback">
                                Please type a valid option.
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-2">
                            <label  class="form-label">Weekend Day</label>
                            <input type="text" class="form-control"  name="weekend_day"
                                   placeholder="$0.00" wire:model.debounce.1000ms="weekend_day"  required>

                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            @error('weekend_day')
                            <div class="invalid-feedback">
                                Please type a valid option.
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-2">
                            <label  class="form-label">Sleep Out</label>
                            <input type="text" class="form-control"  name="sleep_out"
                                   placeholder="$0.00" wire:model.debounce.1000ms="sleep_out"  required>

                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            @error('sleep_out')
                            <div class="invalid-feedback">
                                Please type a valid option.
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-2">
                            <label  class="form-label">On call</label>
                            <input type="text" class="form-control"  name="oncall"
                                   placeholder="$0.00" wire:model.debounce.1000ms="oncall" required>

                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            @error('oncall')
                            <div class="invalid-feedback">
                                Please type a valid option.
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-2">
                            <label  class="form-label">Hurricane Extra</label>
                            <input type="text" class="form-control"  name="hurricane"
                                   placeholder="$0.00" wire:model.debounce.1000ms="hurricane"  required>

                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            @error('hurricane')
                            <div class="invalid-feedback">
                                Please type a valid option.
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-2">
                            <button class="btn btn-lg btn-success m-2 "
                                    {{isset($this->type) ? ' ': 'disabled'}}

                                    type="submit" ><i class="bx bx-save"></i> Save  </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </form>
</div>
