<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100 listtable">
                    @include('referrals::index.thead')
                    <tbody>
                    @foreach($referrals as $row)
                        @include('referrals::index.tr')
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div> <!-- end col -->
    {{--kk--}}
</div> <!-- end row -->
