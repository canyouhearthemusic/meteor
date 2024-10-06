<?php

namespace App\Http\Requests\BookSession;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'session_duration' => ['required', 'integer', 'min:1'],
            'current_duration' => ['nullable', 'integer', 'min:1'],
            'notes'            => ['nullable', 'array'],
            'notes.*.comment'  => ['required', 'string'],
        ];
    }
}
