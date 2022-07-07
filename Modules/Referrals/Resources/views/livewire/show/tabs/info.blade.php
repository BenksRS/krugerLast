<div class="row">
    <div class="col-lg-4">

        @livewire('referrals::show.tabs.info.address', ['referral' => $referral->id], key('referral_info_address'))


        @livewire('referrals::show.tabs.info.phones', ['referral' => $referral->id], key('referral_info_phones'))




    </div>
    <div class="col-lg-4">
        @include('referrals::show.tabs.info.generalinfo')
    </div>
    <div class="col-lg-4">
        @livewire('referrals::show.tabs.info.notes', ['referral' => $referral->id], key('referral_info_notes'))
    </div>
</div>
