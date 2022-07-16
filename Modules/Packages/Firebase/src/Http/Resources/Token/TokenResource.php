<?php

namespace Callkruger\Api\Http\Resources\Token;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TokenResource extends JsonResource {

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray ($request)
    {
        return [
            'access_token' => $this->token,
            'token_type'   => 'Bearer'
        ];
    }

}
