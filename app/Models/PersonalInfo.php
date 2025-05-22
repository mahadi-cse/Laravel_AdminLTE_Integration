<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalInfo extends Model
{
    use HasFactory;

    protected $table = 'personal_info';

    protected $fillable = [
        'user_id',
        'name',
        'father_name',
        'mother_name',
        'email',
        'phone_number',
        'present_address',
        'permanent_address',
        'nationality',
        'hobby',
        'dob',
        'gender',
        'identity_type',
        'nid_number',
        'bid_number',
        'profile_photo_path',
        'covid_certificate_path',
        'description',
    ];
}
