<x-layouts.app layout="horizontal">
    {{--    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />--}}
    {{--    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>--}}

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
    @livewire('employees::show.header', ['user' => $user->id], key('employees_header'))

    @livewire('employees::show.tabs', ['user' => $user->id], key('employees_tab_panel'))


    @push('js')
        <script>
            var taskFlatpickrConfigDate = {
                enableTime: false,
                altInput: true,
                dateFormat: "Y-m-d",
                altFormat: "m\/d\/Y",
            };
            var taskFlatpickrConfigDateTime = {
                enableTime: true,
                altInput: true,
                dateFormat: "Y-m-d H:i",
                altFormat: "m\/d\/Y h:i K",
                time_24hr: false
            };

            function componentsLoadPage(){
                console.log('START components employees');
                $('.select2').select2();
                $('.dropzone').dropzone();
                $('.flatpickr_date').flatpickr(taskFlatpickrConfigDate);
                $('.flatpickr_datetime').flatpickr(taskFlatpickrConfigDateTime);
                console.log('END components employees')

            }
            document.addEventListener("DOMContentLoaded", () => {
                Livewire.hook('message.processed', (message, component) => {componentsLoadPage()})
            });
        </script>

    @endpush
</x-layouts.app>



