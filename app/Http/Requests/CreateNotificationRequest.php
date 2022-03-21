<?php

namespace App\Http\Requests;

use App\Models\Notifications;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateNotificationRequest extends FormRequest
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
            'user_id' => ['required', 'exists:App\Models\User,id'],
            'channel' => ['required', Rule::in([Notifications::TYPE_SMS, Notifications::TYPE_EMAIL])],
            'content' => ['required', 'string'],
        ];
    }
}
