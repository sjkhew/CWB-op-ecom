<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductSku extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = true;
}
