<div>
    {{--{{$referral->type->name}}--}}{{--kk--}}
    <!-- Nav panes -->
    <ul class="nav nav-pills nav-justified" role="tablist" >

        @foreach($navs as $nav)
            @if($nav['category'] == 'all' || $nav['category'] == $referral->referral_type_id)
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
            @if($nav['category'] == 'all' || $nav['category'] == $referral->referral_type_id)
                @if($isActive == $nav['href'])
                    <div class="tab-pane {{($isActive == $nav['href']) ? 'active' : ''}}" id="{{$nav['href']}}" role="tabpanel">
                        <div wire:loading class="row">
                            <div class="spinner-border text-primary " role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        <div wire:loading.remove>
                            @livewire($nav['tab'], ['referral' => $referral->id], key($nav['key']))
                        </div>
                    </div>
                @endif
            @endif
        @endforeach
    </div>

</div>
