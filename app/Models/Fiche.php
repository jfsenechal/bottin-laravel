<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fiche extends Model
{
    use HasFactory;

    public function adresse(): BelongsTo
    {
        return $this->belongsTo(Adresse::class);
    }

    //https://chatgpt.com/c/66daffdd-0380-8008-82f3-cfdeb84e5a15
    public function categories(): BelongsToMany
    {
        return $this
            ->belongsToMany(Category::class)
            ->withPivot('is_main')
            ->withTimestamps();
    }

    public function mainCategory()
    {
        return $this->categories()->wherePivot('is_main', true)->first();
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function mainImage()
    {
        return $this->hasOne(Image::class)->where('main', true);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Get the contacts for the fiche.
     */
    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    protected function location222(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes)
                => [
                'latitude' => $attributes['latitude'],
                'longitude' => $attributes['longitude'],
            ],
            set: fn(array $value)
                => [
                'latitude' => $value['lat'],
                'longitude' => $value['lng'],
            ],
        );
    }

}
