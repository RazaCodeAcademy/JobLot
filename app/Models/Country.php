<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 
        'name_ar',
        'currency'
        
    ];

    
    public function city()
    {
        return $this->hasMany(City::class, 'country_id', 'id');
    }
    
}
