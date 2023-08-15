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

                        <div class="car-btn-actions position-absolute">
                            <button type="button" class="btn btn-info file-zoom top-0 start-0" data-bs-toggle="modal"
                                data-bs-target="#file-zoom-{{ $type['key'] }}" data-file-id="{{ $file->id }}">
                                <i class="fa fa-search-plus"></i>
                            </button>
                            <button type="button" class="btn btn-danger file-delete top-0 end-0"
                                wire:click.prevent="deleteFile( {{ $file->id }} )">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                        <img src="{{ $file->path }}" class="car-file" id="file-path-{{ $file->id }}">
                    </div>
                @endforeach
            </div>

        </div>
    </div>

    <div class="modal" id="file-zoom-{{ $type['key'] }}">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="" class="img-fluid">
                </div>
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

        .car-btn-actions {
            left: 0.6em;
            right: 0.6em;
            top: 0.3em;
        }

        .car-btn-actions button {
            width: 3em;
            height: 3em;
            border-radius: 0.25rem;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            position: absolute
        }

        #file-zoom-{{ $type['key'] }} .modal-dialog .modal-body img {
            width: 100%;
            height: 100%;
        }
    </style>

    <script>
        const fileUploaded = 'file-uploaded-{{ $type['key'] }}';
        const modal = document.querySelector('#file-zoom-{{ $type['key'] }}');


        window.addEventListener(fileUploaded, () => {
            let inputFile = document.querySelector('#file-{{ $type['key'] }}-input');
            inputFile.value = '';
        })

        modal.addEventListener('show.bs.modal', (event) => {
            let button = event.relatedTarget;
            let fileId = button.getAttribute('data-file-id');
            let img = document.querySelector('#file-path-' + fileId);

            img.src = img.getAttribute('src');


            modal.querySelector('.modal-body').innerHTML = img.outerHTML;
        })
    </script>

</div>
