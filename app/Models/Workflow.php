<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workflow extends Model
{
    protected $table = 'workflow';
    protected  $fillable = [
        'name','category_id','status','order','user_id','description'
    ];
    use HasFactory;
}
