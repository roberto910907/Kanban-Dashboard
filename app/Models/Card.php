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
      'title',
      'position',
      'description',
      'column_id',
    ];

    protected $casts = [
      'created_at' => 'datetime:Y-m-d H:i:s',
      'updated_at' => 'datetime:Y-m-d H:i:s',
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
