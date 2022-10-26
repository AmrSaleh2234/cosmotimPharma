<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class expenses extends Model
{
    use HasFactory;
    protected $fillable = ['id','name','com_code','created_by','updated_by','active'];
    public function exchangeRevenue()
    {
        return $this->hasMany(exchangeRevenue::class)->where('type', '=', '8');
    }

}