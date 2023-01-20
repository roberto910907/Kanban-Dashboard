<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Column extends BaseModel
{
    protected $fillable = [
      'title',
      'position',
      'board_id',
    ];

    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class);
    }

    public function cards(): HasMany
    {
        return $this->hasMany(Card::class);
    }
}
