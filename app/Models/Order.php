<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable=['sessionId','token','status','total','content','user_id'];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function orderUser()
    {
        return $this->belongsTo(User::class);
    }
}
