<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_id',
        'sale_price',
        'sale_quantity',
        'sale_date',
        'customer',
        'staff',
        'comment',
    ];

    /**
     *リレーション 
     * 
     */

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
