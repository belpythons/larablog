<?php

namespace Database\Factories;

use App\Models\Component;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ComponentFactory extends Factory
{
    protected $model = Component::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->word() . ' Component';
        return [
            'name' => ucfirst($name),
            'class_name' => 'x-' . Str::slug($name),
            'blade_snippet' => '<x-component>Content</x-component>',
            'preview_html' => '<div class="p-4 bg-gray-100">Preview</div>',
        ];
    }
}
