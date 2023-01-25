<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends BaseModel
{
    use HasFactory;

    protected $fillable = [
      'name',
      'email',
      'email_verified_at',
    ];
}
