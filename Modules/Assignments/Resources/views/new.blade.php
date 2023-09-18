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
    @livewire('assignments::new.new-assignment', key('assignments_new'))


    @push('js')
        <script>

            {{--var taskFlatpickrConfigDate = {--}}
            {{--    enableTime: false,--}}
            {{--    altInput: true,--}}
            {{--    dateFormat: "Y-m-d",--}}
            {{--    altFormat: "m\/d\/Y",--}}
            {{--};--}}
            {{--var taskFlatpickrConfigDateTime = {--}}
            {{--    enableTime: true,--}}
            {{--    altInput: true,--}}
            {{--    dateFormat: "Y-m-d H:i",--}}
            {{--    altFormat: "m\/d\/Y h:i K",--}}
            {{--    time_24hr: false--}}
            {{--};--}}
            {{--$('#date_start').on('change.datetimepicker', function (e){--}}
            {{--    let data = $(this).val();--}}
            {{--    @this.set('date_start', data);--}}
            {{--});--}}
            {{--$('#date_end').on('change.datetimepicker', function (e){--}}
            {{--    let data = $(this).val();--}}
            {{--    @this.set('date_end', data);--}}
            {{--});--}}
            {{--$('.select_referral').on('change', function (e){--}}
            {{--    let data = $(this).val();--}}
            {{--    @this.set('referralSelected', data);--}}
            {{--});--}}

            function componentsLoadPageADD(){
                console.log('START components ADD');
                {{--$('#date_start').on('change.datetimepicker', function (e){--}}
                {{--    let data = $(this).val();--}}
                {{--    @this.set('date_start', data);--}}
                {{--});--}}
                {{--$('#date_end').on('change.datetimepicker', function (e){--}}
                {{--    let data = $(this).val();--}}
                {{--    @this.set('date_end', data);--}}
                {{--});--}}
                {{--$('.select_referral').on('change', function (e){--}}
                {{--    let data = $(this).val();--}}
                {{--    @this.set('referralSelected', data);--}}
                {{--});--}}

                console.log('END components ADD')
            }
            document.addEventListener("DOMContentLoaded", () => {
                Livewire.hook('message.processed', (message, component) => {componentsLoadPageADD()})
            });
        </script>
    @endpush

</x-layouts.app>
