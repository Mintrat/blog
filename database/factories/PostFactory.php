<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'content' => $this->faker->text(1000),
            'image' => 'photo1.jpg',
            'date' => '08/09/22',
            'views' => $this->faker->biasedNumberBetween(0, 9999),
            'category_id' => 1,
            'user_id' => 1,
            'status' => Post::IS_PUBLIC,
            'is_featured' => Post::IS_STANDART,
            'description' => $this->faker->text(5),
        ];
    }
}
