<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['fiche_id', 'main'];

    /**
     * Get the fiche that owns the image.
     */
    public function fiche(): BelongsTo
    {
        return $this->belongsTo(Fiche::class);
    }
}
