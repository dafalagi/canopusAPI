<?php

namespace App\Http\Requests;

use App\Enums\ContentCategory;
use App\Enums\ContentEvent;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreContentRequest extends FormRequest
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
            'title' => 'required|string|unique:contents|min:4',
            'intro' => 'required|string|min:10',
            'history' => 'required|string|min:10',
            'category' => 'required|'.[new Enum(ContentCategory::class)],
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
