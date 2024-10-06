<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateBookRequest",
 *     @OA\Property(property="name",type="string",description="Название книги"),
 *     @OA\Property(property="author",type="string",description="Автор книги"),
 *     @OA\Property(property="total_duration",type="integer",description="Длительность/кол-во книги"),
 *     @OA\Property(property="description",type="string",description="Описание книги"),
 *     @OA\Property(property="image",type="binary",description="Обложка книги"),
 *     @OA\Property(property="book_type_id",type="integer",description="ID тип книги"),
 *     @OA\Property(property="book_status_id",type="integer",description="ID статус книги"),
 *     @OA\Property(property="planning_date",type="string",description="Планируемая дата чтения"),
 *     @OA\Property(property="start_date",type="string",description="Дата начала чтения"),
 *     @OA\Property(property="end_date",type="integer",description="Дата конец чтения"),
 *     @OA\Property(property="rating",type="float",description="Оценка"),
 *     @OA\Property(property="review",type="string",description="Отзыв"),
 *     @OA\Property(property="avg_emoji",type="integer",description="Эмодзи"),
 * )
 *
 */
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
            'name'           => ['nullable', 'string', 'max:255'],
            'author'         => ['nullable', 'string'],
            'total_duration' => ['nullable', 'integer', 'min:1'],
            'description'    => ['nullable', 'string'],
            'image'          => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'book_type_id'   => ['nullable', 'integer', 'exists:book_types,id'],
            'book_status_id' => ['nullable', 'integer', 'exists:book_statuses,id'],
            'planning_date'  => ['nullable', 'string'],
            'start_date'     => ['nullable', 'string'],
            'end_date'       => ['nullable', 'string'],
            'rating'         => ['nullable', 'numeric', 'min:0', 'max:5'],
            'review'         => ['nullable', 'string'],
            'avg_emoji'      => ['nullable', 'numeric', 'min:1', 'max:9'],
        ];
    }
}
