<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BookType extends Model
{
    const AUDIO = 1;
    const PHYSICAL = 2;

    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}
