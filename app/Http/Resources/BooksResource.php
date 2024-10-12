<?php

namespace App\Http\Resources;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @OA\Schema(
 *     type="array",
 *     @OA\Items(ref="#/components/schemas/BookResource")
 * )
 *
 * @property Book $resource
 */
class BooksResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return ResourceCollection
     */
    public function toArray(Request $request): ResourceCollection
    {
        return BookResource::collection($this->resource);
    }
}
