@extends('layouts.app')
@section('title', 'Műfaj - {{$genre->name}}')

@section('content')
<div class="container">
    <div class="row justify-content-between">
        <div class="col-12 col-md-8">
            <h1 class="mb-1"><span id="genre">{{$genre->name}}</span></h1>
        </div>
        <div class="col-12 col-md-4">
                <div class="py-md-3 text-md-right" id="genre-actions">
                    <p class="my-1">Elérhető műveletek:</p>
                    <a href="{{ route('genres.edit', $genre) }}" role="button" class="btn btn-sm btn-primary mb-1" id="edit-genre-btn"><i class="fas fa-plus-circle"></i> Módosítás</a>
                    <form action="{{ route('genres.destroy', $genre) }}" method="POST" style="display: inline">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-sm btn-danger mb-1" id="delete-genre-btn"><i class="fas fa-plus-circle"></i> Törlés</button>
                    </form>
                </div>
        </div>
    </div>

    @if (session('status'))
        @if(session('title'))
            <div class="alert alert-success w-100 d-flex justify-content-center" id="book-deleted">
                <span id="book-name">{{session('title')}}</span>
                &nbsp;
                {{ "című ".session('status') }}
            </div>
        @else
            <div class="alert alert-danger w-100 d-flex justify-content-center" id="book-deleted">
            {{ session('status') }}
        </div>
        @endif
    @endif


    <div class="row mt-3">
        <div class="col-12 col-lg-9">
            <div class="row" id="books">
                @forelse ($books as $book)
                    <div class="col-12 col-md-6 col-lg-4 mb-3 d-flex align-items-strech">
                        <div class="card w-100 book">
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
                @empty
                @endforelse
            </div>

            <div class="w-100 d-flex justify-content-center">
                {{ $books->links() }}
            </div>

        </div>
        <div class="col-12 col-lg-3">
            <div class="row">
                <div class="col-12 mb-3">
                    <div class="card bg-light">
                        <div class="card-body genres-list">
                            <h5 class="card-title mb-2">Műfajok</h5>
                            <p class="small">Könyvek megtekintése egy adott műfajhoz.</p>
                            @forelse ($genres as $genree)
                            <a href="{{ route('genres.show', $genree->id) }}" class="badge badge-{{$genree->style}}">{{$genree->name}}</a>
                            @empty
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-3">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h5 class="card-title mb-2">Statisztika</h5>
                            <div class="small">
                                <p class="mb-1">Adatbázis statisztika:</p>
                                <ul class="fa-ul">
                                    <li><span class="fa-li"><i class="fas fa-user"></i></span>Felhasználók: <span id="stats-users">{{$user_count}}</span></li>
                                    <li><span class="fa-li"><i class="fas fa-file-alt"></i></span>Műfajok: <span id="stats-genres">{{$genres->count()}}</span></li>
                                    <li><span class="fa-li"><i class="fas fa-book"></i></span>Könyvek: <span id="stats-books">{{$book_count->count()}}</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
