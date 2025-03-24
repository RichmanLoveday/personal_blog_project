<?php

namespace App\Http\Requests;

use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class TagRequestUpdate extends FormRequest
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
            'name' => ['required', 'max:50']
        ];
    }


    public function messages()
    {
        return [
            'name.required' => 'Please enter tag name',
            'name.max' => 'Tag name cannot be more than 50 characters'
        ];
    }


    public function after()
    {
        return [
            function (Validator $validator) {
                if ($this->checkIfTagNameIsSameWithOthers()) {
                    $validator->errors()->add(
                        'name',
                        'Tag name already exist, please change'
                    );
                }
            }
        ];
    }


    public function checkIfTagNameIsSameWithOthers(): bool
    {
        //? find tag name where tag name is same with others expect original
        $TagNameExistance = Tag::where('name', Str::lower($this->name))
            ->whereNot('id', $this->id)
            ->first();

        if ($TagNameExistance) return true;
        return false;
    }
}