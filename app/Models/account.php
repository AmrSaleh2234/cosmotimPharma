<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class account extends Model
{
    use HasFactory,softDeletes;
    protected $fillable = ['id','name','account_type','balance','balance_status','com_code'];

}
