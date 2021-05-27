<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Book;

class Borrow extends Model
{
    use HasFactory;



    protected $fillable = [
        'reader_id','book_id','status',
    ];


    public function borrows() {
        return $this->belongsTo(User::class,'reader_id');
    }

    public function librarian_requested_borrows() {
        return $this->belongsTo(User::class,'request_managed_by');
    }

    public function librarian_returned_borrows() {
        return $this->belongsTo(User::class,'return_managed_by');
    }

    public function borrowed_books() {
        return $this->belongsTo(Book::class,'book_id');
    }


}
