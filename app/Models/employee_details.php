<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employee_details extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'employee_id', 'type', 'done', 'created_by', 'updated_by'
    ];

    public function employee()
    {
        return $this->belongsTo(employee::class);
    }
}
