<?php

namespace Modules\Referrals\Http\Livewire\Authorizations;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Referrals\Entities\ReferralAuthorization;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $listAuth;
    public $searchAuth;

    public function mount(){
        $this->listAuth = ReferralAuthorization::all();
    }
    public function render()
    {
        $searchAuth = "%$this->searchAuth%";
        $list=ReferralAuthorization::whereLike('name',$searchAuth)
            ->whereLike('description',$searchAuth)
            ->paginate(9);

        return view('referrals::livewire.authorizations.index',[
            'list' =>$list,
        ]);
    }
}
