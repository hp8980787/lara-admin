<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'bill_id', 'category_id', 'amount', 'remark', 'writer', 'viewer', 'status', 'model', 'model_id', 'week', 'day', 'month', 'year'
    ];
    protected $casts = [
        'created_at' => 'string:Y-m-d H:i:s',
        'updated_at' => 'string:Y-m-d H:i:s',
    ];

    public function values()
    {
        return $this->belongsToMany(BillColumn::class, 'bill_to_values', 'bill_id', 'column_id')
            ->withTimestamps()->withPivot('value');
    }

    public function writerUser()
    {
        return $this->belongsTo(User::class, 'writer', 'id');
    }

    public function category()
    {
        return $this->belongsTo(BillCategory::class, 'category_id', 'id');
    }

    public function bill()
    {
        return $this->belongsTo(Bill::class,'bill_id','id');
    }

}
