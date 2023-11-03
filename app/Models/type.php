<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_code',
        'type_name',
    ];


     /**
     * リレーション
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function costs()
    {
        return $this->hasMany(Cost::class);
    }
}
