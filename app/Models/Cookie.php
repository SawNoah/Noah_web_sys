<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cookie extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description'
    ];

    public function category()
    {
        return $this->belongsTo(EmployeeCategory::class);
    }
}
