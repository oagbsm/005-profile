<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserProfileSeeder extends Seeder
{
    public function run()
    {
        DB::table('user_profile')->insert([
            [
                'userid' => 1, // Replace with actual user ID from users table
                'age' => 25,
                'gender' => 'Male',
                'location' => 'New York',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'userid' => 2, // Replace with actual user ID from users table
                'age' => 30,
                'gender' => 'Female',
                'location' => 'Los Angeles',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'userid' => 3, // Replace with actual user ID from users table
                'age' => 22,
                'gender' => 'Non-binary',
                'location' => 'Chicago',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more entries as needed
        ]);
    }
}
