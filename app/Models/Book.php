<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Borrow;
use App\Models\Genre;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'authors',
        'description',
        'released_at',
        'cover_image',
        'pages',
        'language_code',
        'isbn',
        'in_stock'
    ];

    public function genres() {
        return $this->belongsToMany(Genre::class, 'book_genre')->withTimestamps();
    }

    public function borrowed() {
        return $this->belongsTo(Borrow::class,'book_id');
    }

    public function activeBorrows(){
        return Borrow::where(['book_id' => $this->id,'status' => 'ACCEPTED'])->get();
    }

    public function availableCount(){
        return $this->in_stock + $this->activeBorrows();
    }

    public function isAvailable(){
        return $this->availableCount() > 0;
    }

    public function thumbnailURL(){
        return $this->cover_image ? $this->cover_image : asset('images/book.png');
    }

}