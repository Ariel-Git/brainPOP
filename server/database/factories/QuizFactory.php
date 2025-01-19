<?php

namespace Database\Factories;

use App\Models\Quiz;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class QuizFactory extends Factory
{
    protected $model = Quiz::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}