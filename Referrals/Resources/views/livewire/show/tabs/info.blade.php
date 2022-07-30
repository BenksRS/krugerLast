<div class="row">
    <div class="col-lg-4">

        @livewire('referrals::show.tabs.info.address', ['referral' => $referral->id], key('referral_info_address'))


        @livewire('referrals::show.tabs.info.phones', ['referral' => $referral->id], key('referral_info_phones'))
        {{--kk--}}



    </div>
    <div class="col-lg-4">
{{--        @include('referrals::show.tabs.info.generalinfo')--}}
        @livewire('referrals::show.tabs.info.general', ['referral' => $referral->id], key('referral_info_notes'))
    </div>
    <div class="col-lg-4">
        @livewire('referrals::show.tabs.info.notes', ['referral' => $referral->id], key('referral_info_notes'))
    </div>
</div>
