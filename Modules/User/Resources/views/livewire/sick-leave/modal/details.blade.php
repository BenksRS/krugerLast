<div>
   @if($show)
      <div class="modal fade show d-block" tabindex="-1" role="dialog">
         <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title">
                     Atestados de {{ $userName ?? 'N/A' }} ({{ now()->year }})
                     <span class="badge bg-{{ $daysUsed >= 3 ? 'danger' : 'success' }} ms-2">
                        {{ $daysUsed }}/3 days
                     </span>
                  </h5>
                  <button type="button" class="btn-close" wire:click="close"></button>
               </div>
               <div class="modal-body">

                  <div class="mb-3 text-end">
                     <button class="btn btn-success btn-label waves-light" type="button"
                             wire:click="$emit('sickLeaveForm', null, {{ $userId }})">
                        <i class="bx bx-plus label-icon"></i> New
                     </button>
                  </div>

                  <div class="table-responsive">
                     <table class="table table-striped table-bordered table-nowrap align-middle">
                        <thead>
                           <tr>
                              <th>Start date</th>
                              <th class="text-center">Days</th>
                              <th>Description</th>
                              <th class="text-center">Status</th>
                              <th></th>
                           </tr>
                        </thead>
                        <tbody>
                           @forelse($sickLeaves as $sickLeave)
                              <tr wire:key="sick-leave-{{ $sickLeave->id }}">
                                 <td>{{ $sickLeave->start_date_view }}</td>
                                 <td class="text-center">{{ $sickLeave->days }}</td>
                                 <td>{{ $sickLeave->description ?? '-' }}</td>
                                 <td class="text-center">
                                    @if($sickLeave->status == 'Y')
                                       <span class="badge bg-success">Y</span>
                                    @else
                                       <span class="badge bg-danger">N</span>
                                    @endif
                                 </td>
                                 <td class="text-center">
                                    <button class="btn btn-info btn-sm" type="button"
                                            wire:click="$emit('sickLeaveForm', {{ $sickLeave->id }}, {{ $userId }})">
                                       <i class="bx bx-edit"></i>
                                    </button>
                                 </td>
                              </tr>
                           @empty
                              <tr>
                                 <td colspan="5" class="text-center text-muted">No medical certificate found.</td>
                              </tr>
                           @endforelse
                        </tbody>
                     </table>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" wire:click="close">Fechar</button>
               </div>
            </div>
         </div>
      </div>

      <div class="modal-backdrop fade show"></div>
   @endif
</div>