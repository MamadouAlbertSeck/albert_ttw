<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'phone',
        'street',
        'city',
        'postal_code',
        'email',
        'status',
        'total_amount',
        'payment_provider',
        'payment_reference',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

}
