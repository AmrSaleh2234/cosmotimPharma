<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class invoice_customer extends Model
{
    use HasFactory;
    protected $fillable=['id', 'customer_id','discount','total_before','total_after','created_by','updated_by','profit','payed'];

    public function customer()
    {
        return $this->belongsTo(customer::class);
    }
    public function inventory()
    {
        return $this->belongsToMany(inventory::class,'order_customers')->withTrashed()->withPivot('invoice_customer_id','inventory_id','price_before_discount','quantity','discount','price_after_discount');
    }

    public function order()
    {
        return $this->hasMany(order_customer::class)    ;
    }

}
