<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VolunteerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:volunteer_requests,email'],
            'phone' => ['required', 'string', 'max:20', 'unique:volunteer_requests,phone'],
            'message' => ['required', 'string'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
