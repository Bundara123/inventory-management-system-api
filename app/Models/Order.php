<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [
        'id',
    ];
    protected $fillable = [
        'customer_id',
        'order_date',
        'order_status',
        'total_products',
        'sub_total',
        'vat',
        'total',
        'invoice_no',
        'payment_type',
        'pay',
        'due'
    ];

    protected $casts = [
        'order_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'order_status' => OrderStatus::class
    ];
}
