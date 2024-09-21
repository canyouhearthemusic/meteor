<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'name'          => ['nullable', 'string', 'max:255'],
            'author'        => ['nullable', 'string'],
            'totalDuration' => ['nullable', 'integer', 'min:1'],
            'description'   => ['nullable', 'string'],
            'image'         => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'bookTypeId'    => ['nullable', 'integer', 'exists:book_types,id'],
            'bookStatusId'  => ['nullable', 'integer', 'exists:book_statuses,id'],
            'planningDate'  => ['nullable', 'string'],
            'startDate'     => ['nullable', 'string'],
            'endDate'       => ['nullable', 'string'],
            'rating'        => ['nullable', 'numeric', 'min:0', 'max:5', function ($attribute, $value, $fail) {
                if (!is_float($value + 0) || $value < 0 || $value > 5) {
                    $fail($attribute . ' значение должно быть в промежутке включительно 0 и 5.');
                }
            }],
            'review'        => ['nullable', 'string'],
            'avgEmoji'      => ['nullable', 'numeric', 'min:1', 'max:9'],
        ];
    }
}
