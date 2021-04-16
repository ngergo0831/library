<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => Str::ucfirst($this->faker->words($this->faker->numberBetween(1,3), true)),
            'authors' => rand(0,1) == 1 ? $this->faker->name() : $this->faker->name() . ', ' . $this->faker->name(),
            'released_at' => $this->faker->date(),
            'description' => Str::ucfirst($this->faker->words($this->faker->numberBetween(6,15), true)),
            'language_code' => $this->faker->languageCode(),
            'pages' => $this->faker->numberBetween(60, 500),
            'isbn' => $this->faker->isbn13(),
            'in_stock' => $this->faker->numberBetween(0, 10)
        ];
    }
}
