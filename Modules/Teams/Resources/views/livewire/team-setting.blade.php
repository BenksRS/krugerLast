<div>
   <div class="card">
      <div class="card-header d-flex align-items-center justify-content-between">
         <h5 class="mb-0">TEAM SETTINGS</h5>
         @if($team)
            <button type="button" class="btn btn-outline-danger btn-sm" wire:click="deleteTeam">
               <i class="bx bx-trash"></i> Delete Team
            </button>
         @endif
      </div>
      <div class="card-body">
         <div class="mb-3">
            <input type="text" class="form-control" placeholder="Team Name" wire:model="name">
            @error('name')
            <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
         </div>

         <hr>

         <label class="form-label">Workers</label>
         <div class="list-group list-group-flush">
            @foreach($workers as $worker)
               <div class="list-group-item d-flex align-items-center">
                  <div class="form-check form-switch me-2">
                     <input class="form-check-input" type="checkbox"
                            id="worker-{{ $worker->id }}"
                            wire:click="toggleWorker({{ $worker->id }})"
                       {{ in_array($worker->id, $selectedWorkers) ? 'checked' : '' }}>
                  </div>
                  <label class="form-check-label mb-0" for="worker-{{ $worker->id }}">
                     {{ $worker->user->name ?? '-' }}
                  </label>
               </div>
            @endforeach
         </div>
      </div>
      <div class="card-footer text-end">
         <button type="button" class="btn btn-outline-success btn-sm" wire:click="saveTeam" {{ !$this->isDirty ? 'disabled' : '' }}>
            <i class="bx bx-check"></i> Save Team
         </button>
      </div>
   </div>
</div>