<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentSeeder extends Seeder
{
    public function run()
    {
        DB::table('comments')->insert([
            'user_id' => 1,
            'feedback_id' => 1,
            'content' => 'This is a sample comment.',
        ]);

        // Add more comments as needed
    }
}
