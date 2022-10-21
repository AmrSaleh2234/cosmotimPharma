<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order_gift extends Model
{
    use HasFactory;
    protected $fillable=['id','gift_id','inventory_id','quantity','total'];

    public function gift()
    {
        return $this->belongsTo(gift::class);
   }


}
