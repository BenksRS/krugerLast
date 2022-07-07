<div>
    <h4 class="card-title mb-4">Collection info</h4>
    <div class="card" style="min-height: 170px">
        <div class="card-body">
            <div class="row">
            <div class="col-lg-7">
                <div class="text-muted mt-3">
                    <h6>Fallow up date:</h6>
                    <p>{{$assignment->follow_up_date}}</p>

                </div>
            </div>
            <div class="col-lg-5">
                <h7 class="mb-1 text-end">Collection Status:
                    <span class="badge {{$assignment->status_collection->class}}" style="font-weight:600;">{{$assignment->status_collection->name}}</span>
                </h7>
{{--                <button type="button" wire:click="showAdd" class="btn btn-sm btn-primary  waves-effect waves-light  me-2 float-end"> <i class="bx bx-flag font-size-16 align-middle "></i> </button>--}}
            </div>
        </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="text-muted mt-3">
                        <h6>Lien Date :</h6>
                        <p></p>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="text-muted mt-3">
                        <h6>Lien Info:</h6>
                        <p></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
