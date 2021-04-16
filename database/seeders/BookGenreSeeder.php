<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class BookGenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('book_genre')->truncate();

        for ($i=1; $i <= 15; $i++) { 
            $genre = rand(1,7);
            DB::table('book_genre')->insert(['book_id'=>$i,'genre_id'=>$genre, 'created_at' => new DateTime('now')]);
            if($genre<4){
                DB::table('book_genre')->insert(['book_id'=>$i,'genre_id'=>rand(4,7), 'created_at' => new DateTime('now')]);
            }
        }    
    }
}
