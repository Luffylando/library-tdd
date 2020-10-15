<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Book;
use App\Models\Author;


class BookManagementTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_added_to_the_library()
    {
        $response = $this->post('/books', $this->data());

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
        $response = $this->post('/books', array_merge($this->data(), ['author_id' => '']));

        $response->assertSessionHasErrors('author_id');
    }

    /** @test */

    public function a_book_can_be_updated()
    {

        $this->post('/books', $this->data());

        $book = Book::first();

        $response = $this->patch($book->path(), [
            'title' => 'Newwww title',
            'author_id' => "Newwww Author"
        ]);

        $this->assertEquals('Newwww title', Book::first()->title);
        $this->assertEquals(24, Book::first()->author_id);

        $response->assertRedirect($book->fresh()->path()); // ovo fresh je da ne bi hvatali stari podatak, vec ovo uzimaa updated iz baze.
    }

    /** @test */

    public function a_book_can_be_deleted()
    {
        $this->post('/books', $this->data());

        $book = Book::first();
        $this->assertCount(1, Book::all());

        $response = $this->delete($book->path());

        $this->assertCount(0, Book::all());
        $response->assertRedirect('/books');
    }

    /** @test*/

    public function a_new_author_is_automatically_added()
    {
        $this->withoutExceptionHandling();
        $this->post('/books', [
            'title' => '1984',
            'author_id' => 'George Orwell'
        ]);

        $book = Book::first();
        $author = Author::first();

        $this->assertEquals($author->id, $book->author_id);
        $this->assertCount(1, Author::all());
    }

    private function data()
    {
        return [
            'title'     => "1984",
            'author_id'    => "George Orwell"
        ];
    }
}
