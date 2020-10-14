<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Author;
use Carbon\Carbon;

class AuthorManagementTest extends TestCase
{

    use RefreshDatabase;

    /** @test */

    public function an_author_can_be_created()
    {
        $this->post('/author', [
            'name'  => 'Author Name',
            'dob'   => '18-05-1993'
        ]);

        $author = Author::all();

        $this->assertCount(1, $author);
        $this->assertInstanceOf(Carbon::class, $author->first()->dob);
        $this->assertEquals('1993-18-05', $author->first()->dob->format('Y-d-m'));
    }
}
