    <div class="row">

        <div class="col-lg-8 auth_list" >

            @include('referrals::shows.tabs.auth.auth-edit', key('referrals_auth_edit') )
            @include('referrals::show.tabs.auth.auth_list', key('referrals_auth_list') )
        </div>
        <div class="col-lg-4 " >
            @include('referrals::show.tabs.auth.auth_add', key('referrals_auth_add'))
        </div>
    </div>

