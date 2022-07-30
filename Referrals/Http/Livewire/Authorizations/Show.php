<?php

namespace Modules\Referrals\Http\Livewire\Authorizations;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Referrals\Entities\ReferralAuthorization;
use Illuminate\Pagination\LengthAwarePaginator;


class Show extends Component
{
    public $auth_id;

    public function mount($auth_id){
        $this->auth_id = $auth_id;
    }
    public function render()
    {
        return view('referrals::livewire.authorizations.show');
    }
}
