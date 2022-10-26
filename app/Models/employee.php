<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employee extends Model
{
    use HasFactory;
    protected $fillable=['id','name','phone','address','balance','start_balance','salary','salary_day','com_code','created_by','updated_by'];

    public function employee_datails()
    {
        return $this->hasMany(employee_details::class);
    }
    public function exchangeRevenue()
    {
        return $this->hasMany(exchangeRevenue::class)->where('type', '=', '5');
    }

}
