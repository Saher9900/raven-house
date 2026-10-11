<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['image_path'];

    public function getImagePathAttribute(?string $value): ?string
    {
        if (blank($value)) {
            return null;
        }

        if (str_starts_with($value, 'images/')) {
            return Storage::disk('s3')->url($value);
        }

        if (str_starts_with($value, '/images/')) {
            return '/storage'.$value;
        }

        return $value;
    }

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}
