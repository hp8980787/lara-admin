<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillColumn extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'label', 'active', 'required'
    ];
}
