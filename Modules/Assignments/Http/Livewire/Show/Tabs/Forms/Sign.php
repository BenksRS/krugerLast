<?php

namespace Modules\Assignments\Http\Livewire\Show\Tabs\Forms;

use Livewire\Component;
use Modules\Assignments\Entities\Assignment;
use Modules\Assignments\Entities\Signdata;
use Auth;

class Sign extends Component {

    protected $listeners = [
        'selectSign'   => 'processPreferred',
        'addBlankSign' => 'processBlankSign',
    ];

    public    $assignment;

    public    $signs;

    public    $user;

    public function mount(Assignment $assignment)
    {

        $this->assignment = $assignment;
        $this->signs      = $this->assignment->signs;
        $this->user       = Auth::user();
    }

    public function processBlankSign()
    {
        if ($this->signs->isEmpty()) {
            $base64 = config('assignments.sign.blank');

            $signature = Signdata::create([
                'assignment_id' => $this->assignment->id,
                'created_by'    => $this->user->id,
                'b64'           => $base64,
                'type'          => 'system',
                'preferred'     => 'Y',
                'date_sign'     => now(),
            ]);

            $this->assignment = Assignment::find($this->assignment->id);
            $this->signs      = $this->assignment->signs;
            $this->emitTo('assignments::show.tabs.forms.lists', '$refresh');
        }
    }

    public function processPreferred($id)
    {

        //        dd($id);
        $signature = Signdata::find($id);
        if ($signature) {
            $signature_all = Signdata::where('assignment_id', $this->assignment->id)->get();
            foreach ($signature_all as $signall) {
                $signall->update([
                    "preferred" => 'N',
                ]);
            }

            $signature->update([
                "preferred" => 'Y',
            ]);
        }

        $this->assignment = Assignment::find($this->assignment->id);
        $this->signs      = $this->assignment->signs;
    }

    public function render()
    {
        $this->signs = $this->assignment->signs;

        return view('assignments::livewire.show.tabs.forms.sign', [
            'listSigns' => $this->signs
        ]);
    }

}