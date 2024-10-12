<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     @OA\Property(property="id",type="integer"),
 *     @OA\Property(property="name",type="string"),
 *     @OA\Property(property="author",type="string"),
 *     @OA\Property(property="book_type",type="string"),
 *     @OA\Property(property="book_status",type="string"),
 *     @OA\Property(property="total_duration",type="integer"),
 *     @OA\Property(property="notes_amount",type="integer"),
 *     @OA\Property(
 *         property="notes",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/NoteResource")
 *     ),
 *     @OA\Property(property="description",type="string"),
 *     @OA\Property(property="image",type="string"),
 *     @OA\Property(property="planning_date",type="string"),
 *     @OA\Property(property="start_date",type="string"),
 *     @OA\Property(property="end_date",type="integer"),
 *     @OA\Property(property="rating",type="float"),
 *     @OA\Property(property="review",type="string"),
 *     @OA\Property(property="avg_emoji",type="integer"),
 * )
 *
 * @property \App\Models\Book $resource
 */
class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->resource->id,
            'name'           => $this->resource->name,
            'author'         => $this->resource->author,
            'book_type'      => $this->resource->type->name,
            'book_status'    => $this->resource->status->name,
            'total_duration' => $this->resource->total_duration,
            'notes_amount'   => $this->resource->notes->count(),
            'notes'          => NoteResource::collection($this->resource->notes),
            'description'    => $this->resource->description,
            'image'          => $this->resource->image,
            'planning_date'  => $this->resource->planning_date,
            'start_date'     => $this->resource->start_date,
            'end_date'       => $this->resource->end_date,
            'rating'         => $this->resource->rating,
            'review'         => $this->resource->review,
            'avg_emoji'      => $this->resource->avg_emoji,
        ];
    }
}
