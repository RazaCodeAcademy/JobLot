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
   
   public function get_location()
   {
       return $this->belongsTo(Country::class, 'name', 'id');
   }
   public function get_bussines_catogories()
   {
       return $this->belongsTo(EmployeeBussinessCategory::class, 'business_cat_id', 'id');
   }

   public function user()
    {
        return $this->belongsTo(User::class, 'employer_id' ,'id');
    }

    public function category()
    {
        return $this->belongsTo(EmployeeBussinessCategory::class, '	business_cat_id', 'id');
    }

    // employee shortlisted or not
    public function isShortListed($user_id){
        return EmployeeShortListed::where([['job_id', $this->id], ['user_id', $user_id]])->first() ? 1 : 0;
    }

    // employee savedlisted or not
    public function isSavedListed($user_id){
        return SavedJob::where([['job_id', $this->id], ['user_id', $user_id]])->first() ? 1 : 0;
    }

    // employee appliedlisted or not
    public function isAppliedListed($user_id){
        return EmployeeAppliedJob::where([['job_id', $this->id], ['user_id', $user_id]])->first() ? 1 : 0;
    }
}