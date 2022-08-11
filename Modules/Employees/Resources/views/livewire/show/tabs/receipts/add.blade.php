<div>
    <h4 class="card-title mb-4">New Receipt

    </h4>
    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent="save" >

                <div class="row">
                <div class="col-lg-6 col-md-12">
                    <h6>Select Receipt:</h6>
                    <div class="input-group">
                        <input type="file" class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload" wire:model="photo" name="photo">
                    </div>

                    @error('photo')
                    <span class="error">{{ $message }}</span>
                    @enderror

                    <div wire:loading wire:target="photo"><i class="fa fa-spinner"></i> Uploading...</div>
                    @if($photo)
                        <img src="{{$photo->temporaryUrl()}}" width="300" style="opacity: 100%" alt="" class="m-2">

                    @endif
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="mb-3" >
                        <label class="form-label">Category Type</label>
                        <select class=" form-control select2-multiple select_carrier" wire:model="category"
                                name="carrier_id" data-placeholder="Select ...">

                                    <option >choose...</option>
                                    <option value="GAS">GAS</option>
                                    <option value="AUTOMAINTENANCE">AUTOMAINTENANCE</option>
                                    <option value="MATERIAL">MATERIAL</option>
                                    <option value="UTILITIES">UTILITIES</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label  class="form-label">Receipt Amount</label>
                        <input type="text" class="form-control"  name="amount"
                               placeholder="$0.00" wire:model.debounce.2000ms="amount"  required>

                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        @error('amount')
                        <div class="invalid-feedback">
                            Please type a valid option.
                        </div>
                        @enderror
                    </div>
                    <button type="button" class="btn btn-secondary btn-sm float-start m-1" wire:click="$emit('backList')"><i class="fas fa-chevron-left"></i> cancel</button>
                    <button type="submit" class="btn btn-success btn-sm float-start m-1"
                            {{ ($photo && $amount && $category)? '' : 'disabled' }}  >
                        <i class="fas fa-save"></i> save</button>

                </div>
                </div>

            </form>

        </div>

    </div>
</div>
