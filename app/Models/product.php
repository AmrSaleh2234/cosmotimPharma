<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class product extends Model
{
    use HasFactory,softDeletes;
    protected $fillable = [
        'name',
        'com_code',
        'created_by',
        'updated_by',
        'price_after',
        'active',
    ];
    public function inventory()
    {
        return $this->hasMany(inventory::class);
    }
}
