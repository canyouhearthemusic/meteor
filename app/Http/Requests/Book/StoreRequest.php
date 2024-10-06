<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreBookRequest",
 *     required={"name", "author", "book_type_id", "book_status_id"},
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Название книги"
 *     ),
 *     @OA\Property(
 *         property="author",
 *         type="string",
 *         description="Имя автора"
 *     ),
 *     @OA\Property(
 *         property="total_duration",
 *         type="string",
 *         description="Длительность/Кол-во страниц"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Описание книги"
 *     ),
 *     @OA\Property(
 *         property="image",
 *         type="binary",
 *         description="Фото обложки"
 *     ),
 *     @OA\Property(
 *         property="book_type_id",
 *         type="integer",
 *         description="Тип книги"
 *     ),
 *     @OA\Property(
 *         property="book_status_id",
 *         type="integer",
 *         description="Статус книги"
 *     ),
 *     @OA\Property(
 *         property="planning_date",
 *         type="string",
 *         description="Дата планируемого читания"
 *     ),
 *     @OA\Property(
 *         property="start_date",
 *         type="string",
 *         description="Дата начала читания"
 *     ),
 *     @OA\Property(
 *         property="end_date",
 *         type="string",
 *         description="Дата конца читания"
 *     ),
 *     @OA\Property(
 *         property="rating",
 *         type="float",
 *         description="Оценка книги"
 *     ),
 *     @OA\Property(
 *         property="review",
 *         type="string",
 *         description="Отзыв"
 *     ),
 *     @OA\Property(
 *         property="avg_emoji",
 *         type="integer",
 *         description="Эмодзи"
 *     )
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
            'name'           => ['required', 'string', 'max:255'],
            'author'         => ['required', 'string'],
            'total_duration' => ['nullable', 'integer', 'min:1'],
            'description'    => ['nullable', 'string'],
            'image'          => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'book_type_id'   => ['required', 'integer', 'exists:book_types,id'],
            'book_status_id' => ['required', 'integer', 'exists:book_statuses,id'],
            'planning_date'  => ['nullable', 'string'],
            'start_date'     => ['nullable', 'string'],
            'end_date'       => ['nullable', 'string'],
            'rating'         => ['nullable', 'numeric', 'min:0', 'max:5', function ($attribute, $value, $fail) {
                if (!is_float($value + 0) || $value < 0 || $value > 5) {
                    $fail($attribute . ' значение должно быть в промежутке включительно 0 и 5.');
                }
            }],
            'review'         => ['nullable', 'string'],
            'avg_emoji'      => ['nullable', 'numeric', 'min:1', 'max:9'],
        ];
    }
}
