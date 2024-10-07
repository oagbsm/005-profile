<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('user_profile', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('userid'); // Foreign key
            $table->integer('age')->nullable(); // Age field
            $table->string('gender')->nullable(); // Gender field
            $table->string('location')->nullable(); // Location field
            $table->timestamps(); // Created at and Updated at timestamps

            // Set up the foreign key constraint
            $table->foreign('userid')->references('id')->on('users')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_profile', function (Blueprint $table) {
            //
        });
    }
};
