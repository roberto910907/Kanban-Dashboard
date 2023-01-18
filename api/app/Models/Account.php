<?php

namespace App\Models;

use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;

class Account extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasUuids;

    protected $table = 'accounts';

    protected $fillable = [
      'uuid',
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
          'uuid',
          'name',
          'email',
          'database',
        ];
    }

    // Disabling the tenancy library logic that generates the uuid
    public function shouldGenerateId(): bool
    {
        return false;
    }

    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    public function domains(): HasMany
    {
        return $this->hasMany(Domain::class);
    }
}
