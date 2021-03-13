<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, Translatable;

    protected $appends = ['image_path', 'profits_percent'];

    public array $translatedAttributes = ['name', 'description'];

    protected $fillable = [
        'category_id',
        'image',
        'purchase_price',
        'sale_price',
        'stock',
    ];


    public function getImagePathAttribute()
    {
        return asset('uploads/products_image/'. $this->image);
    }

    public function getProfitsPercentAttribute()
    {

        $profits = (($this->sale_price - $this->purchase_price) / $this->purchase_price) * 100;

        return number_format($profits, 2);
    }

}
