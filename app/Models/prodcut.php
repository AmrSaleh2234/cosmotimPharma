<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class prodcut extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'com_code',
        'created_by',
        'updated_by'
    ];
    public function inventory()
    {
        return $this->hasMany(inventory::class);
    }
}
