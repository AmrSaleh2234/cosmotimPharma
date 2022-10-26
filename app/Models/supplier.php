<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class supplier extends Model
{
    use HasFactory;
    protected $fillable = ['id','name','phone','address','balance','balance_status','com_code','start_balance_status',
    'start_balance','created_by','updated_by','active'];
    public function invoice_supplier()
    {
        return$this->hasMany(invoice_supplier::class);
    }

}
