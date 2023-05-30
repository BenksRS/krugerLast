<div>

    <ul class="nav nav-pills nav-justified" role="tablist" >


        @foreach($navs as $nav)

            @if($url == 'profile')
                @if($nav['category'] == 'profile' )
                    <li class="nav-item waves-effect waves-light mx-2 card" wire:click="$emit('changeTab', '{{$nav['href']}}')">

                        <a class="nav-link {{($isActive == $nav['href']) ? 'active' : ''}}"   data-bs-toggle="tab" href="#{{$nav['href']}}" role="tab">

                            <span class="fw-bold">{{$nav['title']}}</span>
                        </a>
                    </li>
                @endif
            @else
                <li class="nav-item waves-effect waves-light mx-2 card" wire:click="$emit('changeTab', '{{$nav['href']}}')">

                    <a class="nav-link {{($isActive == $nav['href']) ? 'active' : ''}}"   data-bs-toggle="tab" href="#{{$nav['href']}}" role="tab">

                        <span class="fw-bold">{{$nav['title']}}</span>
                    </a>
                </li>
            @endif
        @endforeach
    </ul>


    {{--<!-- Tab panes -->--}}
    <div class="tab-content p-3 text-muted">
        @foreach($navs as $nav)
            @if($url == 'profile')
                @if($nav['category'] == 'profile' )

                    @if($isActive == $nav['href'])
                        <div class="tab-pane {{($isActive == $nav['href']) ? 'active' : ''}}" id="{{$nav['href']}}" role="tabpanel">
                            <div wire:loading class="row">
                                <div class="spinner-border text-primary " role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                            <div wire:loading.remove>
                                @livewire($nav['tab'], ['car' => $car->id], key($nav['key']))
                            </div>
                        </div>
                    @endif
                @endif
            @else
                @if($isActive == $nav['href'])
                    <div class="tab-pane {{($isActive == $nav['href']) ? 'active' : ''}}" id="{{$nav['href']}}" role="tabpanel">
                        <div wire:loading class="row">
                            <div class="spinner-border text-primary " role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        <div wire:loading.remove>
                            @livewire($nav['tab'], ['car' => $car->id], key($nav['key']))
                        </div>
                    </div>
                @endif

            @endif
        @endforeach
    </div>

</div>
