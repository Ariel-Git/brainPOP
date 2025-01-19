<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Answer;
use App\Models\SubmittedAnswer;
use App\Http\Requests\SubmitAnswersRequest;
use App\Http\Controllers\Controller;

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
    public function submit(SubmitAnswersRequest $request)
    {
        try{
            $validatedData = $request->validated();
            $answers = json_decode($validatedData['answers'], true)['answers'];
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
        }catch(\Exception $err){
            throw $err;
        }
        
    }
    public function getMyAnswers(){
        try{
            $submittedAnswers = SubmittedAnswer::where('id', auth()->id())->get();
            return response()->json($submittedAnswers);
        }catch(\Exception $err){
            throw $err;
        }
    }
}