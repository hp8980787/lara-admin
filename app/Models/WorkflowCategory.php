<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkflowCategory extends Model
{
    use HasFactory;

    protected $table = 'workflow_categories';
    protected $fillable = ['name'];
    protected  $casts=[
        'created_at' => 'date:Y-m-d H:i:s',
        'updated_at' => 'date:Y-m-d H:i:s'
    ];
}
