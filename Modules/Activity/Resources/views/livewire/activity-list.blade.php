<div>
   <div class="row">
      <div class="col-12">
         <div class="card">
            <div class="card-body">
               {{-- The daily/weekly navigation and export always use the same selection. --}}
               <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
                  <div class="btn-group btn-group-sm" role="group" aria-label="Report view">
                     <button type="button"
                             class="btn {{ $viewMode === 'daily' ? 'btn-primary' : 'btn-outline-primary' }}"
                             wire:click="setViewMode('daily')">
                        Daily
                     </button>
                     <button type="button"
                             class="btn {{ $viewMode === 'weekly' ? 'btn-primary' : 'btn-outline-primary' }}"
                             wire:click="setViewMode('weekly')">
                        Weekly
                     </button>
                  </div>

                  <div class="d-flex align-items-center flex-wrap gap-2">
                     <div class="btn-group" role="group" aria-label="Change period">
                        <button type="button" class="btn btn-primary btn-sm btn-rounded"
                                wire:click="changeDate('prev')"
                                wire:loading.attr="disabled" wire:target="changeDate">
                           <i class="mdi mdi-chevron-left"></i>
                        </button>
                        <button type="button" class="btn btn-primary btn-sm btn-rounded"
                                wire:click="changeDate('next')"
                                wire:loading.attr="disabled" wire:target="changeDate"
                          {{ ! $this->canMoveNext ? 'disabled' : '' }}>
                           <i class="mdi mdi-chevron-right"></i>
                        </button>
                     </div>

                     <h5 class="m-0 fw-bold text-nowrap">
                        @if($viewMode === 'weekly')
                           {{ $start->format('M d, Y') }} – {{ $end->format('M d, Y') }}
                        @else
                           {{ $start->format('F d, Y') }}
                           <span class="ms-1 text-secondary opacity-50 fw-normal">
                                        {{ $start->format('l') }}
                                    </span>
                        @endif
                     </h5>

                     <input type="date" class="form-control form-control-sm"
                            aria-label="Choose date" style="max-width: 155px;"
                            wire:model.lazy="date" max="{{ now()->toDateString() }}">
                  </div>

                  <div class="dropdown">
                     <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button"
                             id="activityExportDropdown" data-bs-toggle="dropdown"
                             aria-expanded="false"
                             wire:loading.attr="disabled" wire:target="exportCsv">
                        <i class="bx bx-download align-middle me-1"></i> Export
                     </button>
                     <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="activityExportDropdown">
                        <li>
                           <button type="button" class="dropdown-item"
                                   wire:click="exportCsv('summary')"
                             {{ $missingUser ? 'disabled' : '' }}>
                              <i class="bx bx-table align-middle me-2"></i> Summary (CSV)
                           </button>
                        </li>
                        <li>
                           <button type="button" class="dropdown-item"
                                   wire:click="exportCsv('details')"
                             {{ $missingUser ? 'disabled' : '' }}>
                              <i class="bx bx-list-ul align-middle me-2"></i> Detailed Logs (CSV)
                           </button>
                        </li>
                     </ul>
                  </div>
               </div>

               @if(session()->has('activityExportError'))
                  <div class="alert alert-warning py-2" role="alert">
                     {{ session('activityExportError') }}
                  </div>
               @endif

               @if($viewMode === 'weekly')
                  <div class="d-flex flex-wrap align-items-end gap-3 mb-3">
                     <div>
                        <label class="form-label small text-muted mb-1" for="activityWeeklyMode">View</label>
                        <select class="form-select form-select-sm" id="activityWeeklyMode"
                                wire:model="weeklyMode">
                           <option value="all">All Users</option>
                           <option value="individual">Individual User</option>
                        </select>
                     </div>

                     @if($weeklyMode === 'individual')
                        <div wire:key="activity-weekly-user-select" style="min-width: 220px;">
                           <label class="form-label small text-muted mb-1" for="activityUserId">User</label>
                           <select class="form-select form-select-sm" id="activityUserId"
                                   wire:model="selectedUserId">
                              <option value="">Select a user...</option>
                              @foreach($users as $id => $name)
                                 <option value="{{ $id }}">{{ $name }}</option>
                              @endforeach
                           </select>
                        </div>
                     @endif
                  </div>
               @endif

               <div wire:loading.flex
                    wire:target="changeDate,date,setViewMode,weeklyMode,selectedUserId"
                    class="align-items-center justify-content-center py-4">
                  <div class="spinner-border text-primary" role="status">
                     <span class="visually-hidden">Loading...</span>
                  </div>
               </div>

               <div wire:loading.remove wire:target="changeDate,date,setViewMode,weeklyMode,selectedUserId">
                  @if($viewMode === 'daily')
                     <div class="table-responsive">
                        <table class="table table-striped table-bordered table-nowrap align-middle table-hover mb-0">
                           <thead>
                              <tr>
                                 <th>User</th>
                                 <th class="text-center">Logs</th>
                                 <th class="text-center">First Log</th>
                                 <th class="text-center">Last Log</th>
                                 <th class="text-center">Total Hours</th>
                                 <th class="text-center">IP</th>
                              </tr>
                           </thead>
                           <tbody>
                              @forelse($dailyRows as $row)
                                 <tr wire:key="daily-log-{{ $row['user_id'] }}">
                                    <td>
                                       <a href="javascript:void(0);" class="text-primary fw-bold"
                                          wire:click="openDayLogs({{ $row['user_id'] }}, '{{ $row['date'] }}')">
                                          {{ $row['user_name'] }}
                                       </a>
                                    </td>
                                    <td class="text-center">{{ $row['total'] }}</td>
                                    <td class="text-center">
                                       {{ $row['first_log'] ? \Carbon\Carbon::parse($row['first_log'])->format('m/d/Y H:i:s') : 'N/A' }}
                                    </td>
                                    <td class="text-center">
                                       {{ $row['last_log'] ? \Carbon\Carbon::parse($row['last_log'])->format('m/d/Y H:i:s') : 'N/A' }}
                                    </td>
                                    <td class="text-center fw-semibold">{{ $row['hours'] }}</td>
                                    <td class="text-center">{{ $row['ip'] ?? '—' }}</td>
                                 </tr>
                              @empty
                                 <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                       No logs found for this date.
                                    </td>
                                 </tr>
                              @endforelse
                           </tbody>
                        </table>
                     </div>
                  @elseif($weeklyMode === 'all')
                     <div class="table-responsive">
                        <table class="table table-striped table-bordered table-nowrap align-middle table-hover mb-0">
                           <thead>
                              <tr>
                                 <th>User</th>
                                 @foreach($weekDays as $day)
                                    <th class="text-center">
                                       {{ \Carbon\Carbon::parse($day)->format('D') }}<br>
                                       <small class="fw-normal text-muted">{{ \Carbon\Carbon::parse($day)->format('m/d') }}</small>
                                    </th>
                                 @endforeach
                                 <th class="text-center">Weekly Total</th>
                              </tr>
                           </thead>
                           <tbody>
                              @forelse($weeklyRows as $row)
                                 <tr wire:key="weekly-user-{{ $row['user_id'] }}">
                                    <td class="fw-semibold">{{ $row['user_name'] }}</td>
                                    @foreach($weekDays as $day)
                                       @php $record = $row['days'][$day]; @endphp
                                       <td class="text-center">
                                          @if($record && $record['first_log'] !== null)
                                             <a href="javascript:void(0);" class="text-primary"
                                                wire:click="openDayLogs({{ $row['user_id'] }}, '{{ $day }}')">
                                                {{ $record['hours'] }}
                                             </a>
                                          @else
                                             <span class="text-muted">—</span>
                                          @endif
                                       </td>
                                    @endforeach
                                    <td class="text-center fw-bold">{{ $row['hours'] }}</td>
                                 </tr>
                              @empty
                                 <tr>
                                    <td colspan="9" class="text-center text-muted py-4">
                                       No users available.
                                    </td>
                                 </tr>
                              @endforelse
                           </tbody>
                        </table>
                     </div>
                  @else
                     @if($missingUser)
                        <div class="text-center text-muted py-4">
                           Select a user to see their weekly activity.
                        </div>
                     @else
                        @forelse($weeklyRows as $row)
                           <div class="rounded border bg-light p-3 text-center mb-3">
                              <div class="text-muted small">{{ $row['user_name'] }} · Weekly Total</div>
                              <h3 class="fw-bold mb-0">{{ $row['hours'] }}</h3>
                           </div>
                           <div class="table-responsive">
                              <table class="table table-striped table-bordered table-hover align-middle mb-0">
                                 <thead>
                                    <tr>
                                       <th>Day</th>
                                       <th>Date</th>
                                       <th class="text-end">Total Hours</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    @foreach($weekDays as $day)
                                       @php $record = $row['days'][$day]; @endphp
                                       <tr wire:key="individual-day-{{ $row['user_id'] }}-{{ $day }}">
                                          <td>{{ \Carbon\Carbon::parse($day)->format('l') }}</td>
                                          <td>{{ \Carbon\Carbon::parse($day)->format('m/d/Y') }}</td>
                                          <td class="text-end fw-semibold">
                                             @if($record && $record['first_log'] !== null)
                                                <a href="javascript:void(0);" class="text-primary"
                                                   wire:click="openDayLogs({{ $row['user_id'] }}, '{{ $day }}')">
                                                   {{ $record['hours'] }}
                                                </a>
                                             @else
                                                <span class="text-muted">—</span>
                                             @endif
                                          </td>
                                       </tr>
                                    @endforeach
                                    <tr>
                                       <td colspan="2" class="fw-bold">Weekly Total</td>
                                       <td class="text-end fw-bold">{{ $row['hours'] }}</td>
                                    </tr>
                                 </tbody>
                              </table>
                           </div>
                        @empty
                           <div class="text-center text-muted py-4">No records found.</div>
                        @endforelse
                     @endif
                  @endif
               </div>

               <p class="small text-muted mt-3 mb-0">
                  Hours are counted from the first login at or after 06:00.
                  Intervals greater than 60 minutes between consecutive logs are excluded.
                  Detailed Logs export includes original events, including those before 06:00.
               </p>
            </div>
         </div>
      </div>
   </div>

   {{-- Existing detailed logs modal. --}}
   @livewire('activity::activity-user', key('activity_user'))
</div>