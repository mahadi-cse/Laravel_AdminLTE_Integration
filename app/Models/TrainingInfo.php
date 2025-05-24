<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingInfo extends Model
{
    use HasFactory;
    protected $table = 'training_info';
    protected $fillable = [
        'user_id',
        'ref_id',
        'training_title',
        'institute_name',
        'duration',
        'training_year',
        'location',
    ];
}
