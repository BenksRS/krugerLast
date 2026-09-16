<div>
   <div class="card teams" data-component="teams">
      <div class="card-header border-bottom d-flex justify-content-between align-items-center px-3 py-3">
         <span class="text-uppercase fw-semibold">Team List</span>
         <button type="button" class="btn btn-primary btn-label" wire:click="newTeam" wire:loading.attr="disabled" wire:target="newTeam">
            <i class="bi bi-plus-lg label-icon"></i>New Team
         </button>
      </div>
      <div class="card-body">
         <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @forelse($teams as $team)
               <div class="col">
                  <div class="card h-100 team shadow-sm m-0" data-component="team" wire:key="team-{{ $team->id }}">
                     <div class="card-header d-flex align-items-center py-3 px-3 bg-secondary  text-white">
                        <div class="d-flex align-items-center text-truncate">
                           <i class="bi bi-people-fill me-2 text-white"></i>
                           <span class="fw-semibold text-truncate">{{ $team->name }}</span>
                        </div>
                     </div>
                     <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                           @forelse($team->workers as $worker)
                              <li class="list-group-item p-0">
                                 <div class="hstack gap-0">
                                    <div class="px-4 py-3">
                                       <i class="bi bi-list text-secondary" style="cursor: grab;"></i>
                                    </div>
                                    <div class="vr"></div>
                                    <div class="px-3 py-3 me-auto">
                                       <span>{{ $worker->user->name ?? '-' }}</span>
                                    </div>
                                    <div class="vr"></div>
                                    <div class="px-4 py-3">
                                       <i class="bi bi-person-dash text-danger" role="button"
                                          wire:click="removeWorker({{ $worker->id }})"
                                          wire:loading.class="opacity-50 pe-none"
                                          wire:target="removeWorker({{ $worker->id }})"></i>
                                    </div>
                                 </div>
                              </li>
                           @empty
                              <li class="list-group-item text-muted">No workers assigned</li>
                           @endforelse
                        </ul>
                     </div>
                     <div class="card-footer d-flex justify-content-between align-items-center py-3 px-3">
                        <button type="button" class="btn btn-sm btn-danger btn-label" wire:click="deleteTeam({{ $team->id }})" wire:loading.attr="disabled" wire:target="deleteTeam({{ $team->id }})">
                           <i class="bi bi-trash label-icon"></i>Delete
                        </button>
                        <button type="button" class="btn btn-sm btn-secondary btn-label" wire:click="editTeam({{ $team->id }})" wire:loading.attr="disabled" wire:target="editTeam({{ $team->id }})">
                           <i class="bi bi-pencil label-icon"></i>Edit
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
   </div>
</div>