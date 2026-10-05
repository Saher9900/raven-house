<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Perfume extends Model
{
    use HasFactory;

    protected $fillable = ['perfumes_category_id', 'name', 'price', 'brand', 'description', 'sale', 'stock', 'gender'];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'sale' => 'decimal:2',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(PerfumesCategory::class, 'perfumes_category_id');
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function effectivePrice(): float
    {
        return (float) ($this->sale ?? $this->price);
    }

    public function productTypeLabel(): string
    {
        return 'Perfume';
    }
}
