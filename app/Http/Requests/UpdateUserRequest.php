<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'username' => 'nullable|min:4|max:12',
            'password' => 'nullable|min:6|max:12',
            'confirm_password' => 'required_with:password,current_password|same:password',
            'current_password' => 'required_with:password,confirm_password|min:6|max:12',
            'email' => 'nullable|email:dns',
            'is_admin' => 'nullable|boolean',
            'avatar' => 'nullable|string',
            'banner' => 'nullable|string',
            'bio' => 'nullable|string'
        ];
    }
}
