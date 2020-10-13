<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Book;

class BookReservationTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_added_to_the_library()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/books', [
            'title' => '1984',
            'author' => 'George Orwell'
        ]);

        $response->assertOk();
        $this->assertCount(1, Book::all());
    }

    /** @test */

    public function a_title_is_required()
    {
        $response = $this->post('/books', [
            'title' => '',
            'author' => 'George Orwell'
        ]);

        $response->assertSessionHasErrors('title');
    }

    /** @test */

    public function a_author_is_required()
    {
        $response = $this->post('/books', [
            'title' => '1984',
            'author' => ''
        ]);

        $response->assertSessionHasErrors('author');
    }

    /** @test */

    public function a_book_can_be_updated()
    {

        $this->withoutExceptionHandling();

        $this->post('/books', [
            'title' => '1984',
            'author' => 'George Orwell'
        ]);

        $book = Book::first();

        $response = $this->patch('/books/' . $book->id, [
            'title' => 'Newwww title',
            'author' => "Newwww Author"
        ]);

        $this->assertEquals('Newwww title', Book::first()->title);
        $this->assertEquals('Newwww Author', Book::first()->author);
    }
}
