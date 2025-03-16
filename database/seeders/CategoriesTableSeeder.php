<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['category_name' => 'My Task'],
            ['category_name' => 'Team Tasks'],
            ['category_name' => 'Department Tasks'],
        ];

        DB::table('categories')->insert($categories);
    }
}
