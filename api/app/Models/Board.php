<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Board extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['name', 'is_private'];

    public function columns(): HasMany
    {
        return $this->hasMany(Column::class);
    }

    public function uniqueIds(): array
    {
        return ['uuid'];
    }
}
