<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicInfo extends Model
{
    use HasFactory;
    protected $table = 'academic_info';
    protected $fillable = [
        'user_id',
        'ref_id',
        'education_level',
        'department',
        'institute_name',
        'passing_year',
        'cgpa',
    ];
}
