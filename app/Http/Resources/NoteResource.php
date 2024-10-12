<?php

namespace App\Http\Resources;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     @OA\Property(property="id",type="integer"),
 *     @OA\Property(property="session_id",type="string"),
 *     @OA\Property(property="comment",type="string"),
 *     @OA\Property(property="created_at",type="string"),
 *     @OA\Property(
 *         property="files",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/FileResource")
 *     ),
 * )
 *
 * @property Note $resource
 */
class NoteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->resource->id,
            'session_id' => $this->resource->session_id,
            'comment'    => $this->resource->comment,
            'created_at' => $this->resource->created_at->format('j M Y, H:i'),
            'files'      => FileResource::collection($this->resource->files),
        ];
    }
}
