<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $author = User::inRandomOrder()->first();

        return [
            'title' => $this->faker->word,
            'author' => $author->pseudonym,
            'publication_year' => $this->faker->numberbetween(1900,2022)
        ];
    }
}
