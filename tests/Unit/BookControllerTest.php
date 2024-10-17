<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Book;
use App\Models\Author;

class BookControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $book;
    protected $author;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a sample author
        $this->author = Author::factory()->create();

        // Create a sample book
        $this->book = Book::factory()->create([
            'author_id' => $this->author->id
        ]);
    }

    /** @test */
    public function list_books()
    {
        $response = $this->getJson('/api/books');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            "message",
            'data' => [
                '*' => [
                    'id','title','description','publish_date','author_id',
                ]
            ]
        ]);
    }

    /** @test */
    public function create_a_book()
    {
        $data = [
            'title' => 'New Book Title',
            'description' => 'Book description',
            'publish_date' => '2024-01-01',
            'author_id' => $this->author->id
        ];

        $response = $this->postJson('/api/books', $data);
        $response->assertStatus(201);
        $this->assertDatabaseHas('books', $data);

        $dataValidation = [
            'title' => 'New Book Title',
            'description' => 'Book description'
        ];
        $response = $this->postJson('/api/books', $dataValidation);
        $response->assertStatus(422);
        $response->assertJsonStructure([
            "message",
            'validation' => [
                'publish_date','author_id',
            ]
        ]);
    }

    /** @test */
    public function show_a_specific_book()
    {
        $response = $this->getJson("/api/books/{$this->book->id}");
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'ok',
            'data' => [
                'id' => $this->book->id,
                'title' => $this->book->title,
                'publish_date' => $this->book->publish_date,
                'author_id' => $this->book->author_id
            ]
        ]);

        $book_id = "999XXXX9999";
        $response = $this->getJson("/api/books/{$book_id}");
        $response->assertStatus(404);

    }

    /** @test */
    public function update_a_book()
    {
        $updatedData = [
            'title' => 'Updated Title',
            'description' => 'Updated description',
            'publish_date' => '2024-02-01',
            'author_id' => $this->author->id
        ];

        $response = $this->putJson("/api/books/{$this->book->id}", $updatedData);
        $response->assertStatus(200);
        $this->assertDatabaseHas('books', $updatedData);

        $book_id = "999XXXX9999";
        $response = $this->putJson("/api/books/{$book_id}", $updatedData);
        $response->assertStatus(404);

        $updatedDataValidation = [
            'title' => 'Updated Title',
            'description' => 'Updated description',
        ];
        $response = $this->putJson("/api/books/{$book_id}", $updatedDataValidation);
        $response->assertStatus(422);
        $response->assertJsonStructure([
            "message",
            'validation' => [
                'publish_date','author_id',
            ]
        ]);
    }

    /** @test */
    public function delete_a_book()
    {
        $response = $this->deleteJson("/api/books/{$this->book->id}");
        $response->assertStatus(204);
        $this->assertDatabaseMissing('books', ['id' => $this->book->id]);

        $book_id = "999XXXX9999";
        $response = $this->getJson("/api/books/{$book_id}");
        $response->assertStatus(404);
    }

    /** @test */
    public function get_books_by_author()
    {
        $response = $this->getJson("/api/authors/{$this->author->id}/books");
        $response->assertStatus(200);
        $response->assertJsonStructure([
            "message",
            "data" => [
                '*' => ['id', 'title', 'description', 'publish_date', 'author_id']
            ]
        ]);

        $author_id = "999XXXX9999";
        $response = $this->getJson("/api/authors/{$author_id}/books");
        $response->assertStatus(404);
    }
}