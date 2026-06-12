<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VolunteerDemandeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:volunteer_requests,email'],
            'phone' => ['required', 'string', 'max:20', 'regex:/^[0-9+\-\s()]+$/', 'unique:volunteer_requests,phone'],
            'message' => ['required', 'string', 'max:5000'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
