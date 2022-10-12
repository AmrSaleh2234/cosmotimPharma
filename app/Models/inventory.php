<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class inventory extends Model
{
    use HasFactory,softDeletes;
    protected $fillable=[
        'id','product_id','com_code','quantity','price_before','price_after','created_by','updated_by',
    ];
    public function product()
    {
        return $this->belongsTo(prodcut::class)->withTrashed();
    }

}
