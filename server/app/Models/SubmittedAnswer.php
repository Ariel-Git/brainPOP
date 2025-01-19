<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmittedAnswer extends Model
{
    use HasFactory;

    protected $table = 'submitted_answers'; 

    protected $fillable = [
        'user_id',
        'answers', 
    ];

    protected $casts = [
        'answers' => 'array',
    ];
}