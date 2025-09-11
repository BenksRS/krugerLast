<div>
   @if($show)
      <div class="modal fade show d-block" tabindex="-1" role="dialog">
         <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title">
                     Logs {{ $userName ?? 'N/A' }} ({{ \Carbon\Carbon::parse($date)->format('m/d/Y') }})
                  </h5>
                  <button type="button" class="btn-close" wire:click="close"></button>
               </div>
               <div class="modal-body">
                  <div class="table-responsive">
                     <table class="table table-striped table-bordered table-nowrap align-middle">
                        <thead>
                           <tr>
                              <th width="100px" class="text-center">Event</th>
                              <th>URL</th>
                              <th width="120px">IP</th>
                              <th width="170px">Date</th>
                           </tr>
                        </thead>
                        <tbody>
                           @forelse($logs as $log)
                              <tr>
                                 <td class="text-center">{{ $log->event }}</td>
                                 <td>{{ $log->url }}</td>
                                 <td class="text-center">{{ $log->ip }}</td>
                                 <td class="text-center">{{ \Carbon\Carbon::parse($log->created_at)->format('m/d/Y H:i:s') }}</td>
                              </tr>
                           @empty
                              <tr>
                                 <td colspan="6" class="text-center text-muted">Nenhum log encontrado.</td>
                              </tr>
                           @endforelse
                        </tbody>
                     </table>
                  </div>
               </div>
               <div class="modal-footer d-flex justify-content-between">
                  <div>
                     {{ $logs->links() }}
                  </div>
                  <button type="button" class="btn btn-secondary" wire:click="close">Fechar</button>
               </div>
            </div>
         </div>
      </div>

      <!-- Backdrop -->
      <div class="modal-backdrop fade show"></div>
   @endif
</div>