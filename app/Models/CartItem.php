<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable=['price','cart_id','product_id'];

    public function userCartItem()
    {
        return $this->belongsTo(Cart::class);
    }

    public function cartItemProduct()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
}
