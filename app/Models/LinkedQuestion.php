
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinkedQuestion extends Model
{
    protected $fillable = ['question_id', 'linked_question_id'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function linkedQuestion()
    {
        return $this->belongsTo(Question::class, 'linked_question_id');
    }
}
