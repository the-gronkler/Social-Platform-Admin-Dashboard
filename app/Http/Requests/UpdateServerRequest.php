<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServerRequest extends FormRequest
{

    public function rules(): array
    {
        $server = $this->route('server'); // Get the current server instance from route parameters

        return [
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1|min:' . $server->users()->count(), // Capacity can't be less than current user count
        ];
    }

    public function messages()
    {
        return [
            'capacity.min' => 'Capacity must be at least the current number of members: ' . $this->route('server')->users()->count(),
        ];
    }
}
