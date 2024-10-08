<?php

namespace App\Http\Requests\BookSession;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreBookSessionRequest",
 *     required={"session_duration"},
 *     @OA\Property(
 *         property="session_duration",
 *         type="integer",
 *         description="Длительность сессии (в секундах)"
 *     ),
 *     @OA\Property(
 *         property="current_duration",
 *         type="integer",
 *         description="Страниц прочитано/Секунд прослушано книги"
 *     ),
 *     @OA\Property(
 *         property="notes",
 *         type="array",
 *         description="Заметки сесии книги",
 *         @OA\Items(
 *             @OA\Property(property="comment", type="string", example="Sigma"),
 *         )
 *     ),
 * ),
 */
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
