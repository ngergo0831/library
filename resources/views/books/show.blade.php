@extends('layouts.app')
@section('title', $book->title)

@section('content')
<div class="container">
    <div class="row justify-content-between">
        <div class="col-12 col-md-8">
            <h1><strong>{{ $book->title }}</strong></h1>

            <div class="d-flex my-1 text-secondary">
                <span class="mr-2">
                    <span>
                       Műfajok
                    </span>
                </span>
            </div>

            <div class="mb-2">
                @foreach($book->genres as $genre)
                    <a href="#" class="badge badge-{{ $genre->style }}">{{ $genre->name }}</a>
                @endforeach
            </div>

            <div class="mb-3">
                <a href="{{ route('books.index') }}"><i class="fas fa-long-arrow-alt-left"></i> Minden könyv</a>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="py-md-3 text-md-right">
                <p class="my-1">Könyv kezelése:</p>
                @can('update', $book)
                    <a href="{{ route('books.edit', $book) }}" role="button" class="btn btn-sm btn-primary"><i class="far fa-edit"></i> Módosítás</a>
                @endcan
                <button type="button" class="btn btn-sm btn-danger"><i class="far fa-trash-alt"></i> Törlés</button>
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
            <li><span class="fa-li"><i class="fas fa-user"></i></span><strong>Szerzők:</strong> {{$book->authors}}</li>
            <li><span class="fa-li"><i class="far fa-calendar-alt"></i></span><strong>Kiadás dátuma:</strong> {{$book->released_at}}</li>
            <li><span class="fa-li"><i class="far fa-file"></i></span><strong>Oldalak száma:</strong> {{$book->pages}}</li>
            <li><span class="fa-li"><i class="fas fa-language"></i></span><strong>Nyelv:</strong> {{$book->language_code}}</li>
            <li><span class="fa-li"><i class="fas fa-database"></i></span><strong>ISBN:</strong> {{$book->isbn}}</li>
            <li><span class="fa-li"><i class="fas fa-sign-in-alt"></i></span><strong>Készleten:</strong> {{$book->in_stock}}</li>
            <li><span class="fa-li"><i class="fas fa-sign-out-alt"></i></span><strong>Jelenleg kikölcsönözve:</strong> {{"Még nem jó !!!rossz!!!"}}</li>
        </ul>
        <h1><strong>Könyv leírása</strong></h1>
        <p><strong>{{$book->description}}</strong></p>
    </div>
</div>
@endsection