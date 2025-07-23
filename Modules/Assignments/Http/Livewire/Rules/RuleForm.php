<?php

namespace Modules\Assignments\Http\Livewire\Rules;

use Livewire\Component;
use Modules\Assignments\Entities\AssignmentsRules;
use Modules\Assignments\Entities\AssignmentsJobTypes;
use Modules\Assignments\Entities\AssignmentsTags;
use Modules\Referrals\Entities\Referral;

class RuleForm extends Component
{
    public $ruleId;
    public $ruleData;

    public $jobTypes;
    public $tags;
    public $referrals;
    public $carriers;

    protected $rules = [
        'ruleData.job_type_id' => 'required|integer',
        'ruleData.referral_id' => 'nullable|integer',
        'ruleData.carrier_id'  => 'nullable|integer',
        'ruleData.tag_id'      => 'nullable|integer',
        'ruleData.note_text'   => 'required|string',
        'ruleData.note_type'   => 'required|array',
        'ruleData.active'      => 'required|in:Y,N'
    ];

    protected $listeners = ['ruleForm' => 'show'];

    public function mount()
    {
        $this->jobTypes = AssignmentsJobTypes::where('active', 'y')->get();
        $this->tags = AssignmentsTags::all();
        $this->referrals = Referral::where('status', 'ACTIVE')->get();
        $this->carriers = []; // carriers vazio conforme solicitado
    }

    public function show(AssignmentsRules $rule)
    {
        $this->resetProperties();

        if ($rule->id) {
            $this->ruleId = $rule->id;
            $this->ruleData = $rule;
        }
        $this->emit('openModal');
    }

    public function save()
    {
        $this->validate();

        if ($this->ruleId) {
            $this->ruleData->save();
        } else {
            AssignmentsRules::create($this->ruleData);
        }

        $this->emit('hideModal');
        $this->resetProperties();

        $this->emitTo('assignments::rules.rules', '$refresh');
    }

    protected function resetProperties($properties = ['ruleData', 'ruleId'])
    {
        $this->reset($properties);
    }

    public function render()
    {
        return view('assignments::livewire.rules.rule-form');
    }
}