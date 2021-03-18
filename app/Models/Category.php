<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory, Translatable;

    /**
     * @var array|string[]
     */
    public array $translatedAttributes = ['name'];

    /**
     * @var string[]
     */
    protected $fillable = ['name'];

    /**
     * function return all related products
     *
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
