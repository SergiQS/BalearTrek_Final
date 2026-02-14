<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Comment;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{       
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
     
    public function definition(): array
    {
        return [
            
            'url' => fake()->imageUrl(),
            'comment_id' =>Comment::inRandomOrder()->first()?->id // para crear una imagen con id asociado al comment

        ];
    }
}
