<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class inventory extends Model
{
    use HasFactory,softDeletes;
    protected $fillable=[
        'id','product_id','com_code','quantity','price_before','created_by','updated_by','supplier_id','deleted_at'
    ];
    public function product()
    {
        return $this->belongsTo(product::class)->withTrashed();
    }
    public function supplier()
    {
        return $this->belongsTo(supplier::class);
    }
    public function order_supplier()
    {
        return $this->hasMany(order_supplier::class);
    }
    public function invoice_customer()
    {
        return $this->belongsToMany(invoice_customer::class,'order_customers')->withPivot('invoice_customer_id','inventory_id','price_before_discount','quantity','discount','price_after_discount');
    }
    public function invoice_supplier()
    {
        return $this->belongsToMany(invoice_supplier::class,'order_supplier')->withPivot('id','invoice_supplier_id','inventory_id','quantity','pricePerOne','total');
    }
    public function gift()
    {
        return $this->belongsToMany(gift::class,'order_gifts')->withPivot('invoice_customer_id','inventory_id','quantity','total');
    }
}
