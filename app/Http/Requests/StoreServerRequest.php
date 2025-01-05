<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The server name is required.',
            'capacity.required' => 'The server capacity is required.',
            'capacity.min' => 'The capacity must be at least 1.',
        ];
    }
}
