<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'explain', 'price', 'quantity', 'amount', 'purchase_id', 'storehouse_id'
    ];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];

    public function storehouse()
    {
        return $this->hasOne(Storehouse::class, 'id', 'storehouse_id');
    }

    public function product()
    {
        return $this->hasOne(Product::class,'id','product_id');
    }
}
