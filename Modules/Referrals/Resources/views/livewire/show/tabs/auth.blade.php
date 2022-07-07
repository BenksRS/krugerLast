<div class="authauth">
    <div class="row">
        <div class="col-lg-12" >
        @livewire('referrals::show.tabs.auths.auth-edit',['auth_id' => ''], key('referral_auth_edit'))
        </div>
    </div>
    <div class="row">

        <div class="col-lg-8 auth_list" >
{{--            @include('referrals::show.tabs.auth.auth_list')--}}


            @livewire('referrals::show.tabs.auths.auth-list', ['referral' => $referral->id], key('referral_auth_list'))

        </div>
        <div class="col-lg-4 " >

            @livewire('referrals::show.tabs.auths.auth-add', ['referral' => $referral->id], key('referral_auth_add'))
{{--            @include('referrals::show.tabs.auth.auth_add')--}}
        </div>
    </div>


</div>
