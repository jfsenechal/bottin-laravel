<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contact extends Model
{
    use HasFactory;

    /**
     * Get the fiche that owns the contact.
     */
    public function fiche(): BelongsTo
    {
        return $this->belongsTo(Fiche::class);
    }
}
