<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3), // Generates a book title with 3 words
            'description' => $this->faker->paragraph(), // Generates a random paragraph
            'publish_date' => $this->faker->date('Y-m-d', 'now'), // Generates a random date up to today
            'author_id' => Author::factory(), // Generates a random author using the AuthorFactory
        ];
    }
}