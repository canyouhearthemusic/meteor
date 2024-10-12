<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Table: notes
 *
 * === Columns ===
 * @property int $id
 * @property int $session_id
 * @property string $comment
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 *
 * === Relationships ===
 * @property-read \App\Models\BookSession|null $session
 * @property-read \App\Models\File[]|\Illuminate\Database\Eloquent\Collection $files
 */
class Note extends Model
{
    public function session(): BelongsTo
    {
        return $this->belongsTo(BookSession::class);
    }

    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'client');
    }
}
