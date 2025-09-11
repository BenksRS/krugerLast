<div>
   <div class="row">
      <div class="col-12">
         <div class="card">
            <div class="card-body">

               <div class="row mb-4">
                  <div class="col-12">
                     <div class="d-flex flex-wrap text-center text-sm-start align-items-center p-4">

                        <!-- Botões de navegação -->
                        <div class="d-sm-flex flex-wrap gap-2">
                           <div class="btn-group" role="group" aria-label="Basic example">
                              <button type="button" class="btn btn-primary btn-rounded"
                                      wire:click.prevent="previousDay">
                                 <i class="calendar-icon ic-arrow-line-left mdi mdi-chevron-left"></i>
                              </button>
                              <button type="button" class="btn btn-primary btn-rounded"
                                      wire:click.prevent="nextDay">
                                 <i class="calendar-icon ic-arrow-line-right mdi mdi-chevron-right"></i>
                              </button>
                           </div>
                        </div>

                        <!-- Data formatada -->
                        <h5 class="m-0 ms-3 fw-bold">
                           {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}
                           <span class="ms-1 text-secondary opacity-50 fw-normal">
               {{ \Carbon\Carbon::parse($date)->format('l') }}
            </span>
                        </h5>

                     </div>
                  </div>
               </div>


               <div class="table-responsive">
                  <table class="table align-middle table-nowrap table-hover mb-0">
                     <thead class="table-light">
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
                                 {{ optional($log->user)->name ?? 'N/A' }}
                              </td>
                              <td class="text-center">
                                 {{ $log->total }}
                              </td>
                              <td class="text-center">
                                 {{ $log->first_log }}
                              </td>
                              <td class="text-center">
                                 {{ $log->last_log }}
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
                  {{ $logs->links() }}
               </div>

            </div>
         </div>
      </div>
   </div>
</div>