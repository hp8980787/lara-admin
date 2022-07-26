<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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


    public function productStorehouseDB()
    {
        return DB::table('product_storehouse');
    }

    public function productStorehouse()
    {
        return $this->productStorehouseDB()->where('product_id', $this->product_id)
            ->where('storehouse_id', $this->storehouse_id)->first();
    }

    public function updateStorehouse(): bool
    {
        if ($data = $this->productStorehouse()) {

            $this->productStorehouseDB()->where('id', $data->id)->update([
                'stock' => $this->quantity + $data->stock
            ]);
        } else {
            $time = now('Asia/Shanghai');
            $this->productStorehouseDB()->insert([
                'storehouse_id' => $this->storehouse_id,
                'product_id' => $this->product_id,
                'stock' => $this->quantity,
                'created_at' => $time,
                'updated_at' => $time
            ]);
        }
        return true;
    }

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
