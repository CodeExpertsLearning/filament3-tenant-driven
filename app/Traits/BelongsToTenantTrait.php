<?php

namespace App\Traits;

use App\Models\Tenant;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToTenantTrait
{
    public function scopeLoadWithTenant(Builder $query, int $tenant = null)
    {
        $tenant = $tenant ?? Filament::getTenant();

        return $query->whereBelongsTo($tenant);
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}
