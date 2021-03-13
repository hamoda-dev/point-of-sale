<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    protected $fillable = ['name'];
}
