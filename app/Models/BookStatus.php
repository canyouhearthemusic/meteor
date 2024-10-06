<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Table: book_statuses
 *
 * === Columns ===
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 *
 * === Relationships ===
 * @property-read \App\Models\Book[]|\Illuminate\Database\Eloquent\Collection $books
 */
class BookStatus extends Model
{
    const TO_READ = 1;
    const READING = 2;
    const READ    = 3;
    //    const PAUSED   = 4;
    //    const DROPPED_OUT = 5;

    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}
