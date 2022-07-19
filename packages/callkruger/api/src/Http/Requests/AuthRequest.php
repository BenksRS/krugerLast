<?php

namespace Callkruger\Api\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest {

    protected $providerConfig;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize ()
    {
        return TRUE;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules ()
    {
        $this->providerConfig = collect(config('callkruger-api.providers'))->get($this->provider ?? NULL);

        return [
            'provider' => [
                'required', function ($attribute, $value, $fail) { $this->checkProvider($attribute, $value, $fail); }
            ],
            'username' => ['required'],
            'password' => ['required'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes ()
    {
        $providerCredentials = $this->providerConfig['credentials'] ?? [];

        return [
            'username' => $providerCredentials['username'] ?? 'username',
            'password' => $providerCredentials['password'] ?? 'password',
        ];
    }

    protected function failedValidation ($validator)
    {
        $errors = $validator->errors()->all(
            [
                'name'    => ':key',
                'message' => ':message'
            ]);

        api_response(422, 'The given data was invalid.', compact('errors'));
    }

    protected function checkProvider ($attribute, $value, $fail)
    {
        if ( !$this->providerConfig ) {
            $fail("The selected {$attribute} is invalid.");
        }
    }

}
