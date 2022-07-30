<div class="carrierscarries">
    <div class="row">

        <div class="col-lg-8 auth_list" >
            @livewire('referrals::show.tabs.carriers.pivot', ['referral' => $referral->id], key('referral_carrier_pivot'))
            {{--kk--}}
        </div>
        <div class="col-lg-4 " >
            @livewire('referrals::show.tabs.carriers.insurances', ['referral' => $referral->id], key('referral_carrier_insurances'))
        </div>
    </div>

</div>
