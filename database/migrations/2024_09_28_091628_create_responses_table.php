<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponsesTable extends Migration
{
    public function up()
    {
        Schema::create('responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_id')->constrained()->onDelete('cascade'); // Reference to surveys table
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Reference to users table
            $table->foreignId('question_id')->constrained()->onDelete('cascade'); // Reference to questions table
            $table->text('answer_text')->nullable(); // To store text answers
            $table->foreignId('option_id')->nullable()->constrained()->onDelete('cascade'); // To store selected option
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('responses');
    }
}
