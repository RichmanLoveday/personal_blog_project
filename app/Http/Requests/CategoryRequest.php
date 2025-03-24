<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'name' => ['required', 'unique:categories', 'max:100']
        ];
    }


    public function messages()
    {
        return [
            'name.required' => 'Please enter category name',
            'name.unique' => 'Category name already exist, please change',
            'name.max' => 'Catgory name cannot be more than 100 characters'
        ];
    }
}