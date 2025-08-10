<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Seeder;



class typeseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      
        Type::factory()->count(1000)->create();
    }
}
