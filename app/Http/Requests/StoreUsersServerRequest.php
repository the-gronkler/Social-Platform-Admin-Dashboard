<?php


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsersServerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'server_id' => 'required|exists:servers,id',
            'user_id' => 'required|exists:users,id',
            'is_admin' => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'server_id.required' => 'The server is required.',
            'user_id.required' => 'The user is required.',
            'is_admin.required' => 'You must specify if the user is admin or not.',
            'is_admin.boolean' => 'Is admin must be a boolean value.',
        ];
    }
}
