<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_code',
        'supplier_name',
    ];


     /**
     * リレーション
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
