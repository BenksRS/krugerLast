<div>
   <div class="modal fade" id="modal-sick-leave" tabindex="-1" aria-labelledby="modal-sick-leave-label" aria-hidden="true" wire:ignore.self>
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h1 class="modal-title fs-5 w-100" id="modal-sick-leave-label">
                  {{ $sickLeave_id ? 'Editar Atestado' : 'Novo Atestado' }}
               </h1>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <form class="row g-3" wire:submit.prevent="save">
                  <div class="col-md-6">
                     <label for="SLStartDate" class="form-label">Start date</label>
                     <input type="date" class="form-control" id="SLStartDate" wire:model.defer="sickLeave.start_date">
                     @error('sickLeave.start_date') <span class="text-danger">{{ $message }}</span> @enderror
                  </div>
                  <div class="col-md-6">
                     <label for="SLDays" class="form-label">Days</label>
                     <input type="number" min="1" class="form-control" id="SLDays" wire:model.defer="sickLeave.days">
                     @error('sickLeave.days') <span class="text-danger">{{ $message }}</span> @enderror
                  </div>
                  <div class="col-12">
                     <label for="SLDescription" class="form-label">Description</label>
                     <textarea class="form-control" id="SLDescription" rows="3" wire:model.defer="sickLeave.description"></textarea>
                     @error('sickLeave.description') <span class="text-danger">{{ $message }}</span> @enderror
                  </div>
                  <div class="col-md-6">
                     <label for="SLStatus" class="form-label">Status</label>
                     <select class="form-control" id="SLStatus" wire:model.defer="sickLeave.status">
                        <option value="Y">Y</option>
                        <option value="N">N</option>
                     </select>
                     @error('sickLeave.status') <span class="text-danger">{{ $message }}</span> @enderror
                  </div>
                  <div class="col-md-6">
                     <label for="SLAttachment" class="form-label">File</label>
                     <input type="file" class="form-control" id="SLAttachment" wire:model="attachment">
                     @error('attachment') <span class="text-danger">{{ $message }}</span> @enderror
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
           const modal = new bootstrap.Modal('#modal-sick-leave', {})
           Livewire.on('openModal', data => modal.show())
           Livewire.on('hideModal', data => modal.hide())
       })
   </script>
@endpush