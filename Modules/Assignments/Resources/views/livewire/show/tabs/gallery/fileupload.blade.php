<div>


    <form wire:submit.prevent="save" >


        <div class="input-group">
            <input type="file" class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload" wire:model="photos" name="photos" multiple>
            <button class="btn btn-primary" type="submit" id="inputGroupFileAddon04">Upload Pictures</button>
        </div>
        @error('photos.*') <span class="error">{{ $message }}</span> @enderror

    </form>


</div>
