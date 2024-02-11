<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Bug Report',
            'Feature Request',
            'Improvement',
            'General Feedback',
            'Usability Issue',
            'Security Concern',
            'Performance Problem',
            'Compatibility Issue',
            'User Interface',
            'Other',
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'title' => $category,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
