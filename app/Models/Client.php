<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory, Translatable;

    /**
     * @var array|string[]
     */
    public array $translatedAttributes = ['name', 'address'];

    /**
     * @var string[]
     */
    protected $fillable = ['phone'];
}
