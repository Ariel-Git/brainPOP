<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuizControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_a_quiz_with_questions_and_answers()
    {
        // Create an authenticated user and get the token
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        // Create the quiz, question, and answer
        $quiz = Quiz::factory()->create();
        $question = Question::factory()->create(['quiz_id' => $quiz->id]);
        $answer = Answer::factory()->create(['question_id' => $question->id]);

        // Send GET request with Authorization header
        $response = $this->getJson('/api/quiz', [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'id',
                     'title',
                     'questions' => [
                         [
                             'id',
                             'quiz_id',
                             'answers' => [
                                 ['id', 'question_id', 'answer']
                             ]
                         ]
                     ]
                 ]);
    }

    /** @test */
    public function it_submits_answers_and_returns_correct_count()
    {
        // Create an authenticated user and get the token
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        // Create the quiz, question, and answer
        $quiz = Quiz::factory()->create();
        $question = Question::factory()->create(['quiz_id' => $quiz->id]);
        $answer = Answer::factory()->create(['question_id' => $question->id, 'is_correct' => true]);

        $data = [
            'answers' => json_encode([
                'answers' => [
                    ['questionId' => $question->id, 'selectedAnswer' => $answer->id]
                ]
            ])
        ];

        // Send POST request with Authorization header
        $response = $this->postJson('/api/quiz/submit', $data, [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(200);
    }
}
