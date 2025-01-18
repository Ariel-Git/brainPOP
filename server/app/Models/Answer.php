<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = ['question_id', 'text', 'is_correct']; // Example fields

    // Relationship: An answer belongs to a question
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}