<div>
   <div class="card shadow-sm {{ $mode === 'idle' ? 'settings-disabled' : '' }}" data-component="settings">
      <div class="card-header border-bottom d-flex justify-content-between align-items-center px-3 py-3">
         <span class="text-uppercase fw-semibold">Team Settings</span>
         <button type="button" class="btn btn-success btn-label" wire:click="saveTeam" wire:loading.attr="disabled" wire:target="saveTeam" {{ !$this->isDirty ? 'disabled' : '' }}>
            <i class="bi bi-check2 label-icon"></i>Save
         </button>
      </div>
      <div class="card-body">
         <div class="mb-3">
            <div class="form-floating">
               <input type="text" class="form-control" id="floatingTeamName" placeholder="Team Name" wire:model="name">
               <label for="floatingTeamName">Team Name</label>
            </div>
            @error('name')
            <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
         </div>
         <hr>
         <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle mb-0">
               <thead class="table-light">
                  <tr class="text-secondary">
                     <th scope="col" class="p-3">Name</th>
                     <th scope="col" class="p-3 text-end" style="width: 80px;">Active</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($workers as $worker)
                     <tr>
                        <td class="px-3 border-top fw-bold">{{ $worker->user->name ?? '-' }}</td>
                        <td class="text-end px-3 border-top">
                           <div class="form-check form-switch d-inline-block mb-0">
                              <input class="form-check-input" type="checkbox" role="switch"
                                     id="switch-worker-{{ $worker->id }}"
                                     wire:click="toggleWorker({{ $worker->id }})"
                                {{ in_array($worker->id, $selectedWorkers) ? 'checked' : '' }}>
                           </div>
                        </td>
                     </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
      <div class="card-footer sticky-bottom bg-body border-top d-flex justify-content-between align-items-center py-3 px-3 shadow-sm" style="z-index: 10;">
         @if($team)
            <button type="button" class="btn btn-danger btn-label" wire:click="deleteTeam" wire:loading.attr="disabled" wire:target="deleteTeam">
               <i class="bi bi-trash label-icon"></i>Delete
            </button>
         @else
            <span></span>
         @endif
         <button type="button" class="btn btn-success btn-label" wire:click="saveTeam" wire:loading.attr="disabled" wire:target="saveTeam" {{ !$this->isDirty ? 'disabled' : '' }}>
            <i class="bi bi-check2 label-icon"></i>Save
         </button>
      </div>
   </div>
</div>