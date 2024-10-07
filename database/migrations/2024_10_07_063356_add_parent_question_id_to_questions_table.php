<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddParentQuestionIdToQuestionsTable extends Migration
{
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->unsignedBigInteger('parent_question_id')->nullable()->after('id');

            // If you want to set up a foreign key constraint, uncomment the line below
            // $table->foreign('parent_question_id')->references('id')->on('questions')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropForeign(['parent_question_id']); // Drop foreign key constraint if it exists
            $table->dropColumn('parent_question_id');
        });
    }
}
