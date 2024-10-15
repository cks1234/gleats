<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Job;

class License extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'license',
        'expiry'
    ];

    protected $casts = [
        'expiry' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobs()
    {
        return $this->hasMany(Job::class, 'license_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($license) {
            Job::where('license_id', $license->id)->update([
                'supervisor_id' => null,
                'license_id' => null,
            ]);
        });
    }
}
