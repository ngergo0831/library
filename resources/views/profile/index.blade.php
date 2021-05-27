@extends('layouts.app')
@section('title', 'Profil')

@section('content')
@auth
   <div class="container">
    <h1>Profil</h1>
    <strong>{{Auth::user()->name}} </strong>
    <span class="badge {{ Auth::user()->is_librarian == 0 ? 'badge-dark' : 'badge-primary'}} ">{{Auth::user()->is_librarian == 0 ? "Olvasó" : "Könyvtáros"}}</span>
    <div class="container d-flex flex-column">
        <div><strong>Email: </strong>{{Auth::user()->email}}</div>
        <div><strong>Regisztrált: </strong>{{Auth::user()->created_at}}</div>
        @if (Auth::user()->is_librarian == 0)
            <div><strong>Összes kölcsönzés: </strong>{{Auth::user()->borrows->count()}}</div>
            <div><strong>Könyvek nálad: </strong>{{$borrows->where('reader_id','=',Auth::id())->where('status','=','ACCEPTED')->count()}} (késés: {{DB::table('borrows')->where('reader_id','=',Auth::id())->where('status','=','ACCEPTED')->whereDate('deadline', '<', $now)->count()}})</div>
        @else
            <div><strong>Általad elfogadott kölcsönzések: {{$borrows->where('request_managed_by','=',Auth::id())->where('status','=','ACCEPTED')->count()}}</strong></div>
            <div><strong>Általad elutasított kölcsönzések: {{$borrows->where('request_managed_by','=',Auth::id())->where('status','=','REJECTED')->count()}}</strong></div>
            <div><strong>Általad visszajuttatott kölcsönzések: {{$borrows->where('return_managed_by','=',Auth::id())->where('status','=','RETURNED')->count()}}</strong></div>
        @endif
    </div>
</div>
@endauth


@endsection
