<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;
use App\Models\Book;
use App\Models\Borrow;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\Input;

class BorrowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::id();
        $borrows =
            Auth::user()->is_librarian ?
                Borrow::all()->sortBy('created_at') :
                Borrow::all()->where('reader_id','=',$id)->sortByDesc('created_at');
        return view('borrows.index', ['borrows' => $borrows]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $book = Book::find($request['book']);
        return view('borrows.create',['book' => $book]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $book = Book::find($request['book']);
       $data = $request->validate(
            // Validation rules
            [
                'uj-megjegyzes' => 'max:255',
            ],
            // Custom messages
            [
                'uj-megjegyzes.min' => 'A megjegyzés legalább :min karakter legyen.',
                'uj-megjegyzes.max' => 'A megjegyzés legfeljebb :max karakter legyen'
            ]
        );

        if(DB::table('borrows')->where('reader_id', '=', Auth::id())->where('book_id','=',$book->id)->count() > 0) {
            $request->session()->flash('borrow-error',$book->id);
            return redirect()->route('borrows.create',['book' => $book]);
        }

        $megjegyzes = $data['uj-megjegyzes'];

        $megjegyzes = isset($megjegyzes) ? $megjegyzes : null;

        $borrow = Borrow::create([
            'reader_id' =>  Auth::id(),
            'book_id' => $book->id,
            'reader_message' => $megjegyzes,
            'status' => "PENDING"
        ]);
        $borrow->save();
        var_dump($borrow);
        $request->session()->flash('borrow-created',$book->id);
        return redirect()->route('borrows.create',['book' => $book]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Borrow $borrow)
    {
        $book = $borrow->borrowed_books;
        $now = Carbon::now();
        return view('borrows.show', ['borrow' => $borrow,'book' => $book,'now' => $now]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Borrow $borrow)
    {

        $validated = $request->validate(
            // Validation rules
            [
                'form-datum' => 'required',
                'form-megjegyzes' => 'min:3|max:255',
            ]);

        $allapot = $request->get('radio-allapot', 0);
        if($allapot == 'elutasit'){
            $borrow->status = "REJECTED";
        }else if($allapot == 'elfogad'){
            $borrow->status = "ACCEPTED";
        }else{
            $borrow->status = "RETURNED";
            $borrow->return_managed_by = Auth::id();
            $borrow->returned_at = Carbon::now()->toDateTimeString();
        }

        $borrow->deadline = $validated['form-datum'];
        $borrow->request_managed_by = Auth::id();
        if(isset($validated['form-megjegyzes'])){
            $borrow->request_processed_message = $validated['form-megjegyzes'];
        }
        $borrow->request_processed_at = Carbon::now()->toDateTimeString();

        $borrow->save();

        $request->session()->flash('borrow-updated', $borrow->id);
        return redirect()->route('borrows.show', $borrow);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
