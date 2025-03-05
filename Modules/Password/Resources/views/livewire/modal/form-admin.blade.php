<div>
    <div class="modal fade" id="modal-password" tabindex="-1" aria-labelledby="modal-password-label" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 w-100" id="modal-password-label">
                        <div style="min-height: 25px">
                            <span wire:loading.remove>#</span>
                        </div>
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3" wire:submit.prevent="save">
                        <div class="col-md-6">
                            <label for="PName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="PName" wire:model.defer="password.name">
                        </div>
                        <div class="col-md-6">
                            <label for="PUrl" class="form-label">URL</label>
                            <input type="text" class="form-control" id="PUrl" wire:model.defer="password.url">
                        </div>
                        <div class="col-6">
                            <label for="PUsername" class="form-label">Username</label>
                            <input type="text" class="form-control" id="PUsername" wire:model.defer="password.username">
                        </div>
                        <div class="col-6">
                            <label for="PPassword" class="form-label">Password</label>
                            <input type="text" class="form-control" id="PPassword" wire:model.defer="password.password">
                        </div>
        
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        document.addEventListener('livewire:load', function () {
            const modal = new bootstrap.Modal('#modal-password', {})
            Livewire.on('openModal', data => modal.show())
            Livewire.on('hideModal', data => modal.hide())
            
            const modelEl = document.getElementById('modal-password')
            modelEl.addEventListener('hidden.bs.modal', function (event) {
            
            })
        })
    </script>
@endpush
