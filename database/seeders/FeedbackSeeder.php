<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeedbackSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 5; $i++) {
            DB::table('feedbacks')->insert([
                'title' => 'Feature Report',
                'description' => 'This is a Feature report example.',
                'category_id' => 4,
                'user_id' => 1,
            ]);
        }


        for ($i = 1; $i <= 5; $i++) {
            DB::table('feedbacks')->insert([
                'title' => 'Testing Report',
                'description' => 'This is a Testing report example.',
                'category_id' => 7,
                'user_id' => 1,
            ]);
        }


        for ($i = 1; $i <= 5; $i++) {
            DB::table('feedbacks')->insert([
                'title' => 'Usability Issue',
                'description' => 'This is a Usability Issue report example.',
                'category_id' => 9,
                'user_id' => 1,
            ]);
        }

  

        // Add more feedbacks as needed
    }
}
