@extends('layouts.app')
@section('title', 'Új kategória')

@section('content')
<div class="container">
    <h1>Új bejegyzés</h1>
    <p class="mb-1">Ezen az oldalon tudsz új bejegyzést létrehozni.</p>
    <div class="mb-4">
        <a href="{{ route('books.index') }}"><i class="fas fa-long-arrow-alt-left"></i> Vissza a bejegyzésekhez</a>
    </div>

    @if (Session::has('book-created'))
        <div class="alert alert-success" role="alert">
            A(z) <strong>{{ Session::get('book-created') }}</strong> című bejegyzés sikeresen létre lett hozva!
        </div>
    @endif

    <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group row">
            <label for="title" class="col-sm-2 col-form-label">Cím*</label>
            <div class="col-sm-10">
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" placeholder="Bejegyzés címe" value="{{ old('title') }}">
                @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="text" class="col-sm-2 col-form-label">Szöveg*</label>
            <div class="col-sm-10">
                <textarea id="text" rows="5" class="form-control @error('text') is-invalid @enderror" name="text" placeholder="Bejegyzés szövege">{{ old('text') }}</textarea>
                @error('text')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Kategória</label>
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
            <label class="col-sm-2 col-form-label">Beállítások</label>
            <div class="col-sm-10">
                <div class="form-group">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" value="1" id="disable_comments" name="disable_comments" {{ old('disable_comments') ? 'checked' : '' }}>
                        <label for="disable_comments" class="form-check-label">Hozzászólások tiltása</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" value="1" id="hide_book" name="hide_book" {{ old('hide_book') ? 'checked' : '' }}>
                        <label for="hide_book" class="form-check-label">Bejegyzés elrejtése</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="attachment" class="col-sm-2 col-form-label">Csatolmány</label>
            <div class="col-sm-10">
                <div class="form-group">
                    <input type="file" class="form-control-file @error('attachment') is-invalid @enderror" id="attachment" name="attachment">
                    @error('attachment')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Létrehoz</button>
        </div>
    </form>
</div>
@endsection