<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BookStatus extends Model
{
    const TO_READ  = 1;
    const READING  = 2;
    const READ     = 3;
//    const PAUSED   = 4;
//    const DROPPED_OUT = 5;

    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}
