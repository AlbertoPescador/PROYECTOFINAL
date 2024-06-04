<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    /**
     * Define la relación de un producto con una categoría.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Define la relación de un producto con varias líneas.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lines(): HasMany
    {
        return $this->hasMany(Line::class);
    }
}
