<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\models\User;
use App\models\Book;
use App\models\Borrow;
use App\models\Genre;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(GenreSeeder::class);
        $this->call(BookSeeder::class);
        $this->call(BorrowSeeder::class);
        $this->call(BookGenreSeeder::class);
    }
}
