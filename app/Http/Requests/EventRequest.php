<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'integer', 'exists:users,id'],
            "title" => ['required', 'string', 'max:255'],
            "color" => ['nullable', 'string', 'max:16'],
            'start_datetime' => ['required', 'date', 'before_or_equal:end_datetime'],
            'end_datetime' => ['required', 'date', 'after_or_equal:start_datetime'],
            "is_completed" => [ 'boolean'],
        ];
    }
}
