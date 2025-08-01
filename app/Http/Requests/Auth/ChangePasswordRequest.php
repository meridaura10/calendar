<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'current_password' => ['required','min:4', 'max:255', 'current_password'],
            'password' => ['required', 'min:4'],
        ];
    }
}
