<?php

namespace Database\Factories;

use App\Models\Media;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Media>
 */
class MediaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         $texts = ['RTX graphics card', 'AMD Radeon GPU', 'gaming graphics', 'card hardware', 'computer', 'motherboard','GPU Gamer'];
         return [
            //  "source" =>str_replace(
            //     'via.placeholder.com',
            //     'dummyimage.com',
            //     fake()->imageUrl(360, 360,'',true)
            // )
            "source" => fake()
                        ->imageUrl(
                            360,
                            360,
                            fake()->bothify(
                                fake()->randomElement($texts).
                                ' ####'
                            ),
                            true
                        )
        ];
    }
}
