<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'explain', 'price', 'quantity', 'amount', 'purchase_id','storehouse_id'
    ];

    public function storehouse()
    {
        return $this->hasOne(Storehouse::class,'id','storehouse_id');
    }
}
