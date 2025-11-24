<div>
    <h4 class="card-title">{{ $type['name'] }}</h4>
    <div class="card">
        <div class="card-body">

            {{-- Formulário de Upload --}}
            <form wire:submit.prevent="saveFiles">
                <div class="input-group mb-3">
                    <input type="file" wire:model="files" class="form-control" id="file-{{ $type['key'] }}-input"
                           multiple>
                    <button type="submit" class="btn btn-outline-secondary"
                            id="file-{{ $type['key'] }}-addon">Upload</button>
                </div>
            </form>

            {{-- Área da Galeria --}}
            <div class="row g-2">
                @foreach ($items as $file)
                    <div class="col-sm-2 position-relative">

                        {{-- Detetar se é PDF --}}
                        @php
                            $isPdf = strpos($file->path, 'application/pdf') !== false;
                        @endphp

                        <div class="car-btn-actions position-absolute">
                            {{-- Botão de Zoom --}}
                            <button type="button" class="btn btn-info file-zoom top-0 start-0" data-bs-toggle="modal"
                                    data-bs-target="#file-zoom-{{ $type['key'] }}" data-file-id="{{ $file->id }}">
                                <i class="fa fa-search-plus"></i>
                            </button>

                            {{-- Botão de Apagar --}}
                            <button type="button" class="btn btn-danger file-delete top-0 end-0"
                                    wire:click.prevent="deleteFile( {{ $file->id }} )">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>

                        {{-- Exibição Condicional --}}
                        @if($isPdf)
                            {{-- Se for PDF: Mostra Ícone --}}
                            <div class="car-file d-flex flex-column justify-content-center align-items-center bg-light border"
                                 id="file-path-{{ $file->id }}"
                                 data-path="{{ $file->path }}">
                                <i class="fa fa-file-pdf-o fa-3x text-danger mb-2"></i>
                                <span class="text-muted fw-bold" style="font-size: 3.8em;">PDF</span>
                            </div>
                        @else
                            {{-- Se for Imagem: Mostra Foto --}}
                            <img src="{{ $file->path }}" class="car-file" id="file-path-{{ $file->id }}">
                        @endif

                    </div>
                @endforeach
            </div>

        </div>
    </div>

    {{-- Modal de Zoom --}}
    <div class="modal" id="file-zoom-{{ $type['key'] }}">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- O conteúdo aqui (img ou iframe) será injetado pelo JavaScript --}}
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

        /* Ajuste para o cursor na div do PDF */
        div.car-file {
            cursor: default;
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

        /* Ajustes do Modal */
        #file-zoom-{{ $type['key'] }} .modal-dialog .modal-body {
            padding: 0;
            text-align: center;
            background: #f8f9fa;
        }

        #file-zoom-{{ $type['key'] }} .modal-dialog .modal-body img {
            width: 100%;
            height: auto;
        }

        /* Classe para o visualizador de PDF */
        .pdf-viewer {
            width: 100%;
            height: 80vh;
            border: none;
        }
    </style>

    <script>
        const fileUploaded = 'file-uploaded-{{ $type['key'] }}';
        const modal = document.querySelector('#file-zoom-{{ $type['key'] }}');

        // Limpa o input após upload
        window.addEventListener(fileUploaded, () => {
            let inputFile = document.querySelector('#file-{{ $type['key'] }}-input');
            if(inputFile) inputFile.value = '';
        })

        // Lógica ao abrir o modal
        modal.addEventListener('show.bs.modal', (event) => {
            let button = event.relatedTarget;
            let fileId = button.getAttribute('data-file-id');

            // Procura o elemento na lista (pode ser IMG ou DIV)
            let sourceEl = document.querySelector('#file-path-' + fileId);

            // Tenta pegar o 'src' (imagem) ou 'data-path' (PDF)
            let filePath = sourceEl.getAttribute('src') || sourceEl.getAttribute('data-path');
            let modalBody = modal.querySelector('.modal-body');

            // Verifica se é PDF
            if (filePath && filePath.includes('application/pdf')) {
                // Injeta Iframe para PDF
                modalBody.innerHTML = `<iframe src="${filePath}" class="pdf-viewer"></iframe>`;
            } else {
                // Injeta Imagem normal
                modalBody.innerHTML = `<img src="${filePath}" class="img-fluid">`;
            }
        })
    </script>

</div>