<?php

namespace Database\Seeders;

use App\Models\definition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class definitionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        definition::factory()->count(100)->create();
    }
}
