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
    <!-- end page title -->

    <div class="row">
        <div class="col-lg-12 col-md-12">
    @livewire('employees::list', key('employees_list'))
        </div>
    </div>

</x-layouts.app>
