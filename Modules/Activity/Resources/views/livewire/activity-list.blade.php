<div>
   <div class="row">
      <div class="col-12">
         <div class="card">
            <div class="card-body">

               {{-- Keep the existing daily screen, and add a weekly screen alongside it. --}}
               <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                  <div>
                     <h5 class="fw-bold mb-1">Activity Logs</h5>
                     <div class="text-muted small">Review daily activity or weekly hours.</div>
                  </div>
                  <div class="btn-group" role="group" aria-label="Report period">
                     <button type="button"
                             class="btn btn-sm {{ $mode === 'daily' ? 'btn-primary' : 'btn-outline-primary' }}"
                             wire:click="setMode('daily')">Daily</button>
                     <button type="button"
                             class="btn btn-sm {{ $mode === 'weekly' ? 'btn-primary' : 'btn-outline-primary' }}"
                             wire:click="setMode('weekly')">Weekly</button>
                  </div>
               </div>

               @if($mode === 'daily')
                  <div class="d-flex flex-wrap align-items-center gap-3 mb-4">
                     <div class="btn-group" role="group" aria-label="Navigate days">
                        <button type="button" class="btn btn-primary btn-rounded"
                                wire:click="changeDate('prev')"
                                wire:loading.attr="disabled" wire:target="changeDate">
                           <i class="mdi mdi-chevron-left"></i>
                        </button>
                        <button type="button" class="btn btn-primary btn-rounded"
                                wire:click="changeDate('next')"
                                wire:loading.attr="disabled" wire:target="changeDate"
                          {{ $this->isToday ? 'disabled' : '' }}>
                           <i class="mdi mdi-chevron-right"></i>
                        </button>
                     </div>
                     <h5 class="m-0 fw-bold">
                        {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}
                        <span class="ms-1 text-secondary opacity-50 fw-normal">
                                    {{ \Carbon\Carbon::parse($date)->format('l') }}
                                </span>
                     </h5>
                  </div>

                  <div wire:loading.flex wire:target="changeDate,setMode"
                       class="align-items-center justify-content-center my-3">
                     <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                     </div>
                  </div>

                  <div class="table-responsive" wire:loading.remove wire:target="changeDate,setMode">
                     <table class="table table-striped table-bordered table-nowrap align-middle table-hover mb-0">
                        <thead>
                           <tr>
                              <th>User</th>
                              <th class="text-center" style="width:120px">Logs</th>
                              <th class="text-center">First Log</th>
                              <th class="text-center">Last Log</th>
                              <th class="text-center">Total Hours</th>
                              <th class="text-center">IP</th>
                           </tr>
                        </thead>
                        <tbody>
                           @forelse($logs as $log)
                              <tr>
                                 <td>
                                    <button type="button" class="btn btn-link p-0 fw-bold text-decoration-none"
                                            wire:click="showUserLogs({{ (int) $log->user_id }}, '{{ $date }}')">
                                       {{ optional($log->user)->name ?? 'N/A' }}
                                    </button>
                                 </td>
                                 <td class="text-center">{{ $log->total }}</td>
                                 <td class="text-center">
                                    {{ $log->first_log ? \Carbon\Carbon::parse($log->first_log)->format('m/d/Y H:i:s') : 'N/A' }}
                                 </td>
                                 <td class="text-center">
                                    {{ \Carbon\Carbon::parse($log->last_log)->format('m/d/Y H:i:s') }}
                                 </td>
                                 <td class="text-center">
                                    @if($log->first_log)
                                       @php
                                          $totalMinutes = \Carbon\Carbon::parse($log->first_log)
                                              ->diffInMinutes(\Carbon\Carbon::parse($log->last_log));
                                       @endphp
                                       {{ sprintf('%02d:%02d', intdiv($totalMinutes, 60), $totalMinutes % 60) }}
                                    @else
                                       N/A
                                    @endif
                                 </td>
                                 <td class="text-center">{{ $log->ip }}</td>
                              </tr>
                           @empty
                              <tr><td colspan="6" class="text-center text-muted py-4">No logs found for this date.</td></tr>
                           @endforelse
                        </tbody>
                     </table>
                  </div>
               @else
                  {{-- Example 1: week navigation with arrows. Example 2: pick any date in a week. --}}
                  <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
                     <div class="d-flex align-items-center gap-3">
                        <div class="btn-group" role="group" aria-label="Navigate weeks">
                           <button type="button" class="btn btn-primary btn-rounded"
                                   wire:click="changeWeek('prev')"
                                   wire:loading.attr="disabled" wire:target="changeWeek">
                              <i class="mdi mdi-chevron-left"></i>
                           </button>
                           <button type="button" class="btn btn-primary btn-rounded"
                                   wire:click="changeWeek('next')"
                                   wire:loading.attr="disabled" wire:target="changeWeek"
                             {{ $this->isCurrentWeek ? 'disabled' : '' }}>
                              <i class="mdi mdi-chevron-right"></i>
                           </button>
                        </div>
                        <div>
                           <h5 class="fw-bold mb-1">
                              {{ $weekStart->format('M d, Y') }} – {{ $weekEnd->format('M d, Y') }}
                           </h5>
                           <div class="small text-muted">Monday to Sunday</div>
                        </div>
                     </div>
                     <div>
                        <label for="activity-week-selector" class="form-label small fw-semibold mb-1">Jump to week</label>
                        <input id="activity-week-selector" type="date"
                               class="form-control form-control-sm"
                               style="min-width:175px"
                               max="{{ now()->toDateString() }}"
                               wire:model="weekDate">
                     </div>
                  </div>

                  <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-3">
                     <div class="btn-group" role="group" aria-label="Weekly report view">
                        <button type="button"
                                class="btn btn-sm {{ $weeklyView === 'all' ? 'btn-primary' : 'btn-outline-primary' }}"
                                wire:click="setWeeklyView('all')">All Users</button>
                        <button type="button"
                                class="btn btn-sm {{ $weeklyView === 'individual' ? 'btn-primary' : 'btn-outline-primary' }}"
                                wire:click="setWeeklyView('individual')">Individual User</button>
                     </div>
                     @if($weeklyView === 'individual')
                        <div style="min-width:240px;max-width:100%">
                           <label for="activity-weekly-user" class="form-label small fw-semibold mb-1">User</label>
                           <select id="activity-weekly-user" class="form-select form-select-sm"
                                   wire:model="selectedUserId">
                              <option value="">Select a user</option>
                              @foreach($userOptions as $option)
                                 <option value="{{ $option['id'] }}">{{ $option['name'] }}</option>
                              @endforeach
                           </select>
                        </div>
                     @endif
                  </div>

                  <div wire:loading.flex
                       wire:target="changeWeek,weekDate,setWeeklyView,selectedUserId,setMode"
                       class="align-items-center justify-content-center my-4">
                     <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                     </div>
                  </div>

                  <div wire:loading.remove
                       wire:target="changeWeek,weekDate,setWeeklyView,selectedUserId,setMode">
                     @if($weeklyView === 'all')
                        {{-- All users: seven day columns, plus weekly total. --}}
                        <div class="table-responsive">
                           <table class="table table-striped table-bordered table-nowrap align-middle table-hover mb-0">
                              <thead>
                                 <tr>
                                    <th>User</th>
                                    @foreach($weekDays as $weekDay)
                                       <th class="text-center">
                                          {{ $weekDay['label'] }}
                                          <div class="fw-normal text-muted small">{{ $weekDay['shortDate'] }}</div>
                                       </th>
                                    @endforeach
                                    <th class="text-center">Weekly Total</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 @forelse($weeklyRows as $user)
                                    <tr wire:key="weekly-user-{{ $user['id'] }}">
                                       <td class="fw-semibold">{{ $user['name'] }}</td>
                                       @foreach($user['days'] as $day)
                                          <td class="text-center">
                                             @if($day['hasLogs'])
                                                <button type="button"
                                                        class="btn btn-link text-decoration-none p-0"
                                                        title="View logs for {{ $day['fullDate'] }}"
                                                        wire:click="showUserLogs({{ $user['id'] }}, '{{ $day['date'] }}')">
                                                   {{ $day['hours'] }}
                                                </button>
                                             @else
                                                <span class="text-muted">—</span>
                                             @endif
                                          </td>
                                       @endforeach
                                       <td class="text-center fw-bold">{{ $user['totalHours'] }}</td>
                                    </tr>
                                 @empty
                                    <tr><td colspan="9" class="text-center text-muted py-4">No users with activity history found.</td></tr>
                                 @endforelse
                              </tbody>
                           </table>
                        </div>
                     @elseif($selectedWeeklyRow)
                        {{-- Individual: select one user; daily details and weekly total. --}}
                        <div class="row g-3 mb-3">
                           <div class="col-md-8">
                              <div class="bg-light rounded h-100 p-3 d-flex flex-column justify-content-center">
                                 <div class="small text-muted">Selected user</div>
                                 <div class="fw-bold fs-5">{{ $selectedWeeklyRow['name'] }}</div>
                                 <div class="small text-muted">{{ $selectedWeeklyRow['daysWithLogs'] }} day(s) with activity</div>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="bg-light rounded h-100 p-3 text-center">
                                 <div class="small text-muted">Weekly Total</div>
                                 <div class="fw-bold fs-3 text-primary">{{ $selectedWeeklyRow['totalHours'] }}</div>
                                 <div class="small text-muted">HH:MM</div>
                              </div>
                           </div>
                        </div>
                        <div class="table-responsive">
                           <table class="table table-striped table-bordered align-middle table-hover mb-0">
                              <thead>
                                 <tr>
                                    <th>Day</th>
                                    <th class="text-center">Hours</th>
                                    <th class="text-end">Activity</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 @foreach($selectedWeeklyRow['days'] as $day)
                                    <tr wire:key="individual-day-{{ $day['date'] }}">
                                       <td>{{ \Carbon\Carbon::parse($day['date'])->format('l, m/d/Y') }}</td>
                                       <td class="text-center fw-semibold">{{ $day['hours'] }}</td>
                                       <td class="text-end">
                                          @if($day['hasLogs'])
                                             <button type="button" class="btn btn-sm btn-link text-decoration-none p-0"
                                                     wire:click="showUserLogs({{ $selectedWeeklyRow['id'] }}, '{{ $day['date'] }}')">
                                                View {{ $day['logCount'] }} logs
                                             </button>
                                          @else
                                             <span class="text-muted">No logs</span>
                                          @endif
                                       </td>
                                    </tr>
                                 @endforeach
                              </tbody>
                              <tfoot>
                                 <tr>
                                    <th>Weekly Total</th>
                                    <th class="text-center">{{ $selectedWeeklyRow['totalHours'] }}</th>
                                    <th></th>
                                 </tr>
                              </tfoot>
                           </table>
                        </div>
                        @if($selectedWeeklyRow['incompleteDays'] > 0)
                           <div class="alert alert-warning py-2 mt-3 mb-0 small">
                              {{ $selectedWeeklyRow['incompleteDays'] }} day(s) have logs but no login event;
                              their hours could not be calculated and are excluded from the total.
                           </div>
                        @endif
                     @else
                        <div class="text-center text-muted border rounded py-5">
                           Select a user to view their daily hours and weekly total.
                        </div>
                     @endif
                  </div>
                  <div class="small text-muted mt-3">
                     Hours = time between the first login and last recorded event of each day.
                     A dash means no logs; N/A means logs exist but no login was recorded.
                     This is an activity span, not verified active working time.
                  </div>
               @endif
            </div>
         </div>
      </div>
   </div>
   {{-- The existing modal continues to show detailed logs when a user/day is clicked. --}}
   @livewire('activity::activity-user', key('activity_user'))
</div>