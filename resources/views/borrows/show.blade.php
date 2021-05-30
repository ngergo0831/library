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

        @if (Session::has('borrow-updated'))
            <div class="alert alert-success" role="alert" id="borrow-updated">
                A(z) <strong>{{ Session::get('borrow-updated') }}</strong> számú kölcsönzés sikeresen frissítve lett!
            </div>
        @endif
    </div>
    <div class="d-flex">
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
            @if($borrow->request_processed_at)
            <li><span class="fa-li"><i class="fas fa-sign-in-alt"></i></span><strong>Feldolgozva ekkor:</strong>  <span>{{$borrow->request_processed_at}}</span></li>
            <li><span class="fa-li"><i class="fas fa-sign-out-alt"></i></span><strong>Feldolgozta:</strong>  <span>{{$borrow->librarian_requested_borrows->name}}</span></li>
            <li><span class="fa-li"><i class="fas fa-sign-out-alt"></i></span><strong>Feldolgozó könyvtáros megjegyzése:</strong>  <span>{{$borrow->request_processed_message}}</span></li>
            <li><span class="fa-li"><i class="fas fa-sign-out-alt"></i></span><strong>Határidő:</strong>  <span>{{$borrow->deadline}} {{$borrow->whereDate('deadline', '<', $now)->count() == 0 ? "" : "<strong>(KÉSÉS)</strong>"}}</span></li>
            @else
            <li>Nincs információ a feldolgozásról</li>
            @endif
            </ul>
                <strong>Visszajuttatás</strong>
            <ul class="fa-ul">
            @if($borrow->returned_at)
            <li><span class="fa-li"><i class="fas fa-sign-in-alt"></i></span><strong>Visszajuttatta ekkor:</strong>  <span>{{$borrow->returned_at}}</span></li>
            <li><span class="fa-li"><i class="fas fa-sign-out-alt"></i></span><strong>Feldolgozta:</strong>  <span>{{$borrow->librarian_returned_borrows->name}}</span></li>
            @else
            <li>Nincs információ a feldolgozásról</li>
            @endif
            </ul>
                </div>
        </div>
        @if (Auth::user()->is_librarian)
            <div class="w-25">
            <form action="{{ route('borrows.update', $borrow) }}" method="POST" enctype="multipart/form-data">
            @method('PATCH')
            @csrf
                <h2><strong>Kezelés</strong></h2>
                <p>Állapot megváltoztatása:</p>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="radio-allapot" id="radio-elutasit" value="elutasit">
                    <label class="form-check-label text-danger" for="radio-elutasit">
                        Elutasított
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="radio-allapot" id="radio-elfogad" value="elfogad">
                    <label class="form-check-label text-success" for="radio-elfogad">
                        Elfogadott
                    </label>
                </div>
                 <div class="form-check">
                    <input class="form-check-input" type="radio" name="radio-allapot" id="radio-visszahoz" value="visszahoz">
                    <label class="form-check-label text-primary" for="radio-visszahoz">
                        Visszahozott
                    </label>
                </div>
                <p class="mt-3">Határidő</p>
                <input class="form-control" type="datetime-local" name="form-datum" id="form-datum">
                <p class="mt-3">Megjegyzés a művelethez</p>
                <textarea class="form-control" id="form-megjegyzes" name="form-megjegyzes" rows="3" maxlength="255"></textarea>
                <button type="submit" class="btn btn-primary m-3">Mentés</button>
            </form>
        </div>
        @endif
    </div>
</div>

@endsection
