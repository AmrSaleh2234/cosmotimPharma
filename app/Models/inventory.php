<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class inventory extends Model
{
    use HasFactory;
    protected $fillable=[
        'id','product_id','com_code','quantity','price_before','price_after','created_by','updated_by',
    ];
    public function product()
    {
        return $this->belongsTo(prodcut::class);
    }

}
