<div>
   <h4 class="card-title mb-4">Collection info</h4>
   <div class="card" style="min-height: 170px">

      <div class="card-body">

         <div class="row">
            <div class="col-lg-7">
               <div class="text-muted">
                  @if($showFollowUp)
                     <h6>Follow up Date:
                        <button type="button" class="btn btn-primary btn-sm float-end" wire:click="toggleFollowup"><i class="fas fa-edit"></i> Edit</button>
                     </h6>
                     <p>{{$assignment->follow_up_date}}</p>
                  @else
                     <h6>Follow up Date:</h6>
                     <form action="" wire:submit.prevent="updateFollowup(Object.fromEntries(new FormData($event.target)))">
                        <div class="row">
                           <div class="col-md-12">
                              <div class="col-md-12 mt-2">
                                 <div class="input-group" id="service_date" wire:ignore>
                                    <x-flatpickr id="service_date" class="flatpickr_date" name="follow_up" wire:model="follow_up_date" value="{{$follow_up_date}}"/>
                                    <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
                                 </div>
                                 @error('service_date')
                                 <div class="invalid-feedback show">
                                    Please type a valid date.
                                 </div>
                                 @enderror
                              </div>
                              <div class="col-md-12 mt-2">
                                 <button type="button" class="btn btn-secondary btn-sm float-start m-1" wire:click="toggleFollowup"><i class="fas fa-chevron-left"></i> cancel</button>
                                 <button type="submit" class="btn btn-success btn-sm float-start m-1"><i class="fas fa-save"></i> save</button>
                              </div>
                           </div>
                        </div>
                     </form>
                  @endif
               </div>
            </div>
            <div class="col-lg-5">
               <h7 class="mb-1 text-end">Collection Status: <span class="badge {{$assignment->status_collection->class}}" style="font-weight:600;">{{$assignment->status_collection->name}}</span>
                  <div class="btn-group float-end">
                     <button type="button" class="btn btn-sm btn-secondary dropdown-toggle " data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                        <i class="bx bx-dots-horizontal align-middle"></i>
                     </button>
                     <ul class="dropdown-menu dropdown-menu-lg-end">
                        <li>
                           <button class="dropdown-item" wire:click="setCollectionStatus(9)" type="button">LIEN PLACED</button>
                        </li>
                        <li>
                           <button class="dropdown-item" wire:click="setCollectionStatus(19)" type="button">PENDING SOLUTION</button>
                        </li>
                        {{--                            <li><button class="dropdown-item" wire:click="setCollectionStatus(21)"  type="button">CALLED</button></li>--}}
                        <li>
                           <button class="dropdown-item" wire:click="setCollectionStatus(22)" type="button">PAYMENT AGREEMENT</button>
                        </li>
                        <li>
                           <button class="dropdown-item" wire:click="setCollectionStatus(25)" type="button">PAYMENT PLAN</button>
                        </li>
                        {{--<li><button class="dropdown-item" wire:click="setCollectionStatus(26)" type="button">NTO</button></li>--}}
                        <li>
                           <button class="dropdown-item" wire:click="setCollectionStatus(27)" type="button">LAWYER</button>
                        </li>
                        <li>
                           <button class="dropdown-item" wire:click="setCollectionStatus(28)" type="button">COLLECTION AGENCY</button>
                        </li>
                        {{--<li><button class="dropdown-item" wire:click="setCollectionStatus(29)" type="button">INCLUDED IN SS</button></li>--}}
                        <li>
                           <button class="dropdown-item" wire:click="setCollectionStatus(24)" type="button">CARRIER PAYMENT PENDING</button>
                        </li>
                        {{--                            <li><button class="dropdown-item" wire:click="setCollectionStatus(11)"  type="button">LEFT MESSAGE</button></li>--}}
                        <li>
                           <button class="dropdown-item" wire:click="setCollectionStatus(23)" type="button">COURT</button>
                        </li>
                        <li>
                           <button class="dropdown-item" wire:click="setCollectionStatus(30)" type="button">PAS</button>
                        </li>
                        <li>
                           <button class="dropdown-item" wire:click="setCollectionStatus(31)" type="button">DENIED CLAIM</button>
                        </li>
                        <li>
                           <button class="dropdown-item" wire:click="setCollectionStatus(32)" type="button">UNDER DEDUCTIBLE</button>
                        </li>
                        <li>
                           <button class="dropdown-item" wire:click="setCollectionStatus(33)" type="button">PAID TO THE INSURED</button>
                        </li>
                     </ul>
                  </div>
               </h7>
               {{--                <button type="button" wire:click="showAdd" class="btn btn-sm btn-primary  waves-effect waves-light  me-2 float-end"> <i class="bx bx-flag font-size-16 align-middle "></i> </button>--}}
            </div>
         </div>
         <div class="row">
            <div class="col-lg-7">
               <div class="text-muted">
                  @if($showProjectedLien)
                     <div class="row align-items-center" style="min-height: 27.06px">
                        <!-- Coluna esquerda: Texto + Checkbox -->
                        <div class="col-auto d-flex align-items-center">
                           <h6 class="mb-0">Projected Lien Date:</h6>
                           <div class="form-check ms-2">
                              <input type="checkbox" class="form-check-input" id="projectedLienActive"
                                     wire:click="toggleProjectedLienActive"
                                     @if($projected_lien_active === 'N') checked @endif>
                              <label class="form-check-label" for="projectedLienActive">N/A</label>
                           </div>
                        </div>

                        <!-- Coluna direita: Botão "Edit" -->
                        <div class="col text-end">
                           @if($projected_lien_active === 'Y')
                              <button type="button" class="btn btn-primary btn-sm" wire:click="toggleProjectedLien">
                                 <i class="fas fa-edit"></i> Edit
                              </button>
                           @endif
                        </div>
                     </div>
                        <p>{{$projected_lien_active === 'Y' ? $assignment->projected_lien_date_view : '-'}}</p>
                  @else
                     <h6>Projected Lien Date:</h6>
                     <form action="" wire:submit.prevent="updateProjectedLien(Object.fromEntries(new FormData($event.target)))">
                        <div class="row">
                           <div class="col-md-12">
                              <div class="col-md-12 mt-2">
                                 <div class="input-group" id="service_date" wire:ignore>
                                    <x-flatpickr id="service_date" class="flatpickr_date" name="projected_lien_date" wire:model="projected_lien_date" value="{{$projected_lien_date}}"/>
                                    <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
                                 </div>
                                 @error('service_date')
                                 <div class="invalid-feedback show">
                                    Please type a valid date.
                                 </div>
                                 @enderror
                              </div>
                              <div class="col-md-12 mt-2">
                                 <button type="button" class="btn btn-secondary btn-sm float-start m-1" wire:click="toggleProjectedLien"><i class="fas fa-chevron-left"></i> cancel</button>
                                 <button type="submit" class="btn btn-success btn-sm float-start m-1"><i class="fas fa-save"></i> save</button>
                              </div>
                           </div>
                        </div>
                     </form>
                  @endif
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-lg-5">
               <div class="text-muted mt-3">
                  <h6>Days from Billed:
                     @if(isset($assignment->finance->collection->days_from_billing))
                        <small class="text-muted">{{$assignment->finance->collection->days_from_billing }} days</small>
                     @endif
                  </h6>
               </div>


               <div class="text-muted mt-3">

                  <h6>Days from Service:
                     @if(isset($assignment->finance->collection->days_from_service))
                        <small class="text-muted"> {{$assignment->finance->collection->days_from_service }} days</small>
                     @endif
                  </h6>
               </div>
            </div>
            <div class="col-lg-7">
               <div class="text-muted mt-3">
                  @if($showLien)
                     <h6>Lien Date : <small class="text-muted">{{$assignment->lien_date_view}} </small>
                        <button type="button" class="btn btn-primary btn-sm float-end" wire:click="toggleLien"><i class="fas fa-edit"></i> Edit</button>
                     </h6>
                     <p></p>
                     <h6>Lien Info: <small class="text-muted"> {{$assignment->lien_info}}</small>
                     </h6>
                  @else
                     <h6>Lien Date:</h6>
                     <form action="" wire:submit.prevent="updateLien(Object.fromEntries(new FormData($event.target)))">
                        <div class="row">
                           <div class="col-md-12">
                              <div class="col-md-12 mt-2">
                                 <div class="input-group" id="service_date" wire:ignore>
                                    <x-flatpickr id="service_date" class="flatpickr_date" name="lien_date" wire:model="lien_date_m" value="{{$lien_date_m}}"/>
                                    <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
                                 </div>
                                 @error('service_date')
                                 <div class="invalid-feedback show">
                                    Please type a valid date.
                                 </div>
                                 @enderror
                              </div>
                              <div class="col-md-12 mt-2">
                                 <textarea class="form-control  me-2" name="lien_info" wire:model="lien_info" rows="5" placeholder="Enter note here..."></textarea>
                              </div>
                              <div class="col-md-12 mt-2">
                                 <button type="button" class="btn btn-secondary btn-sm float-start m-1" wire:click="toggleLien"><i class="fas fa-chevron-left"></i> cancel</button>
                                 <button type="submit" class="btn btn-success btn-sm float-start m-1"><i class="fas fa-save"></i> save</button>
                              </div>
                           </div>
                        </div>
                     </form>
                  @endif
               </div>
            </div>
         </div>

      </div>

   </div>

</div>