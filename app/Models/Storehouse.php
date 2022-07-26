<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Storehouse extends Model
{
    use HasFactory;

    protected $table = 'storehouse';

    protected $fillable = [
        'name'
    ];

    public function stocks()
    {
        return $this->belongsToMany(Product::class, 'product_storehouse', 'storehouse_id', 'product_id')
            ->withTimestamps()->withPivot('stock');
    }

    public function record(int $type,object $info) :bool
    {
        switch ($type){
            case 1:

        }
    }
}
