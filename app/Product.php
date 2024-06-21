<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = true;

    public function productDetails()
    {
        return $this->hasMany(ProductDetail::class);
    }

    public function productSku()
    {
        return $this->belongsTo(ProductSku::class);
    }
}
