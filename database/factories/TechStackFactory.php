<?php

namespace Database\Factories;

use App\Models\TechStack;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TechStackFactory extends Factory
{
    protected $model = TechStack::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->word();
        return [
            'name' => ucfirst($name),
            'slug' => Str::slug($name),
            'type' => $this->faker->randomElement(['framework', 'library', 'ui_kit', 'server']),
            'website_url' => $this->faker->url(),
            'icon_path' => null,
        ];
    }
}
