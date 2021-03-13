<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    protected $fillable=['categoryName','status'];

    public function categoryProducts()
    {
        return $this->hasMany(Product::class);
    }
}
