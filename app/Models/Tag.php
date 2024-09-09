<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;
    protected $fillable = ['name'];public $timestamps = false;

    public function fiches(): BelongsToMany
    {
        return $this->belongsToMany(Fiche::class);
    }
}
