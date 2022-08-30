<x-layouts.app layout="horizontal">
    <!-- start page title -->

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{$page->title}}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">

                        <li class="breadcrumb-item"><a href="{{$page->back}}">{{$page->back_title}}</a></li>
                        <li class="breadcrumb-item active">{{$page->title}}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>


    @switch($type)
        @case('open')
            @livewire('dashboard::list.open', key('dash_list_open'))
        @break
        @case('readytobill')
            @livewire('dashboard::list.readytobill', key('dash_list_readytobill'))
        @break
        @case('collection')
            @livewire('dashboard::list.collection', key('dash_list_collection'))
        @break
        @case('takeactions')
        @livewire('dashboard::list.take-actions', key('dash_list_take_actions'))
        @break
        @case('followup')
        @livewire('dashboard::list.fallow-up', key('dash_list_followup'))
        @break
        @case('revisebill')
        @livewire('dashboard::list.revisebill', key('dash_list_followup'))
        @break
        @default
        <h3>OPPSSSS!!!! No list found!! </h3>
    @endswitch



</x-layouts.app>
