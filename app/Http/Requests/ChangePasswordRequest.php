<?php

namespace App\Http\Requests;

use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ChangePasswordRequest extends FormRequest
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
            'old_password' => ['required'],
            'password' => ['required', 'confirmed', Password::min(8)->max(50)->numbers()->letters()],
        ];
    }

    /**
     * Validate old password after main validation runs.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!$this->validateOldPassword()) {
                $validator->errors()->add(
                    'old_password',
                    'Old password does not match.'
                );
            }
        });
    }

    /**
     * Check if the provided old password matches the authenticated user's password.
     */
    private function validateOldPassword(): bool
    {
        return Hash::check($this->old_password, Auth::user()->password);
    }
}