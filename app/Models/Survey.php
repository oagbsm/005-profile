<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'age',
        'credits',
        'respondent_limit',         // Demographic field
        'location',    // Demographic field
        'gender',      // Demographic field
        'created_at',  // Created timestamp
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}

