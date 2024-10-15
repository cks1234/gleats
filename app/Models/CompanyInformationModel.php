<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyInformationModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'license',
        'name',
        'post_office_box',
        'address',
        'phone',
        'mobile',
        'email'
    ];
}
