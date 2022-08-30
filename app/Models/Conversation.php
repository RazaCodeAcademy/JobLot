<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'job_id',
        'user_id',
        'deleted_by_employee',
        'deleted_by_employer',
    ];

    protected $appends = ['image'];

    public function getImageAttribute(){
        return User::find($this->user_id)->get_image();
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'conversation_id', 'id');
    }

    public function recipient()
    {
        return $this->belongsToMany(User::class, 'participants', 'conversation_id', 'user_id');
    }

    public function getLastMessage(){
        $lastMessage = $this->messages->last() ? Str::limit($this->messages->last()->text, 12).'...' : '....';
        return [
            'text' => $lastMessage,
        ];
    }
}