<div>
    <h4 class="card-title">CHECK LIST</h4>
    <div class="card">
        <div class="card-body">
            <div class="row">
            @foreach ($options_chek as $op)
            <div class="col-md-2">
                <div class="mt-4">
                    <h5 class="font-size-14 mb-4">{{$op}}</h5>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="{{$op}}"  wire:model="{{$op}}"
                               wire:click="updateAll"       id="{{$op}}1" value="N" >
                        <label class="form-check-label" for="{{$op}}1">
                            No
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="{{$op}}"  wire:model="{{$op}}"
                               wire:click="updateAll"   id="{{$op}}2" value="Y" >
                        <label class="form-check-label" for="{{$op}}2">
                            Yes
                        </label>
                    </div>

                </div>
            </div>
            @endforeach
        </div>
        </div>
    </div>



    @foreach ($docs as $doc)
        @livewire('employees::show.tabs.docs.upload', ['type' => $doc, 'user' => $user->id], key('employees::docs.upload.' . $doc['key']))
    @endforeach
</div>