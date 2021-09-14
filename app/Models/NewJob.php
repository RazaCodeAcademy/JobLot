<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewJob extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'business_cat_id',
        'employer_id',
        'title',
        'salary',
        'job_type',
        'job_qualification',
        'state_authorized',
        'description',
        'status',
        'job_approval',
        'expired',
    ];
}
