<div>
    <div class="row">

    @foreach($jobTypes as $js)


            @switch($js->id)
                @case(16)
                @case(17)

                @if(Auth::user()->id == 2  || Auth::user()->id == 10)
                    @if($jbSelectedSingle->isNotEmpty())
                        <div class="col-lg-5">
                            <div class="form-check form-check-left mb-3">
                                <label class="form-check-label {{ ($js->type == 'S') ? (($jbSelected->contains($js->id)) ? '' : 'label_disable') :''  }}"   for="{{$js->name}}{{$js->id}}">
                                    <input class="form-check-input check_types" type="checkbox" data-type="{{$js->type}}" wire:click="update({{$js->id}})"
                                            {{ ($jbSelected->contains($js->id)) ? 'checked' :''    }}  {{ ($js->type == 'S') ? (($jbSelected->contains($js->id)) ? '' : ' disabled="disabled"') :''  }} >

                                    {{$js->name}}
                                </label>
                            </div>
                        </div>
                    @else
                        <div class="col-lg-5">
                            <div class="form-check form-check-left mb-3">
                                <label class="form-check-label" for="{{$js->name}}{{$js->id}}">
                                    <input class="form-check-input check_types" type="checkbox" data-type="{{$js->type}}" wire:click="update({{$js->id}})"
                                            {{ ($jbSelected->contains($js->id)) ? 'checked' :'' }}  >

                                    {{$js->name}}
                                </label>
                            </div>
                        </div>
                    @endif


                @endif

                @default
                    @if($jbSelectedSingle->isNotEmpty())
                        <div class="col-lg-5">
                            <div class="form-check form-check-left mb-3">
                                <label class="form-check-label {{ ($js->type == 'S') ? (($jbSelected->contains($js->id)) ? '' : 'label_disable') :''  }}"   for="{{$js->name}}{{$js->id}}">
                                    <input class="form-check-input check_types" type="checkbox" data-type="{{$js->type}}" wire:click="update({{$js->id}})"
                                            {{ ($jbSelected->contains($js->id)) ? 'checked' :''    }}  {{ ($js->type == 'S') ? (($jbSelected->contains($js->id)) ? '' : ' disabled="disabled"') :''  }} >

                                    {{$js->name}}
                                </label>
                            </div>
                        </div>
                    @else
                        <div class="col-lg-5">
                            <div class="form-check form-check-left mb-3">
                                <label class="form-check-label" for="{{$js->name}}{{$js->id}}">
                                    <input class="form-check-input check_types" type="checkbox" data-type="{{$js->type}}" wire:click="update({{$js->id}})"
                                            {{ ($jbSelected->contains($js->id)) ? 'checked' :'' }}  >

                                    {{$js->name}}
                                </label>
                            </div>
                        </div>
                    @endif
                @break
            @endswitch






    @endforeach
    </div>
</div>
