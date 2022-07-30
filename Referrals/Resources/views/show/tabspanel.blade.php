
<!-- Nav panes -->
<ul class="nav nav-pills nav-justified" role="tablist" >
    {{--kk--}}
    @foreach($navs as $nav)
        @if($nav['category'] == 'all' or $nav['category'] == $referral->referral_type_id)
        <li class="nav-item waves-effect waves-light mx-2 card">

            <a class="nav-link {{$nav['status']}}" data-bs-toggle="tab" href="#{{$nav['href']}}" role="tab">

                <span class="fw-bold">{{$nav['title']}}</span>
            </a>
        </li>
        @endif
    @endforeach
</ul>


<!-- Tab panes -->
<div class="tab-content p-3 text-muted">
    @foreach($navs as $nav)
        @if($nav['category'] == 'all' or $nav['category'] == $referral->referral_type_id)
        <div class="tab-pane {{$nav['status']}}" id="{{$nav['href']}}" role="tabpanel">
{{--            @include($nav['tab'])--}}



        </div>
        @endif
    @endforeach
</div>
