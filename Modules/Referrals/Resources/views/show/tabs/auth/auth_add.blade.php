<h4 class="card-title mb-4">All Authorizations </h4>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
{{--                <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">--}}
                <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                    @include('referrals::show.tabs.auth.authadd.thead')
                    <tbody>
                    @foreach($auths as $row)
                        @include('referrals::show.tabs.auth.authadd.tr')
{{--                        @include('referrals::show.tabs.auth.authadd.tr')--}}
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div> <!-- end col -->
</div>
