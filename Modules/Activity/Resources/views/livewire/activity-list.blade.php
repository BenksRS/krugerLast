<div>
   <div class="row">
      <div class="col-12">
         <div class="card">
            <div class="card-body">

               <div class="row">
                  <div class="col-12">
                     <div class="d-flex flex-wrap justify-content-between">

                        <div class="mb-3">
                           <h5 class="card-title mb-0">User Activity (Today)</h5>
                        </div>

                        <div class="mb-3 ms-auto">
                           <div class="btn-group">
                              <button type="button"
                                      class="btn btn-light btn-label waves-effect"
                                      wire:click="$refresh">
                                 <i class="bx bx-refresh label-icon"></i> Refresh
                              </button>
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
                                       Nenhum log encontrado para hoje.
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
   </div>
</div>