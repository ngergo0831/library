@extends('layouts.app')
@section('title', $book->title)

@section('content')
<div class="container">
    <div class="row justify-content-between">
        <div class="col-12 col-md-8">
            <h1 id="#book-title"><strong>{{ $book->title }}</strong></h1>
            <div class="d-flex my-1 text-secondary">
                <span class="mr-2">
                    <span>
                       Műfajok
                    </span>
                </span>
            </div>
            <div class="mb-2" id="book-genres">
                @foreach($book->genres as $genre)
                    <a href="{{ route('genres.show', $genre->id) }}" class="badge badge-{{ $genre->style }}">{{ $genre->name }}</a>
                @endforeach
            </div>

            <div class="mb-3">
                <a href="{{ route('books.index') }}" id="all-books-ref"><i class="fas fa-long-arrow-alt-left"></i> Minden könyv</a>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="py-md-3 text-md-right" id="book-actions">
                @auth
                <p class="my-1">Könyv kezelése:</p>
                <a href="{{ route('books.edit', $book) }}" role="button" class="btn btn-sm btn-primary" id="edit-book-btn"><i class="far fa-edit"></i> Módosítás</a>
                <form action="{{ route('books.destroy', $book) }}" style="display: inline" method="POST">
                    @csrf
                    @method("DELETE")
                    <button type="submit" class="btn btn-sm btn-danger"><i class="far fa-trash-alt"></i> Törlés</button>
                </form>
                @endauth
            </div>
        </div>
    </div>

    <div class="mt-3">
        <div class="mb-3">{!! nl2br(e($book->text)) !!}</div>

        @if ($book->attachment_hash_name !== null)
            <div class="attachment mb-3">
                <h5>Csatolmány</h5>
                <a href="{{ route('books.attachment', ['id' => $book->id]) }}">{{ $book->attachment_original_name }}</a>
            </div>
        @endif
        <h1><strong>Könyv adatai</strong></h1>
        <ul class="fa-ul">
            <li><span class="fa-li"><i class="fas fa-user"></i></span><strong>Szerzők:</strong> <span id="book-authors">{{$book->authors}}</span></li>
            <li><span class="fa-li"><i class="far fa-calendar-alt"></i></span><strong>Kiadás dátuma:</strong>  <span id="book-date">{{$book->released_at}}</span></li>
            <li><span class="fa-li"><i class="far fa-file"></i></span><strong>Oldalak száma:</strong>  <span id="book-pages">{{$book->pages}}</span></li>
            <li><span class="fa-li"><i class="fas fa-language"></i></span><strong>Nyelv:</strong>  <span id="book-lang">{{$book->language_code}}</span></li>
            <li><span class="fa-li"><i class="fas fa-database"></i></span><strong>ISBN:</strong>  <span id="book-isbn">{{$book->isbn}}</span></li>
            <li><span class="fa-li"><i class="fas fa-sign-in-alt"></i></span><strong>Készleten:</strong>  <span id="book-in-stock">{{$book->in_stock}}</span></li>
            <li><span class="fa-li"><i class="fas fa-sign-out-alt"></i></span><strong>Jelenleg kikölcsönözve:</strong>  <span id="book-borrowed">{{$book->activeBorrows()->count()}}</span></li>
        </ul>
        <h1><strong>Könyv leírása</strong></h1>
        <p><strong> <span id="book-description">{{$book->description}}</span></strong></p>
    </div>
</div>
@endsection
