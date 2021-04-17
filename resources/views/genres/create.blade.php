@extends('layouts.app')
@section('title', 'Új kategória')

@section('content')
@auth
@if (Auth::user()->is_librarian)
<div class="container">
    <h1>Új kategória</h1>
    <p class="mb-1">Ezen az oldalon lehet új kategóriát létrehozni.</p>
    <div class="mb-4">
        <a href="{{ route('books.index') }}" id="all-books-ref"><i class="fas fa-long-arrow-alt-left"></i> Vissza a könyvekhez</a>
    </div>

    @if (Session::has('genre-created'))
        <div class="alert alert-success" id="genre-created" role="alert">
            A(z) <strong><span id="genre-name">{{ Session::get('genre-created') }}</span></strong> című bejegyzés sikeresen létre lett hozva!
        </div>
    @endif

    <form action="{{ route('genres.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Műfaj neve*</label>
            <div class="col-sm-10">
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Műfaj neve" value="{{ old('name') }}">
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="style" class="col-sm-2 col-form-label">Műfaj stílusa*</label>
            <div class="col-sm-10">
                <input type="text" class="form-control @error('style') is-invalid @enderror" id="style" name="style" placeholder="Műfaj stílusa" value="{{ old('style') }}">
                @error('style')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Létrehoz</button>
        </div>
    </form>
</div>
@endsection
@endif
@endauth
