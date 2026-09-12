<div>
   <div class="d-flex align-items-center justify-content-between mb-3">
      <h5 class="mb-0">TEAM LIST</h5>
      <button type="button" class="btn btn-outline-primary btn-sm" wire:click="newTeam">
         <i class="bx bx-plus"></i> New Team
      </button>
   </div>

   <div class="row">
      @forelse($teams as $team)
         <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
               <div class="card-header d-flex align-items-center justify-content-between">
                  <span class="fw-bold"><i class="bx bx-group me-1"></i>{{ $team->name }}</span>
                  <button type="button" class="btn btn-outline-danger btn-sm" wire:click="deleteTeam({{ $team->id }})">
                     <i class="bx bx-trash"></i> Delete Team
                  </button>
               </div>
               <ul class="list-group list-group-flush">
                  @forelse($team->workers as $worker)
                     <li class="list-group-item d-flex align-items-center justify-content-between">
                        <span><i class="bx bx-menu me-2 text-muted"></i>{{ $worker->user->name ?? '-' }}</span>
                        <button type="button" class="btn btn-link text-danger p-0" wire:click="removeWorker({{ $worker->id }})">
                           <i class="bx bx-user-x"></i>
                        </button>
                     </li>
                  @empty
                     <li class="list-group-item text-muted">No workers assigned</li>
                  @endforelse
               </ul>
               <div class="card-footer text-end">
                  <button type="button" class="btn btn-outline-secondary btn-sm" wire:click="editTeam({{ $team->id }})">
                     <i class="bx bx-edit"></i> Edit Team
                  </button>
               </div>
            </div>
         </div>
      @empty
         <div class="col-12">
            <div class="alert alert-info">No teams created yet.</div>
         </div>
      @endforelse
   </div>
</div>