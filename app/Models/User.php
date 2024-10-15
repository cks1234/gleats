<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'mobile',
        'address',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function licenses()
    {
        return $this->hasMany(License::class);
    }

    public function jobs()
    {
        return $this->hasMany(Job::class, 'supervisor_id');
    }
}
