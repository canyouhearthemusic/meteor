<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
 */
class Note extends Model
{
    public function session(): BelongsTo
    {
        return $this->belongsTo(BookSession::class);
    }
}
