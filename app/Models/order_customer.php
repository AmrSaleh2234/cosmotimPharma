<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order_customer extends Model
{
    use HasFactory;
    protected $fillable=['invoice_customer_id','inventory_id','price_before_discount','quantity','discount','price_after_discount'];

    public function customer()
    {
        return $this->belongsTo(invoice_customer::class,'invoice_customer_id');
    }
    public function inventory()
    {
        return $this->belongsTo(inventory::class)->withTrashed();
    }
}
