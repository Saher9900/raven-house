<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'productable_type',
        'productable_id',
        'product_name',
        'product_brand',
        'product_type',
        'quantity',
        'unit_price',
        'subtotal',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'unit_price' => 'decimal:2',
            'subtotal' => 'decimal:2',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function productable(): MorphTo
    {
        return $this->morphTo();
    }

    public function displayProductType(): string
    {
        if ($this->product_type !== 'Perfume' || ! $this->productable instanceof Perfume) {
            return $this->product_type;
        }

        return match ($this->productable->perfume_type) {
            'box' => 'Perfume - Box',
            'fragrance' => 'Perfume - Fragrances',
            default => $this->product_type,
        };
    }
}
