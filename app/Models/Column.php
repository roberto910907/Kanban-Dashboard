<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Column extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'position',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d h:i a',
        'updated_at' => 'datetime:Y-m-d h:i a',
    ];

    public function cards(): HasMany
    {
        return $this->hasMany(Card::class);
    }
}
