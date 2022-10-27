<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class expenses extends Model
{
    use HasFactory,softDeletes;
    protected $fillable = ['id','name','com_code','created_by','updated_by','active'];
    public function exchangeRevenue()
    {
        return $this->hasMany(exchangeRevenue::class,'fk')->where('type', '=', '8');
    }

}
