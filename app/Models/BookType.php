<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Table: book_types
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
class BookType extends Model
{
    const AUDIO    = 1;
    const PHYSICAL = 2;

    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}
