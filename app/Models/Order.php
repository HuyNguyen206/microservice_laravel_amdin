<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getTotalAttribute()
    {
        return $this->orderItems->sum(function ($orderItem) {
            return $orderItem->quantity * $orderItem->price;
        });
    }

    public function getNameAttribute()
    {
        return "{$this->first_name}_{$this->last_name}";
    }


}
