<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class NewUser extends Authenticatable
{
    use HasApiTokens, HasFactory;

    // fillable data
    protected $fillable = [
        'first_name',
        'last_name',
        'business_name',
        'city_name',
        'state_id',
        'zip_code',
        'email',
        'email_verified_at',
        'phone_number',
        'password',
        'profile_image',
        'terms_and_conditions',
        'status',
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
}
