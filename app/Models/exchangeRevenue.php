<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class exchangeRevenue extends Model
{
    use HasFactory;
    protected $fillable=['id','fk','type','amount'];

    public function supplier()
    {
        return $this->belongsTo(supplier::class)->where('type','=',1)->get();
    }

    public function customer()
    {
        return $this->belongsTo(customer::class)->where('type','=',2)->get();
    }

    public function supplier_invoice()
    {
        return $this->belongsTo(invoice_supplier::class)->where('type','=',3)->get();
    }

    public function customer_invoice()
    {
        return $this->belongsTo(invoice_customer::class)->where('type','=',4)->get();
    }

    public function employee()
    {
        return $this->belongsTo(employee::class)->where('type','=',5)->get();
    }
    public function capital()
    {
        return $this->belongsTo(capital::class)->where('type','=',6)->get();
    }

    public function gift()
    {
        return $this->belongsTo(gift::class)->where('type','=',7)->get();
    }
    public function expenses()
    {
        return $this->belongsTo(expenses::class)->where('type','=',8)->get();
    }


}
