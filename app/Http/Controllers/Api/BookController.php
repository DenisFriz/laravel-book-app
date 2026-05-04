<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Info(title: 'Book Library API', version: '1.0.0', description: 'API for managing books in library')]
#[OA\Server(url: 'http://localhost:8000', description: 'Local server')]
class BookController extends Controller
{
    #[OA\Get(path: '/api/books', summary: 'Get all books', tags: ['Books'])]
    #[OA\Response(response: 200, description: 'List of books')]
    public function index()
    {
        return Book::all();
    }

    #[OA\Post(path: '/api/books', summary: 'Create book', tags: ['Books'])]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ['title', 'publisher', 'author', 'genre', 'publication_date', 'words_count', 'price_usd'],
            properties: [
                new OA\Property(property: 'title', type: 'string'),
                new OA\Property(property: 'publisher', type: 'string'),
                new OA\Property(property: 'author', type: 'string'),
                new OA\Property(property: 'genre', type: 'string'),
                new OA\Property(property: 'publication_date', type: 'string', format: 'date'),
                new OA\Property(property: 'words_count', type: 'integer'),
                new OA\Property(property: 'price_usd', type: 'number'),
            ]
        )
    )]
    #[OA\Response(response: 201, description: 'Book created')]
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'publisher' => 'required|string',
            'author' => 'required|string',
            'genre' => 'required|string',
            'publication_date' => 'required|date',
            'words_count' => 'required|integer',
            'price_usd' => 'required|numeric',
        ]);

        $book = Book::create($request->all());

        return response()->json($book, 201);
    }

    #[OA\Get(path: '/api/books/{id}', summary: 'Get book by ID', tags: ['Books'])]
    #[OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'string'))]
    #[OA\Response(response: 200, description: 'Book data')]
    public function show(string $id)
    {
        $book = Book::findOrFail($id);
        return response()->json($book);
    }

    #[OA\Patch(path: '/api/books/{id}', summary: 'Update book', tags: ['Books'])]
    #[OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'string'))]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'title', type: 'string'),
                new OA\Property(property: 'publisher', type: 'string'),
                new OA\Property(property: 'author', type: 'string'),
                new OA\Property(property: 'genre', type: 'string'),
                new OA\Property(property: 'publication_date', type: 'string', format: 'date'),
                new OA\Property(property: 'words_count', type: 'integer'),
                new OA\Property(property: 'price_usd', type: 'number'),
            ]
        )
    )]
    #[OA\Response(response: 200, description: 'Book updated')]
    public function update(Request $request, string $id)
    {
        $book = Book::findOrFail($id);

        $book->update($request->all());

        return response()->json($book);
    }

    #[OA\Delete(path: '/api/books/{id}', summary: 'Delete book', tags: ['Books'])]
    #[OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'string'))]
    #[OA\Response(response: 204, description: 'Book deleted')]
    public function destroy(string $id)
    {
        $book = Book::findOrFail($id);

        $book->delete();

        return response()->noContent();
    }
}
