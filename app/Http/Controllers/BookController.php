<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Storage;
use Auth;
use Gate;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['create', 'store', 'edit', 'update']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::paginate(9);
        $book_count = Book::all();
        $genres = DB::table('genres')->get();
        $user_count = DB::table('users')->get()->count();
        return view('books.index', ['books' => $books,'book_count' => $book_count, 'genres' => $genres, 'user_count' => $user_count]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $genres = Genre::all();
        return view('books.create', compact('genres'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        return "edit";
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = Book::where('id',$id);
        $title = $res->first()->title;
        $res->delete();
        if ($res){
            $status = "könyv sikeresen törölve";
        }else{
            $status = "A törlés során hiba lépett fel.";
        }
        return redirect()->route('books.index')->with(['status' => $status,'title' => $title]);
    }
}
