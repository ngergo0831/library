@extends('layouts.app')
@section('title', 'Bejegyzések')

@section('content')
<div class="container">
    <div class="row justify-content-between">
        <div class="col-12 col-md-8">
            <h1>Üdvözlünk a könyvtárban!</h1>
            <h3 class="mb-1">Minden könyv</h3>
        </div>
        <div class="col-12 col-md-4">
            @auth
                <div class="py-md-3 text-md-right">
                    <p class="my-1">Elérhető műveletek:</p>
                    <a href="{{ route('books.create') }}" role="button" class="btn btn-sm btn-success mb-1"><i class="fas fa-plus-circle"></i> Új bejegyzés</a>
                    <a href="{{ route('genres.create') }}" role="button" class="btn btn-sm btn-success mb-1"><i class="fas fa-plus-circle"></i> Új kategória</a>
                </div>
            @endauth
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12 col-lg-9">
            <div class="row">
                @forelse ($books as $book)
                    <div class="col-12 col-md-6 col-lg-4 mb-3 d-flex align-items-strech">
                        <div class="card w-100">
                            <img class="card-img-top" src="{{ $book->thumbnailURL() }}" alt="cover-image" width="200" height="200" style="background: rgb(194, 243, 175)">
                            <div class="card-body">
                                <div class="mb-2">
                                    <h5 class="card-title mb-0">{{ $book->title }}</h5>
                                    <small class="text-secondary">
                                        <span class="mr-2">
                                            <i class="fas fa-user"></i>
                                            <span>{{ $book->authors ? $book->authors : 'Nincs szerző' }}</span>
                                        </span>
                                        <span class="mr-2">
                                            <i class="far fa-calendar-alt"></i>
                                            <span>{{ date('Y', strtotime($book->released_at )) }}</span>
                                        </span>
                                    </small>
                                </div>
                                <p class="card-text">{{ Str::of($book->description) }}</p>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('books.show', $book) }}" class="btn btn-primary">Adatlap <i class="fas fa-angle-right"></i></a>
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
                        <div class="card-body">
                            <h5 class="card-title mb-2">Keresés</h5>
                            <p class="small">Könyv keresése cím alapján.</p>
                            <form>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Keresett cím">
                                </div>
                                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Keresés</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-3">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h5 class="card-title mb-2">Műfajok</h5>
                            <p class="small">Könyvek megtekintése egy adott műfajhoz.</p>
                            @forelse ($genres as $genre)
                            <a href="#" class="badge badge-{{$genre->style}}">{{$genre->name}}</a>
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
                                    <li><span class="fa-li"><i class="fas fa-user"></i></span>Felhasználók: {{$user_count}}</li>
                                    <li><span class="fa-li"><i class="fas fa-file-alt"></i></span>Műfajok: {{$genres->count()}}
                                    </li>
                                    <li><span class="fa-li"><i class="fas fa-book"></i></span>Könyvek: {{$book_count->count()}}
                                    </li>
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