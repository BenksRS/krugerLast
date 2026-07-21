<div>
   <div class="row">
      <div class="col-12">
         <div class="card">

            <div class="card-body">

               <div class="row">
                  <div class="col-12">

                     <div class="table-responsive mt-3">
                        <table class="table table-hover table-bordered listtable mb-0 align-middle">
                           <thead>
                              <tr>
                                 <th scope="col" class="text-center">ID</th>
                                 <th scope="col">Nome</th>
                                 <th scope="col" class="text-center">Dias usados</th>
                                 <th scope="col"></th>
                              </tr>
                           </thead>
                           <tbody>
                              @forelse($employees as $employee)
                                 <tr wire:key="employee-{{ $employee->id }}">
                                    <td class="text-center" style="width: 100px">{{ $employee->id }}</td>
                                    <td>{{ $employee->name }}</td>
                                    <td class="text-center">
                                       {{ $employee->sick_days_used ?? 0 }}/3
                                    </td>
                                    <td style="width: 250px">
                                       <div class="d-flex gap-2">
                                          <button class="btn btn-info btn-label waves-light" type="button"
                                                  wire:click="$emit('sickLeaveDetails', {{ $employee->id }}, '{{ $employee->name }}')">
                                             <i class="bx bx-list-ul label-icon"></i> Ver atestados
                                          </button>
                                          <button class="btn btn-success btn-label waves-light" type="button"
                                                  wire:click="$emit('sickLeaveForm', null, {{ $employee->id }})">
                                             <i class="bx bx-plus label-icon"></i> Novo
                                          </button>
                                       </div>
                                    </td>
                                 </tr>
                              @empty
                                 <tr>
                                    <td colspan="4" class="text-center">
                                       No items found
                                    </td>
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

      @livewire('user::sick-leave.modal.details', key('sick-leave-details'))
      @livewire('user::sick-leave.modal.form', key('sick-leave-form'))
   </div>
</div>