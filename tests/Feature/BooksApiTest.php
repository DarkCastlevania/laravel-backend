<?php

namespace Tests\Feature;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BooksApiTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    use RefreshDatabase;

    /** @test */
    public function test_the_application_returns_a_successful_response()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** @test */
    function can_get_all_books()
    {
        $book = Book::factory()->create();
        dd($book);

        $book = Book::factory(4)->create();
        dd($book->count());

        $this->get('/api/books')->dump();
        $this->get(route('books.index'))->dump();
        $this->getJson(route('books.index'))
            ->assertJsonFragment([
                'title' => $books[0]->title
            ])->assertJsonFragment([
                'title' => $books[1]->title
            ]);
    }

    /** @test */
    function can_get_one_book()
    {
        $book = Book::factory()->create();

        dd(route('books.show', $book));

        $response = $this->getJson(route('books.show',$book));
        $response->assertJsonFragment([
            'title' => $book->title
        ]);
    }

    /** @test */
    function can_create_books()
    {
        $this->postJson(route('books.store'), [])
            ->assertJsonValidationErrorFor('title');

        $this->postJson(route('books.store'), [
            'title' => 'My new book'
        ])->assertJsonFragment([
            'title' => 'My new book'
        ]);

        $this->assertDatabaseHas('books', [
            'title' => 'My new book'            
        ]);
    }

    /** @test*/
    function can_update_books()
    {
        $book = Book::factory()->create();

        $this->patchJson(route('books.update', $book), [])
        ->assertJsonValidationErrorFor('title');


        $this->patchJson(route('books.update',$book), [
            'title' => 'Edited book'
        ])->assertJsonFragment([
            'title' => 'Edited book'
        ]);
    }

    /** @test */
    function can_delete_books()
    {
        $book = Book::factory()->create();

        $this->deleteJson(route('books.destroy',$book))
            ->assertNoContent();
        
        $this->assertDatabaseCount('books',0);
    }

}
