<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
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
            'first_name'   => ['string', 'max:20'],
            'last_name'    => ['string', 'max:20'],
            'email'        => ['email'],
            'phone_number' => ['regex:/^\+[1-9]\d{1,14}$/'],
        ];
    }
}
