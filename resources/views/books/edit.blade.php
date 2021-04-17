@extends('layouts.app')
@section('title', 'Könyv szerkesztése: '.$book->title)

@auth
@if (Auth::user()->is_librarian)
@section('content')
<div class="container">
    <h1>Könyv módosítása</h1>
    <p class="mb-1">Ezen az oldalon tudsz könyvet módosítani.</p>
    <div class="mb-4">
        <a href="{{ route('home') }}" id="all-books-ref"><i class="fas fa-long-arrow-alt-left"></i> Vissza a könyvekhez</a>
    </div>

    @if (Session::has('book-updated'))
        <div class="alert alert-success" role="alert" id="book-updated">
            A(z) <strong><span id="book-title">{{ Session::get('book-updated') }}</span></strong> című könyv sikeresen frissítve lett!
        </div>
    @endif

    @if(Session::has('book-update-error'))
        <div class="alert alert-danger w-100 d-flex justify-content-center">
            <strong>{{ 'Ha el szeretnéd távolítani a borítóképet, akkor ne tölts fel újat!' }}</strong>
        </div>
    @endif

    <form action="{{ route('books.update', $book) }}" method="POST" enctype="multipart/form-data">
        @method('PATCH')
        @csrf
        <div class="form-group row">
            <label for="title" class="col-sm-2 col-form-label">Könyv címe*</label>
            <div class="col-sm-10">
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" placeholder="Könyv címe" value="{{ old('title') ? old('title') : $book->title }}">
                @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="authors" class="col-sm-2 col-form-label">Könyv szerzői*</label>
            <div class="col-sm-10">
                <input type="text" class="form-control @error('authors') is-invalid @enderror" id="authors" name="authors" placeholder="Bejegyzés címe" value="{{ old('authors') ? old('authors') : $book->authors }}">
                @error('authors')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="released_at" class="col-sm-2 col-form-label">Kiadás dátuma*</label>
            <div class="col-sm-10">
                <input type="date" class="form-control @error('released_at') is-invalid @enderror" id="released_at" name="released_at" value="{{ old('released_at') ? old('released_at') : $book->released_at }}">
                @error('released_at')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="pages" class="col-sm-2 col-form-label">Oldalak száma*</label>
            <div class="col-sm-10">
                <input type="number" class="form-control @error('pages') is-invalid @enderror" id="pages" name="pages" value="{{ old('pages') ? old('pages') : $book->pages }}">
                @error('pages')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="isbn" class="col-sm-2 col-form-label">ISBN*</label>
            <div class="col-sm-10">
                <input type="text" class="form-control @error('isbn') is-invalid @enderror" id="isbn" name="isbn" value="{{ old('isbn') ? old('isbn') : $book->isbn }}">
                @error('isbn')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="description" class="col-sm-2 col-form-label">Leírás</label>
            <div class="col-sm-10">
                <input type="textarea" class="form-control @error('description') is-invalid @enderror" id="description" name="description" value="{{ old('description') ? old('description') : $book->description }}">
                @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="genres" class="col-sm-2 col-form-label">Műfajok</label>
            <div class="col-sm-10">
                <div class="row">
                    @forelse ($genres->chunk(5) as $genreChuck)
                        <div class="col-6 col-md-3 col-lg-2">
                            @foreach ($genreChuck as $genre)
                                <div class="form-check">
                                    <input
                                        type="checkbox"
                                        class="form-check-input"
                                        value="{{ $genre->id }}"
                                        id="genre{{ $loop->iteration }}"
                                        name="genres[]"
                                        @if (is_array(old('genres')) && in_array($genre->id, old('genres')))
                                            checked
                                        @endif
                                        @foreach($book->genres as $book_genre)
                                            @if ($genre->name == $book_genre->name)
                                                checked
                                            @endif
                                        @endforeach
                                    >
                                    <label for="genre{{ $loop->iteration }}" class="form-check-label">
                                        <span class="badge badge-{{ $genre->style }}">{{ $genre->name }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    @empty
                        <p>Nincsenek kategóriák</p>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="attachment" class="col-sm-2 col-form-label">Borítókép</label>
            <div class="col-sm-10">
                <div class="form-group">
                    <input type="file" class="form-control-file @error('attachment') is-invalid @enderror" id="attachment" name="attachment">
                    @error('attachment')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    @if ($book->cover_image)
                        <img src="{{$book->cover_image}}" alt="" id="book-cover-preview" class="mt-3 mb-2 img-thumbnail" width="200" height="200">
                        <div>
                            <input type="checkbox" name="remove_cover" id="remove_cover" value="{{ old('remove_cover') }}">
                            <label for="remove_cover" >Borítókép eltávolítása</label>
                        </div>
                    @else
                        <p>A könyvhöz jelenleg nincs feltöltve borítókép.</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="in_stock" class="col-sm-2 col-form-label">Készleten*</label>
            <div class="col-sm-10">
                <input type="number" class="form-control @error('in_stock') is-invalid @enderror" id="in_stock" name="in_stock" value="{{ old('in_stock') ? old('in_stock') : $book->in_stock }}">
                @error('in_stock')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Módosítás</button>
        </div>
    </form>
</div>
@endsection
@endif
@endauth
