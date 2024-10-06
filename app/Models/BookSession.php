<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Table: book_sessions
 *
 * === Columns ===
 * @property int $id
 * @property int $book_id
 * @property int $session_duration
 * @property int|null $current_duration
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 *
 * === Relationships ===
 * @property-read \App\Models\Note[]|\Illuminate\Database\Eloquent\Collection $notes
 */
class BookSession extends Model
{
    use HasFactory;

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class, 'session_id');
    }
}
