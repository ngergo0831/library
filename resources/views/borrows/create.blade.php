@extends('layouts.app')
@section('title', 'Kölcsönzés')

@section('content')
<div class="container">
@if (Session::has('borrow-error'))
            <div class="alert alert-danger" role="alert" id="borrow-error">
                A(z) <strong>{{ Session::get('borrow-error') }}</strong> számú könyv már kölcsönzésre került!
            </div>
@endif
@if (Session::has('borrow-created'))
            <div class="alert alert-success" role="alert" id="borrow-created">
                A(z) <strong>{{ Session::get('borrow-created') }}</strong> számú könyv sikeresen ki lett kölcsönözve!
            </div>
@endif
<div class="container d-flex">
    <div class="w-25 mr-5">
            <h2><strong>Könyv</strong></h2>
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

                </div>
            </div>
    </div>
    <div class="w-50">
        <h3><strong>Készletinformáció</strong></h3>
        @if ($book->availableCount() > 0)
            <div class="text-success">Ez a könyv jelenleg elérhető</div>
        @else
            <div class="text-danger">Ez a könyv jelenleg nem elérhető!</div>
        @endif
        <h3><strong>Kölcsönzés</strong></h3>
        <p>Itt benyújthatod a kölcsönzési igényedet.</p>
        <p>Megjegyzés a kölcsönzéshez</p>
        <form action="{{ route('borrows.store', ['book' => $book]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <textarea class="form-control" id="uj-megjegyzes" name="uj-megjegyzes" rows="3" maxlength="255" placeholder="Max 255 karakter"></textarea>
            <button type="submit" class="btn btn-primary m-3">Beküldés</button>
        </form>
    </div>
</div>
</div>
@endsection
