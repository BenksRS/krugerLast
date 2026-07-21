<?php

namespace Modules\User\Http\Livewire\SickLeave\Modal;

use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\User\Entities\SickLeave;
use Carbon\Carbon;

class Form extends Component {

    use WithFileUploads;

    public    $sickLeave;

    public    $sickLeave_id;

    public    $user_id;

    public    $attachment;

    protected $rules = [
        'sickLeave.start_date'  => 'required|date',
        'sickLeave.days'        => 'required|integer|min:1',
        'sickLeave.description' => 'nullable|string',
        'sickLeave.status'      => 'required',
    ];

    protected $listeners = ['sickLeaveForm' => 'show'];

    public function show($sickLeave_id = null, $user_id = null)
    {
        $this->resetProperties();

        if ($sickLeave_id) {
            $sickLeave = SickLeave::findOrFail($sickLeave_id);
            $this->sickLeave_id = $sickLeave->id;
            $this->user_id      = $sickLeave->user_id;
        } else {
            $sickLeave = new SickLeave();
            $sickLeave->status = 'Y';
            $this->user_id     = $user_id;
        }

        $this->sickLeave = $sickLeave;

        $this->emit('openModal');
    }

    public function save()
    {
        $this->validate();

        if ($this->attachment) {
            $this->sickLeave->b64 = base64_encode(file_get_contents($this->attachment->getRealPath()));
        }

        $this->sickLeave->user_id = $this->user_id;
        $this->sickLeave->year    = Carbon::parse($this->sickLeave->start_date)->year;

        $this->sickLeave->save();

        $this->emit('hideModal');
        $this->resetProperties();

        $this->emitTo('user::sick-leave.show', '$refresh');
        $this->emitTo('user::sick-leave.modal.details', '$refresh');
    }

    protected function resetProperties($properties = ['sickLeave', 'sickLeave_id', 'user_id', 'attachment'])
    {
        $this->reset($properties);
    }

    public function render()
    {
        return view('user::livewire.sick-leave.modal.form');
    }

}