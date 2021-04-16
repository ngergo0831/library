<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    const STYLES = [
        'primary',
        'secondary',
        'success',
        'danger',
        'warning',
        'info',
        'light',
        'dark',
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $genres = Genre::all();
        return view('genres.create', compact('genres'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            // Validation rules
            [
                'name' => 'required|min:3|max:255',
                'style' => 'required|in:primary,secondary,success,danger,warning,info,light,dark',
            ],
            // Custom messages
            [
                'name.required' => 'A nevet meg kell adni.',
                'name.min' => 'A név legalább :min karakter legyen.',
                'required' => 'A(z) :attribute mezőt meg kell adni.',
            ]
        );

        $category = Genre::create($validated);

        $request->session()->flash('genre-created', $category->name);
        return redirect()->route('genres.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Genre $genre)
    {
        return view('genres.edit', ['styles' => self::STYLES, 'genre' => $genre]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Genre $genre)
    {
        $validated = $request->validate(
        // Validation rules
        [
            'name' => 'required|min:3|max:255',
            'style' => 'required|in:primary,secondary,success,danger,warning,info,light,dark',
        ],
        // Custom messages
        [
            'name.required' => 'A nevet meg kell adni.',
            'name.min' => 'A név legalább :min karakter legyen.',
            'required' => 'A(z) :attribute mezőt meg kell adni.',
        ]);

        $genre->update($validated);

        $request->session()->flash('genre-updated', $genre->name);
        return redirect()->route('genres.edit', $genre);
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
