<?php

namespace Database\Factories;

use App\Models\Borrow;
use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BorrowFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $borrow = Borrow::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $possible_status = ['PENDING', 'ACCEPTED', 'REJECTED', 'RETURNED'];
        $status = $this->faker->randomElement($possible_status);
        return [
            'reader_id'=>rand(1,15),
            'book_id'=>rand(1,15),
            'status'=> $status,
            'request_processed_at'=> $status == 'PENDING' ? null : $this->faker->dateTimeBetween('-3 years','-1 years'),
            'request_processed_message'=> $status == 'PENDING' ? null : Str::ucfirst($this->faker->words($this->faker->numberBetween(1,5), true)),
            'request_managed_by'=> $status == 'PENDING' ? null : rand(16,20),
            'deadline'=> $status == 'ACCEPTED' ? $this->faker->dateTimeBetween('now', '+10 week') : null,
            'returned_at'=>$status == 'RETURNED' ? $this->faker->dateTimeBetween('-1 years') : null,
            'return_managed_by'=> $status == 'RETURNED' ? rand(16,20) : null
        ];
    }
}
