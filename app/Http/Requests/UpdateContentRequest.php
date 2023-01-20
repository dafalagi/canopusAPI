<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateContentRequest extends FormRequest
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
            'title' => 'nullable|string|min:4',
            'intro' => 'nullable|string|min:10',
            'history' => 'nullable|string|min:10',
            'category' => 'nullable|'.[new Enum(ContentCategory::class)],
            'coordinate' => 'nullable|string',
            'distance' => 'nullable|string',
            'event' => 'nullable|'.[new Enum(ContentEvent::class)],
            'mainpicture' => 'nullable|string',
            'pictures' => 'nullable',
            'trivia' => 'nullable|string|min:10',
            'videoId' => 'nullable|string'
        ];
    }
}
