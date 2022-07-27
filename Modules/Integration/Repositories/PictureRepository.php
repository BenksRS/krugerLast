<?php

namespace Modules\Integration\Repositories;

use Modules\Assignments\Entities\Gallery;

class PictureRepository extends Gallery {

    use IntegrationRepository;

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
            'type'          => $data['type'],
            'created_by'    => 73,
            'updated_by'    => 73,
        ];
    }

}