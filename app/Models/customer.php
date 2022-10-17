<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class customer extends Model
{
    use HasFactory;
    protected $fillable = ['id','name','phone','address','balance','balance_status','com_code','start_balance_status',
        'start_balance','discount','created_by','updated_by','active'];
    public function invoice_customer()
    {
        return$this->hasMany(invoice_customer::class);
    }






}
