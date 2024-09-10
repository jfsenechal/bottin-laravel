<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function fiches(): BelongsToMany
    {
        return $this
            ->belongsToMany(Fiche::class)
            ->withPivot('is_main')
            ->withTimestamps();
    }

    // Define relationship with parent category
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Define relationship with children categories
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public static function roots()
    {
        return self::where('parent_id', '=', null)->orderby('name')->get();
    }

    public static function childrenOfParent(int $parent_id)
    {
        return self::where('parent_id', '=', $parent_id)->orderby('name')->get();
    }

    public function scopeRoots($query)
    {
        return $query->whereNull('parent_id');
    }
}
