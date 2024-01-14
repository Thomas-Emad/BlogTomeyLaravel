<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = ['Programming', 'Data Engineering', 'Data Science', 'Technology', 'Self Improvement', 'Writing', 'Machine Learning', 'Productivity', 'Politics', 'Cryptocurrency', 'Psychology', 'History', 'Money', 'Business', 'Coding', 'Software Development', 'Artificial Intelligence (AI)', 'Web Development', 'Android', 'Apple', 'UI', 'UX'];
        foreach ($types as $type):
            \App\Models\Type::create([
                'name' => $type,
            ]);
        endforeach;
    }
}
