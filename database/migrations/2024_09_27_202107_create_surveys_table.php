<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveysTable extends Migration
{
    public function up()
    {
        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Assuming you have a user_id
            $table->string('title');
            $table->text('description')->nullable(); // Add nullable if needed
            $table->string('age')->nullable();
            $table->string('location')->nullable();
            $table->string('gender')->nullable();
            $table->integer('credits') ;// Default value for credits
            $table->integer('respondent_limit')-// Default value for respondent_limit
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('surveys');
    }
}
