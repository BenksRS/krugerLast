<div>
   <div class="modal fade" id="modal-rule" tabindex="-1" aria-labelledby="modal-rule-label" aria-hidden="true" wire:ignore.self>
      <div class="modal-dialog">
         <div class="modal-content">
            <form wire:submit.prevent="save">
               <div class="modal-header">
                  <h5 class="modal-title" id="modal-rule-label">
                     {{ $ruleId ? 'Edit Rule' : 'New Rule' }}
                  </h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                  <div class="row g-3">
                     <div class="col-md-12" wire:ignore>
                        <label class="form-label">Job Type</label>
                        <select
                          class="form-control" data-placeholder="Select..."
                          name="ruleData.job_type_id"
                          wire:model.defer="ruleData.job_type_id">
                           <option value="" selected>Select Job Type</option>
                           @foreach($jobTypes as $jobType)
                              <option value="{{ $jobType->id }}">{{ $jobType->name }}</option>
                           @endforeach
                        </select>
                        @error('ruleData.job_type_id') <span class="text-danger">{{ $message }}</span> @enderror
                     </div>
                     <div class="col-md-12" wire:ignore>
                        <label class="form-label">Referral</label>
                        <select
                          class="form-control" data-placeholder="Select..."
                          name="ruleData.referral_id"
                          wire:model.defer="ruleData.referral_id">
                           <option value="" selected>Select Referral</option>
                           @foreach($referrals as $referral)
                              <option value="{{ $referral->id }}">{{ $referral->company_entity }}</option>
                           @endforeach
                        </select>
                        @error('ruleData.referral_id') <span class="text-danger">{{ $message }}</span> @enderror
                     </div>
                     <div class="col-md-12" wire:ignore>
                        <label class="form-label">Carrier</label>
                        <select
                          class="form-control" data-placeholder="Select..."
                          name="ruleData.carrier_id"
                          wire:model.defer="ruleData.carrier_id">
                           <option value="" selected>Select Carrier</option>
                           @foreach($referrals as $referral)
                              <option value="{{ $referral->id }}">{{ $referral->company_entity }}</option>
                           @endforeach
                        </select>
                        @error('ruleData.carrier_id') <span class="text-danger">{{ $message }}</span> @enderror
                     </div>
                     <div class="col-md-12" wire:ignore>
                        <label class="form-label">Tag</label>
                        <select
                          class="form-control" data-placeholder="Select..."
                          name="ruleData.tag_id"
                          wire:model.defer="ruleData.tag_id">
                           <option value="" selected>Select Tag</option>
                           @foreach($tags as $tag)
                              <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                           @endforeach
                        </select>
                        @error('ruleData.tag_id') <span class="text-danger">{{ $message }}</span> @enderror
                     </div>
                     <div class="col-12" wire:ignore>
                        <label class="form-label">Note Text</label>
                        <textarea
                          class="form-control"
                          name="ruleData.note_text"
                          wire:model.defer="ruleData.note_text"
                          rows="4"></textarea>
                        @error('ruleData.note_text') <span class="text-danger">{{ $message }}</span> @enderror
                     </div>
                     <div class="col-md-12" wire:ignore>
                        <label class="form-label">Note Type</label>
                        <select
                          class="form-control" multiple data-placeholder="Select..."
                          name="ruleData.note_type"
                          wire:model.defer="ruleData.note_type"
                          multiple>
                           <option value="tech" selected>tech</option>
                           <option value="assignment">assignment</option>
                           <option value="finance">finance</option>
                           <option value="billing">billing</option>
                           <option value="payment">payment</option>
                           <option value="referral">referral</option>
                           <option value="no_job">no_job</option>
                           <option value="car">car</option>
                           <option value="nadal">nadal</option>
                        </select>
                        @error('ruleData.note_type') <span class="text-danger">{{ $message }}</span> @enderror
                     </div>
                     <div class="col-md-12">
                        <label class="form-label">Active?</label>
                        <select
                          class="form-control"
                          name="ruleData.active"
                          wire:model.defer="ruleData.active">
                           <option value="Y" selected>Yes</option>
                           <option value="N">No</option>
                        </select>
                        @error('ruleData.active') <span class="text-danger">{{ $message }}</span> @enderror
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-primary">Save</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>

@push('js')
   <script>
       document.addEventListener('livewire:load', function () {
           $('.select-filters').select2({}).on('change', function (e) {
               let name  = e.target.name
               let value = $(this).val()
           @this.set(name, value, true)
           });

 /*          Livewire.hook('message.processed', (message, component) => {
               $('.select-filters').select2({})
           });*/

           const modal = new bootstrap.Modal('#modal-rule', {})
           Livewire.on('openModal', data => modal.show())
           Livewire.on('hideModal', data => modal.hide())

           const modelEl = document.getElementById('modal-rule')
           modelEl.addEventListener('hidden.bs.modal', function (event) {

           })
       })
       $(document).ready(function() {
           $('.select2').select2({
               placeholder: "chose..."
           });

       });
   </script>
@endpush