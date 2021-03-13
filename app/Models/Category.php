<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
