<?php

namespace App\Models;

use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;

class Account extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase;

    protected $table = 'accounts';

    protected $fillable = [
      'name',
      'email',
      'database',
    ];

    public function getTenantKeyName(): string
    {
        return 'database';
    }

    public static function getCustomColumns(): array
    {
        return [
          'id',
          'name',
          'email',
          'database',
        ];
    }

    public function shouldGenerateId(): bool
    {
        return false;
    }

    public function domains(): HasMany
    {
        return $this->hasMany(Domain::class);
    }
}
