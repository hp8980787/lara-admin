<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorehouseRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'storehouse_id', 'product_id', 'quantity', 'status', 'reviewer'
    ];
    protected  $casts=[
        'created_at'=>'string:Y-m-d H:i:s',
        'updated_at'=>'string:Y-m-d H:i:s',
    ];

    public function storehouse()
    {
        return $this->belongsTo(Storehouse::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class,'reviewer','id');
    }
}
