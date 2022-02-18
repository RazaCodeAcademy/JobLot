<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobQualifcation extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 
        'name_ar',
       
        
    ];
    protected $table ='job_qualifications';
}
