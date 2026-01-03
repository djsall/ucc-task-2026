<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'description' => ['nullable', 'string'],
        ];
    }
}
