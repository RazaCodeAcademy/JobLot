<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeBussinessCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'category', 
        'category_ar',
       
        
    ];
}
