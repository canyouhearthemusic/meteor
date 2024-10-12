<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * Table: files
 *
 * === Columns ===
 * @property int $id
 * @property string $client_type
 * @property int $client_id
 * @property int $user_id
 * @property string $path
 * @property string $original_name
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 */
class File extends Model
{
    public function getPath(): string
    {
        return Storage::disk(config('filesystems.default'))->url($this->path);
    }
}
