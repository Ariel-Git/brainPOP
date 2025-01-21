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
    /**
     * Submit, calculate score and return it
     * @param no
     * @return array
     * @throws \Exception
     * */
    public function handleQuizSubmit($reqData)
    {   
        // Decode and extract answers from the request data
        $answers = json_decode($reqData['answers'], true)['answers'] ?? [];
    
        // Extract 'selectedAnswer' IDs while handling missing keys gracefully
        $selectedAnswerIds = array_map(
            fn($answer) => $answer['selectedAnswer'] ?? null,
            $answers
        );
    
        // Filter out invalid/null selectedAnswer IDs
        $selectedAnswerIds = array_filter($selectedAnswerIds);
    
        // Retrieve correct answers (is_correct mapping) in a single query
        $answersMap = Answer::whereIn('id', $selectedAnswerIds)
            ->pluck('is_correct', 'id');
    
        $answersWithIsCorrect = [];
    
        // Process answers to check correctness
        foreach ($answers as $answer) {
            $selectedAnswer = $answer['selectedAnswer'] ?? null;
            $isCorrect = $answersMap[$selectedAnswer] ?? false;
    
            // Add isCorrect info to the current answer
            $answersWithIsCorrect[] = array_merge($answer, ['isCorrect' => $isCorrect]);
        }
    
        // Store submitted answers in the database
        SubmittedAnswer::create([
            'user_id' => auth()->id(),
            'answers' => json_encode($answersWithIsCorrect), // Store enhanced answers with isCorrect info
        ]);
    
        // Return true on when data saved
        return true;
    }
    /**
     * Get the user quiz history
     * @param no
     * @return array
     * @throws \Exception
     * */
    public function getUserQuizHistory()
    {
        $submittedAnswers = SubmittedAnswer::where('user_id', auth()->id() )->get();
        return response()->json($submittedAnswers);
    }
    /**
     * Get the user quiz history
     * @param no
     * @return array
     * @throws \Exception
     * */
    public function getUserLastAnswers()
    {
        $lastSubmittedAnswers = SubmittedAnswer::where('user_id', auth()->id())->latest()->first();
        return response()->json($lastSubmittedAnswers);
    }
    
}
