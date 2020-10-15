<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BooksController extends Controller
{

    public function store()
    {


        $book = Book::create($this->validateRequest());
        return redirect($book->path());

        //path funkciju smo napravili u Book Modelu.
    }

    public function update(Book $book)
    {

        $book->update($this->validateRequest());
        return redirect($book->path());
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect('/books');
    }

    private function validateRequest()
    {

        return request()->validate([
            'title' => 'required',
            'author_id' => 'required'

        ]);
    }
}
