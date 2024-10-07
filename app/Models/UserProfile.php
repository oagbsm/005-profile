<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    // Define the table if it's not the plural form of the model name
    protected $table = 'user_profile'; // Optional if the table name matches the plural form of the model

    // Specify the fillable fields
    protected $fillable = ['userid', 'age', 'gender', 'location'];
}
