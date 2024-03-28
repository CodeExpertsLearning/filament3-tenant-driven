<?php

namespace App\Models;

use App\Traits\BelongsToTenantTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductPhoto extends Model
{
    use HasFactory, BelongsToTenantTrait;

    protected $fillable = ['photo', 'tenant_id'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
