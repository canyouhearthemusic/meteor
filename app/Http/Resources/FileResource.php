<?php

namespace App\Http\Resources;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     @OA\Property(property="id",type="integer"),
 *     @OA\Property(property="path",type="string"),
 *     @OA\Property(property="original_name",type="string"),
 *     @OA\Property(property="created_at",type="string"),
 * )
 *
 * @property File $resource
 */
class FileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->resource->id,
            'path'          => $this->resource->getPath(),
            'original_name' => $this->resource->original_name,
            'created_at'    => $this->resource->created_at
        ];
    }
}
