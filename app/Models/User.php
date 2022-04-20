<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Passport\HasApiTokens;

// use facades here
use Carbon\Carbon;


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
        'profile_image',
        'social_id',
        'social_type',
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

    // protected $appends = ['saved', 'shortListed', 'applied'];

    // public function getSavedAttribute(){
    //     return $this->isSavedListed()
    // }

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
            return asset('public/images/1615444706.jpg');
        }
    }

    public function saved_jobs()
    {
        return $this->belongsToMany(Job::class, 'saved_jobs', 'user_id', 'job_id');
    }

    public function applied_jobs()
    {
        return $this->belongsToMany(Job::class, 'employee_applied_jobs', 'user_id', 'job_id');
    }

    public function get_jobs()
    {
        return $this->hasMany(Job::class, 'employer_id', 'id');
    }

    public function get_experiences()
    {
        return $this->hasMany(EmployeeExperience::class, 'user_id', 'id');
    }

 

    public function get_notification()
    {
        return $this->hasMany(Notification::class, 'notifiable_id', 'id')->where('read_at', null)->orderBy('created_at', 'desc');
    }
    
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'model_has_roles', 'model_id', 'role_id');
    }
    public function country()
    {
        return $this->belongsTo(Country::class, 'state_id', 'id');
    }
    
    public function city()
    {
        return $this->belongsTo(City::class, 'city_name', 'id');
    }

    public function jobs()
    {
        return $this->hasMany(Job::class, 'employer_id', 'id');
    }
    
    public function jobAppliedEmployee()
    {
        // return $this->jobs->pluck('id');
        return EmployeeAppliedJob::whereIn('job_id', $this->jobs->pluck('id'))->count();
    }

    public function getLastMessage(){
        $conversation = Conversation::where([
            ['moderator_id', $user->id],
            ['participant_id', $participantId],
        ])->orWhere([
            ['moderator_id', $participantId],
            ['participant_id', $user->id],
        ])->first();

        $lastMessage = $this->messages->last() ? Str::limit($this->messages->last()->text, 12).'...' : '....';
        return [
            'text' => $lastMessage,
        ];
    }

    // employee shortlisted or not
    public function isShortListed($job_id){
        return EmployeeShortListed::where([['job_id', $job_id], ['user_id', $this->id]])->first() ? 1 : 0;
    }

    // employee savedlisted or not
    public function isSavedListed($job_id){
        return EmployeeSavedListed::where([['job_id', $job_id], ['user_id', $this->id]])->first() ? 1 : 0;
    }

    // employee appliedlisted or not
    public function isAppliedListed($job_id){
        return EmployeeAppliedJob::where([['job_id', $job_id], ['user_id', $this->id]])->first() ? 1 : 0;
    }

    // is saved job
    public function isSavedJob($id){
        return $this->saved_jobs()->where('job_id', $id)->first() ? true : false;
    }

    // is saved job
    public function isAppliedJob($id){
        return $this->applied_jobs()->where('job_id', $id)->first() ? true : false;
    }

    public function getLastLogin(){
        return $this->last_login != null ? Carbon::parse($this->last_login)->diffForHumans() : 'N/A';
    }
}
