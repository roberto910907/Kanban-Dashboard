<?php

namespace App\Models;

use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Stancl\Tenancy\Database\Models\Domain as BaseDomain;

class Domain extends BaseDomain
{
    use HasDatabase;

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(config('tenancy.tenant_model'), 'account_id');
    }
}
