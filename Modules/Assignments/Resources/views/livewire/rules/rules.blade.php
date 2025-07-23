<div>
   <div class="row">
      <div class="col-12">
         <div class="card">

            <div class="card-body">

               <div class="row">
                  <div class="col-12">
                     <div class="d-flex flex-wrap justify-content-between">

                        <div class="mb-3 ms-auto">
                           <div class="btn-group">
                              <button class="btn btn-success btn-label waves-light" type="button"
                                      wire:click="$emit('ruleForm')">
                                 <i class="bx bx-plus label-icon"></i> New Rule
                              </button>
                           </div>
                        </div>
                     </div>
                  </div>

                  <form class="d-block">
                     <div class="position-relative col-lg-12">
                        <input type="text" class="form-control" placeholder="Search..." wire:model.debounce.500ms="search">
                     </div>
                  </form>

                  <div wire:loading.flex wire:target="search" class="justify-content-center mt-3">
                     <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                     </div>
                  </div>

                  <div class="table-responsive mt-3" wire:loading.remove wire:target="search">
                     <table class="table table-hover table-bordered listtable mb-0 align-middle">
                        <thead>
                           <tr>
                              <th scope="col" class="text-center">ID</th>
                              <th scope="col">Job Type</th>
                              <th scope="col">Referral</th>
                              <th scope="col">Carrier</th>
                              <th scope="col">Tag</th>
                              <th scope="col">Note Type</th>
                              <th scope="col">Active?</th>
                              <th scope="col"></th>
                           </tr>
                        </thead>
                        <tbody>
                           @forelse($rules as $rule)
                              <tr wire:key="rule-{{ $rule->id }}">
                                 <td class="text-center">{{ $rule->id }}</td>
                                 <td>{{ optional($rule->job_type)->name ?? '-' }}</td>
                                 <td>{{ optional($rule->referral)->company_entity ?? '-' }}</td>
                                 <td>{{ optional($rule->carrier)->company_entity ?? '-' }}</td>
                                 <td>{{ optional($rule->tag)->name ?? '-' }}</td>
                                 <td>
                                    @if(is_array($rule->note_type))
                                       {{ implode(', ', $rule->note_type) }}
                                    @else
                                       {{ $rule->note_type }}
                                    @endif
                                 </td>
                                 <td class="text-center">
                                    @if($rule->active == 'Y')
                                       <span class="badge bg-success">Yes</span>
                                    @else
                                       <span class="badge bg-danger">No</span>
                                    @endif
                                 </td>
                                 <td style="width: 150px">
                                    <button class="btn btn-primary btn-sm"
                                            wire:click="$emit('ruleForm', {{ $rule->id }})">
                                       <i class="bx bx-edit"></i> Edit
                                    </button>
                                    <button class="btn btn-danger btn-sm"
                                            wire:click="$emit('ruleDelete', {{ $rule->id }})">
                                       <i class="bx bx-trash"></i> Delete
                                    </button>
                                 </td>
                              </tr>
                           @empty
                              <tr>
                                 <td colspan="8" class="text-center">No rules found.</td>
                              </tr>
                           @endforelse
                        </tbody>
                     </table>
                  </div>

                  {{-- PAGINATION (if needed) --}}
                  {{-- <div class="mt-3">
                      {{ $rules->links() }}
                  </div> --}}

               </div>
            </div>
         </div>
      </div>
      @livewire('assignments::rules.rule-form', key('rule-modal-form'))
   </div>

</div>