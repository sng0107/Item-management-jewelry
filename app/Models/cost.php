<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cost extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'user_id',
        'metal_cost',
        'chain_cost',
        'parts_cost',
        'stone_cost',
        'processing_cost',
        'other_cost',
        'total_cost',
        'cost_rate',
        'comment',
    ];

    /**
     *リレーション 
     * 
     */

    public function item()
    {
        //リレーション先のカラムでの並び替え(表示されるようになったが並び変わらなかった)
        // return $this->belongsTo(Item::class)
        // ->orderBy('item_code', 'desc');

        return $this->belongsTo(Item::class);
    }


    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }



}
