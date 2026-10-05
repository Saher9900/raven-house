<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PerfumesCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image'];

    public function getImageAttribute($value): ?string
    {
        if (blank($value)) {
            return null;
        }

        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            return $value;
        }

        if (str_starts_with($value, '/storage/')) {
            return $value;
        }

        if (str_starts_with($value, '/images/')) {
            return '/storage'.$value;
        }

        return $value;
    }

    public function setImageAttribute($value): void
    {
        if (blank($value)) {
            $this->attributes['image'] = null;

            return;
        }

        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://') || str_starts_with($value, '/storage/')) {
            $this->attributes['image'] = $value;

            return;
        }

        if (str_starts_with($value, '/images/')) {
            $this->attributes['image'] = '/storage'.$value;

            return;
        }

        $this->attributes['image'] = $value;
    }

    public function perfumes(): HasMany
    {
        return $this->hasMany(Perfume::class, 'perfumes_category_id');
    }
}
