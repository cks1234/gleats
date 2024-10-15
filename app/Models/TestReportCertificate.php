<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestReportCertificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'report',
        'comments',
        'equipment',
        'electrical_work',
        'supervisor_signature',
        'supervisor_signature_date',
        'contractor_signature',
        'contractor_signature_date',
        'status'
    ];

    protected $casts = [
        'supervisor_signature_date' => 'date',
        'contractor_signature_date' => 'date'
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}
