<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BooksController extends Controller
{

    public function store()
    {

        $data = request()->validate([
            'title' => 'required',
            'author_id' => 'required'
        ]);
        $book = Book::create($data);
        return redirect($book->path());

        //path funkciju smo napravili u Book Modelu.
    }

    public function update(Book $book)
    {
        $data = request()->validate([
            'title' => 'required',
            'author_id' => 'required'
        ]);
        $book->update($data);
        return redirect($book->path());
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect('/books');
    }
}
