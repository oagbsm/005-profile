<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->foreignId('survey_id')->constrained()->onDelete('cascade'); // Foreign key referencing surveys
            $table->text('question_text'); // The question text
            $table->enum('question_type', ['dropdown', 'multiple_choice', 'text']); // Question type
            $table->integer('target_age_min')->nullable(); // Minimum target age
            $table->integer('target_age_max')->nullable(); // Maximum target age
            $table->enum('target_gender', ['male', 'female', 'other', 'all'])->nullable(); // Target gender
            $table->string('target_location')->nullable(); // Target location
            $table->timestamps(); // Created and updated timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
