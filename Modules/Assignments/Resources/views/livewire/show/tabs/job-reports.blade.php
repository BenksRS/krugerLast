<div>
    <div class="row">
        <div class="col-lg-8">
            <h4 class="card-title mb-4">Job Report</h4>
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12">
                        <div class="mt-0">
                            <div class="accordion accordion-flush" id="accordionJobReports">
                                <?php $count = 0;?>
                                @if($this->noJob->isNotEmpty())
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="report-heading-nojob">
                                            <button class="accordion-button fw-medium 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#report-collapse-nojob" aria-expanded="true" aria-controls="report-collapse-nojob">
                                              No Job
                                            </button>
                                        </h2>
                                        <div id="report-collapse-nojob" class="accordion-collapse collapse show" aria-labelledby="report-heading-nojob" data-bs-parent="#accordionJobReports">


                                            <div class="row mt-2">
                                                <div class="col-lg-12">
                                                    <div class="table-responsive">
                                                        <table class="table mb-0">
                                                            <tbody>

                                                            <tr>
                                                                <th scope="row">No Job Info :</th>
                                                                <td colspan="5">
                                                                    @foreach($this->noJob as $note)

                                                                        <div class="d-flex">
                                                                            <div class="flex-grow-1">
                                                                                <h6>{{$note->user->name}}<small class="text-muted mb-0" > <i class="mdi mdi-clock-outline me-1"></i>{{$note->created_datetime}}</small></h6>

                                                                                <p class="text-muted"><small>{{$note->text}} </small></p>
                                                                            </div>
                                                                        </div>

                                                                    @endforeach
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <?php $count++?>
                                @endif

                                @foreach($assignment->job_types as $job_types)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="report-heading-{{$job_types->id}}">
                                            <button class="accordion-button fw-medium {{($count==0) ? ' ' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#report-collapse-{{$job_types->id}}" aria-expanded="{{($count==0) ? 'true' : 'false' }}" aria-controls="report-collapse-{{$job_types->id}}">
                                                {{$job_types->name}}
                                            </button>
                                        </h2>
                                        <div id="report-collapse-{{$job_types->id}}" class="accordion-collapse collapse {{($count==0) ? ' show' : ' ' }}" aria-labelledby="report-heading-{{$job_types->id}}" data-bs-parent="#accordionJobReports">
                                            @livewire($job_types->view, ['assignment' => $assignment->id, 'job_type' => $job_types->id], key("jobreport_$job_types->name"))
                                        </div>
                                    </div>
                                    <?php $count++?>
                                @endforeach
                            </div>
                            <!-- end accordion -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            @livewire('assignments::show.tabs.job-report.notes', ['assignment' => $assignment->id, 'job_type' => $job_types->id], key("jobreport_notes_tech"))
        </div>
    </div>
</div>
