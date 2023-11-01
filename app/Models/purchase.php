<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class purchase extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'item_id',
        'purchase_price',
        'purchase_quantity',
        'purchase_date',
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
