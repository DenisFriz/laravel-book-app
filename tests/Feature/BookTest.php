<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    private function validPayload(): array
    {
        return [
            'title' => 'Test Book',
            'publisher' => 'Test Pub',
            'author' => 'Author',
            'genre' => 'Fiction',
            'publication_date' => '2024-01-01',
            'words_count' => 100000,
            'price_usd' => 19.99,
        ];
    }

    /** @test */
    public function can_create_book()
    {
        $response = $this->postJson('/api/books', $this->validPayload());

        $response->assertStatus(201)
                 ->assertJsonFragment([
                     'title' => 'Test Book',
                 ]);

        $this->assertDatabaseHas('books', [
            'title' => 'Test Book',
        ]);
    }

    /** @test */
    public function can_get_all_books()
    {
        Book::factory()->count(3)->create();

        $response = $this->getJson('/api/books');

        $response->assertStatus(200);
        $this->assertCount(3, $response->json());
    }

    /** @test */
    public function can_get_single_book()
    {
        $book = Book::factory()->create();

        $response = $this->getJson("/api/books/{$book->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'id' => $book->id,
                 ]);
    }

    /** @test */
    public function can_update_book()
    {
        $book = Book::factory()->create();

        $response = $this->patchJson("/api/books/{$book->id}", [
            'title' => 'Updated Title',
            'publisher' => $book->publisher,
            'author' => $book->author,
            'genre' => $book->genre,
            'publication_date' => $book->publication_date,
            'words_count' => $book->words_count,
            'price_usd' => $book->price_usd,
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'title' => 'Updated Title',
                 ]);

        $this->assertDatabaseHas('books', [
            'title' => 'Updated Title',
        ]);
    }

    /** @test */
    public function can_delete_book()
    {
        $book = Book::factory()->create();

        $response = $this->deleteJson("/api/books/{$book->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('books', [
            'id' => $book->id,
        ]);
    }
}