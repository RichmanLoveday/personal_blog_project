<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'description1' => ['required', 'string', 'min:50', 'max:10000'],
            'title' => ['required', 'string', 'min:10', 'max:200'],
            'category' => ['required'],
            'status' => ['required'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:10048']
        ];
    }
}