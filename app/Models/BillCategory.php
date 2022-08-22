<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class BillCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'status', 'form'
    ];

    public function scopeActive(Builder $builder)
    {
        return $builder->where('status', 1);
    }

    public function columns()
    {
        return $this->belongsToMany(BillColumn::class, 'category_to_columns', 'category_id', 'column_id')->withTimestamps();
    }
}
