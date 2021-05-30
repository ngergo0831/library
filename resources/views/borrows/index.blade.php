@extends('layouts.app')
@section('title', 'Kölcsönzéseim')

@section('content')

<div class="container">
<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <a class="nav-link active" id="nav-igeny-tab" data-toggle="tab" href="#nav-igeny" role="tab" aria-controls="nav-igeny" aria-selected="true">Igények</a>
    <a class="nav-link" id="nav-elutasit-tab" data-toggle="tab" href="#nav-elutasit" role="tab" aria-controls="nav-elutasit" aria-selected="false">Elutasítva</a>
    <a class="nav-link" id="nav-elfogad-tab" data-toggle="tab" href="#nav-elfogad" role="tab" aria-controls="nav-elfogad" aria-selected="false">Elfogadva</a>
    <a class="nav-link" id="nav-visszahoz-tab" data-toggle="tab" href="#nav-visszahoz" role="tab" aria-controls="nav-visszahoz" aria-selected="false">Visszahozva</a>
    <a class="nav-link" id="nav-keses-tab" data-toggle="tab" href="#nav-keses" role="tab" aria-controls="nav-keses" aria-selected="false">Késés</a>
  </div>
</nav>
<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-igeny" role="tabpanel" aria-labelledby="nav-igeny-tab">
        <div class="mt-3 mb-3">
            <h4>Kölcsönzési igények</h4>
            @foreach ($borrows->where('status','=','PENDING') as $borrow)
                <div class="card">
                <div class="card-body p-2">
                    <div class="d-flex">
                        <div class="p-2"><b>#{{$loop->index + 1}}</b></div>
                        <div class="p-2">Könyv: <b>{{ $borrow->borrowed_books->title}}</b></div>
                        <div class="d-flex flex-column p-auto ml-auto">
                            <div>Kérve: {{$borrow->created_at}}</div>
                            <a href="{{ route('borrows.show', $borrow) }}" class="btn btn-primary m-auto ">{{Auth::user()->is_librarian ? "Kezelés" : "Adatlap"}}</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="tab-pane fade" id="nav-elutasit" role="tabpanel" aria-labelledby="nav-elutasit-tab">
        <div class="mt-3 mb-3">
            <h4>Elutasított kölcsönzések</h4>
            @foreach ($borrows->where('status','=','REJECTED') as $borrow)
                <div class="card">
                <div class="card-body p-2">
                    <div class="d-flex">
                        <div class="p-2"><b>#{{$loop->index + 1}}</b></div>
                        <div class="p-2">Könyv: <b>{{ $borrow->borrowed_books->title}}</b></div>
                        <div class="d-flex flex-column p-auto ml-auto">
                            <div>Kérve: {{$borrow->created_at}}</div>
                            <a href="{{ route('borrows.show', $borrow) }}" class="btn btn-primary m-auto ">{{Auth::user()->is_librarian ? "Kezelés" : "Adatlap"}}</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div></div>
    <div class="tab-pane fade" id="nav-elfogad" role="tabpanel" aria-labelledby="nav-elfogad-tab">
        <div class="mt-3 mb-3">
            <h4>Elfogadott kölcsönzések</h4>
            @foreach ($borrows->where('status','=','ACCEPTED') as $borrow)
               <div class="card">
                <div class="card-body p-2">
                    <div class="d-flex">
                        <div class="p-2"><b>#{{$loop->index + 1}}</b></div>
                        <div class="p-2">Könyv: <b>{{ $borrow->borrowed_books->title}}</b></div>
                        <div class="d-flex flex-column p-auto ml-auto">
                            <div>Kérve: {{$borrow->created_at}}</div>
                            <a href="{{ route('borrows.show', $borrow) }}" class="btn btn-primary m-auto ">{{Auth::user()->is_librarian ? "Kezelés" : "Adatlap"}}</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="tab-pane fade" id="nav-visszahoz" role="tabpanel" aria-labelledby="nav-visszahoz-tab">
        <div class="mt-3 mb-3">
            <h4>Visszahozott kölcsönzések</h4>
            @foreach ($borrows->where('status','=','RETURNED') as $borrow)
                <div class="card">
                <div class="card-body p-2">
                    <div class="d-flex">
                        <div class="p-2"><b>#{{$loop->index + 1}}</b></div>
                        <div class="p-2">Könyv: <b>{{ $borrow->borrowed_books->title}}</b></div>
                        <div class="d-flex flex-column p-auto ml-auto">
                            <div>Kérve: {{$borrow->created_at}}</div>
                            <a href="{{ route('borrows.show', $borrow) }}" class="btn btn-primary m-auto ">{{Auth::user()->is_librarian ? "Kezelés" : "Adatlap"}}</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="tab-pane fade" id="nav-keses" role="tabpanel" aria-labelledby="nav-keses-tab">
        <div class="mt-3 mb-3">
            <h4>Késésben lévő könyvek</h4>
            @foreach ($borrows->where('status','=','RETURNED') as $borrow)
                <div class="card">
                <div class="card-body p-2">
                    <div class="d-flex">
                        <div class="p-2"><b>#{{$loop->index + 1}}</b></div>
                        <div class="p-2">Könyv: <b>{{ $borrow->borrowed_books->title}}</b></div>
                        <div class="d-flex flex-column p-auto ml-auto">
                            <div>Kérve: {{$borrow->created_at}}</div>
                            <a href="{{ route('borrows.show', $borrow) }}" class="btn btn-primary m-auto ">{{Auth::user()->is_librarian ? "Kezelés" : "Adatlap"}}</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
</div>
@endsection
