<?php

namespace App\Models;

use App\Traits\BelongsToTenantTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory, BelongsToTenantTrait;

    protected $fillable = [
        'product_id', 'order_value',
        'amount', 'tenant_id',
        'store_id', 'order_id'
    ];


    public function orderValue(): Attribute
    {
        return new Attribute(get: fn ($attr) => $attr / 100, set: fn ($attr) => $attr * 100);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
