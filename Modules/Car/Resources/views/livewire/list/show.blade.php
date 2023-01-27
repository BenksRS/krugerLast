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
    @livewire('car::list.show.header', ['car' => $car->id], key('car_show_header'))

    @livewire('car::list.show.tabs', ['car' => $car->id], key('car_show_tabs'))

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
                console.log('START components');
                $('.select2').select2();
                $('.flatpickr_date').flatpickr(taskFlatpickrConfigDate);
                $('.flatpickr_datetime').flatpickr(taskFlatpickrConfigDateTime);
                console.log('END components')
            }
            document.addEventListener("DOMContentLoaded", () => {
                Livewire.hook('message.processed', (message, component) => {componentsLoadPage()})
            });
        </script>

    @endpush

</x-layouts.app>