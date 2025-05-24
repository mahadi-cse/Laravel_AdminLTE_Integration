<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExperienceInfo extends Model
{
    use HasFactory;
    protected $table = 'experience_info';
    protected $fillable = [
        'user_id',
        'ref_id',
        'company_name',
        'designation',
        'location',
        'start_date',
        'end_date',
        'total_years',
    ];
}
