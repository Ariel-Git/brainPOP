<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Answer;
use App\Models\SubmittedAnswer;
use App\Services\QuizService;
use App\Http\Requests\SubmitAnswersRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class QuizController extends Controller
{
    public function index(QuizService $quizService)
    {
        try{
            return response()->json($quizService->getQuiz());
        }catch(\Exception $err){
            Log::error('Exception details:', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return response()->json(['error' => 'Something went wrong, please try again later.'], 500);
        }
    }
    public function submit(SubmitAnswersRequest $request, QuizService $quizService)
    {
        try{
            $validatedData = $request->validated();
            return response()->json($quizService->handleQuizSubmit($validatedData));
            
        }catch(\Exception $err){
            Log::error('Exception details:', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return response()->json(['error' => 'Something went wrong, please try again later.'], 500);
        }
        
    }
    public function getMyAnswers(QuizService $quizService){
        try{
            return $quizService->getUserQuizHistory();
        }catch(\Exception $err){
            Log::error('Exception details:', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return response()->json(['error' => 'Something went wrong, please try again later.'], 500);
        }
    }
    public function getLastAnswers(QuizService $quizService){
        try{
            return $quizService->getUserLastAnswers();
        }catch(\Exception $err){
            Log::error('Exception details:', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return response()->json(['error' => 'Something went wrong, please try again later.'], 500);
        }
    }
}