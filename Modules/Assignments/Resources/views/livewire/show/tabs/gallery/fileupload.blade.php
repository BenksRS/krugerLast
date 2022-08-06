<div>


    {{--    <form wire:submit.prevent="save" >--}}


    {{--        <div class="input-group">--}}
    {{--            <input type="file" class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload" wire:model="photos" name="photos" multiple>--}}
    {{--            <button class="btn btn-primary" type="submit" id="inputGroupFileAddon04">Upload Pictures</button>--}}
    {{--        </div>--}}
    {{--        <div wire:loading wire:target="photos">Uploading...</div>--}}
    {{--        @error('photos.*') <span class="error">{{ $message }}</span> @enderror--}}

    {{--    </form>--}}

    <form wire:submit.prevent="save" >

        <div class="input-group">
            <input type="file" class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload" wire:model="photos" name="photos" multiple>
            <button class="btn btn-primary" type="submit" id="inputGroupFileAddon04" wire:loading.attr="disabled" wire:target="photos">Upload Pictures</button>
        </div>

        @error('photos')
        <span class="error">{{ $message }}</span>
        @enderror

        <div wire:loading wire:target="photos"><i class="fa fa-spinner"></i> Uploading...</div>
        @if($photos)
            @foreach($photos as $photo)
                <img src="{{$photo->temporaryUrl()}}" width="100" height="100" style="opacity: 50%" alt="" class="m-2">
            @endforeach
        @endif

    </form>


</div>