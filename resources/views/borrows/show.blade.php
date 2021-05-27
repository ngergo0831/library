@extends('layouts.app')
@section('title', 'Kölcsönzés részletei')

@section('content')
<div class="container">
    <div class="row justify-content-between">
        <div class="col-12 col-md-8">
            <h1 id="#book-title"><strong>Kölcsönzés megtekintése</strong></h1>
            <div class="mb-3">
                <a href="{{ route('borrows.index') }}" id="all-books-ref"><i class="fas fa-long-arrow-alt-left"></i>Vissza a kölcsönzésekhez</a>
            </div>
        </div>
    </div>
    <div class="d-flex">
        <div class="w-25 mr-5">
            <strong>Könyv</strong>
            <div class="card w-100">
                <img class="card-img-top" src="{{ $book->thumbnailURL() }}" alt="cover-image" width="200" height="200" style="background: rgb(194, 243, 175)">
                <div class="card-body">
                    <div class="mb-2">
                        <h5 class="card-title mb-0 .book-title">{{ $book->title }}</h5>
                        <small class="text-secondary">
                            <span class="mr-2">
                                <i class="fas fa-user"></i>
                                <span class="book-author">{{ $book->authors ? $book->authors : 'Nincs szerző' }}</span>
                            </span>
                            <span class="mr-2">
                                <i class="far fa-calendar-alt"></i>
                                <span class="book-date">{{ date('Y. m. d.', strtotime($book->released_at )) }}</span>
                            </span>
                        </small>
                    </div>
                    <p class="card-text book-description">{{ Str::of($book->description) }}</p>
                </div>
                <div class="card-footer">
                    <a href="{{ route('books.show', $book) }}" class="btn btn-primary book-details">Adatlap <i class="fas fa-angle-right"></i></a>
                </div>
            </div>
        </div>
        <div class="w-50">
            <div class="mt-3">
        <div class="mb-3">{!! nl2br(e($book->text)) !!}</div>

        @if ($book->attachment_hash_name !== null)
            <div class="attachment mb-3">
                <h5>Csatolmány</h5>
                <a href="{{ route('books.attachment', ['id' => $book->id]) }}">{{ $book->attachment_original_name }}</a>
            </div>
        @endif
        <h1><strong>Adatok</strong></h1>
        <strong>Kölcsönzés alapadatai</strong>
        <ul class="fa-ul">
            <li><span class="fa-li"><i class="fas fa-user"></i></span><strong>Olvasó: </strong>{{$borrow->borrows->name}}</li>
            <li><span class="fa-li"><i class="far fa-calendar-alt"></i></span><strong>Könyv: </strong>{{$borrow->borrowed_books->title}}</li>
            <li><span class="fa-li"><i class="far fa-file"></i></span><strong>Kölcsönzés kérve ekkor: </strong>{{$borrow->created_at}}</li>
            <li><span class="fa-li"><i class="fas fa-language"></i></span><strong>Olvasó megjegyzése: </strong>{{$borrow->reader_message ? $borrow->reader_message : "Nincsen"}}</li>
            <li><span class="fa-li"><i class="fas fa-database"></i></span><strong>Állapot: </strong>{{$borrow->status}}</li>
        </ul>
            <strong>Kölcsönzés feldolgozása</strong>
        <ul class="fa-ul">
            <li><span class="fa-li"><i class="fas fa-sign-in-alt"></i></span><strong>Feldolgozva ekkor:</strong>  <span>{{$borrow->request_processed_at ? $borrow->request_processed_at : "Még nem került feldolgozásra"}}</span></li>
            <li><span class="fa-li"><i class="fas fa-sign-out-alt"></i></span><strong>Feldolgozta:</strong>  <span>{{$borrow->request_managed_by ? $borrow->request_managed_by : "Még nem került feldolgozásra"}}</span></li>
            <li><span class="fa-li"><i class="fas fa-sign-out-alt"></i></span><strong>Feldolgozó könyvtáros megjegyzése:</strong>  <span>{{$borrow->request_processed_message ? $borrow->request_processed_message : "Nincsen"}}</span></li>
            <li><span class="fa-li"><i class="fas fa-sign-out-alt"></i></span><strong>Határidő:</strong>  <span>{{$borrow->deadline ? $borrow->deadline : "Nincsen"}}</span></li>
        </ul>
            <strong>Visszajuttatás</strong>
        <ul class="fa-ul">
        </ul>
    </div>
        </div>
    </div>
</div>

@endsection
