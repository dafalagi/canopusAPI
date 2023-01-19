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
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'username' => 'required|min:4|max:12',
            'password' => 'nullable|min:6|max:12',
            'confirm_password' => 'required_with:password|same:password',
            'email' => 'nullable|email:dns',
            'is_admin' => 'nullable|boolean',
            'avatar' => 'nullable|string',
            'bio' => 'nullable|string'
        ];
    }
}
