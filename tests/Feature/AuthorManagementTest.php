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
        $this->post('/authors', $this->data());

        $author = Author::all();

        $this->assertCount(1, $author);
        $this->assertInstanceOf(Carbon::class, $author->first()->dob);
        $this->assertEquals('1993-18-05', $author->first()->dob->format('Y-d-m'));
    }

    /** @test */


    public function a_name_is_required()
    {

        $response = $this->post('/authors', array_merge($this->data(), ['name' => '']));

        $response->assertSessionHasErrors('name');
    }

    /** @test */


    public function a_dob_is_required()
    {

        $response = $this->post('/authors', array_merge($this->data(), ['dob' => '']));

        $response->assertSessionHasErrors('dob');
    }

    private function data()
    {
        return [
            'name' => 'Author Name',
            'dob'  => '18-05-1993'
        ];
    }
}
