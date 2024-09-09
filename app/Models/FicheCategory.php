<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FicheCategory extends Model
{
    use HasFactory;

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);//belong id set here
    }

    /**
     * Get the registration that owns the RegistrationRunner.
     */
    public function fiche(): BelongsTo
    {
        return $this->belongsTo(Fiche::class);//belong id set here
    }
}
