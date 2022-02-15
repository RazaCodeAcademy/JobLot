<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Passport\HasApiTokens;


class User extends Authenticatable
{
    use Notifiable, HasRoles, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 
        'last_name', 
        'street_address', 
        'city_name', 
        'state_id', 
        'zip_code', 
        'terms_and_conditions', 
        'email', 
        'password', 
        'phone_number',
        'comp_name',
        'comp_location',
        'salary_schedual',
        'job_schedual_from',
        'job_schedual_to',
        'latitude',
        'longitude',
        'profile_image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function get_name(){
        if(!empty($this->first_name) && !empty($this->last_name)){
            return $this->first_name.' '.$this->last_name;
        }else{
            return "Guest User";
        }
    }

    public function get_image(){
        if(!empty($this->profile_image)){
            return asset('storage/app/'.$this->profile_image);
        }else{
            return asset('images/12432424.jpg');
        }
    }

    public function saved_jobs()
    {
        return $this->belongsToMany(Job::class, 'saved_jobs', 'user_id', 'job_id');
    }

    public function get_jobs()
    {
        return $this->hasMany(Job::class, 'employer_id', 'id');
    }

    public function get_experiences()
    {
        return $this->hasMany(EmployeeExperience::class, 'user_id', 'id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'model_has_roles', 'model_id', 'role_id');
    }

    public function get_notification()
    {
        return $this->hasMany(Notification::class, 'notifiable_id', 'id')->where('read_at', null);
    }
}
