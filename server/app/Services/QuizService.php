<?php

namespace App\Services;

use App\Models\Answer;
use App\Models\SubmittedAnswer;
use Illuminate\Support\Facades\Auth;

class QuizService
{


    /**
     * Process the submitted quiz answers.
     *
     * 
     * */
    public function getQuiz(): array
    {
        $quiz = Quiz::with(['questions' => function ($query) {
            $query->with(['answers' => function ($answerQuery) {
                // Select specific columns and exclude 'is_correct'
                $answerQuery->select('id', 'question_id', 'answer');
            }]);
        }])->find(1);
        return $quiz;
    }
    
}
