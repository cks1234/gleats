<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_no',
        'type',
        'client_id',
        'supervisor_id',
        'license_id',
        'work_address_id',
        'description',
        'status'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function license()
    {
        return $this->belongsTo(License::class, 'license_id');
    }

    public function test_report_certificates()
    {
        return $this->hasMany(TestReportCertificate::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class, 'work_address_id');
    }
}
