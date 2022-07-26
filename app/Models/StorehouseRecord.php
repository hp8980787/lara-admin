<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorehouseRecord extends Model
{
    use HasFactory;
    protected  $fillable =[
        'storehouse_id','product_id','quantity','status','reviewer'
    ];
}
