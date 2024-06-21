<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = true;

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
