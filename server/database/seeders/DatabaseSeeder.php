<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       // DB::table('users')->insert(['name' => 'tester', 'password', bcrypt('123456')]);
        DB::table('quizzes')->insert(['title' => 'General Knowledge']);

        DB::table('questions')->insert([
            ['quiz_id' => 1, 'question' => 'What is the capital of France?'],
            ['quiz_id' => 1, 'question' => 'What is the capital of Germany?'],
            ['quiz_id' => 1, 'question' => 'What is the capital of Israel?'],
            ['quiz_id' => 1, 'question' => 'What is the capital of Spain?'],

        ]);

        DB::table('answers')->insert([
            ['question_id' => 1, 'answer' => 'Paris', 'is_correct' => true],
            ['question_id' => 1, 'answer' => 'Berlin', 'is_correct' => false],
            ['question_id' => 1, 'answer' => 'Jerusalem', 'is_correct' => false],
            ['question_id' => 1, 'answer' => 'Madrid', 'is_correct' => false],
            ['question_id' => 2, 'answer' => 'Paris', 'is_correct' => false],
            ['question_id' => 2, 'answer' => 'Berlin', 'is_correct' => true],
            ['question_id' => 2, 'answer' => 'Jerusalem', 'is_correct' => false],
            ['question_id' => 2, 'answer' => 'Madrid', 'is_correct' => false],
            ['question_id' => 3, 'answer' => 'Paris', 'is_correct' => false],
            ['question_id' => 3, 'answer' => 'Berlin', 'is_correct' => false],
            ['question_id' => 3, 'answer' => 'Jerusalem', 'is_correct' => true],
            ['question_id' => 3, 'answer' => 'Madrid', 'is_correct' => false],
            ['question_id' => 4, 'answer' => 'Paris', 'is_correct' => false],
            ['question_id' => 4, 'answer' => 'Berlin', 'is_correct' => false],
            ['question_id' => 4, 'answer' => 'Jerusalem', 'is_correct' => false],
            ['question_id' => 4, 'answer' => 'Madrid', 'is_correct' => true],
        ]);
    }
}
