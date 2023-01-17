@once
    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endpush
@endonce


<x-layouts.app layout="horizontal">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Charts</h4>
                
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                        <li class="breadcrumb-item active">Charts</li>
                    </ol>
                </div>
            
            </div>
        </div>
    </div>
    @livewire('charts::referrals', key('charts-referrals'))
</x-layouts.app>