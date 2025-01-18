<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['quiz_id', 'text']; // Example fields

    // Relationship: A question belongs to a quiz
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    // Relationship: A question has many answers
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
