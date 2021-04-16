<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Book;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('books')->truncate();

        // 15 kategória létrehozása
        Book::factory(15)->create();

        $image = "https://picsum.photos/200/200";

        $book = Book::find(2);
        $book->cover_image = $image;
        $book->save();

        $book = Book::find(4);
        $book->cover_image = $image;
        $book->save();

        $book = Book::find(6);
        $book->cover_image = $image;
        $book->save();

        $book = Book::find(8);
        $book->cover_image = $image;
        $book->save();

        $book = Book::find(11);
        $book->cover_image = $image;
        $book->save();

        $book = Book::find(13);
        $book->cover_image = $image;
        $book->save();

        $book = Book::find(15);
        $book->cover_image = $image;
        $book->save();
    }
}
