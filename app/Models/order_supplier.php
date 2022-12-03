<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order_supplier extends Model
{
    use HasFactory;
    protected $fillable=['id','invoice_supplier_id','inventory_id','quantity','pricePerOne','total'];
    public function invoice_supplier()
    {
        return $this->belongsTo(invoice_supplier::class,'invoice_supplier_id');
    }
    public function inventory()
    {
        return $this->belongsTo(inventory::class)->withTrashed();
    }
}
