<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name'   => ['required', 'string', 'max:20'],
            'last_name'    => ['required', 'string', 'max:20'],
            'email'        => ['required', 'email', 'unique:users'],
            'phone_number' => ['required', 'regex:/^\+[1-9]\d{1,14}$/'],
        ];
    }
}
