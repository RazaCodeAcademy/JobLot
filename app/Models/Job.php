<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
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
        'comp_name',
        'comp_location',
        'salary_schedual',
        'job_schedual_from',
        'job_schedual_to'
    ];


    public function saved_jobs()
    {
        return $this->belongsToMany(User::class, 'saved_jobs', 'job_id', 'user_id');
    }

    public function get_employees()
    {
        return $this->belongsToMany(User::class, 'employee_applied_jobs', 'job_id', 'user_id');
    }
}
