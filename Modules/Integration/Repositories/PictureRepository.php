<?php

namespace Modules\Integration\Repositories;

use Modules\Assignments\Entities\Gallery;

class PictureRepository extends Gallery {

    use IntegrationRepository;

    protected $sectionType = [
        'start_job'   => 'front',
        'pics_inside' => 'inside',
        'pics_before' => ['pitch', 'before'],
        'pics_after'  => 'after',
    ];

    public function getData ()
    {
    }

    public function setData ($data)
    {
        return [
            'assignment_id' => $data['job_id'],
            'category_id'   => $data['label'] ?? 25,
            'img_id'        => $data['id'],
            'b64'           => $data['file'],
            'type'          => $data['type'] ?? $this->checkType($data['section']),
            'created_by'    => 73,
            'updated_by'    => 73,
        ];
    }

    protected function checkType ($section = NULL)
    {
        return collect($this->sectionType)->filter(function ($value, $key) use ($section) {
            return collect($value)->contains($section);
        })->keys()->first();
    }

}