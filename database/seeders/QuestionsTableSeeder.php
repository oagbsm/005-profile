<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;

class QuestionsTableSeeder extends Seeder
{
    public function run()
    {
        Question::create([
            'survey_id' => 1, // Replace with an actual survey ID
            'question_text' => 'How satisfied are you with our service?',
            'question_type' => 'multiple_choice',
            'target_age_min' => 18,
            'target_age_max' => 65,
            'target_gender' => 'all',
            'target_location' => null,
        ]);

        Question::create([
            'survey_id' => 1, // Replace with another survey ID
            'question_text' => 'What improvements would you suggest?',
            'question_type' => 'text',
            'target_age_min' => null,
            'target_age_max' => null,
            'target_gender' => 'all',
            'target_location' => null,
        ]);
    }
}
