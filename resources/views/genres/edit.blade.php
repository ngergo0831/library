@extends('layouts.app')
@section('title', 'Műfaj szerkesztése: '.$genre->name)

@section('content')
@auth
@if (Auth::user()->is_librarian)
<div class="container">
    <h1>Műfaj szerkesztése</h1>
    <p class="mb-1">Ezen az oldalon tudsz műfajt szerkeszteni. A könyveket úgy tudod hozzárendelni, ha a
        műfaj szerkesztése után módosítod a könyvet, és ott bejelölöd ezt a műfajt is.</p>
    <div class="mb-4">
        <a href="{{ route('home') }}" id="all-books-ref"><i class="fas fa-long-arrow-alt-left"></i> Vissza a könyvekhez</a>
    </div>

    @if (Session::has('genre-updated'))
        <div class="alert alert-success" id="genre-updated" role="alert">
            A(z) <span id="genre-name">{{ Session::get('genre-updated') }}</span> nevű műfaj sikeresen módosítva lett!
        </div>
    @endif

    <form action="{{ route('genres.update', $genre) }}" method="POST">
        @method('PATCH')
        @csrf
        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Műfaj neve*</label>
            <div class="col-sm-10">
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Műfaj neve" value="{{ old('name') ? old('name') : $genre->name }}">
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
                <input type="text" class="form-control @error('style') is-invalid @enderror" id="style" name="style" placeholder="Műfaj stílusa" value="{{ old('style') ? old('style') : $genre->style }}">
                @error('style')
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
@endif
@endauth
@endsection
