<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Link extends Model
{
    use HasFactory;

    protected $fillable = ['type','url'];

    /**
     * Get the fiche that owns the link.
     */
    public function fiche(): BelongsTo
    {
        return $this->belongsTo(Fiche::class);
    }
}
