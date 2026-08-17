<div wire:ignore>
   @php
      $grouped = $workers->groupBy(function($wk) {
          return $wk->team ?? 'no_team';
      });

      $teams = $grouped->filter(function($teamWorkers, $teamKey) {
          return $teamKey !== 'no_team';
      })->sortKeys();

      $noTeam = $grouped->get('no_team', collect());
   @endphp

   {{-- Times --}}
   <div class="row">
      @foreach($teams as $teamKey => $teamWorkers)
         <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card h-100 shadow-sm">
               <div class="card-header bg-dark text-white d-flex align-items-center justify-content-between">
                  <span class="fw-bold"><i class="bx bx-time-five me-1"></i> Team {{ $teamKey }}</span> <i class="bx bx-group"></i>
               </div>
               <div class="card-body p-0">
                  <ul class="list-group list-group-flush">
                     @foreach($teamWorkers as $wk)
                        <li class="list-group-item">
                           <div class="form-check form-checkbox-outline form-check-primary">
                              <input
                                class="form-check-input"
                                type="checkbox"
                                id="checkWorker{{ $wk->user->id }}"
                                wire:click="syncWorkers({{ $wk->user->id }})"
                                value="{{ $wk->user->id }}"
                                {{ ($workersDB && $workersDB->contains($wk->user->id)) ? 'checked' : '' }}
                              > <label class="form-check-label" for="checkWorker{{ $wk->user->id }}">
                                 {{ $wk->user->name }}
                              </label>
                           </div>
                        </li>
                     @endforeach
                  </ul>
               </div>
            </div>
         </div>
      @endforeach
   </div>

   {{-- Sem Time --}}
   @if($noTeam->isNotEmpty())
      <hr class="my-4">
      <div class="row">
         @foreach($noTeam as $wk)
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-4">
               <div class="card shadow-sm">
                  <div class="card-header bg-secondary text-white d-flex align-items-center justify-content-between">
                     <span class="fw-bold"><i class="bx bx-user me-1"></i>{{ $wk->user->name }}</span>
                  </div>
                  <div class="card-body p-0">
                     <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                           <div class="form-check form-checkbox-outline form-check-primary">
                              <input
                                class="form-check-input"
                                type="checkbox"
                                id="checkWorker{{ $wk->user->id }}"
                                wire:click="syncWorkers({{ $wk->user->id }})"
                                value="{{ $wk->user->id }}"
                                {{ ($workersDB && $workersDB->contains($wk->user->id)) ? 'checked' : '' }}
                              > <label class="form-check-label" for="checkWorker{{ $wk->user->id }}">
                                 {{ $wk->user->name }}
                              </label>
                           </div>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         @endforeach
      </div>
   @endif
</div>