<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Card extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
      'name',
      'position',
      'column_id',
    ];

    protected $casts = [
      'created_at' => 'datetime:Y-m-d h:i a',
      'updated_at' => 'datetime:Y-m-d h:i a',
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
