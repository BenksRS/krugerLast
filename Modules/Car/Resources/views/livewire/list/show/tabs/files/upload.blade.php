<div>
    <h4 class="card-title">{{ $type['name'] }}</h4>
    <div class="card">
        <div class="card-body">

            <form wire:submit.prevent="saveFiles">
                <div class="input-group mb-3">
                    <input type="file" wire:model="files" class="form-control" id="file-{{ $type['key'] }}-input"
                        multiple>
                    <button type="submit" class="btn btn-outline-secondary"
                        id="file-{{ $type['key'] }}-addon">Upload</button>
                </div>
            </form>

            <div class="row g-2">
                @foreach ($items as $file)
                    <div class="col-sm-2 position-relative">
                        <div class="position-absolute top-0 end-0 car-delete-button"
                            wire:click.prevent="deleteFile( {{ $file->id }} )">
                            <i class="fa fa-trash"></i>
                        </div>
                        <a href="{{ $file->path }}" class="image-popup-vertical-fit">
                            <img src="{{ $file->path }}" class="car-file" alt="">
                        </a>
                    </div>
                @endforeach
            </div>

        </div>
    </div>

    <style>
        .car-file {
            width: 100%;
            height: 220px;
            object-fit: cover;
            object-position: center;
        }

        .car-delete-button {
            width: 3em;
            height: 3em;
            background-color: var(--bs-danger);
            border-radius: 0.25rem;
            margin-right: 0.5em;
            margin-top: 0.25em;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
        }
    </style>

    <script>
        const fileUploaded = 'file-uploaded-{{ $type['key'] }}';


        window.addEventListener(fileUploaded, () => {
            let inputFile = document.querySelector('#file-{{ $type['key'] }}-input');
            inputFile.value = '';
        })
    </script>

</div>
