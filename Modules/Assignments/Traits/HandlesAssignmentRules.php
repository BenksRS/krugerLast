<?php

namespace Modules\Assignments\Traits;

use Modules\Assignments\Entities\Assignment;
use Modules\Assignments\Entities\AssignmentsRules;

trait HandlesAssignmentRules {

    public function processAssignmentRules($id)
    {
        $assignment = Assignment::find($id);
        $rules = $this->getAssignmentRules($assignment);

        if (empty($rules)) {
            return;
        }
        $tags = $rules
            ->pluck('tag_id')
            ->filter()       // remove null/0
            ->unique()
            ->values()
            ->toArray();

        if (!empty($tags)) {
            $this->addRuleTags($assignment, $tags);
        }

        foreach ($rules as $rule) {
            if (empty($rule->note_type)) {
                $this->addRuleNotes($id, $rule->note_text);
            } else {
                foreach ($rule->note_type as $type) {
                    $this->addRuleNotes($id, $rule->note_text, $type);
                }
            }
        }
    }

    protected function getAssignmentRules($assignment)
    {
        // pega todos os tipos de job vinculados
        $jobTypeIds = $this->jbSelected;

        return AssignmentsRules::query()
            ->where('active', 'Y')
            ->whereIn('job_type_id', $jobTypeIds)
            ->where(function($query) use ($assignment) {
                $referral = $assignment->referral_id ?? 0;
                $carrier  = $assignment->carrier_id ?? 0;
                
                $query
                    ->where(function($q) use ($referral, $carrier) {
                        $q->where('referral_id', $referral)->where('carrier_id', $carrier);
                    })
                    ->orWhere(function($q) use ($referral) {
                        $q->where('referral_id', $referral)->whereNull('carrier_id');
                    })
                    ->orWhere(function($q) use ($carrier) {
                        $q->where('carrier_id', $carrier)->whereNull('referral_id');
                    });
            })
            ->get();
    }

    protected function addRuleTags($assignment, $tags)
    {
        $assignment->tags()->syncWithoutDetaching($tags);
    }

    protected function addRuleNotes($id, $text = '', $type = 'tech')
    {
        $assignment = Assignment::find($id);
        $assignment->notes()->create([
            'text'         => $text,
            'notable_id'   => $id,
            'type'         => $type,
            'created_by'   => 73,
            'notable_type' => Assignment::class,
        ]);
    }

}