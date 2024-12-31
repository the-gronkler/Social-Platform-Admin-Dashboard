<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:user,admin',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The user name is required.',
            'email.required' => 'The email is required.',
            'email.unique' => 'Email address is already taken.',
            'email.email' => 'Please provide a valid email address.',
            'password.required' => 'The password is required.',
            'password.min' => 'The password must be at least 6 characters.',
            'role.required' => 'The role is required',
        ];
    }
}
