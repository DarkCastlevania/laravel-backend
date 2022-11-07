<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* return Book::paginate(); */

        return Book::all();
    }

    public function created()
    {
        return View::make('book.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required']
        ]);

        
        $book = new Book;
        $book->title = $request->input('title');
        $book->save();
        
        return $book;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */

    /*
    otra forma de mostrar el resultado con el metodo find
     public function show($book)
    {
        return Book::find($book);
    }
  
    */


    public function show(Book $book)
    {
        return $book;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request , Book $book)
    {        
        $request->validate([
            'title' => ['required']
        ]);   
        
        $book->title = $request->input('title');        
        $book->save();
        return $book;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return response()->noContent();
    }
}
