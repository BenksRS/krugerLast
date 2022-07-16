<?php

namespace Modules\Referrals\Http\Livewire\Authorizations;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Modules\Assignments\Entities\Gallery;
use Modules\Referrals\Entities\ReferralAuthorization;

class Index extends Component
{
    protected $listeners = [
        'uploadAuth' => 'uploadAuth',
        ];
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    public $listAuth;
    public $searchAuth;
    public $newauth;
    public $showUploading=false;

    public function mount(){
        $this->listAuth = ReferralAuthorization::all();
    }
    public function save(){

        $this->validate([
            'newauth' => 'mimes:jpg,jpeg,png',
        ]);

        if($this->newauth){
//        dd($this->newauth);
            $imagedata = file_get_contents($this->newauth->path());
            $base64 = base64_encode($imagedata);
            $b64='data:image/jpeg;base64,'.$base64;



            $created = ReferralAuthorization::create([
                'name' => 'new',
                'description' => 'new',
                'active' => 'Y',
                'b64' => $b64,
             ]);

            $this->redirect("/referrals/authorizations/show/$created->id");
        }


    }
    public function uploadAuth(){
        $this->showUploading = !$this->showUploading;
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
