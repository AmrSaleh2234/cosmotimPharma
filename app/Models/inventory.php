<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class inventory extends Model
{
    use HasFactory,softDeletes;
    protected $fillable=[
        'id','product_id','com_code','quantity','price_before','created_by','updated_by','account_id','deleted_at'
    ];
    public function product()
    {
        return $this->belongsTo(product::class)->withTrashed();
    }
    public function invoice_customer()
    {
        return $this->belongsToMany(invoice_customer::class,'order_customers')->withPivot('invoice_customer_id','inventory_id','price_before_discount','quantity','discount','price_after_discount');
    }
}
