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
        DB::table('users')->insert(['name' => 'tester', 'email' => 'a@b.c','password' => bcrypt('123456')]);
        DB::table('quizzes')->insert(['title' => 'Capital Cities']);

        DB::table('questions')->insert([
            ['quiz_id' => 1, 'question' => 'What is the capital of France?'],
            ['quiz_id' => 1, 'question' => 'What is the capital of Germany?'],
            ['quiz_id' => 1, 'question' => 'What is the capital of Israel?'],
            ['quiz_id' => 1, 'question' => 'What is the capital of Spain?'],
            ['quiz_id' => 1, 'question' => 'What is the capital of Australia?'],
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
            ['question_id' => 5, 'answer' => 'Perth', 'is_correct' => false],
            ['question_id' => 5, 'answer' => 'Canberra', 'is_correct' => true],
            ['question_id' => 5, 'answer' => 'Sydney', 'is_correct' => false],
            ['question_id' => 5, 'answer' => 'Melbourne', 'is_correct' => false],
        ]);
    }
}
