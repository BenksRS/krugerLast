<div>
   <div class="row">
      <div class="col-12">
         <div class="card">
            <div class="card-body">

               <div class="row mb-4">
                  <div class="col-12">
                     <div class="d-flex flex-wrap text-center text-sm-start align-items-center p-2">

                        <!-- Botões de navegação -->
                        <div class="d-sm-flex flex-wrap gap-2">
                           <div class="btn-group" role="group" aria-label="Basic example">
                              <button type="button" class="btn btn-primary btn-rounded"
                                      wire:click.prevent="changeDate('prev')"
                                      wire:loading.attr="disabled" wire:target="changeDate">
                                 <i class="calendar-icon ic-arrow-line-left mdi mdi-chevron-left"></i>
                              </button>
                              <button type="button" class="btn btn-primary btn-rounded"
                                      wire:click.prevent="changeDate('next')"
                                      wire:loading.attr="disabled" wire:target="changeDate"
                                    {{ $this->isToday ? 'disabled' : '' }}>
                                 <i class="calendar-icon ic-arrow-line-right mdi mdi-chevron-right"></i>
                              </button>
                           </div>
                        </div>

                        <!-- Data formatada -->
                        <h5 class="m-0 ms-3 fw-bold">
                           {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}
                           <span class="ms-1 text-secondary opacity-50 fw-normal">{{ \Carbon\Carbon::parse($date)->format('l') }}</span>
                        </h5>

                     </div>
                  </div>
               </div>
               <div wire:loading.flex class="align-items-center justify-content-center">
                  <div class="spinner-border text-primary " role="status">
                     <span class="sr-only">Loading...</span>
                  </div>
               </div>

               <div class="table-responsive" wire:loading.remove wire:target="changeDate">
                  <table class="table table-striped table-bordered table-nowrap align-middle table-hover mb-0">
                     <thead>
                        <tr>
                           <th>User</th>
                           <th class="text-center" style="width: 120px;">Logs</th>
                           <th class="text-center">First Log</th>
                           <th class="text-center">Last Log</th>
                           <th class="text-center">IP</th>
                        </tr>
                     </thead>
                     <tbody>
                        @forelse($logs as $log)
                           <tr>
                              <td>
                                 <a href="javascript:void(0);"
                                    class="text-primary fw-bold"
                                    wire:click="$emit('openUserLogs', {{ $log->user_id }}, '{{ $log->user->name }}', '{{ $date }}')">
                                    {{ optional($log->user)->name ?? 'N/A' }}
                                 </a>
                              </td>
                              <td class="text-center">
                                 {{ $log->total }}
                              </td>
                              <td class="text-center">
                                 {{ \Carbon\Carbon::parse($log->first_log)->format('m/d/Y H:i:s') }}
                              </td>
                              <td class="text-center">
                                 {{ \Carbon\Carbon::parse($log->last_log)->format('m/d/Y H:i:s') }}
                              </td>
                              <td class="text-center">
                                 {{ $log->ip }}
                              </td>
                           </tr>
                        @empty
                           <tr>
                              <td colspan="5" class="text-center text-muted">
                                 Nenhum log encontrado para esta data.
                              </td>
                           </tr>
                        @endforelse
                     </tbody>
                  </table>
               </div>

               <div class="mt-3">
             {{--     {{ $logs->links() }}--}}
               </div>

            </div>
         </div>
      </div>
   </div>
   @livewire('activity::activity-user', key('activity_user'))
</div>