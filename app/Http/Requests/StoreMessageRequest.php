<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMessageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'question' => ['required', 'string', 'min:10', 'max:5000'],
        ];
    }
}
