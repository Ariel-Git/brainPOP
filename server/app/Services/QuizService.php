<?php

namespace App\Services;

use App\Models\Answer;
use App\Models\SubmittedAnswer;
use Illuminate\Support\Facades\Auth;
use App\Models\Quiz;
class QuizService
{


    /**
     * Get Quiz
     * @param no
     * @return array
     * @throws \Exception
     * */
    public function getQuiz(): Quiz
    {
        $quiz = Quiz::with(['questions' => function ($query) {
            $query->with(['answers' => function ($answerQuery) {
                // Select specific columns and exclude 'is_correct'
                $answerQuery->select('id', 'question_id', 'answer');
            }]);
        }])->find(1);
        return $quiz;
    }

    public function handleQuizSubmit($reqData)
    {
        $answers = json_decode($reqData['answers'], true)['answers'];
            $correctCount = 0;

            $answersWithIsCorrect = [];
            foreach ($answers as $answer) {
                $isCorrect = Answer::where('id', $answer['selectedAnswer'])->value('is_correct');
                if ($isCorrect) $correctCount++;
                
                $answer = array_merge($answer, ['isCorrect' => $isCorrect]);
                array_push($answersWithIsCorrect, $answer);
            }
            SubmittedAnswer::create([
                'user_id' => auth()->id(), 
                'answers' => json_encode($answers) 
            ]);
            return response()->json([
                'correct' => $correctCount,
                'total' => count($answers),
                'answers' => $answersWithIsCorrect
            ]);
    }
    
    public function getUserQuizHistory()
    {
        $submittedAnswers = SubmittedAnswer::where('user_id', auth()->id() )->get();
        return response()->json($submittedAnswers);
    }

    
}
