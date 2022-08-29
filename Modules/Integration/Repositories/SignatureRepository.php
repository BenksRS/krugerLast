<?php

namespace Modules\Integration\Repositories;

use Modules\Assignments\Entities\Signdata;

class SignatureRepository extends Signdata {

    use IntegrationRepository;

    public function getData ()
    {
    }

    public function setData ($data)
    {
        return [
            'assignment_id' => $data['job_id'],
            'b64'           => $this->checkEncoder($data['file']),
            'date_sign'     => $data['uploaded_at'],
            'type'          => 'app',
            'preferred'     => 'N',
            'created_by'    => 73,
        ];
    }

}