<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'trans_id', 'order_number', 'total', 'total_usd', 'currency', 'name', 'phone', 'email', 'postal',
        'country', 'state', 'city', 'street1', 'street2', 'ip', 'description', 'product_code', 'status',
        'link_status','is_shipping','url'
    ];

    const ORDER_STATUS_PENDING = 'pending';   //待办
    const ORDER_STATUS_RECEIVED = 'received'; //已收到
    const ORDER_STATUS_DELIVERED = 'delivered'; //已发货

    const ORDER_STATUS_GROUP = [
        self::ORDER_STATUS_PENDING => '未发货',
        self::ORDER_STATUS_DELIVERED => '已发货',
        self::ORDER_STATUS_RECEIVED => '已收货',
    ];

    protected $casts = [
        'created_at' => 'string:Y-m-d H:i:s'
    ];


    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_products', 'order_id', 'product_id')->withTimestamps()->withPivot('quantity');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

}
