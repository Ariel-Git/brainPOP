<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Answer;

class QuizController extends Controller
{
    public function index()
    {
        $quiz = Quiz::with(['questions' => function ($query) {
            $query->with(['answers' => function ($answerQuery) {
                // Select specific columns and exclude 'is_correct'
                $answerQuery->select('id', 'question_id', 'answer');
            }]);
        }])->find(1);
        
        return response()->json($quiz);
    }
    public function submit(Request $request)
    {
        $answers = $request->input('answers');
        $correctCount = 0;

        $answersWithIsCorrect = [];
        foreach ($answers as $answer) {
            $isCorrect = Answer::where('id', $answer['selectedAnswer'])->value('is_correct');
            if ($isCorrect) $correctCount++;
            
            $answer = array_merge($answer, ['isCorrect' => $isCorrect]);
            array_push($answersWithIsCorrect,$answer);
        }

        return response()->json([
            'correct' => $correctCount,
            'total' => count($answers),
            'answers' => $answersWithIsCorrect
        ]);
    }
}