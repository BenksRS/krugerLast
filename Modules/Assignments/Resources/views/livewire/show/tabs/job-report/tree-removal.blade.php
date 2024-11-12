<div>
   <div class="card-body">

      @if(!$show)
         <div class="row">
            <div class="col-lg-12">
               <h5 class="card-title mt-4">Tree Size</h5>

               <form class="row gy-2 gx-3 align-items-center">
                  <div class="col-sm-auto">
                     <label class="visually-hidden" for="autoSizingInput">Length</label>
                     <div class="input-group">
                        <input type="number" min="0" class="form-control" id="autoSizingInputGroup" wire:model="length" placeholder="length">
                        <div class="input-group-text">ft</div>
                     </div>
                     @error('length')
                     <div class="invalid-feedback show">
                        Please input a number > 0.
                     </div>
                     @enderror
                  </div>
                  x
                  <div class="col-sm-auto">
                     <label class="visually-hidden" for="autoSizingInputGroup">Diameter</label>
                     <div class="input-group">
                        <input type="number" min="0" class="form-control" id="autoSizingInputGroup" wire:model="diameter" placeholder="diameter">
                        <div class="input-group-text">in</div>
                     </div>
                     @error('diameter')
                     <div class="invalid-feedback show">
                        Please input a number > 0.
                     </div>
                     @enderror
                  </div>
                  -
                  <div class="col-sm-auto">
                     <label class="visually-hidden" for="autoSizingInputGroup">Canopy</label>
                     <div class="input-group">
                        <input type="number" min="0" class="form-control" id="autoSizingInputGroup" wire:model="canopy" placeholder="canopy">
                        <div class="input-group-text">ft</div>
                     </div>
                     @error('canopy')
                     <div class="invalid-feedback show">
                        Please input a number > 0.
                     </div>
                     @enderror
                  </div>


                  <div class="col-sm-auto">
                     <button type="submit" wire:click.prevent="addTreeSize" class="btn btn-primary w-md">Add Tree Size</button>
                  </div>
               </form>
            </div>

            <!-- end col -->
            <div class="row mt-2">
               <div class="col-lg-12">
                  <hr>

                  @if($tsList->isNotEmpty())
                     @foreach($tsList as $ts)
                        <h5 class="text-end"> #{{$ts->length}} ft Length x {{$ts->diameter}} in Diameter - {{$ts->canopy}}ft Canopy
                           <a href="#" wire:click.prevent="deleteTreesize({{$ts->id}})" class="btn btn-danger btn-sm waves-effect waves-light"><i class="bx bx-trash"></i></a></h5>
                     @endforeach
                     {{--                            <h5 class="text-end"> Total Sqft Installed: {{$totalsqft}} sqft</h5>--}}
                  @else
                     <div class="alert alert-danger" role="alert">
                        No Tree size info added!
                     </div>
                  @endif


                  <hr>
               </div>
            </div>

            <div class="card-body">
               <div class="row">
                  <div class="col-lg-12">
                     <h5 class="card-title">Service Time:</h5>

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
                        <h5 class="font-size-14 mb-4">Did we haul or leave debris?</h5>
                        <div class="form-check mb-3">
                           <input class="form-check-input" type="radio" name="debris" wire:model="debris"
                                  id="formRadios1" value="leave"> <label class="form-check-label" for="formRadios1"> leave </label>
                        </div>
                        <div class="form-check">
                           <input class="form-check-input" type="radio" name="debris" wire:model="debris"
                                  id="formRadios2" value="haul"> <label class="form-check-label" for="formRadios2"> haul </label>
                        </div>
                        @error('debris')
                        <div class="invalid-feedback show">
                           Please select a valid option.
                        </div>
                        @enderror

                     </div>

                  </div>
                  @if($debris == 'haul')
                     <div class="col-md-3">
                        <div class="mb-3 mt-4">
                           <label for="formrow-firstname-input" class="form-label">How many loads?</label>
                           <input type="number" class="form-control" id="formrow-firstname-input" name="loads" wire:model="loads">
                        </div>
                        @error('loads')
                        <div class="invalid-feedback show">
                           Please input a number > 0.
                        </div>
                        @enderror
                     </div>
                  @endif
                  <div class="col-lg-12"><hr></div>
               </div>
               <div class="row d-none">
                  <div class="col-md-3">
                     <div class="mt-4">
                        <h5 class="font-size-14 mb-4">Did we use wood chipper?</h5>
                        <div class="form-check mb-3">
                           <input class="form-check-input" type="radio" name="wood_chipper" wire:model="wood_chipper"
                                  id="formRadios3" value="N"> <label class="form-check-label" for="formRadios3"> No </label>
                        </div>
                        <div class="form-check">
                           <input class="form-check-input" type="radio" name="wood_chipper" wire:model="wood_chipper"
                                  id="formRadios4" value="Y"> <label class="form-check-label" for="formRadios4"> Yes </label>
                        </div>
                        @error('wood_chipper')
                        <div class="invalid-feedback show">
                           Please select a valid option.
                        </div>
                        @enderror

                     </div>

                  </div>
                  <div class="col-lg-12"><hr></div>
               </div>
               <div class="row">
                  <div class="col-md-3">
                     <div class="mt-4">
                        <h5 class="font-size-14 mb-4">Did we use Crane?</h5>
                        <div class="form-check mb-3">
                           <input class="form-check-input" type="radio" name="crane" wire:model="crane"
                                  id="formRadios5" value="N"> <label class="form-check-label" for="formRadios5"> No </label>
                        </div>
                        <div class="form-check">
                           <input class="form-check-input" type="radio" name="crane" wire:model="crane"
                                  id="formRadios6" value="Y"> <label class="form-check-label" for="formRadios6"> Yes </label>
                        </div>
                        @error('crane')
                        <div class="invalid-feedback show">
                           Please select a valid option.
                        </div>
                        @enderror

                     </div>

                  </div>
                  @if($crane == 'Y')
                     <div class="col-md-3">
                        <div class="mb-3 mt-4">
                           <label for="formrow-crane_amount-input" class="form-label">Crane Amount</label>
                           <input type="text" class="form-control" id="formrow-crane_amount-input" name="crane_amount" wire:model="crane_amount">
                        </div>
                     </div>
                  @endif
                  <div class="col-lg-12"><hr></div>
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
                        @error('debris')
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
                           {{--                                    <div class="form-check">--}}
                           {{--                                        <input class="form-check-input" type="radio"  name="bobcat_type"  wire:model="bobcat_type"--}}
                           {{--                                               id="formRadios10" value="mini_skid_loader" >--}}
                           {{--                                        <label class="form-check-label" for="formRadios10">--}}
                           {{--                                            Mini Skid Loader--}}
                           {{--                                        </label>--}}
                           {{--                                    </div>--}}
                           @error('debris')
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
                  @endif
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
                        @error('debris')
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
                           {{--                                    <div class="form-check mb-3">--}}
                           {{--                                        <input class="form-check-input" type="radio" name="mini_type"  wire:model="mini_type"--}}
                           {{--                                               id="formRadios9" value="bobcat" >--}}
                           {{--                                        <label class="form-check-label" for="formRadios9">--}}
                           {{--                                            Bobcat--}}
                           {{--                                        </label>--}}
                           {{--                                    </div>--}}
                           <div class="form-check">
                              <input class="form-check-input" type="radio" name="mini_type" wire:model="mini_type"
                                     id="formRadios10" value="mini_skid_loader"> <label class="form-check-label" for="formRadios10"> Mini Skid Loader </label>
                           </div>
                           @error('debris')
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
                        @error('bobcat_hour')
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
                  <div class="col-xl-6 col-sm-6">
                     <label class="form-label">Workers</label>
                     <div class="row" wire:ignore>
                        @foreach($workers as $wk)
                           <div class="col-auto float-start">
                              <div class="form-check form-checkbox-outline form-check-primary mb-3">
                                 @if($workersDB)
                                    <input class="form-check-input" type="checkbox" id="checkWorker{{$wk->user->id}}" wire:click="syncWorkers({{$wk->user->id}})" value="{{$wk->user->id}}"  {{ $workersDB->contains($wk->user->id) ? 'checked=""' : '' }}">
                                 @else
                                    <input class="form-check-input" type="checkbox" id="checkWorker{{$wk->user->id}}" wire:click="syncWorkers({{$wk->user->id}})" value="{{$wk->user->id}}">
                                 @endif
                                 <label class="form-check-label" for="checkWorker{{$wk->user->id}}">
                                    {{$wk->user->name}}
                                 </label>
                              </div>
                           </div>
                        @endforeach
                     </div>

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


               </form>
            </div>
         </div>
      @else
         <div class="col-lg-12">
            <h5 class="card-title mt-4">Tree Size
               <button type="button" class="btn btn-info btn-sm float-end" wire:click="$emit('editReport', {{$jobType_id}})"><i class="fas fa-edit"></i> Edit</button>
               </h5>
         </div>
         <div class="row mt-2">
            <div class="col-lg-12">
               <hr>

               @if($tsList->isNotEmpty())
                  @foreach($tsList as $ts)
                     <h5 class="text-end"> #{{$ts->length}} ft Length x {{$ts->diameter}} in Diameter - {{$ts->canopy}}ft Canopy
                        <a href="#" wire:click.prevent="deleteTreesize({{$ts->id}})" class="btn btn-danger btn-sm waves-effect waves-light"><i class="bx bx-trash"></i></a></h5>
                  @endforeach

               @else
                  <div class="alert alert-danger" role="alert">
                     No Tree size added!
                  </div>
               @endif
               <hr>
            </div>
            <div class="col-lg-12">
               <h5 class="card-title mt-4">Service Time</h5>
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
                           <th scope="row">Did we haul or leave debris?</th>
                           <td>{{ $this->debris}}</td>

                           @if($this->debris == 'haul')
                              <th scope="row">How many loads?</th>
                              <td colspan="5">{{ $this->loads}} loads</td>
                           @else
                              <td colspan="5">
                           @endif
                        </tr>
                        <tr>
                           <th scope="row" class="d-none">Did we use wood chipper?</th>
                           <td class="d-none">{{($this->wood_chipper  == 'Y') ? 'Yes' : 'No'}}</td>


                           <th scope="row">Did we use Crane? :</th>
                           <td>{{($this->crane  == 'Y') ? 'Yes' : 'No'}}</td>

                           @if($this->crane == 'Y')
                              <th scope="row">Crane amount</th>
                              <td colspan="5">{{ $this->crane_amount}}</td>
                           @else
                              <td colspan="5">
                           @endif
                        </tr>
                        <tr>
                           <th scope="row">Did we use Bobcat?</th>
                           <td>{{($this->bobcat_use  == 'Y') ? 'Yes' : 'No'}}</td>
                           @if($this->bobcat_use == 'Y')
                              <th scope="row">Type?</th>
                              <td>{{$this->bobcat_type}}</td>
                              <th scope="row">How many hours :</th>
                              <td>{{$this->bobcat_hour}} hr</td>
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