<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class gift extends Model
{
    use HasFactory;
    protected $fillable=['id','description','total','created_by','updated_by'];

    public function order_gift()
    {
        return $this->hasMany(order_gift::class);
    }
    public function inventory()
    {
        return $this->belongsToMany(inventory::class,'order_gifts')->withTrashed()->withPivot('gift_id','inventory_id','quantity','total');
    }

}
