<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable=['price','download_url','download_token','order_id','product_id'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function productOrderItem()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
}
