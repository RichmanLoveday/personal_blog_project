<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class CreateAuthorRequest extends FormRequest
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
            'firstName' => ['required', 'string', 'max:50'],
            'lastName' => ['required', 'string', 'max:50'],
            'email' => ['required', 'unique:users'],
            'phone' => ['required', 'max:20'],
            'role' => ['required'],
            'password' => ['required', 'confirmed', Password::min(8)->max(50)->numbers()->letters()]
        ];
    }


    public function messages()
    {
        return [
            'firstName.max' => 'Please first name should not exceed 50 characters',
            'lastName.max' => 'Please last name should not exceed 50 characters',
            'email.unique' => 'Pleas email provided already exist in the database',
            'password.confirmed' => 'Please password do not match',
        ];
    }
}
