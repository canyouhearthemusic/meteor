<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'book_type'      => $this->resource->type,
            'book_status'    => $this->resource->status,
            'total_duration' => $this->resource->total_duration,
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
