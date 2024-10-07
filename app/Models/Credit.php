<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
    ];

    // You can also define relationships if needed
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
