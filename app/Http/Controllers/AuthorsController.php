<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;

class AuthorsController extends Controller
{


    public function store()
    {
        Author::create(request()->only([
            'name', 'dob'
        ]));
    }
}
