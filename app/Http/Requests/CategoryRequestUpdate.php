<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use Illuminate\Support\Str;

class CategoryRequestUpdate extends FormRequest
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
            'name' => ['required', 'max:100']
        ];
    }


    public function messages()
    {
        return [
            'name.required' => 'Please enter category name',
            'name.max' => 'Catgory name cannot be more than 100 characters'
        ];
    }


    public function after()
    {
        return [
            function (Validator $validator) {
                if ($this->checkIfCategoryNameIsSameWithOthers()) {
                    $validator->errors()->add(
                        'name',
                        'Category name already exist, please change'
                    );
                }
            }
        ];
    }


    public function checkIfCategoryNameIsSameWithOthers(): bool
    {
        //? find category name where category name is same with others expect original
        $categoryNameExistance = Category::where('name', Str::lower($this->name))
            ->whereNot('id', $this->category_id)
            ->first();

        if ($categoryNameExistance) return true;
        return false;
    }
}