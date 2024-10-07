<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credits extends Model
{
    use HasFactory;

    // If your table name is not 'credits', specify the table name
    protected $table = 'credits';

    // If you have specific fillable fields, add them here
    protected $fillable = ['user_id', 'amount']; // Adjust as per your fields
}
