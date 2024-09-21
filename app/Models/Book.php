<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $user_id
 * @property
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
