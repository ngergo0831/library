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
        $books = Book::query();
        if(request('search_text')){
            $books->where('title','LIKE','%'.request('search_text').'%');
        }
        $book_count = Book::all();
        $genres = DB::table('genres')->get();
        $user_count = DB::table('users')->get()->count();
        return view('books.index', ['books' => $books->paginate(9),'book_count' => $book_count, 'genres' => $genres, 'user_count' => $user_count]);
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
        $data = $request->validate(
            // Validation rules
            [
                'title' => 'required|min:3|max:255',
                'authors' => 'required|min:3|max:255',
                'released_at' => 'required|date|before_or_equal:today',
                'pages' => 'required|min:1',
                'isbn' => 'required|regex:/^(?=(?:\D*\d){10}(?:(?:\D*\d){3})?$)[\d-]+$/i',
                'description' => 'nullable',
                'genres' => 'nullable',
                'genres.*' => 'integer|distinct|exists:genres,id',
                'attachment' => 'nullable|image|max:1024',
                'in_stock' => 'required|integer|min:0|max:3000',
            ],
            // Custom messages
            [
                'title.required' => 'A c??met meg kell adni.',
                'title.min' => 'A c??m legal??bb :min karakter legyen.',
                'required' => 'A(z) :attribute mez??t meg kell adni.',
            ]
        );

        // Store file
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            Storage::disk('book_covers')->put('cover_'.(Book::all()->count()+1).'.'.$file->extension(), $file->get());
            $data['cover_image'] = asset('images/book_covers/'.'cover_'.(Book::all()->count()+1).'.'.$file->extension());
        }

        $book = Book::create($data);

        $book->genres()->attach($request->genres);

        $request->session()->flash('book-created', $book->title);
        return redirect()->route('books.create');
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
    public function edit(Book $book)
    {
        $genre = Genre::all();
        return view('books.edit', ['book' => $book, 'genres' => $genre]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $data = $request->validate(
            // Validation rules
            [
                'title' => 'required|min:3|max:255',
                'authors' => 'required|min:3|max:255',
                'released_at' => 'required|date|before_or_equal:today',
                'pages' => 'required|min:1',
                'isbn' => 'required|regex:/^(?=(?:\D*\d){10}(?:(?:\D*\d){3})?$)[\d-]+$/i',
                'description' => 'nullable',
                'genres' => 'nullable',
                'genres.*' => 'integer|distinct|exists:genres,id',
                'attachment' => 'nullable|image|max:1024',
                'in_stock' => 'required|integer|min:0|max:3000',
                'remove_cover' => 'nullable|boolean'
            ],
            // Custom messages
            [
                'title.required' => 'A c??met meg kell adni.',
                'title.min' => 'A c??m legal??bb :min karakter legyen.',
                'required' => 'A(z) :attribute mez??t meg kell adni.',
            ]
        );

        $file = $request->file('attachment') ? $request->file('attachment') : ltrim(strrchr(parse_url($book->cover_image, PHP_URL_PATH), '/'), '/');

        if($request->has('remove_cover')){
            if ($request->hasFile('attachment')) {
                $request->session()->flash('book-update-error');
                return redirect()->route('books.edit', $book);
            }else{
                Storage::disk('book_covers')->delete($file);
                $data['cover_image'] = null;
            }
        }else{
            if ($request->hasFile('attachment')) {
                Storage::disk('book_covers')->delete('cover_'.$book->id.'.'.$file->extension());
                Storage::disk('book_covers')->put('cover_'.$book->id.'.'.$file->extension(), $file->get());
                $data['cover_image'] = asset('images/book_covers/'.'cover_'.$book->id.'.'.$file->extension());
            }
        }

        $book->update($data);

        $book->genres()->sync($request->genres);

        $request->session()->flash('book-updated', $book->title);
        return redirect()->route('books.edit', $book);
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
        $file = ltrim(strrchr(parse_url($res->first()->cover_image, PHP_URL_PATH), '/'), '/');
        Storage::disk('book_covers')->delete($file);
        $res->delete();
        if ($res){
            $status = "k??nyv sikeresen t??r??lve";
        }else{
            $status = "A t??rl??s sor??n hiba l??pett fel.";
        }
        return redirect()->route('books.index')->with(['status' => $status,'title' => $title]);
    }
}
