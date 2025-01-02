<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUsersServerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'is_admin' => 'required|boolean',
        ];
    }
    public function messages()
    {
        return [
            'is_admin.required' => 'You must specify if the user is admin or not.',
            'is_admin.boolean' => 'Is admin must be a boolean value.',
        ];
    }
}
