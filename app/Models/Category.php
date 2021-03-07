<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, Translatable;

    /**
     * @var string[]
     */
    public array $translatedAttributes = ['name'];

    protected $fillable = ['name'];
}
