<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Board extends BaseModel
{
    protected $fillable = ['name', 'is_private'];

    public function columns(): HasMany
    {
        return $this->hasMany(Column::class);
    }
}
