<?php

namespace Database\Factories;

use App\Models\Answer;
use App\Models\Question; // If the answer is associated with a question
use Illuminate\Database\Eloquent\Factories\Factory;

class AnswerFactory extends Factory
{
    protected $model = Answer::class;

    public function definition()
    {
        return [
            'question_id' => Question::factory(), 
            'answer' => $this->faker->sentence,   
            'is_correct' => $this->faker->boolean,
        ];
    }
}