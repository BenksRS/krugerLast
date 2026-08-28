<div>

   <form wire:submit.prevent="save">
      <div class="card">
         <div class="card-body">
            <h5 class="card-title mb-4">Estimate</h5>
            <div class="row mb-3">
               <label class="col-md-1 col-form-label">Tree Estimate</label>
               <div class="col-md-6 align-items-center d-flex">
                  <div class="form-check form-check-inline">
                     <input type="radio" wire:model="assignment.crane_needed" value="Y" class="form-check-input" id="crane_needed_y"> <label class="form-check-label" for="crane_needed_y">Yes</label>
                  </div>
                  <div class="form-check form-check-inline">
                     <input type="radio" wire:model="assignment.crane_needed" value="N" class="form-check-input" id="crane_needed_n"> <label class="form-check-label" for="crane_needed_n">No</label>
                  </div>
                  @error('assignment.crane_needed') <span class="text-danger d-block">{{ $message }}</span> @enderror
               </div>
            </div>

            @if($assignment->crane_needed === 'Y')
               <div class="row mb-3">
                  <label class="col-md-1 col-form-label">Crane Request</label>
                  <div class="col-md-4">
                     <input type="text" wire:model.debounce.500ms="assignment.crane_request" class="form-control" placeholder="Crane Request...">
                     @error('assignment.crane_request') <span class="text-danger">{{ $message }}</span> @enderror
                  </div>
               </div>

               <div class="row mb-3">
                  <label class="col-md-1 col-form-label">Crane Nadal</label>
                  <div class="col-md-4">
                     <input type="text" wire:model.debounce.500ms="assignment.crane_nadal" class="form-control" placeholder="Crane Nadal...">
                     @error('assignment.crane_nadal') <span class="text-danger">{{ $message }}</span> @enderror
                  </div>
               </div>
            @endif

            <div class="row mb-3">
               <label class="col-md-1 col-form-label">Crane Notes</label>
               <div class="col-md-6">
                  <textarea wire:model.debounce.500ms="assignment.crane_notes" class="form-control" rows="15" placeholder="Crane Notes..."></textarea>
                  @error('assignment.crane_notes') <span class="text-danger">{{ $message }}</span> @enderror
               </div>
            </div>

            @if($this->hasChanges)
               <div class="row">
                  <div class="col-md-7">
                     <button type="submit" class="btn btn-success float-end">Save</button>
                  </div>
               </div>
            @endif

         </div>
      </div>
   </form>
</div>