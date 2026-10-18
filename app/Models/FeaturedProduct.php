<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeaturedProduct extends Model
{
    protected $fillable = ['perfume_id', 'sunglasses_id', 'position'];

    public function perfume(): BelongsTo
    {
        return $this->belongsTo(Perfume::class);
    }

    public function sunglasses(): BelongsTo
    {
        return $this->belongsTo(Sunglasses::class);
    }
}
