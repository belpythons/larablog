<?php

namespace Database\Factories;

use App\Models\Version;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class VersionFactory extends Factory
{
    protected $model = Version::class;

    public function definition(): array
    {
        $name = 'v' . $this->faker->numberBetween(10, 12) . '.x';
        return [
            'name' => $name . ' (Stable)',
            'slug' => Str::slug($name),
        ];
    }
}
