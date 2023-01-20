<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Card extends BaseModel
{
    protected $fillable = [
        'title',
        'position',
        'description',
        'column_id',
    ];

    public function scopeOrderByPosition(Builder $query): void
    {
        $query->orderBy('position')->orderBy('updated_at');
    }

    public function column(): BelongsTo
    {
        return $this->belongsTo(Column::class);
    }
}
