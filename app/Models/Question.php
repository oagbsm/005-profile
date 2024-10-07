<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    // Specify the attributes that can be mass-assigned
    protected $fillable = [
        'question_text',
        'question_type',
        'options', // Assuming options are stored as JSON
        'survey_id', // Associate with Survey
    ];

    // Define relationships
    public function survey()
    {
        return $this->hasMany(Option::class);
    }
    public function options()
    {
        return $this->hasMany(Option::class);
    }
    public function linkedQuestions()
    {
        return $this->hasMany(LinkedQuestion::class);
    }
}
