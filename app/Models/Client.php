<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'name',
        'email',
        'phone',
        'mobile',
        'postal_address'
    ];

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

}
