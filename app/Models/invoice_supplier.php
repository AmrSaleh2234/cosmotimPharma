<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoice_supplier extends Model
{
    use HasFactory;
    protected $fillable=['id','supplier_id','total','payed','created_by','updated_by','com_code'];

    public function supplier()
    {
        return $this->belongsTo(supplier::class);
    }
    public function inventory()
    {
        return $this->belongsToMany(inventory::class,'order_suppliers')->withTrashed()->withPivot('id','invoice_supplier_id','inventory_id','quantity','pricePerOne','total');
    }

    public function order()
    {
        return $this->hasMany(order_supplier::class);
    }
    public function exchangeRevenue()
    {
        return $this->hasMany(exchangeRevenue::class,'fk')->where('type', '=', '3');
    }


}
