<x-layouts.applive layout="horizontal">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">REFERRAL LIST (ALL)</h4>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <livewire:referrals::pages.show-referrals />


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


        <!-- Datatable init js -->
        <script src="{{ themes('js/pages/datatables.init.js') }}"></script>
    @endpush

</x-layouts.applive>




