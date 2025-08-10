<?php

namespace Database\Factories;
use App\Models\Type;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Definition>
 */
class DefinitionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->word(),
            'code' => 'C-' . fake()->unique()->randomNumber(5),
            'barcode' => fake()->unique()->ean13(),
            'type_id' => Type::inRandomOrder()->first()->id ?? Type::factory()->create()->id, // ✅ حل المشكلة
            'madin' => fake()->boolean() ? fake()->word() : null,
            'image' => fake()->imageUrl(200, 200),
        ];
    }
}
