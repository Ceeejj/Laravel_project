<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tasks = [
            ['task_title' => 'Personal Tasks'],
            ['task_title' => 'Team Tasks'],
            ['task_title' => 'Progress']
        ];

        DB::table('tasks')->insert($tasks);
    }
}
