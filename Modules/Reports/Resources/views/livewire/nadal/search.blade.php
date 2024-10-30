<div>
   <div class="card">
      <div class="card-body">
         <form class="row flex-xl-row flex-column align-items-center justify-content-end" method="post">

            <div class="col-sm-auto">
               <div class="input-daterange input-group" id="datepicker_dates"
                    data-date-autoclose="true" data-provide="datepicker" data-date-format="dd M, yyyy" data-date-container='#datepicker_dates'>
                  <input type="text" class="form-control" autocomplete="off"
                         placeholder="Start Date"
                         id="filter_dates_start"
                         name="filters.dates.start"
                  >
                  <input type="text" class="form-control" autocomplete="off"
                         placeholder="End Date"
                         id="filter_dates_end"
                         name="filters.dates.end"
                  >
               </div>
            </div>
            <div class="col-sm-auto hstack">
               <div class="vr"></div>
            </div>
            <div class="col-sm-3" wire:ignore>
               <select class="form-control select2 select2-multiple select-filters" multiple data-placeholder="Select..." name="filters.techs" wire:model.defer="filters.techs">
                  <option selected>Technician...</option>
                  @foreach($commissionsTechs as $tech)
                     <option value="{{$tech->id}}">{{$tech->name}}</option>
                  @endforeach
               </select>
            </div>
            <div class="col-sm-auto hstack">
               <div class="vr"></div>
            </div>
            <div class="col-sm-2" wire:ignore>
               <select class="form-control select2-multiple select-filters" multiple data-placeholder="Select..." name="filters.job_types" wire:model.defer="filters.job_types" >
                  <option selected>Job Type</option>
                  @foreach($jobTypes as $jobType)
                     <option value="{{$jobType->id}}">{{$jobType->name}}</option>
                  @endforeach
               </select>
            </div>
            <div class="col-sm-auto hstack">
               <div class="vr"></div>
            </div>
            <div class="col-sm-auto">
               <button class="btn btn-primary w-md" wire:loading.attr="disabled" wire:click.prevent="submit" wire:target="submit">
                  <i class="bx bx-search"></i> Filter
               </button>
            </div>
         </form>
      </div>
   </div>

   <div wire:loading.flex class="align-items-center justify-content-center">
      <div class="spinner-border text-primary " role="status">
         <span class="sr-only">Loading...</span>
      </div>
   </div>

   <div class="row" wire:loading.remove>
      <div class="col-12">
         <div class="card">
            <div class="card-header bg-transparent border-bottom text-uppercase px-4 py-3"></div>
            <div class="card-body overflow-auto" data-scroll-sync>
               <div class="table-responsive">
                  <table class="table table-bordered table-nowrap align-middle accordion table-accordion">
                     <thead>
                        <tr>
                           <th scope="col" width="50px"></th>
                           <th scope="col" width="100px" class="text-center">ID</th>
                           <th scope="col">Technician</th>
                           <th scope="col" width="150px" class="text-center">Total Jobs</th>
                           <th scope="col" width="200px" class="text-end">Total Commissions</th>
                        </tr>
                     </thead>
                     <tbody>
                        @forelse($listData as $key => $list)
                           <tr>
                              <td class="text-center" data-bs-toggle="collapse" data-bs-target="#r{{ $key }}" style="cursor: pointer; max-width: 50px; width: 50px">
                                 <i class="fas fa-plus"></i>
                              </td>
                              <td class="text-center"><p class="mb-0">{{ $key }}</p></td>
                              <td><p class="mb-0">{{ $list['tech']['name'] ?? '' }}</p></td>
                              <td class="text-center"><p class="mb-0">{{ $list['assignments']->count() ?? 0 }}</p></td>
                              <td class="text-end"><p class="mb-0">${{ $list['commissions']['total_commission'] ?? 0 }}</p></td>
                           </tr>
                           @if(!empty($list['assignments']))
                              <tr>
                                 <td colspan="8">
                                    <div class="table-responsive collapse accordion-collapse {{ $loop->first ? '' : '' }}"
                                         id="r{{ $key }}" data-bs-parent=".table-accordion">
                                       <table class="table table-bordered table-nowrap align-middle mb-0">
                                          <thead>
                                             <tr style="background-color:#f9f9f9;">
                                                <th width="150px" class="text-center">ID</th>
                                                <th width="150px" class="text-center">Assignment ID</th>
                                                <th width="150px" class="text-center">Technician</th>
                                                <th>Text</th>
                                                <th width="150px" class="text-end">Commission</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                             @foreach($list['assignments']->sortByDesc('commission') as $data)
                                                <tr>
                                                   <td class="text-center">{{ $data['id'] }}</td>
                                                   <td class="text-center">
                                                      <a target="_blank" href="{{ route('assignments.show', $data['assignment_id']) }}">#{{ $data['assignment_id'] }}</a>
                                                   </td>
                                                   <td class="text-center">{{ $data['user_name'] ?? 0 }}</td>
                                                   <td class="text-uppercase">{!! $data['text'] ?? ''!!}</td>
                              {{--                     <td class="text-center">
                                                      <span class="badge text-uppercase {{ $data['status'] }}" style="display: block; line-height: normal; padding: 7px">{{ $data['status'] }}</span>
                                                   </td>--}}
                                                   <td class="text-end">${{ $data['commission'] ?? 0 }}</td>
                     {{--                              <td class="text-center">{{ $data['due_month'] }}/{{ $data['due_year'] }}</td>--}}
                                                </tr>
                                             @endforeach
                                          </tbody>
                                       </table>
                                    </div>
                                 </td>
                              </tr>
                           @endif
                        @empty
                           <tr>
                              <td colspan="8" class="text-center">No data</td>
                           </tr>
                        @endforelse
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@push('css')
   <style>
       .datepicker > div {
           display : block;
       }
       select.form-control {
           appearance: auto;
       }
   </style>
@endpush
@push('js')
   <script>
       document.addEventListener('livewire:load', function () {

           $('.input-daterange').datepicker({
               format: 'dd M, yyyy',
           }).on('changeDate', function (e) {
               let date = e.date.toISOString().split('T')[0]
               let name = e.target.name;
               /*             let date = e.format();*/
               console.log('start', date, name)
               if (!name || !date) return;
               console.log('end', date, name)

           @this.set(`${ name }`, date, true);
           });


           $('.select-filters').select2({

           }).on('change', function (e) {
               let name  = e.target.name
               let value = $(this).val()
           @this.set(name, value, true)

           })
       })
   </script>
@endpush