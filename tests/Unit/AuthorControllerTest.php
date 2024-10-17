<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Author;

class AuthorControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $author;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a sample author
        $this->author = Author::factory()->create();
    }

    /** @test */
    public function list_authors()
    {
        $response = $this->getJson('/api/authors');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            "message",
            'data' => [
                '*' => ['id', 'name', 'bio', 'birth_date'] 
            ]
        ]);
    }

    /** @test */
    public function create_an_author()
    {
        $data = [
            'name' => 'John Doe',
            'bio' => 'Author biography',
            'birth_date' => '1980-10-10'
        ];

        $response = $this->postJson('/api/authors', $data);
        $response->assertStatus(201);
        $this->assertDatabaseHas('authors', $data);

        $dataValidation = [
            'name' => 'Joko'
        ];
        $response = $this->postJson('/api/authors', $dataValidation);
        $response->assertStatus(422);
        $response->assertJsonStructure([
            "message",
            'validation' => [
                'bio','birth_date',
            ]
        ]);
    
    }

    /** @test */
    public function show_a_specific_author()
    {
        $response = $this->getJson("/api/authors/{$this->author->id}");
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'ok',
            'data' => [
                'id' => $this->author->id,
                'name' => $this->author->name,
                'bio' => $this->author->bio,
                'birth_date' => $this->author->birth_date,
            ],
        ]);

        $author_id = "999XXXX9999";
        $response = $this->getJson("/api/authors/{$author_id}");
        $response->assertStatus(404);
    }

    /** @test */
    public function update_an_author()
    {
        $updatedData = [
            'name' => 'Jane Doe',
            'bio' => 'Updated biography',
            'birth_date' => '1985-05-05'
        ];

        $response = $this->putJson("/api/authors/{$this->author->id}", $updatedData);
        $response->assertStatus(200);
        $this->assertDatabaseHas('authors', $updatedData);

        $author_id = "999XXXX9999";
        $response = $this->putJson("/api/authors/{$author_id}",$updatedData);
        $response->assertStatus(404);

        $dataValidation = [
            'name' => 'Joko'
        ];
        $response = $this->putJson("/api/authors/{$author_id}", $dataValidation);
        $response->assertStatus(422);
        $response->assertJsonStructure([
            "message",
            'validation' => [
                'bio','birth_date',
            ]
        ]);
    }

    /** @test */
    public function delete_an_author()
    {
        $response = $this->deleteJson("/api/authors/{$this->author->id}");
        $response->assertStatus(204);
        $this->assertDatabaseMissing('authors', ['id' => $this->author->id]);

        $author_id = "999XXXX9999";
        $response = $this->deleteJson("/api/authors/{$author_id}");
        $response->assertStatus(404);
    }
}