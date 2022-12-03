<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class invoice_customer extends Model
{
    use HasFactory;
    protected $fillable=['id', 'customer_id','discount','total_before','total_after','created_by','updated_by','profit','payed','com_code'];

    public function customer()
    {
        return $this->belongsTo(customer::class);
    }
    public function inventory()
    {
        return $this->belongsToMany(inventory::class,'order_customers')->withTrashed()->withPivot('id','invoice_customer_id','inventory_id','price_before_discount','quantity','discount','price_after_discount');
    }

    public function order()
    {
        return $this->hasMany(order_customer::class);
    }
    public function exchangeRevenue()
    {
        return $this->hasMany(exchangeRevenue::class,'fk')->where('type', '=', '4');
    }


}
