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
        @livewire('referrals::show.actions', ['referral' => $referral->id], key('referral_actions'))

        @livewire('referrals::show.header', ['referral' => $referral->id], key('referral_header'))

        @livewire('referrals::show.tabs-panel', ['referral' => $referral->id], key('referral_tab_panel'))


    @push('js')
        <!-- Required datatable js -->
            <script src="{{ themes('libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
            <script src="{{ themes('libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
            <!-- Buttons examples -->
            <script src="{{ themes('libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
            <script src="{{ themes('libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
            <script src="{{ themes('libs/jszip/jszip.min.js') }}"></script>
            <script src="{{ themes('libs/pdfmake/build/pdfmake.min.js') }}"></script>
            <script src="{{ themes('libs/pdfmake/build/vfs_fonts.js') }}"></script>
            <script src="{{ themes('libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
            <script src="{{ themes('libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
            <script src="{{ themes('libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>

            <!-- Responsive examples -->
            <script src="{{ themes('libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
            <script src="{{ themes('libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

            <script src="{{ themes('libs/parsleyjs/parsley.min.js') }}"></script>
            <script src="{{ themes('js/pages/form-validation.init.js') }}"></script>

            <!-- Datatable init js -->
            <script src="{{ themes('js/pages/datatables.init.js') }}"></script>
        @endpush

</x-layouts.app>



