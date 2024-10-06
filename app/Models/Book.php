<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Table: books
 *
 * === Columns ===
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $author
 * @property int|null $book_type_id
 * @property int|null $book_status_id
 * @property int|null $total_duration
 * @property string|null $description
 * @property string|null $image
 * @property string|null $planning_date
 * @property string|null $start_date
 * @property string|null $end_date
 * @property float|null $rating
 * @property string|null $review
 * @property int|null $avg_emoji
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 *
 * === Relationships ===
 * @property-read \App\Models\BookType|null $type
 * @property-read \App\Models\BookStatus|null $status
 */
class Book extends Model
{
    protected $with = [
        'type:id,name',
        'status:id,name'
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(BookType::class, 'book_type_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(BookStatus::class, 'book_status_id');
    }
}
