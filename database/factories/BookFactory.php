<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Book>
 */
class BookFactory extends Factory
{
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'publisher' => $this->faker->company(),
            'author' => $this->faker->name(),
            'genre' => $this->faker->word(),
            'publication_date' => $this->faker->date(),
            'words_count' => $this->faker->numberBetween(1000, 200000),
            'price_usd' => $this->faker->randomFloat(2, 5, 100),
        ];
    }
}
