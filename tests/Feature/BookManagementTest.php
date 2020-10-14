<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Book;

class BookManagementTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_added_to_the_library()
    {
        $response = $this->post('/books', [
            'title' => '1984',
            'author' => 'George Orwell'
        ]);

        $book = Book::first();

        $this->assertCount(1, Book::all());
        $response->assertRedirect($book->path());
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

        $this->post('/books', [
            'title' => '1984',
            'author' => 'George Orwell'
        ]);

        $book = Book::first();

        $response = $this->patch($book->path(), [
            'title' => 'Newwww title',
            'author' => "Newwww Author"
        ]);

        $this->assertEquals('Newwww title', Book::first()->title);
        $this->assertEquals('Newwww Author', Book::first()->author);
        $response->assertRedirect($book->fresh()->path()); // ovo fresh je da ne bi hvatali stari podatak, vec ovo uzimaa updated iz baze.
    }

    /** @test */

    public function a_book_can_be_deleted()
    {
        $this->withoutExceptionHandling();
        $this->post('/books', [
            'title' => '1984',
            'author' => 'George Orwell'
        ]);

        $book = Book::first();
        $this->assertCount(1, Book::all());

        $response = $this->delete($book->path());

        $this->assertCount(0, Book::all());
        $response->assertRedirect('/books');
    }
}
