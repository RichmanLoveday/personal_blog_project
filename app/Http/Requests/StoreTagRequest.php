<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTagRequest extends FormRequest
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
            'name' => ['required', 'unique:tags', 'max:50']
        ];
    }


    public function messages()
    {
        return [
            'name.required' => 'Please enter tag name',
            'name.unique' => 'Tag name already exist, please change',
            'name.max' => 'Tag name cannot be more than 50 characters'
        ];
    }
}