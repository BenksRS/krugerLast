<?php

namespace Modules\Assignments\Traits;

use Modules\Assignments\Entities\Assignment;

trait HandlesTechTags {

    protected function techTagRules(): array
    {
        return [
            [
                'techs' => [124],
                'tags'  => [26],
            ],
            [
                'techs' => [140, 175, 176, 177],
                'tags'  => [57],
            ],
            [
                'techs' => [134],
                'tags'  => [69],
            ],
        ];
    }

    protected function getTagsByTech($tech_id): array
    {
        $tech_id = (int) $tech_id;

        return collect($this->techTagRules())
            ->filter(fn ($rule) => in_array($tech_id, $rule['techs'], TRUE))
            ->flatMap(fn ($rule) => $rule['tags'])
            ->unique()
            ->values()
            ->all();
    }

    protected function addTagsByTech($tech_id, Assignment $assignment): void
    {
        $tags = $this->getTagsByTech($tech_id);

        if (empty($tags)) {
            return;
        }

        $assignment->tags()->syncWithoutDetaching($tags);
    }

}