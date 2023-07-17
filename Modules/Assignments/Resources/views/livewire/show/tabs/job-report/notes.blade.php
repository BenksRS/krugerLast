<div>


    @if(!$show)
        <button type="button" wire:click="showAdd" class="btn btn-sm btn-primary  waves-effect waves-light  me-2 float-end"> <i class="bx bx-file font-size-16 align-middle "></i> ADD</button>
    @endif
    <h4 class="card-title mb-4">Technician Notes</h4>
    <div class="card">
        <div class="card-body">




            @if($show)
                <div>
                    <div class="d-flex">
                        <textarea class="form-control  me-2" wire:model="notetext"  rows="5" placeholder="Enter note here..."></textarea>
                        <button type="button" {{(empty($this->notetext)) ?'disabled' : '' }} class="btn btn-success waves-effect waves-light  float-end" wire:click.prevent="addNewNoteTech"><i class="bx bx-save font-size-16 align-middle me-2"></i></button>
                    </div>
                    <br>
                </div>
            @endif
            <div class="scroolldiv">
                <ul class="list-group list-group-flush">

                    @if($notesListAll->isNotEmpty())
                        @foreach($notesListAll as $note)


                            <li class="list-group-item">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <h6>{{$note->user->name}}<small class="text-muted mb-0" > <i class="mdi mdi-clock-outline me-1"></i>{{$note->created_datetime}}</small></h6>

                                        <p class="text-muted"><small>{{$note->text}} </small></p>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    @else
                        <li class="list-group-item">
                            <div class="d-flex">
                                <div class="flex-grow-1">

                                    <h5 class="font-size-15 text-center not_found"> No notes for this referral..</h5>
                                </div>
                            </div>
                        </li>
                    @endif


                </ul>
            </div>
        </div>
    </div>
</div>
