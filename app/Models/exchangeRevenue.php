<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class exchangeRevenue extends Model
{
    use HasFactory;
    protected $fillable=['id','fk','type','amount','com_code'];

    public function supplier()//done
    {
        return $this->belongsTo(supplier::class,'fk')->where('type','=',1)->get();
    }

    public function customer()//done
    {
        return $this->belongsTo(customer::class,'fk')->where('type','=',2)->get();
    }

    public function supplier_invoice()
    {
        return $this->belongsTo(invoice_supplier::class,'fk')->where('type','=',3)->get();
    }

    public function customer_invoice()
    {
        return $this->belongsTo(invoice_customer::class,'fk')->where('type','=',4)->get();
    }

    public function employee()
    {
        return $this->belongsTo(employee::class,'fk')->where('type','=',5)->get();
    }
    public function capital()//done
    {
        return $this->belongsTo(capital::class,'fk')->withTrashed()->where('type','=',6)->get();
    }

    public function gift()
    {
        return $this->belongsTo(gift::class,'fk')->where('type','=',7)->get();
    }
    public function expenses()
    {
        return $this->belongsTo(expenses::class,'fk')->withTrashed()->where('type','=',8)->get();
    }


}
