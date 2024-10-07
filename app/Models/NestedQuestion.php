<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NestedQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_text',
        'question_type',
        'parent_question_id',
    ];

    // Define the relationship to the parent question
    public function parentQuestion()
    {
        return $this->belongsTo(Question::class, 'parent_question_id');
    }
}
