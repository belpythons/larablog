<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use App\Enums\PillarType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        $title = $this->faker->sentence(6);
        $pillar = $this->faker->randomElement(array_column(PillarType::cases(), 'value'));

        return [
            'user_id' => User::factory(),
            'title' => $title,
            'slug' => Str::slug($title),
            'pillar' => $pillar,
            'excerpt' => $this->faker->paragraph(),
            'content_theory' => $this->faker->paragraphs(3, true),
            'content_technical' => "```php\n// Sample Code\npublic function handle() {\n    return 'Hello World';\n}\n```",
            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
