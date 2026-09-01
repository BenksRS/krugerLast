<div>
   <div class="card-body">

      @if(!$show)
         <div class="row">
            <div class="col-lg-12">
               <h5 class="card-title mt-4">Service Time:</h5>

               <form action="" wire:submit.prevent="addServiceTime(Object.fromEntries(new FormData($event.target)))">

                  <div class="col-lg-3 float-start">
                     <div class="mt-2">
                        <label>Start Date:</label>
                        <div class="input-group" id="start_date" wire:ignore>
                           <x-flatpickr id="service_date" class="flatpickr_datetime" name="start_date" value=""/>
                           <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
                        </div>

                        @error('start_date')
                        <div class="invalid-feedback show">
                           Please type a valid date.
                        </div>
                        @enderror
                     </div>
                  </div>

                  <div class="col-lg-3 float-start">
                     <div class="col-md-12 mt-2">
                        <label>End Date:</label>
                        <div class="input-group" id="end_date" wire:ignore>
                           <x-flatpickr id="end_date" class="flatpickr_datetime" name="end_date" value=""/>
                           <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
                        </div>

                        @error('end_date')
                        <div class="invalid-feedback show">
                           Please type a valid date.
                        </div>
                        @enderror
                     </div>
                  </div>
                  <div class="col-lg-3 float-start mt-2">
                     <div class="mb-3">
                        <label for="formrow-firstname-input" class="form-label">How many workers?</label>
                        <input type="number" class="form-control" id="formrow-firstname-input" name="many_workers" wire:model="many_workers">
                        @error('many_workers')
                        <div class="invalid-feedback show">
                           Please input a number > 0.
                        </div>
                        @enderror
                     </div>

                  </div>
                  <div class="col-lg-auto float-start mt-4">
                     <div class="mb-3  mt-2" style="margin-left: 5px;">
                        <button type="submit" class="btn btn-primary w-md">Add Service Time</button>
                     </div>
                  </div>

               </form>
            </div>

            <div class="row mt-2">
               <div class="col-lg-12">
                  <hr>

                  @if($serviceList->isNotEmpty())
                     @foreach($serviceList as $sl)
                        <h5 class="text-end"> # Start {{$sl->start_date_view}} To {{$sl->end_date_view}} With {{$sl->workers}} workers
                           <a href="#" wire:click.prevent="deleteServicetime({{$sl->id}})" class="btn btn-danger btn-sm waves-effect waves-light"><i class="bx bx-trash"></i></a></h5>
                     @endforeach
                  @else
                     <div class="alert alert-danger" role="alert">
                        No Service time added!
                     </div>
                  @endif

                  <hr>
               </div>
            </div>

            <div class="row">
               <div class="col-md-3">
                  <div class="mt-4">
                     <h5 class="font-size-14 mb-4">Did we use Bobcat ?</h5>
                     <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="bobcat_use" wire:model="bobcat_use"
                               id="formRadios7" value="N"> <label class="form-check-label" for="formRadios7"> No </label>
                     </div>
                     <div class="form-check">
                        <input class="form-check-input" type="radio" name="bobcat_use" wire:model="bobcat_use"
                               id="formRadios8" value="Y"> <label class="form-check-label" for="formRadios8"> Yes </label>
                     </div>
                     @error('bobcat_use')
                     <div class="invalid-feedback show">
                        Please select a valid option.
                     </div>
                     @enderror

                  </div>

               </div>
               @if($bobcat_use == 'Y')
                  <div class="col-md-3">
                     <div class="mt-4">
                        <h5 class="font-size-14 mb-4">Type?</h5>
                        <div class="form-check mb-3">
                           <input class="form-check-input" type="radio" name="bobcat_type" wire:model="bobcat_type"
                                  id="formRadios9" value="bobcat"> <label class="form-check-label" for="formRadios9"> Bobcat </label>
                        </div>
                        @error('bobcat_type')
                        <div class="invalid-feedback show">
                           Please select a valid option.
                        </div>
                        @enderror

                     </div>

                  </div>
                  <div class="col-md-3">
                     <div class="mb-3 mt-4">
                        <label for="formrow-firstname-input" class="form-label">How many hours Bobcat?</label>
                        <input type="number" class="form-control" id="formrow-firstname-input" name="bobcat_hour" wire:model="bobcat_hour">
                     </div>
                     @error('bobcat_hour')
                     <div class="invalid-feedback show">
                        Please input a number > 0.
                     </div>
                     @enderror
                  </div>
                  <div class="col-md-3">
                     <div class="mb-3 mt-4">
                        <label for="formrow-firstname-input" class="form-label">How many hours Bobcat Travel?</label>
                        <input type="number" class="form-control" id="formrow-firstname-input" name="travel_bobcat" wire:model="travel_bobcat">
                     </div>
                     @error('travel_bobcat')
                     <div class="invalid-feedback show">
                        Please input a number > 0.
                     </div>
                     @enderror
                  </div>
               @endif
               <div class="col-lg-12"><hr></div>
            </div>

            {{--                    // mini --}}
            <div class="row">
               <div class="col-md-3">
                  <div class="mt-4">
                     <h5 class="font-size-14 mb-4">Did we use Mini Skid loader ?</h5>
                     <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="mini_use" wire:model="mini_use"
                               id="formRadios17" value="N"> <label class="form-check-label" for="formRadios17"> No </label>
                     </div>
                     <div class="form-check">
                        <input class="form-check-input" type="radio" name="mini_use" wire:model="mini_use"
                               id="formRadios18" value="Y"> <label class="form-check-label" for="formRadios18"> Yes </label>
                     </div>
                     @error('mini_use')
                     <div class="invalid-feedback show">
                        Please select a valid option.
                     </div>
                     @enderror

                  </div>

               </div>
               @if($mini_use == 'Y')
                  <div class="col-md-3">
                     <div class="mt-4">
                        <h5 class="font-size-14 mb-4">Type?</h5>
                        <div class="form-check">
                           <input class="form-check-input" type="radio" name="mini_type" wire:model="mini_type"
                                  id="formRadios10" value="mini_skid_loader"> <label class="form-check-label" for="formRadios10"> Mini Skid Loader </label>
                        </div>
                        @error('mini_type')
                        <div class="invalid-feedback show">
                           Please select a valid option.
                        </div>
                        @enderror

                     </div>

                  </div>
                  <div class="col-md-3">
                     <div class="mb-3 mt-4">
                        <label for="formrow-firstname-input" class="form-label">How many hours Mini Bobcat?</label>
                        <input type="number" class="form-control" id="formrow-firstname-input" name="mini_hour" wire:model="mini_hour">
                     </div>
                     @error('mini_hour')
                     <div class="invalid-feedback show">
                        Please input a number > 0.
                     </div>
                     @enderror

                     <div class="mb-3">
                        <label for="formrow-firstname-input" class="form-label">How many hours Mini Bobcat Travel?</label>
                        <input type="number" class="form-control" id="formrow-firstname-input" name="travel_miniskid" wire:model="travel_miniskid">
                     </div>
                     @error('travel_miniskid')
                     <div class="invalid-feedback show">
                        Please input a number > 0.
                     </div>
                     @enderror
                  </div>
               @endif
            </div>
            <div class="col-lg-12">
               <hr>
            </div>

            <div class="row">
               <div class="col-xl-12 col-sm-12">
                  <label class="form-label">Workers</label>
                  @include('assignments::livewire.show.tabs.job-report.partials.workers')

                  @if(count($workersDB) == 0)
                     <div class="invalid-feedback show">
                        Please select a worker valid option.
                     </div>
                  @endif
               </div>
               <hr>
            </div>
            <div class="row">
               <div class="col-xl-12 col-sm-12">
                  <div class="mb-3">
                     <label class="form-label mt-2">Job Info:</label> <textarea id="textarea" class="form-control" rows="6" wire:model="job_info" name="job_info"
                                                                                placeholder="Job info here limit of 225 chars."></textarea>
                  </div>
               </div>

               <div class="col-xl-12 col-sm-12">
                  <button type="submit" class="btn  btn-primary w-md pull-right" wire:click.prevent="saveReport">Save</button>
               </div>
            </div>

         </div>
      @else
         <div class="row mt-2">
            <div class="col-lg-12">
               <h5 class="card-title mt-4">Service Time
                  <button type="button" class="btn btn-info btn-sm float-end" wire:click="$emit('editReport', {{$jobType_id}})"><i class="fas fa-edit"></i> Edit</button>
               </h5>
               <hr>
               @if($serviceList->isNotEmpty())
                  @foreach($serviceList as $sl)
                     <h5 class="text-end"> # Start {{$sl->start_date_view}} To {{$sl->end_date_view}} With {{$sl->workers}} workers
                        <a href="#" wire:click.prevent="deleteServicetime({{$sl->id}})" class="btn btn-danger btn-sm waves-effect waves-light"><i class="bx bx-trash"></i></a></h5>
                  @endforeach
               @else
                  <div class="alert alert-danger" role="alert">
                     No Service time added!
                  </div>
               @endif
               <hr>
            </div>
         </div>
         <div class="row mt-2">
            <div class="col-lg-12">
               <div class="table-responsive">
                  <table class="table  mb-0">
                     <tbody>
                        <tr>
                           <th scope="row">Did we use Bobcat?</th>
                           <td>{{($this->bobcat_use  == 'Y') ? 'Yes' : 'No'}}</td>
                           @if($this->bobcat_use == 'Y')
                              <th scope="row">Type?</th>
                              <td>{{$this->bobcat_type}}</td>
                              <th scope="row">How many hours :</th>
                              <td>{{$this->bobcat_hour}} hr</td>
                              <th scope="row">Bobcat Travel hours :</th>
                              <td>{{$this->travel_bobcat}} hr</td>
                           @else
                              <td colspan="5">
                           @endif

                        </tr>
                        <tr>
                           <th scope="row">Did we use Mini Bobcat?</th>
                           <td>{{($this->mini_use  == 'Y') ? 'Yes' : 'No'}}</td>
                           @if($this->mini_use == 'Y')
                              <th scope="row">Type?</th>
                              <td>{{$this->mini_type}}</td>
                              <th scope="row">How many hours :</th>
                              <td>{{$this->mini_hour}} hr</td>
                              <th scope="row">Mini Bobcat Travel hours :</th>
                              <td>{{$this->travel_miniskid}} hr</td>
                           @else
                              <td colspan="5">
                           @endif

                        </tr>
                        <tr>
                           <th scope="row">Workers :</th>
                           <td colspan="5">
                                   <?php $count = 0; ?>
                              @foreach($workersSelected as $work)
                                       <?php $count++; ?>
                                 @if($count == 1)
                                    {{$work->name}}
                                 @else
                                    {{" , $work->name"}}
                                 @endif
                              @endforeach
                           </td>
                        </tr>
                        <tr>
                           <th scope="row">Job Info :</th>
                           <td colspan="5">
                              {{$jobReport->job_info}}
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </div>

            </div>
         </div>
      @endif
      @push('js')
      @endpush
   </div>
</div>